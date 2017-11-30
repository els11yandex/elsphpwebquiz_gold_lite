<?php

access::allow("1");

    require "grid.php";    
    require "db/quiz_db.php";    

    $val = new validations("btnSubmit");
    $val->AddValidator("txtName", "empty", QUIZ_NAME_VAL,"");
    $val->AddValidator("txtDesc", "empty", QUIZ_DESC_VAL,"");
    $val->AddValidator("drpCats", "notequal", QUIZ_CAT_VAL, "-1");

    $txtIntroText="";
    $selected = "-1";
    if(isset($_GET["id"]))
    {
        $id = util::GetID("?module=quizzes");
        $rs_quiz=orm::Select("quizzes", array(), array("id"=>$id), "");
        
        if(db::num_rows($rs_quiz) == 0 ) header("location:?module=quizzes");

        $row_quiz=db::fetch($rs_quiz);
        $txtName = $row_quiz["quiz_name"];
        $txtDesc = $row_quiz["quiz_desc"];
        $chkShowIntro = $row_quiz["show_intro"] == "1" ? "checked" : "";
        $txtIntroText = $row_quiz["intro_text"];
        $selected = $row_quiz["cat_id"];        
    }

    $results = orm::Select("cats", array(), array(),"");
    $cat_options = webcontrols::GetOptions($results, "id", "cat_name", $selected);

    if(isset($_POST["btnSubmit"]) && $val->IsValid())
    {        
     
        $date = date('Y-m-d H:i:s');
        if(!isset($_GET["id"]))
        {
            orm::Insert("quizzes", array(
                                "cat_id"=>$_POST["drpCats"],
                                "quiz_name"=>$_POST["txtName"] ,
                               "quiz_desc"=>$_POST["txtDesc"],
                               "added_date"=>$date,
                                "show_intro"=>isset($_POST["chkShowIntro"]) ? 1:0,
                                "intro_text"=>$_POST["editor1"]
                                ));
        }
        else
        {
            orm::Update("quizzes", array(
                                "cat_id"=>$_POST["drpCats"],
                                "quiz_name"=>$_POST["txtName"] ,
                               "quiz_desc"=>$_POST["txtDesc"],
                                "show_intro"=>isset($_POST["chkShowIntro"]) ? 1:0,
                                "intro_text"=>$_POST["editor1"]
                                ) ,
                                array("id"=>$id)
                        );
        }
        header("location:?module=quizzes");
    }


    include_once "ckeditor/ckeditor.php";     
    $CKEditor = new CKEditor();
    $CKEditor->config['filebrowserBrowseUrl']='ckeditor/kcfinder/browse.php?type=files';
    $CKEditor->config['filebrowserImageBrowseUrl']='ckeditor/kcfinder/browse.php?type=images';
    $CKEditor->config['filebrowserFlashBrowseUrl']='ckeditor/kcfinder/browse.php?type=flash';
    $CKEditor->basePath = 'ckeditor/';


    function desc_func()
    {
        return ADD_EDIT_QUIZ;
    }

/*
    if(isset($_POST["ajax"]))
    {
         
    }
 */
?>
