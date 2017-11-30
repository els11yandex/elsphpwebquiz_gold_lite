<?php if(!isset($RUN)) { exit(); } ?>
<?php

    access::allow("1");
    
    require "grid.php";
    require "db/ratings_db.php";
    
    $hedaers = array("&nbsp;",RAT_TYPE,DESCRIPTION,  ADDED_DATE,"&nbsp;","&nbsp;","&nbsp;","&nbsp;","&nbsp;");
    $columns = array("active_img"=>"text","description"=>"text", "added_date"=>"short date");
  
    $grd = new grid($hedaers,$columns, "index.php?module=ratings");
    $grd->id_links=array(RAT_USER_RATES=>"?module=user_rates",HTML_CODE=>"?module=rating_htmlcode");
    $grd->edit_link="index.php?module=add_edit_rating";    
    $grd->auto_id=true;
    $grd->id_column="id";
    
    $grd->commands=array(ENABLE=>"Enable");
    $grd->process_command_override="grd_process_command_override";
    
    $grd->column_override=array("active_img"=>"active_img_override");
    
    function active_img_override($row)
    {
        return "<img width='25px' src='rating_img/".$row['active_img']."'>";        
    }
    
    if($grd->IsClickedBtnDelete())
    {
        db::exec_sql(orm::GetDeleteQuery("ratings", array("id"=>$grd->process_id)));        
    }

    if($grd->IsClickedBtn("Enable"))
    {
        $q=orm::GetUpdateQuery("ratings", array("status"=>1),array("id"=>$grd->process_id));
        db::exec_sql($q);
    }

    if($grd->IsClickedBtn("Disable"))
    {        
        $q=orm::GetUpdateQuery("ratings", array("status"=>0),array("id"=>$grd->process_id));                        
        db::exec_sql($q);
    }
    
    function grd_process_command_override($row)
    {
        global $grd;
        if($row['status']==0)
        {
            return grid::ProcessCommandTemplate($row, "Enable",ENABLE,$grd);
        }
        else if($row['status']==1)
        {
            return grid::ProcessCommandTemplate($row, "Disable",DISABLE, $grd);
        }
        else 
        {
            return "<td>&nbsp;</td>";
        }
    }
    
    
    $query = ratings_db::GetRatingsQuery();
    $grd->DrowTable($query);
    $grid_html = $grd->table;

    if(isset($_POST["ajax"]))
    {
         echo $grid_html;
    }
    
    function desc_func()
    {
        return RATINGS;
    }

?>