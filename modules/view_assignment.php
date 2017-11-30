<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

 require "grid.php";
 require "db/asg_db.php";
 require "lib/cmail.php";
 require "lib/libmail.php";

 $asg_id=util::GetKeyID("asg_id", "?module=assignments");

 $asg_res = asgDB::GetAsgById($asg_id);

 if(db::num_rows($asg_res)==0)
 {
     die(ASG_CANNOT_BE_FOUND);
 }

 $row=db::fetch($asg_res);

 $cat_name=$row['cat_name'];
 $test_name=$row['quiz_name'];
 $quiz_type=$row['quiz_type']=="1" ? O_QUIZ : O_SURVEY;
 
 $questions_order=$row['qst_order']=="1" ? BY_PRIORITY : RANDOM;
 $answer_order=$row['answer_order']=="1" ? BY_PRIORITY : RANDOM;
 $review_answers=$row['allow_review']=="1" ? O_YES : O_NO;
 
 $show_results=$row['show_results']=="1" ? O_YES : O_NO;
 $results_by=$row['results_mode'] == "1" ? O_POINT : O_PERCENT;
 $asg_how_many=$row['limited'] == "1" ? ASG_ONCE : ASG_NO_LIMIT;

 $pass_score=$row['pass_score'];
 $test_time=$row['quiz_time'];

 $srv_display = "";
 if($row['quiz_type']=="2") $srv_display ="none";


 $chk_all_html = "<input type=checkbox name=chkAll2 onclick='grd_select_all(document.getElementById(\"form1\"),\"chklcl\",\"this.checked\")'>";
 $hedaers = array($chk_all_html,USER_ID, LOGIN, USER_NAME, USER_SURNAME ,STATUS,SUCCESS, TOTAL_POINT,"&nbsp;");
 $columns = array("user_id"=>"text","UserName"=>"text", "Name"=>"text","Surname"=>"text","status_name"=>"text","is_success"=>"text","total_point"=>"text");

 $grd = new grid($hedaers,$columns, "index.php?module=view_assginments");
 $grd->edit=false;
 $grd->delete=false;

 $grd->id_links=(array(DETAILS=>"?module=view_details"));
 $grd->id_link_key="user_quiz_id";
 $grd->id_column="user_quiz_id";
 $grd->checkbox=true;
$grd->chk_class="chklcl";
 $grd->column_override=array("is_success"=>"success_override","status_name"=>"status_override");

 $i = -1;
 function success_override($row)
 {
     global $YES_NO,$i;
     $i++; 
     return $YES_NO[$row['is_success']]."<input type=hidden id=hdnuq$i value='".$row['user_quiz_id']."'><input type=hidden id=hdn$i value=".$row['user_id']." />";
 }


 function status_override($row)
 {
     global $ASG_STATUS;
     return $ASG_STATUS[$row['status_id']];
 }




 $query = asgDB::GetUserResultsQuery($asg_id, 1);
 $grd->DrowTable($query);
 $grid_lu_html = $grd->table;

 $chk_all_html = "<input type=checkbox name=chkAll2 onclick='grd_select_all(document.getElementById(\"form1\"),\"chkimp\",\"this.checked\")'>";
 $hedaers = array($chk_all_html,USER_ID, LOGIN, USER_NAME, USER_SURNAME ,STATUS, SUCCESS, TOTAL_POINT,"&nbsp;");
  
 $grd_iu = new grid($hedaers,$columns, "index.php?module=view_assginments");
 $grd_iu->edit=false;
 $grd_iu->delete=false;

 $grd_iu->id_links=(array(DETAILS=>"?module=view_details"));
 $grd_iu->id_link_key="user_quiz_id";
 $grd_iu->id_column="user_quiz_id";
 $grd_iu->checkbox=true;
 $grd_iu->chk_class="chkimp";
 $grd_iu->column_override=array("is_success"=>"iu_success_override","status_name"=>"iu_status_override");


 $y = -1;
 function iu_success_override($row)
 {
     global $YES_NO,$y;
     $y++;
     return $YES_NO[$row['is_success']]."<input type=hidden id=hdnuqi$y value='".$row['user_quiz_id']."'><input type=hidden id=hdnI$y value=".$row['user_id']." />";;
 }
  

 function iu_status_override($row)
 {
     global $ASG_STATUS;
     return $ASG_STATUS[$row['status_id']];
 }

 $query = asgDB::GetUserResultsQuery($asg_id, 2);
 $grd_iu->DrowTable($query);
 $grid_iu_html = $grd_iu->table;


 if(isset($_POST['ajax']))
 {

 }



 function desc_func()
 {
        return VIEW_ASSIGNMENT;
 }

?>
