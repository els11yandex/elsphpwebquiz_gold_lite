<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

    require "extgrid.php";
    require "db/users_db.php";

    $hedaers = array("&nbsp;",LOGIN,  USER_NAME, USER_SURNAME, ADDED_DATE, USER_TYPE, EMAIL,"&nbsp;","&nbsp;","&nbsp;");
    $columns = array("UserName"=>"text", "Name"=>"text","Surname"=>"Surname","added_date"=>"short date","type_name"=>"text","email"=>"text");

    $grd = new extgrid($hedaers,$columns, "index.php?module=local_users");
    $grd->edit_link="index.php?module=add_edit_user";
    $grd->id_column="UserID";
    $grd->column_override=array("type_name"=>"user_type_override");
    $grd->auto_id=true;
    $grd->id_links=array(QUIZZES=>"?module=old_assignments");

    function user_type_override($row)
    {
        global $USER_TYPE;
        return $USER_TYPE[$row['user_type']];
    }

    if($grd->IsClickedBtnDelete())
    {
       orm::Delete("users", array("UserID"=>$grd->process_id));
    }

    $query = users_db::GetUsersQuery();
    $grd->DrowTable($query);
    $grid_html = $grd->table;

    $search_html = $grd->DrowSearch(array(LOGIN, USER_NAME, USER_SURNAME),array("UserName", "Name", "Surname"));

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }

    function desc_func()
    {
        return LOCAL_USERS;
    }

?>
