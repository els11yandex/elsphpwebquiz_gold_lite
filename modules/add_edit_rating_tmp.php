<script language="JavaScript" type="text/javascript" src="lib/validations.js"></script>

<?php echo $val->DrowJsArrays(); ?>


    <script language="javascript">
        function ChangeColor()
        {
            var color = document.getElementById('drpColors').options[document.getElementById('drpColors').selectedIndex].value;            
            if(color=="-1")
                {
                    color="";
                }
            document.getElementById('tblColor').style.backgroundColor=color;            
        }
    </script>
<form method="post" name="form1">    
<table width="700px" cellpadding="3" cellspacing="3" border="0" align="center">
     <tr>
        <td valign="middle" class="desc_text" align="right">
           <?php echo DESCRIPTION ?> : 
        </td>
        <td class="desc_text">
            <input style="width:300px" type="text" name="txtdesc" value="<?php echo util::GetData("txtDesc") ?>" > 
        </td>
    </tr>
    <tr>
        <td valign="middle" class="desc_text" align="right">
            <?php echo SELECT_TEMP ?> :
        </td>
        <td valign="top">
            <table border="0" cellpadding="0" cellspacing="0">
                <?php 
                $i=0;
                    while($row_tmp=db::fetch($temps_res))
                    {
                        if(!isset($_GET['id'])) 
                        {
                            if($i==0) $selected_temp="checked" ; else $selected_temp="";
                        }
                        else
                        {
                            $row_tmp['id']==$temp_id ? $selected_temp="checked" : $selected_temp="";                        
                        }
                        $i++;   
                ?>
                
                    <td>
                        <input type="radio" <?php echo $selected_temp ?> name="rdtmps" value="<?php echo $row_tmp['id'] ?>">
                    </td>
                    <td>                      
                       <img src="rating_img/<?php echo $row_tmp['active_img'] ?>">                                                                                           
                    </td>
                
                <?php } ?>
            </table>
        </td>
    </tr>
    <tr>
        <td valign="middle" class="desc_text" align="right">
            <?php echo HEADER_TEXT ?>  : 
        </td>
        <td class="desc_text">
            <input style="width:300px" type="text" name="txtheader" value="<?php echo util::GetData("txtHeader") ?>" > (<?php echo CAN_BE_EMPTY ?>)                      
        </td>
    </tr>
    <tr>
        <td valign="middle" class="desc_text" align="right">
            <?php echo FOOTER_TEXT ?> : 
        </td>
        <td class="desc_text">
            <input style="width:300px" type="text" name="txtfooter" value="<?php echo util::GetData("txtFooter") ?>" > (<?php echo CAN_BE_EMPTY ?>)           
        </td>
    </tr>
    <tr>
        <td valign="middle" class="desc_text" align="right">
            <?php echo IMG_COUNT ?> : 
        </td>
        <td>
            <input style="width:50px" type="text" name="txtImgCount" value="<?php echo util::GetData("txtImgCount") ?>">            
        </td>
    </tr>
    <tr>
        <td valign="middle" class="desc_text" align="right">
            <?php echo SHOW_RESULTS ?> :
        </td>
        <td class="desc_text">                
              <select name="drpResults" style="width:250px">
                   <?php echo $result_options ?>
              </select>
        </td>
    </tr>
    <tr>
        <td valign="middle" class="desc_text" align="right">
            <?php echo USER_WAR ?> : 
        </td>
        <td class="desc_text">
            <select name="drpRest" style="width:250px">
                   <?php echo $restriction_options ?>
              </select>      
        </td>
    </tr>
     <tr>
        <td valign="middle" class="desc_text" align="right">
            <?php echo LANGUAGE ?> : 
        </td>
        <td class="desc_text">
            <select name="drpLang" style="width:250px">
                   <?php echo $language_options ?>
              </select>      
        </td>
    </tr>
      <tr>
        <td valign="middle" class="desc_text" align="right">
            <?php echo BGCOLOR ?> : 
        </td>
        <td class="desc_text"><table cellpadding="0" cellspacing="0">
                <tr><td>
            <select name="drpColors" style="width:250px" onchange="ChangeColor()">
                   <?php echo $bgcolors_options ?>
            </select>
            </td>
            <td>&nbsp;</td>
            <td><table id="tblColor" style="width:20px;height:20px"><tr><td></td></tr></table></td></tr></table>                        
                        
        </td>
    </tr>
    <tr>
        <TD COLSPAN="2" align="center"><br>
            <input style="width:150px" type="submit" id="btnSubmit" name="btnSubmit" value="<?php echo SAVE ?>" onclick="return validate()">
            <input style="width:150px" type="button" name="btnCancel" value="<?php echo CANCEL ?>" onclick="javascript:window.location.href='?module=ratings'">
        </td>
    </tr>
</table>
</form>