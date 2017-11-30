<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("2");

 require "grid.php";
 //require "db/users_db.php";
 require "db/asg_db.php";

 $asg_id = util::GetID("?module=active_assignments");
 $results=asgDB::GetAsgQueryById($asg_id);

 $row_num = db::num_rows($results);
 if($row_num==0)
 {
     header("location:?module=active_assignments");
     exit;
 }
 $row = db::fetch($results);

 if($row['show_intro']=="1")
 {
    $intro = $row['intro_text'];
 }
 else
 {
     archive_old() ;
     header("location:?module=start_quiz&id=".$asg_id);
 }

 if(isset($_POST['btnCont']))
 {
     archive_old() ;
     header("location:?module=start_quiz&id=".$asg_id);     
 }

 function archive_old() 
 {
	global $asg_id;
	$user_id = $_SESSION['user_id'];
	$query = asgDB::GetActAsgByUserIDQuery($user_id);
	$results = db::exec_sql($query);
	$row = db::fetch($results);
	$status = intval($row['user_quiz_status']);  
	if($row['limited']==2 && $status>1)
	{
		orm::Update("user_quizzes", array("archived"=>1) , array("assignment_id"=>$asg_id,"user_id"=>$user_id));
	}
 }

 function desc_func()
 {
        return INTRO;
 }
 
?>
