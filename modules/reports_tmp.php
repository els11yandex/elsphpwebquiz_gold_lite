<?php if(!isset($RUN)) { exit(); } ?>

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
                        while ($row_ans=db::fetch($res_ans))
                        {
                            ?>
                        <table border="0" class="desc_text">
                            <tr>
                                <td style="width:150px">
                                    <?php echo $row_ans['answer_text']; ?>
                                </td>
                                <td style="width:420px">
                                    <table style="width:100%;border-width:0px" border="0" cellpadding="0" cellspacing="0">
                                        <tr>
                                            <td bgcolor="red" style="width:<?php echo get_percent($row_ans['rate'],$row_ans['acount'])  ?>%">
                                               
                                            </td>
                                            <td>
                                                &nbsp;
                                            </td>
                                        </tr>
                                     </table>
                                </td>
                                <td width="130px">
                                    <?php echo $row_ans['rate']." (".$percent."%)"; ?>
                                </td>
                            </tr>
                        </table>                        
                            <?php                            
                        }
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