<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

require "grid.php";
require "db/ratings_db.php";

$rate_id = util::GetKeyID("rate_id","?module=user_ratings");
$product_id = $_GET['id'];

$hedaers = array("&nbsp;",RAT_PRODUCT,RATE,IP_ADDRESS,RAT_USER_NAME);
$columns = array("product_id"=>"text","point"=>"text", "ip_address"=>"text", "UserName"=>"text");
  
$grd = new grid($hedaers,$columns, "index.php?module=ratings");
$grd->id_column="product_id";
$grd->auto_id=true;
$grd->edit=false;
$grd->delete=false;

$query = ratings_db::GetRatingDetails($rate_id,$product_id);
$grd->DrowTable($query);
$grid_html = $grd->table;

function desc_func()
{
    return USER_RATES_DETAILS;
}

?>


