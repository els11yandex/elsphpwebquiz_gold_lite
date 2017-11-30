<?php

require "lib/util.php";
require "config.php";

$product = get_qs("product");
$rate = get_qs("rate");
$site = get_qs("site");
$mode = get_qs("mode");
$lang = get_qs("lang");
$type = get_qs("type");


function get_qs($qs)
{
    if(isset($_GET[$qs]))
    {
        return urldecode(trim($_GET[$qs]));
    }
    else
    {
        exit();
    }
}

?>
<html>
    <head>
        <STYLE TYPE="text/css"> body{background-color:transparent}</STYLE>
    </head>
<body >
<link href="<?php echo WEB_SITE_URL ?>style/ratings.css" type="text/css" rel="stylesheet" />
<script language="javascript" src="jquery.js" type="text/javascript" ></script>                
<script language="javascript" src="ratings.js" type="text/javascript" ></script>                        

<script language="javascript" type="text/javascript">            
      DrowRating('<?php echo $product ?>',<?php echo $rate ?>, '<?php echo $site ?>','<?php echo $mode ?>','<?php echo $lang ?>','<?php echo $type ?>');            
</script>                                
<div id="<?php echo $product ?>"></div>    
</body>
</html>