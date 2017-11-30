<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

    require "extgrid.php";
    require "db/users_db.php";

    $hedaers = array("&nbsp;",LOGIN,  USER_NAME, USER_SURNAME, EMAIL,"&nbsp;");
    $columns = array("UserName"=>"text", "Name"=>"text","Surname"=>"Surname","email"=>"text");

    $grd = new extgrid($hedaers,$columns, "index.php?module=imported_users");
    $grd->id_column="UserID";
    $grd->auto_id=true;
    $grd->edit = false;
    $grd->delete=false;
    $grd->search=false;
    $grd->id_links=array(QUIZZES=>"?module=old_assignments");


    $query = orm::GetSelectQuery("v_imported_users", array(), array(), "name,surname",true);
    $grd->DrowTable($query);
    $grid_html = $grd->table;

    $search_html = $grd->DrowSearch(array(LOGIN, USER_NAME, USER_SURNAME),array("UserName", "Name", "Surname"));

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

    function desc_func()
    {
        return IMPORTED_USERS;
    }

?>
