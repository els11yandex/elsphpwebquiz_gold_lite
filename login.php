<?php

  require "lib/util.php";
  require 'config.php';
  require 'db/mysql2.php';  
  require "db/orm.php";
  require "db/access_db.php";
  require "db/users_db.php";
  require "db/asg_db.php";
  require "lib/validations.php";
  require "lib/webcontrols.php";

  $RUN = 1;


  $msg = "";
  $autorized =false;
  $openidurl = "";
 
  
  if(PAYPAL_LOGIN=="yes")
  {
  
		$paypal_prefix="";
		if(PAYPAL_LOGIN_USE_SANDBOX=="yes") $paypal_prefix="sandbox.";
  
		$error_msg = "";
		
		$redirectUri = WEB_SITE_URL."login.php";
		$openidurl = "https://www.".$paypal_prefix."paypal.com/webapps/auth/protocol/openidconnect/v1/authorize?client_id=".PAYPAL_CLIENTID."&response_type=code&scope=".PAYPAL_SCOPE."&redirect_uri=$redirectUri";
		
		
		if(isset($_GET['code']))
		{
			
			$code = $_GET['code'];
			
			//$postfields['client_id'] = PAYPAL_CLIENTID;
			//$postfields['client_secret'] = PAYPAL_SECRET;
			//$postfields['grant_type'] = "authorization_code";
			//$postfields['code'] = $code;
			
			$postfields = "client_id=".PAYPAL_CLIENTID."&client_secret=".PAYPAL_SECRET."&grant_type=authorization_code&code=$code";
	
			$url = "https://api.".$paypal_prefix."paypal.com/v1/identity/openidconnect/tokenservice";
			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postfields);
			curl_setopt($ch, CURLOPT_TIMEOUT, 600);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//curl_setopt($ch, CURLOPT_PROXY, "218.108.168.70:82");							
            $response = curl_exec($ch);
			
			if ($response === false) {				
				$error_msg.= "cURL Error: ".curl_error($ch);					
			} 			
			else { 				
							
				$res_arr = json_decode($response,true);			;
				if(isset($res_arr['token_type'])) {
				
				$auth_str= $res_arr['token_type']." ".$res_arr['access_token'];
				
				$url = "https://api.".$paypal_prefix."paypal.com/v1/identity/openidconnect/userinfo/?schema=openid&access_token=".$res_arr['access_token'];
				
				$headerarray = array("Authorization:".$auth_str);
				//$headerarray= array("Authorization:Bearer A0151PE9nORIqGTX9ZBaAFQed4NKW8PKZ59iYidSzdpNPtc");
				$ch = curl_init($url);
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_HEADER, 0);
				curl_setopt($ch, CURLOPT_HTTPHEADER, $headerarray);
				curl_setopt($ch, CURLOPT_TIMEOUT, 600);
				curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			//	curl_setopt($ch, CURLOPT_POST, true);
				//curl_setopt($ch, CURLOPT_PROXY, "218.108.168.70:82");							
				$response = curl_exec($ch);
				curl_close($ch);
				
				if ($response === false) {				
					$error_msg.= "cURL Error: ".curl_error($ch);
				} 
				else { 				
					$res_arr = json_decode($response,true);				
					$details = explode(' ',$res_arr['name']);
					$name = $details[0];
					$surname = isset($details[1]) ? $details[1] : "";
					$row = users_db::AddPaypalUser($res_arr['email'],$name,$surname);
					if($row!=-1 && isset($res_arr['email']))
					{
						if($row['disabled']=="0" && $row['approved']=="1") {						
						asgDB::AcceptNewUser($row['UserID']);
						$_SESSION['lang_file']=$LANGUAGES['english'];
						$_SESSION['txtLogin'] = $row['UserName'];
						$_SESSION['txtPass'] = $row['Password'];
						$_SESSION['txtPassImp'] = $row['Password'];
						$_SESSION['user_id'] = $row['UserID'];
						$_SESSION['user_type'] = 2;
						$_SESSION['imported'] = 0;
						$_SESSION['name'] = $row['Name'];
						$_SESSION['surname'] = $row['Surname'];
						$_SESSION['email'] = $row['email'];
						header("location:index.php?module=active_assignments");
						exit();
						} else  $msg.= LOGIN_INCORRECT;
					} else $msg.=PAYPAL_ERROR;
					
				}				
				
				}else if(isset($res_arr['error_description'])) $error_msg.=$res_arr['error_description'];
			
			}
			
			if(PAYPAL_SHOW_ERROR=="yes") $msg.=$error_msg;
			
		}
  }


  if(isset($_POST['btnSubmit']))
  {      
      $txtLogin = db::esp(trim($_POST['txtLogin']));
      $txtPass = md5(trim($_POST['txtPass']));
      $password="";
      //$txtPassImp= Imported_Users_Password_Hash(trim($_POST['txtPass']));
      $results = access_db::GetModules($txtLogin, "", "", false);
      $has_result = db::num_rows($results);      
      if($has_result!=0 && isset($LANGUAGES[$_POST['drpLang']]))
      {
          $row = db::fetch($results);

          if($row['imported']=="0") $password = $txtPass ;
          else $password = Imported_Users_Password_Hash(trim($_POST['txtPass']), $row['password']);

          if($password==$row['password'])
          {

            $_SESSION['lang_file']=$_POST['drpLang'];
            $_SESSION['txtLogin'] = $txtLogin;
            $_SESSION['txtPass'] = $password;
            $_SESSION['txtPassImp'] = $password;
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['user_type'] = $row['user_type'];
			$_SESSION['imported'] = $row['imported'];
			$_SESSION['name'] = $row['Name'];
			$_SESSION['surname'] = $row['Surname'];
			$_SESSION['email'] = $row['email'];
            if($row['user_type']=="1")
            header("location:index.php?module=quizzes");
            else
            header("location:index.php?module=active_assignments");
          }
      }
      $msg = LOGIN_INCORRECT;
  }

  $language_options = webcontrols::BuildOptions($LANGUAGES, $DEFAULT_LANGUAGE_FILE);

  $menus = orm::Select("pages", array("page_name","id"), array(), "priority");

 

  include "login_".SITE_TEMPLATE."_tmp.php";


?>
