<?php if(!isset($RUN)) { exit(); } ?>
<?php

    access::allow("1,2");

    require "grid.php";
    require "db/asg_db.php";

    $user_id = $_SESSION['user_id'];

    if($_SESSION['user_type']=="1" && isset($_GET['id']))
    {
	$user_id= util::GetID("?module=assignments");	
    }  

    $columns_quiz = array("quiz_name"=>"text", "added_date"=>"text","finish_date"=>"text","is_success"=>"text","pass_score"=>"text","total_point"=>"text", "allow_review"=>"test");
    $headers_quiz = array(QUIZ_SURV_NAME,START_DATE,FINISH_DATE,SUCCESS,PASS_SCORE,TOTAL_POINT,VIEW_DETAILS);

    $query = asgDB::GetOldAssignmentsQuery($user_id,1);
    $grd_quiz = new grid($headers_quiz,$columns_quiz, "index.php?module=old_assignments");
    $grd_quiz->edit=false;
    $grd_quiz->delete=false;

    $grd_quiz->column_override=array("is_success"=>"success_override", "allow_review"=>"review_override");

    function success_override($row)
    {
        global $YES_NO;
        return $YES_NO[$row['is_success']];
    }
    
    function review_override($row)
    {
        if(($row['allow_review']=="1" && $row['uq_status']!="1" && $row['uq_status']!="0" ) || $_SESSION['user_type']=="1")
        {
            return "<a href='?module=view_details&user_quiz_id=".$row['id']."'>".VIEW_DETAILS."</a>";            
        }
        else
        {
            return NOT_ENABLED;
        }
    }
    

    $grd_quiz->DrowTable($query);
    $grid_quiz_html = $grd_quiz->table;


    $columns_surv = array("quiz_name"=>"text", "added_date"=>"text","finish_date"=>"text","allow_review"=>"test");
    $headers_surv = array(QUIZ_SURV_NAME,START_DATE,FINISH_DATE,VIEW_DETAILS);

    $query = asgDB::GetOldAssignmentsQuery($user_id,2);
    $grd_surv = new grid($headers_surv,$columns_surv, "index.php?module=old_assignments");
    $grd_surv->edit=false;
    $grd_surv->delete=false;
    $grd_surv->column_override=array("allow_review"=>"review_override");
    $grd_surv->DrowTable($query);
    $grid_surv_html = $grd_surv->table;

    function desc_func()
    {
        return OLD_ASSIGNMENTS;
    }
?>
