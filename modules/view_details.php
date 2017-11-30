<?php if(!isset($RUN)) { exit(); } ?>
<?php

 access::allow("1,2");

 require "grid.php";
 require "db/asg_db.php";
 require "db/questions_db.php";
 require "qst_viewer.php";

 $id=util::GetKeyID("user_quiz_id", "?module=assignments");
 
 if($_SESSION['user_type']=="2") 
 {
     $uq_res = asgDB::GetUserQuizById($id);
     if(db::num_rows($uq_res)==0) header("location:?module=old_assignments");
     
     $row = db::fetch($uq_res);
     
     if($row['user_id']!=$_SESSION['user_id'] || $row['allow_review']!="1") { header("location:?module=old_assignments"); exit(); }
	 if($row['uq_status']=="1" || $row['uq_status']=="0")  { header("location:?module=old_assignments"); exit(); }
 }

 $asg_res = questions_db::GetQuestionsByUserQuizId($id);

 $uq  = 0;
 function get_question($row)
 {
     global $id, $uq;

     $qst_viewer = new qst_viewer("#");
     $qst_viewer->user_quiz_id=$id;

     $qst_viewer->show_prev=false;

     $qst_viewer->show_next=false;
     $qst_viewer->show_finish=false;
     $qst_viewer->SetReadOnly();
     $qst_viewer->show_correct_answers=true;
     $qst_viewer->control_unq = $uq;     
     $qst_viewer->BuildQuestionWithResultset($row);
     $qst_html = $qst_viewer->html;
     $uq++;
     return $qst_html;
 }

function desc_func()
{
        return VIEW_DETAILS;
}

?>
