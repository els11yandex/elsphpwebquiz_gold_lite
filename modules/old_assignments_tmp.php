<?php if(!isset($RUN)) { exit(); } ?>

<table width="100%">
    <tr>
        <td>
            <table width="90%">
                <tr>
                    <td class="desc_text_bg2">
                       <?php echo OLD_QUIZ_ASSIGNMENTS ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="div_grid"><?php echo $grid_quiz_html ?></div>
                    </td>
                </tr>
            </table>

        </td>
    </tr>
    <tr>
        <td>
            <br>
        </td>
    </tr>
    <tr>
        <td>
            <table width="90%">
                <tr>
                    <td class="desc_text_bg2">
                        <?php echo OLD_SURVEY_ASSIGNMENTS ?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <div id="div_grid"><?php echo $grid_surv_html ?></div>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>
  
