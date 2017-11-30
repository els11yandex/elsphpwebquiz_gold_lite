<?php

 access::allow("1");

 $val = new validations("btnSubmit");
 $val->AddValidator("txtdesc", "empty",RAT_DESC_VAL,"");
 $val->AddValidator("txtImgCount", "empty", RAT_IMG_VAL,"");
 $val->AddValidator("txtImgCount", "numeric", RAT_IMG_NUMERIC_VAL,"");

 
$temps_res = db::exec_sql(orm::GetSelectQuery("rating_temps", "*", array(), ""));

$selected_result = "";
$selected_restriction = "";
$selected_color="";
$temp_id = "";
$lang = "";

 if(isset($_GET["id"]))
 {
        $id = util::GetID("?module=ratings");
        $rs_ratings=orm::Select("ratings", array(), array("id"=>$id), "");
        
        if(db::num_rows($rs_ratings) == 0 ) header("location:?module=ratings");

        $row_rat=db::fetch($rs_ratings);
        $txtDesc = $row_rat["description"];
        $txtHeader = $row_rat["header_text"];
        $txtFooter = $row_rat["footer_text"];
        $txtImgCount = $row_rat["img_count"];
        //$chkShowIntro = $row_quiz["show_intro"] == "1" ? "checked" : "";        
        $selected_result = $row_rat["show_results"];               
        $selected_restriction = $row_rat["restrict_user"]; 
        $selected_color = $row_rat["bgcolor"]; 
        $temp_id = $row_rat["temp_id"];
        $lang=$row_rat["lang"];
 }

 $language_options = webcontrols::BuildOptionsByValue($LANGUAGES, $lang);
 $result_options = webcontrols::BuildOptions(array("1"=>ALWAYS,"2"=>NEVER), $selected_result);
 $restriction_options = webcontrols::BuildOptions(array("1"=>REST_BY_IP,"2"=>REST_BY_LOGIN,"3"=>REST_BY_COOKIE), $selected_restriction);
 $bgcolors_options = webcontrols::BuildOptions(util::GetColors(), $selected_color);

if(isset($_POST["btnSubmit"]) && $val->IsValid())
{
    if(isset($_GET["id"]))
    {
        $query = orm::GetUpdateQuery("ratings", array("description"=>$_POST['txtdesc'],
                                                  "temp_id"=>$_POST['rdtmps'],
                                                  "header_text"=>$_POST['txtheader'],
                                                  "footer_text"=>$_POST['txtfooter'],
                                                  "img_count"=>$_POST['txtImgCount'],
                                                  "show_results"=>$_POST['drpResults'],
                                                  "restrict_user"=>$_POST['drpRest'],
                                                  "bgcolor"=>$_POST['drpColors'],
                                                  "lang"=>$_POST['drpLang'],
                                                  "added_date"=>util::Now()
                                                  ),
                                                 array("id"=>$id)
                                                 );    
        db::exec_sql($query);        
    }
    else
    {
        $query = orm::GetInsertQuery("ratings", array("description"=>$_POST['txtdesc'],
                                                  "temp_id"=>$_POST['rdtmps'],
                                                  "header_text"=>$_POST['txtheader'],
                                                  "footer_text"=>$_POST['txtfooter'],
                                                  "img_count"=>$_POST['txtImgCount'],
                                                  "show_results"=>$_POST['drpResults'],
                                                  "restrict_user"=>$_POST['drpRest'],
                                                  "bgcolor"=>$_POST['drpColors'],
                                                  "lang"=>$_POST['drpLang'],
                                                  "added_date"=>util::Now()
                                                  ));    
        $id = db::exec_insert($query);
        
    }
    
    header("location:?module=rating_htmlcode&id=$id");
}

function desc_func()
{
    return ADD_EDIT_RATING;
}

?>
