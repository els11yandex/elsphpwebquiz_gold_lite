<?php if(!isset($RUN)) { exit(); } ?>

<SCRIPT LANGUAGE="Javascript" SRC="FusionCharts/FusionCharts.js"></SCRIPT>
<table width="100%">
    

<?php
$i = 0;
while($row=db::fetch($res_qst))
{
    ?>
    <tr>
        <td>
            <font face="tahoma" size="4"><?php echo $row['question_text'] ?></font>
        </td>
    </tr>
    <tr>
        <td><br><table style="width:700px">
                <tr>
                    <td>
                    <?php
                        $res_ans = $db->query(reports_db::GetAnswersReport($row['id'],$asg_id));
                        //while ($row_ans=db::fetch($res_ans))
                       // {
                            echo renderChart("FusionCharts/FCF_Column3D.swf", "", get_chart_xml($res_ans), "byCount".$row['id'], 800, 300);                           
                      //  }
                    ?>
                    </td>
                </tr>
            </table>
            <br><hr>
        </td>
    </tr>
   <?php
  $i++;
}

$db->close_connection();

?>

    </table>
<br>
<br>
<br>