<?php if(!isset($RUN)) { exit(); } ?>
<form method="post" name="form1">
<table align="center" class="qst_main_table" cellpadding="5" cellspacing="5">
    <tr>
        <td>
            <font face=tahoma><?php echo $intro ?>
        </td>
    </tr>
     <tr>
        <td align="center">
            <input type="button" style="width:150px" value="<?php echo CANCEL ?>" name="btnCancel" onclick="javascript:window.location.href='index.php?module=active_assignments'" />
            <input type="submit" style="width:150px" value="<?php echo CCONTINUE ?>" name="btnCont"  />
        </td>
    </tr>
</table>
</form>