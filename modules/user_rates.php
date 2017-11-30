<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

require "grid.php";
require "db/ratings_db.php";

$rate_id = util::GetID("?module=user_ratings");

$hedaers = array("&nbsp;",RAT_PRODUCT,AVG_RATE,MAX_RATE,RAT_COUNT,"&nbsp;");
$columns = array("product_id"=>"text","avarage_point"=>"text","img_count"=>"text", "total_rate"=>"text");
  
$grd = new grid($hedaers,$columns, "index.php?module=ratings");
$grd->id_links=array(RAT_DETAILS=>"?module=user_rate_details&rate_id=$rate_id");
$grd->id_column="product_id";
$grd->auto_id=true;
$grd->edit=false;
$grd->delete=false;

$query = ratings_db::GetRatingsTotalByProduct($rate_id);
$grd->DrowTable($query);
$grid_html = $grd->table;

function desc_func()
{
    return USER_RATES;
}

?>
