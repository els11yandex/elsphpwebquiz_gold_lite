<?php

    require "lib/util.php";
    require 'config.php';        
    require "db/orm.php";
    require 'db/mysql2.php';
    require 'db/ratings_db.php';
    require 'db/access_db.php';
    require "modules/rating_viewer.php";
       
    
    if(isset($_GET['module']))
    {
       // sleep(3);
        $file = file_get_contents('modules/tmps/login_box.xml', true);
        $file = str_replace("[rate_id]",$_GET['rate_id'], $file );
        $file = str_replace("[prod_id]",$_GET['product_id'], $file );        
        $file = str_replace("[RATE]",RATE, $file );        
        $file = str_replace("[WAIT]",WAIT, $file );        
        $file = str_replace("[CANCEL]",CANCEL, $file );        
        $file = str_replace("[LOGIN]",LOGIN, $file );        
        $file = str_replace("[PASSWORD]",PASSWORD, $file );        
        echo $file;
        exit();
    }        
    
    if(!isset($_GET['rate_id'])) exit();      
    
    $rat = new rating_viewer($_GET['rate_id'], $_GET['product_id']);        
    $rat->web_site=$_GET['website'];
              
    if($_GET['mode']=="rate")
    {        
       // sleep(3);
        $user_id = -1;
        if(isset($_POST['login']))
        {
            $user_id=access_db::HasAccess($_POST['login'], $_POST['password']);            
            if($user_id=="-1") 
            {
                echo "msg;|".LOGIN_INCORRECT;
                exit();
            }
        }    
            
        $rated = $rat->RateIt($_GET['product_id'], $_GET['rate_id'], $_GET['clicked'], $user_id);
        if($rated=="-1")
        {
             echo "msg;|".ALREADY_RATED;
             exit();
        }
        else if($rated =="-2")
        {
             echo "msg;|Wrong rate";
             exit();
        }
                              
    }
    
    if(isset($_GET['viewmode']) && $_GET['viewmode']=="view")          
    {
       $rat->preview=true; 
    }
    
    $rat->BuildRating();
    echo $rat->GetHtml();
        

?>
