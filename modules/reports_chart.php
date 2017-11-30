<?php

include("Includes/FusionCharts.php");
//We've also included ../Includes/FC_Colors.asp, having a list of colors
//to apply different colors to the chart's columns. We provide a function for it - getFCColor()
include("Includes/FC_Colors.php");

access::allow("1");

require "db/reports_db.php";

$data = array();
$tableSize = 300;

$asg_id=util::GetKeyID("asg_id", "?module=assignments");

$db = new db();
$db->connect();

$res_qst = $db->query(reports_db::GetQuestionsForReports($asg_id));

$percent = 0;

function get_chart_xml($res_ans)
{
    $i=0;
    while ($row_ans=db::fetch($res_ans))
    {        
        $arrData[$i][1] = $row_ans['answer_text']."(".$row_ans['rate']." rates )";
	$arrData[$i][2] = get_percent($row_ans['rate'],$row_ans['acount']);
        $i++;
	//Now, we need to convert this data into XML. We convert using string concatenation.
	//Initialize <graph> element	
    }
        $strXML = "<graph  numberPrefix='%' formatNumberScale='0' decimalPrecision='0'>";
	//Convert data to XML and append
	foreach ($arrData as $arSubData)
		$strXML .= "<set name='" . $arSubData[1] . "' value='" . $arSubData[2] ."' color='". getFCColor() ."' />";

	//Close <graph> element
	$strXML .= "</graph>";       
    
        return $strXML;
}


function get_percent($rate,$count)
{
    global $percent;
    $percent = round($rate*100/($count!=0 ? $count : 1),2);
    return $percent;
}
	
	//Create the chart - Column 3D Chart with data contained in strXML	

function desc_func()
{
     return "Reports";
}
        
?>
