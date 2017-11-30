<?php if(!isset($RUN)) { exit(); } ?>
<?php 

access::allow("1,2");

$pass_display = "";
$msg_display = "none";

if($_SESSION['imported'] != 0)
{
	$pass_display = "none";
	$msg_display = "";		
}

$val = new validations("btnRegister");
$val->AddValidator("txtOldPass", "an", OLD_PASS_VAL,"");
$val->AddValidator("txtNewPass", "an", NEW_PASS_VAL,"");

if(isset($_POST["ajax"]))
{
	if($val->IsValid() && $_SESSION['imported']=="0")
	{
		$old_pass = trim($_POST['old_password']);
		$new_pass = trim($_POST['new_password']);
		$old_pass_hash=md5($old_pass);
		$new_pass_hash=md5($new_pass);
		
		$results = orm::Select("users", array() , array("UserName"=>$_SESSION['txtLogin'], "Password"=>$old_pass_hash, "approved"=>1 , "disabled"=>0) , "");
		$count = db::num_rows($results);
		if($count == 0 )
		{
			echo WRONG_PASS;
		}
		else
		{
			orm::Update("users", array("Password"=>$new_pass_hash),array("UserName"=>$_SESSION['txtLogin']));
			$_SESSION['txtPass'] = $new_pass_hash;
			echo PASS_CHANGED;
		}
	}
}


function desc_func () { return CHNG_PASS; }

?>
