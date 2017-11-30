<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

require "db/reports_db.php";

$data = array();
$tableSize = 300;

$asg_id=util::GetKeyID("asg_id", "?module=assignments");

$db = new db();
$db->connect();

$res_qst = $db->query(reports_db::GetQuestionsForReports($asg_id));

$percent = 0;

function get_percent($rate,$count)
{
    global $percent;
    $percent = round($rate*100/$count,2);
    return $percent;
}


function desc_func()
{
    return REPORTS;
}

?>
