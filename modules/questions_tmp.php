<?php if(!isset($RUN)) { exit(); } ?>

<script language="javascript">
function ShowPreview(ID,pageY)
{
            var sw = window.screen.width;
            var sh = window.screen.height;

            var top_position=0;

            if (navigator.appName == "Microsoft Internet Explorer")
            {
                y=document.documentElement.scrollTop ;
                mouseY=event.clientY;
                top_position=parseInt(y)+parseInt(mouseY);

            }
            else
            {
                y=window.pageYOffset;
                top_position=parseInt(pageY);
            }

            document.getElementById('test_div').style.position="absolute";
            document.getElementById('test_div').style.top=(y+220)+'px';
            document.getElementById('test_div').style.left=((sw/2)-300)+'px';

            document.getElementById('test_hr').innerHTML=document.getElementById('templateDiv').innerHTML;
            document.getElementById('test_div').style.display="";

            $.post("modules/qst_previwer.php", {  ajax: "yes", qst_id : ID, preview: "1" },
            function(data){
                 //alert(data);
                 document.getElementById('test_hr').innerHTML=data;
            });
}

function close_window()
{    
    document.getElementById('test_div').style.display="none";    
}
</script>

<div id="div_grid"><?php echo $grid_html ?></div>
    <br>
    <hr />

    <a href="?module=add_question&quiz_id=<?php echo $quiz_id ?>"><?php echo NEW_QUESTION ?></a>
    <table id="test_div" style="display: none;" bgcolor="#F9DD93" width="610px">
        <tr>
            <td colspan=2 align=right><a href="#" border="0" onclick="close_window()"><img src="style/i/close_button.gif" /></a></td>
        </tr>
        <tr>
            <td id="test_hr"  >

            </td>
        </tr>
    </table>    
     <div id="templateDiv" style="display: none;">
        <table width="610px" bgcolor="#767F86" align="center" border="0">
            <tr>
                <td align="center">
                    <font color="white" face=tahoma size="3"><b><?php echo PLEASE_WAIT ?></b></font>
                </td>
            </tr>
        </table>
    </div>
