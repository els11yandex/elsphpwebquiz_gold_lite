<?php if(!isset($RUN)) { exit(); } ?>

<script language="JavaScript" type="text/javascript" src="rte/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="rte/richtext.js"></script>
<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>

<?php echo $val->DrowJsArrays(); ?>


<form method="post" name="form1" >
<table class="desc_text" border="0" width="100%">
    <tr>
        <td width="120px">
            <?php echo CAT ?> :
        </td>
        <td>
            <select id="drpCats" name="drpCats" class="st_txtbox">
                <?php echo $cat_options ?>
            </select>
        </td>
    </tr>
    <tr>
        <td><?php echo NAME ?> :</td>
        <td><input class="st_txtbox" type="text" id="txtName" name="txtName" value="<?php echo util::GetData("txtName") ?>" /></td>
    </tr>
    <tr>
        <td><?php echo DESC ?> :</td>
        <td><input class="st_txtbox" type="text" id="txtDesc" name="txtDesc" value="<?php echo util::GetData("txtDesc") ?>" /></td>
    </tr>
     <tr>
        <td><?php echo SHOW_INTRO ?> :</td>
        <td ><input  type="CHECKBOX" id="chkShowIntro" name="chkShowIntro" <?php echo util::GetData("chkShowIntro") ?>  /></td>
    </tr>
    <tr>
        <td><?php echo INTRO_TEXT ?> :</td>
        <td >
            <?php $CKEditor->editor("editor1", $txtIntroText) ?>
        </td>
    </tr>
    <tr>
        <td>
            &nbsp;
        </td>
    </tr>
    <tr>
        <td colspan="2" align="center"><input style="width:100px" type="submit" id="btnSubmit" name="btnSubmit" value="<?php echo SAVE ?>" onclick="return validate();">
        <input type="button" style="width:100px" id="btnCancel" value="<?php echo CANCEL ?>" onclick="javascript:window.location.href='?module=quizzes'">
        </td>
    </tr>
</table>
</form>
