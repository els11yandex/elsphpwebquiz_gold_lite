<?php

 
  require "lib/util.php";
  require 'config.php';
  require 'db/mysql2.php';
  require 'db/access_db.php';  
  require "lib/access.php";
  require "db/orm.php"; 
  require "lib/validations.php";
  require "lib/webcontrols.php";

  if(!isset($LANGUAGES)) header("location:install/index.php");

  if(USE_MATH=="yes") include("mathpublisher/mathpublisher.php") ;


  $RUN = 1;

   //@session_start();

  
  $module_name = GetModuleName();
  $expand =false;
  $autorized = false;
  $check = true;

  if ($module_name=="show_page")
  {
	if(!isset($_SESSION['txtLogin']) && SHOW_MENU=="all") $check = false;
  }

  if($check==true) 
  {
	$modules = access_db::GetModules($_SESSION['txtLogin'], $_SESSION['txtPass'],$_SESSION['txtPassImp'],true);
  	$has_result = db::num_rows($modules);
  

  	if($has_result==0)
  	{ 
        	header("location:login.php");
        	exit;
  	}

  	if($has_result!=0) {
  		$_SESSION['KCFINDER'] = array();
  		$_SESSION['KCFINDER']['disabled'] = false;
 	}
  	$autorized = true;
	$expand  = true;
  	ExpandModules($modules);
  }
    
  function ExpandModules($modules)
  {
      global $child_modules,$main_modules;
      while($row=db::fetch($modules))
      {	  
          if($row['parent_id']=="0")
          {		  
              $main_modules[] = $row;
          }
          else
          {        
              $child_modules[$row['parent_id']][]=$row;
          }
      }
  }   

  $sql = ppages::getqueryu();
  if($_SESSION['user_type']=="1")  $sql = ppages::getquerya();
  $menus = db::exec_sql($sql);

  ShowModule();

  function ShowModule()
  {
        global $module_name,$module_t_name,$Util;

       // $module_name= GetModuleName() ;

        if(!file_exists("modules/$module_name".".php") || $module_name=="" || strpos($module_name,"../")!=0)
            $module_name="default";

        $module_t_name=$module_name."_tmp";

  }

  function GetModuleName()
  {
	return isset($_GET["module"]) ? $_GET["module"] : "default" ;
  }

  include "modules/".$module_name.".php";
  
  if(!isset($_POST["ajax"]))
  {
        $queries = debug::GetSQLs();
        include "index_".SITE_TEMPLATE."_tmp.php";
//	include "index_tmp.php";
  }  


?>
