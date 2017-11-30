<?php if(!isset($RUN)) { exit(); } ?>
<?php 

if(SHOW_MENU=="registered" || SHOW_MENU=="nobody")
access::allow("1,2");	

$id = util::GetID("?module=default");
$results = orm::Select("pages",array(),array("id"=>$id), "");
$count = db::num_rows($results);
if($count == 0) header("location:?module=default");

$row = db::fetch($results);
$page_name =$row['page_name'];
$page_content =$row['page_content'];

function desc_func()
{
	global $page_name;
	return $page_name;
}

?>
