<?php if(!isset($RUN)) { exit(); } ?>

<?php
if(DEBUG_SQL=="no") echo ENABLE_DEBUGGING;
?>

   <table style="width:100%" >
            <tr>
                <td bgcolor="white">
                    <table style="width:100%" cellpadding="0" cellspacing="0">
                        <?php
                        for($i=0;$i<count($queries);$i++)
                        {
                            ?>
                                <tr>
                                    <td bgcolor="moccasing" class="query_head">
                                      <b>Query <?php echo $i+1 ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="query">
                                        <?php echo util::getFormattedSQL($queries[$i]) ?>                                        
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <br>
                                    </td>
                                </tr>
                            <?php
                        }
                        ?>
                    </table>
                </td>
            </tr>
        </table>
