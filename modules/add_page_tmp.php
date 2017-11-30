<?php if(!isset($RUN)) { exit(); } ?>
<script language="JavaScript" type="text/javascript" src="rte/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="rte/richtext.js"></script>
<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>

<?php echo $val->DrowJsArrays(); ?>


<form method="post" name="form1" >
<table>
	<tr>
		<td width="100px">
			<?php echo MENU_NAME ?> : 
		</td>
		<td>
			<input class="st_txtbox" type="text" id="txtName" name="txtName" value="<?php echo util::GetData("txtName") ?>" />
		</td>
	</tr>
	<tr>
		<td width="100px">
			<?php echo PRIORITY ?> : 
		</td>
		<td>
			<input class="st_txtbox" type="text" id="txtPriority" name="txtPriority" value="<?php echo util::GetData("txtPriority") ?>" />
		</td>
	</tr>
	<tr>
		<td valign=top>
			<?php echo PAGE_CONTENT ?> : 
		</td>
		<td>
			<?php $CKEditor->editor("editor1", $txtPagecontent) ?>
		</td>
	</tr>
   <tr>
        <td colspan=2>
            &nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input style="width:100px" type="submit" id="btnSubmit" name="btnSubmit" value="<?php echo SAVE ?>" onclick="return validate();">
        <input type="button" style="width:100px" id="btnCancel" value="<?php echo CANCEL ?>" onclick="javascript:window.location.href='?module=cms'">
        </td>
    </tr>
</table>
</form>
