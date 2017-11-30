<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

    require "grid.php";
    require "db/questions_db.php";

    $quiz_id = util::GetKeyID("quiz_id", "index.php?module=quizzes");

    $hedaers = array("&nbsp;",QUESTION, TYPE, POINT, ADDED_DATE, "&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
    $columns = array("question_text"=>"text","question_type"=>"text" ,"point"=>"text","added_date"=>"short date");

    $grd = new grid($hedaers,$columns, "index.php?module=questions&quiz_id=$quiz_id");
    $grd->edit_link="index.php?module=add_question&quiz_id=$quiz_id";
    $grd->column_override=array("question_type"=>"question_type_override");
    $grd->jslinks=array("Preview"=>"ShowPreview(\"[id]\",event.pageY)");
    $grd->auto_id=true;

    function question_type_override($row)
    {
        global $QUESTION_TYPE;
        return $QUESTION_TYPE[$row['question_type_id']];
    }

    //$grd->links=(array("Questions"=>"?module=questions"));
    $grd->commands=array(UP=>"up", DOWN=>"down");

    if($grd->IsClickedBtnDelete())
    {
        questions_db::DeleteQuestion($grd->process_id);    
	$priority = questions_db::GetMinPriority($quiz_id);
	if($priority!=-1)
	questions_db::UpdatePriority($quiz_id,$priority);    
    }

    if($grd->IsClickedBtn("up"))
    {        
        questions_db::MoveQuestion("up", $grd->process_id);        
    }

    if($grd->IsClickedBtn("down"))
    {
        questions_db::MoveQuestion("down", $grd->process_id);
    }

    $query = questions_db::GetQuestionsQuery($quiz_id);
    $grd->DrowTable($query);
    $grid_html = $grd->table;

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

    function desc_func()
    {
        return QUESTIONS;
    }

?>
