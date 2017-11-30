<?php

  require "../lib/util.php";
  require '../config.php';
  require "../db/questions_db.php";
  require "../db/asg_db.php";
  require "qst_viewer.php";
  require '../db/mysql2.php';
  require '../db/access_db.php';  
  require "../db/orm.php";
  require "../lib/validations.php";
  require "../lib/webcontrols.php";
  require '../lib/access.php';
  if(USE_MATH=="yes") include("../mathpublisher/mathpublisher.php") ;

 //@session_start();
 if(!isset($_POST['qst_id'])) exit ;

 $priority=intval($_POST['qst_id']);
 
 $link = "";
 $user_quiz_id = -1;
 $answer_order = 1;
 if(!isset($_POST['preview']))
 {
     $link = "?module=start_quiz&id=".$_SESSION['asg_id'];
     $user_quiz_id = $_SESSION['user_quiz_id'];
     $answer_order=db::clear($_POST['ao_']);
     $qst_query = questions_db::GetQuestionsByPriority($priority, $_SESSION['asg_id'], $_SESSION['user_id'], db::clear($_POST['ran_']),db::clear($_POST['qz_']));
 }
 else
 {
      access::allow("1");
      $qst_query = questions_db::GetQuestionsByID($priority);      
 }


 $qst_viewer = new qst_viewer($link);
 $qst_viewer->user_quiz_id=$user_quiz_id;

 $qst_viewer->show_prev=false;

 $qst_viewer->show_next=false;
 $qst_viewer->show_finish=false;

 
 $row_qst = db::fetch(db::exec_sql($qst_query));

 $qst_viewer->ans_priority=$answer_order;
 $qst_viewer->BuildQuestionWithResultset($row_qst);
 $qst_html = $qst_viewer->html;


 echo $qst_html;

?>
