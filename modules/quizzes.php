<?php if(!isset($RUN)) { exit(); } ?>
<?php

    access::allow("1");

    require "extgrid.php";
    require "db/quiz_db.php";

    $hedaers = array("&nbsp;",QUIZ_NAME, QUIZ_DESC, ADDED_DATE,QUESTIONS,"&nbsp;","&nbsp;");
    $columns = array("quiz_name"=>"text", "quiz_desc"=>"text","added_date"=>"short date");

    $grd = new extgrid($hedaers,$columns, "index.php?module=quizzes");
    $grd->edit_link="index.php?module=add_edit_quiz";
    
    $grd->id_links=(array(QUESTIONS=>"?module=questions"));
    $grd->id_link_key="quiz_id";
    $grd->auto_id=true;

    if($grd->IsClickedBtnDelete())
    {
       quizDB::DeleteQuizById($grd->process_id);
    }
      
    $query =  orm::GetSelectQuery("quizzes", array() , array("parent_id"=>"0"), "added_date desc", true);  //quizDB::GetQuizQuery();
    $grd->search=true;
    $grd->DrowTable($query);
    $grid_html = $grd->table;

    $search_html = $grd->DrowSearch(array(QUIZ_NAME, QUIZ_DESC),array("quiz_name", "quiz_desc"));

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

    function desc_func()
    {
        return QUIZZES;
    }

?>
