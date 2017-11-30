<?php if(!isset($RUN)) { exit(); } ?>

<?php 
    access::allow("1"); 
    
    require "extgrid.php";

    $hedaers = array("&nbsp;",MENU_NAME ,"&nbsp;","&nbsp;");
    $columns = array("page_name"=>"text");

    $grd = new extgrid($hedaers,$columns, "index.php?module=cms");
    $grd->edit_link="index.php?module=add_page";
    $grd->auto_id=true;

    if($grd->IsClickedBtnDelete())
    {
       orm::Delete("pages", array("id"=>$grd->process_id));
    }

    $query = "select * from pages";
    $grd->DrowTable($query);
    $grid_html = $grd->table;

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

function desc_func() { return CONTENT_MAN;}

?>
