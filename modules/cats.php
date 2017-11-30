<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

    require "grid.php";
    require "db/cats_db.php";

    $hedaers = array(CAT_NAME, "&nbsp;", "&nbsp;");
    $columns = array("cat_name"=>"test");
    
    $grd = new grid($hedaers,$columns, "index.php?module=cats");

    $grd->process_html_command="process_quiz_status";
    $grd->edit=false;

    function process_quiz_status($row)
    {
        $editjs="EditCat('".$row['cat_name']."','".$row['id']."')";
        $html="<td><a href='#' onclick=\"".$editjs."\">".EDIT."</a></td>";
        return $html;
    }

    if(isset($_POST["add"]))
    {
        if($_POST["add"]=="adding")
        {
            catsDB::AddNewCat($_POST["name"]);
        }
        else
        {            
            catsDB::EditCat($_POST["name"],$_POST["hdnT"]);
        }
    }

    if($grd->IsClickedBtnDelete())
    {        
       catsDB::DeleteCategoryById($grd->process_id);
    }    
  
    //$grd->links =array("Az"=>"az.php" , "En"=>"english.php");
    $query = catsDB::GetCatsQuery();
    $grd->DrowTable($query);
    $grid_html = $grd->table;    

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

    function desc_func()
    {
        return CAT_DESC;
    }
    
?>
