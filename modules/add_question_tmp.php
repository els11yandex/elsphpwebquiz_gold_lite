<?php if(!isset($RUN)) { exit(); } ?>
<script language="JavaScript" type="text/javascript" src="rte/html2xhtml.js"></script>
<script language="JavaScript" type="text/javascript" src="rte/richtext.js"></script>
<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>



<form id="form1" method="post" onsubmit="return submitForm();">
<table class="desc_text" style="width:850px">
    <tr>
        <td valign="top">
            <?php echo QUESTION ?> :
        </td>
        <td>
            <?php $CKEditor->editor("txtQstsEd", $txtQsts) ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo POINT ?> :
        </td>
        <td>
            <input style="width:100px" type="text" id="txtPoint" value="<?php echo util::GetData("txtPoint") ?>" name="txtPoint">
        </td>
    </tr>
    <tr>
        <td valign="top">
            <?php echo HEADER_TEXT ?> :
        </td>
        <td>
            <textarea style="width:100%;height:70px" id="txtHeader" name="txtHeader"><?php echo util::GetData("txtHeader") ?></textarea>
        </td>
    </tr>
    <tr>
        <td valign="top">
            <?php echo FOOTER_TEXT ?> :
        </td>
        <td>
            <textarea style="width:100%;height:70px" id="txtFooter" name="txtFooter"><?php echo util::GetData("txtFooter") ?></textarea>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo SELECT_TEMP ?> :
        </td>
        <td>
            <select id="drpTemplate" name="drpTemplate" style="width:100%" onchange="ChangeTemplate()">
                <?php echo $temp_options ?>
            </select>
        </td>
    </tr>
</table>

<table style="width:850px">
    <tr style="display:none" id="trMulti">
        <td align="center">
            <table class="desc_text" id="tblMulti" >
                <tr>
                    <td><?php echo HEADER_TEXT ?> (<?php echo CAN_BE_EMPTY ?>):</td>
                    <td><input type="text" value="<?php echo util::GetData("txtGroupName") ?>"  name="txtMultiGroupName" id="txtMultiGrpName"></td>
                </tr>
                <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>                    
                    <td><?php echo ANSWER_VARIANTS ?>
                    </td>
                    <td class="desc_text"><?php echo CORRECT_ANSWER ?> </td>
                </tr>
                <?php for($i=1;$i<=$answers_count;$i++) { ?>
                <tr>
                    
                    <td>
                        <input type="text" id="txtChoise1" value="<?php echo util::GetData("txtChoise$i") ?>" name="txtMulti<?php echo $i ?>"></td>
                    <td><input <?php echo util::GetData("ans_selected$i") ?> type="checkbox" id="chkMulti<?php echo $i ?>" name="chkMulti<?php echo $i ?>" ></td>
                </tr>
                <?php } ?>
            </table>
            <table width="170px">
                <tr>

                    <td align="center"><input style="width:25px" type="button" value=" + " onclick="addRow('tblMulti','txtMulti')" />
                        <input style="width:25px" type="button" value=" - " onclick="deleteRow('tblMulti')" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="display:none" id="trOne" >
        <td align="center">
            <table id="tblOne" class="desc_text" >
                <tr>
                    <td><?php echo HEADER_TEXT ?> (<?php echo CAN_BE_EMPTY ?>):</td>
                    <td><input type="text" value="<?php echo util::GetData("txtGroupName") ?>" name="txtOneGroupName"></td>
                </tr>
                 <tr>
                    <td colspan="2"><hr></td>
                </tr>
                <tr>

                    <td><?php echo ANSWER_VARIANTS ?>
                   </td>
                    <td class="desc_text"><?php echo CORRECT_ANSWER ?> </td>
                </tr>
                <?php for($i=1;$i<=$answers_count;$i++) { ?>
                <tr>
                    <td>
                        <input type="text" id="txtChoise<?php echo $i ?>" name="txtOne<?php echo $i ?>" value="<?php echo util::GetData("txtChoise$i") ?>"></td>
                    <td><input <?php echo util::GetData("ans_selected$i") ?> type="radio" name="rdOne" value="<?php echo $i ?>"></td>
                </tr>
                <?php } ?>
            </table>
            <table width="170px">
                <tr>

                    <td align="center"><input style="width:25px" type="button" value=" + " onclick="addRow('tblOne','txtOne')" />
                        <input style="width:25px" type="button" value=" - " onclick="deleteRow('tblOne')" />
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr style="display:none" id="trArea">
        <td align="center">
            <table id="tblArea" class="desc_text">
                 <tr>
                     <td valign="top" align="right">
                         <?php echo HEADER_TEXT ?> (<?php echo CAN_BE_EMPTY ?>):
                     </td>
                    <td>
                        <input style="width:300px" type="text" value="<?php echo util::GetData("txtGroupName") ?>" name="txtAreaGroupName"></td>

                </tr>
                <tr>
                    <td valign="top" align="right">
                         <?php echo ENTER_CORRECT_ANSWER ?> (<?php echo CAN_BE_EMPTY ?>):
                     </td>
                    <td>
                        <textarea style="width:300px;height:100px" name="txtArea1"><?php echo util::GetData("txtCrctAnswer1") ?></textarea>
                    <td>
                </tr>
            </table>
        </td>
    </tr>
        <tr style="display:none" id="trMultiText">
        <td align="center">
            <table id="tblMultiText" class="desc_text">
                <tr>
                    <td><?php echo HEADER_TEXT ?> (<?php echo CAN_BE_EMPTY ?>):</td>
                    <td><input type="text" value="<?php echo util::GetData("txtGroupName") ?>" name="txtMultiTextGroupName"></td>
                </tr>
               <tr>
                    <td colspan="2"><hr></td>
                </tr>
               <tr>
                    <td><?php echo ANSWER_VARIANTS ?>
                    </td>
                    <td class="desc_text"><?php echo CORRECT_ANSWER ?> </td>
                </tr>
                <?php for($i=1;$i<=$answers_count;$i++) { ?>
                <tr>

                    <td>
                        <input type="text" id="txtChoise<?php echo $i ?>" name="txtMultiText<?php echo $i ?>" value="<?php echo util::GetData("txtChoise$i") ?>"></td>
                    <td><input type="text" id="txtText<?php echo $i ?>" name="txtMultiCrctAnswer<?php echo $i ?>" value="<?php echo util::GetData("txtCrctAnswer$i") ?>"></td>
                </tr>
                <?php } ?>
            </table>          
             <table width="320px">
                <tr>

                    <td align="center"><input style="width:25px" type="button" value=" + " onclick="addRow('tblMultiText','txtMultiText')" />
                        <input style="width:25px" type="button" value=" - " onclick="deleteRow('tblMultiText')" />
                    </td>
                </tr>
            </table>
              <table style="display:none">
                <tr>
                    <td><input type="checkbox" id="chkAllowNumbers" name="chkAllowNumbers" /><label id="lbl1" for="chkAllowNumbers">Allow users to enter only numbers</label></td>
                </tr><tr>
                    <td><input type="checkbox" id="chkDontCalc" name="chkDontCalc" /><label id="lbl1" for="chkDontCalc">Do not calculate results of this question</label></td>
                </tr>
            </table>
        </td>
    </tr>
   
    

