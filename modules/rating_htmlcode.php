<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

 require 'db/ratings_db.php';
 require "rating_viewer.php";

 $id=util::GetID("?module=ratings");
 $rat = new rating_viewer($id,"1");   
 $row = $rat->BuildRating();

 $file = file_get_contents('tmps/html_code.xml', true);
 $file = str_replace("[URL]", WEB_SITE_URL, $file);
 $file = str_replace("[RATE_ID]", $id, $file); 
 $file = str_replace("[LANG]", $row['lang'], $file); 
 
 
 $hg = 70; 
 if($row['restrict_user']=="2") $hg = 120;
 
 $file2 = file_get_contents('tmps/html_code2.xml', true);
 $file2 = str_replace("[URL]", WEB_SITE_URL, $file2);
 $file2 = str_replace("[RATE_ID]", $id, $file2); 
 $file2 = str_replace("[height]", $hg, $file2); 
 $file2 = str_replace("[LANG]", $row['lang'], $file2);
 
 
 $TEXTBOX  = str_replace("[MODE]", "rating", $file); 
 //$PREVIEW  = str_replace("[MODE]", "view", $file); 
 $PREVIEW = str_replace("[MODE]", "view", $file2);
 $TEXTBOX2 = str_replace("[MODE]", "rating", $file2);
 
       
 $rat->web_site=WEB_SITE_URL;
 
 
 $html = $rat->GetHtml();
 
 function desc_func()
 {
        return GENERATED_HTML;
 }

 
?>
