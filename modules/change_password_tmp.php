<?php if(!isset($RUN)) { exit(); } ?>
<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>
<?php echo $val->DrowJsArrays(); ?>
<script language="javascript">

function checkform()
{
	document.form1.btnSave.disabled=true;
	var old_pass= document.getElementById('txtOldPass').value;
	var new_pass= document.getElementById('txtNewPass').value;
        var status=validate();
        if(status)
        {
             $.post("?module=change_password", { old_password: old_pass, new_password : new_pass, ajax: "yes" },
             function(data){
                    alert(data);
                    document.form1.btnSave.disabled=false;                
            });
        }
        else
        {
            document.form1.btnSave.disabled=false;
        } 
}
</script>
<form id=form1 name=form1>
<table style="display:<?php echo $pass_display ?>">
	<tr>
		<td class="desc_text">
			<?php echo OLD_PASS ?> : 
		</td>
		<td>
			<input type="txtOldPass" id=txtOldPass name=txtOldPass maxlength=20  />  
		</td>
	</tr>
	<tr>
		<td class="desc_text">
			<?php echo NEW_PASS ?> : 
		</td>
		<td>
			<input type="txtOldPass" id=txtNewPass name=txtNewPass maxlength=20  /> 
		</td>
	</tr>
	<tr>
		<td colspan=2 align=center>
			<input type=button id=btnSave name=btnSave value="<?php echo SAVE ?>" onclick="checkform()" style="width:125px" />
			<input type=button id=btnCancel name=btnCancel value="<?php echo CANCEL ?>" onclick="javascript:history.back(1)" style="width:125px" />
		</td>	
	</tr>
</table>

<table style="display:<?php echo $msg_display ?>">
	<tr>
		<td class="desc_text">
			<?php echo ONLY_LOCAL ?>  
		</td>
</table>
</form>