</table>
    <br>
     <hr />
     <br>
     <table style="width:850px">
         <tr>
        <td align="center">
            <input type="submit" id="btnSave" name="btnSave" value="<?php echo SAVE ?>" style="width:150px">
            <input type="button" id="btnCancel" name="btnCancel" value="<?php echo CANCEL ?>" style="width:150px" onclick="javascript:window.location.href='?module=questions'">
        </td>
    </tr>
     </table>
<script type="text/javascript">
CKEDITOR.config.width ='740px';
</script>
    <SCRIPT language="javascript">
        ChangeTemplate();

        //var c_multi = 4;

        var counters = new Array();
        var answer_count = <?php echo $answers_count ?>;
        counters["tblMulti"] = answer_count;
        counters["tblOne"] = answer_count;
        counters["tblArea"] = answer_count;
        counters["tblMultiText"] = answer_count;

        function addRow(tableID, textboxID ) {

            counters[tableID]++;            			
                        
            var table = document.getElementById(tableID);

            var rowCount = table.rows.length;
            var row = table.insertRow(rowCount);

            var colCount = table.rows[0].cells.length;
            
            for(var i=0; i<colCount; i++) {

                var newcell = row.insertCell(i);

                newcell.innerHTML = table.rows[3].cells[i].innerHTML.replace(new RegExp("1",'g'),counters[tableID]);
                //alert(newcell.childNodes[0].type);                
				//alert(newcell.innerHTML);
               
                switch(newcell.childNodes[0].type) {
                    case "text":                            
                            newcell.childNodes[0].value = "";
                            var txtname=newcell.childNodes[0].name;
                            var newname=txtname.substr(0,txtname.length-1)+counters[tableID];
                            newcell.childNodes[0].id=newname;
                            newcell.childNodes[0].name=newname;
                            break;
                    case "checkbox":					
                            newcell.childNodes[0].checked = false;
                            newcell.childNodes[0].id="chkMulti"+counters[tableID];
                            newcell.childNodes[0].name="chkMulti"+counters[tableID];
                            break;
                    case "select-one":
                            newcell.childNodes[0].selectedIndex = 0;
                            newcell.childNodes[0].value=counters[tableID];
                            break;
                    
                }
            }
            
        }

        function deleteRow(tableID) {
            var table = document.getElementById(tableID);
            var rowCount = table.rows.length;
            if(rowCount==4)
                {
                    alert('<?php echo CANNOT_DELETE_LAST ?>');
                    return;
                }
            table.deleteRow(rowCount-1);
            counters[tableID]--;
        }

        function ChangeTemplate()
        {
            DisableAllTemplates();
            var val = document.getElementById('drpTemplate').options[document.getElementById('drpTemplate').selectedIndex].value;
            
            if(val ==0)
            {
                document.getElementById('trMulti').style.display="";
            }
            else if(val==1)
            {
                  document.getElementById('trOne').style.display="";
            }
            else if(val==3)
            {
                  document.getElementById('trArea').style.display="";
            }
            else if(val==4)
            {
                  document.getElementById('trMultiText').style.display="";
            }
        }

        function DisableAllTemplates()
        {
            document.getElementById('trMulti').style.display="none";
            document.getElementById('trOne').style.display="none";
            document.getElementById('trArea').style.display="none";
            document.getElementById('trMultiText').style.display="none";
        }

    </SCRIPT>
</form>

