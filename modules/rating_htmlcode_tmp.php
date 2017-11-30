<table align="center" style="width:100%" border="0">
    <tr>
        <td>
            <table>
                <tr>
                    <td valign="top" class="rating_preview"><?php echo PREVW ?> : </td>
                    <td ><?php echo $PREVIEW; ?></td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td class="desc_text">
            <br>
            <?php echo PUT_THIS ?> (for single domain and intranet applications)
        </td>
    </tr>
    <tr>
        <td align="center">
            <textarea id="txtHtml" name="txtHtml" style="width:100%;height:250px"><?php echo htmlspecialchars($TEXTBOX) ?></textarea>
        </td>
    </tr>
     <tr>
        <td class="desc_text">
            <br>
            <?php echo PUT_THIS ?> (for all sites)
        </td>
    </tr>
    <tr>
        <td align="center">
            <textarea id="txtHtml" name="txtHtml" style="width:100%;height:250px"><?php echo htmlspecialchars($TEXTBOX2) ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            <a href="?module=ratings"><?php echo BACK_TO_RAT ?></a>
            &nbsp;
            <a href="?module=add_edit_rating&id=<?php echo $id ?>"><?php echo EDIT_THIS_RAT ?></a>
        </td>
    </tr>
</table>
