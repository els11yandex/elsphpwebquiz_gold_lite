<?php if(!isset($RUN)) { exit(); } ?>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script language=javascript src='tooltip_files/tooltip.js'></script>
<script language="javascript">
    function NextQst(page,question_type, nextPriority, qst_id, finish)
    {

        if(finish=="1")
        {
            var conf = confirm('<?php echo ARE_YOU_SURE ?>');
            if(!conf) return false;
        }
        
        var qst_type = question_type;
        var post_string = "";

        if(qst_type=="0")
        {
            post_string = get_checkbox_post();
        }
        else if(qst_type=="1")
        {
            post_string = get_radio_post();
        }
        else if(qst_type=="3")
        {
            post_string = get_free_text_post();
        }
          else if(qst_type=="4")
        {
            post_string = get_text_post();
        }

         $.post(page, { ajax:"yes" , data_post: "yes", btnNext : "yes", post_data : post_string , next_priority:nextPriority, qst_type: question_type , qstID:qst_id , finish_quiz:finish },
         function(data){
             //alert(data);
             ShowData(data);
           // alert(data);
        });
    }

    function PrevQst(page,question_type, prevPriority)
    {       
         $.post(page, { ajax:"yes" , data_post: "yes", btnPrev : "yes", prev_priority:prevPriority },
         function(data){
             //document.getElementById('divQst').innerHTML=data;
             ShowData(data);
          //  alert(data);
        });
    }

    function get_checkbox_post()
    {
        var chk_values = "";        
        for(var i=0;i<document.form1.chkAns.length;i++)
        {            
            if(document.form1.chkAns[i].checked)
            {
                chk_values+=document.form1.chkAns[i].value+";|";
            }
        }        
        return chk_values;
    }

    function get_radio_post()
    {
        var rd_val = "";
        for( i = 0; i < document.form1.rdAns.length; i++ )
        {
            if( document.form1.rdAns[i].checked == true )
            rd_val = document.form1.rdAns[i].value;
        }
        
        return rd_val;
    }
//txtMultiAns
    function get_free_text_post()
    {        
        return document.getElementById('txtFreeId').value+";|"+document.getElementById('txtFree').value;
    }

    function get_text_post()
    {
        var txt_values = "";
        for(var i=0;i<document.form1.txtMultiAns.length;i++)
        {
          //  if(document.form1.txtMultiAns[i].checked)
          //  {
                txt_values+=document.form1.txtMultiAnsId[i].value+":|"+document.form1.txtMultiAns[i].value+";|";
         //   }
        }        
        return txt_values;
    }

    function ShowData(data)
    {        
        var data_arr = data.split('[{sep}]');
        data = data_arr[0];

        document.getElementById('divPager').innerHTML="<?php echo QUESTIONS ?> : "+data_arr[1];

        if(data.substring(0,6)=="error:")
        {
            data= data.substring(6,data.length);
            document.getElementById('divMsg').innerHTML="<font color=red>"+data+"</font>";
            document.getElementById('divQst').style.display="none";
            document.getElementById('divMsg').style.display="";
            document.getElementById('divTimer').style.display="none";
            document.getElementById('divPager').style.display="none";
            document.getElementById('trLine').style.display="none";
        }
        else if (data.substring(0,6)=="warni:")
        {            
            data= data.substring(6,data.length);
            document.getElementById('divMsg').innerHTML="<font color=green>"+data+"</font>";
            document.getElementById('divQst').style.display="none";
            document.getElementById('divMsg').style.display="";
            document.getElementById('divTimer').style.display="none";
            document.getElementById('divPager').style.display="none";
            document.getElementById('trLine').style.display="none";
        }
        else
        {
            document.getElementById('divQst').innerHTML=data;
            document.getElementById('divQst').style.display="";
            document.getElementById('divMsg').style.display="none";
            document.getElementById('divTimer').style.display="";
            document.getElementById('divPager').style.display="";
            document.getElementById('trLine').style.display="";
        }
    }

    function ShowQst(x,y,id,ran,qz,ao)
    {
        document.getElementById('divText').innerHTML="<?php echo PLEASE_WAIT ?> ";
        MoveObject(x,y, "tblTip");
        $.post("modules/qst_previwer.php", {qst_preview:"yes", qst_id:id, ran_:ran, qz_:qz,ao_:ao},
         function(data){
             //alert(data);             
             document.getElementById('divText').innerHTML="&nbsp;&nbsp;"+data;
           // alert(data);
        });
    }

    function LoadQst(page,question_type, priority, qst_id, finish)
    {
        document.getElementById('divText').innerHTML="<?php echo PLEASE_WAIT ?> ";
          $.post(page, { ajax:"yes" ,data_post:"yes", load_priority:priority , load_question:"yes"},
         function(data){
             //alert(data);
             ShowData(data);
             HideObject('tblTip');
           // alert(data);
        });
    }

</script>

<form method="post" name="form1">
    <div id="dvCont">
    <table align="left" width="100%" border="0" cellpadding="0" cellspacing="0">
        <tr>
            <td style="display:<?php echo $timer_display ?>" align="left">
                <div class="c_timer" align="left" id="divTimer" style="display:<?php echo $timer_display ?>">
                &nbsp;&nbsp;<?php echo TIME ?> : <label id="lblTimer"></label>
                </div>
            </td>        
            <td class="desc_text_bg2" align="right">
                <div id="divPager" style="display:<?php echo $pager_display ?>">
                    <?php echo QUESTIONS ?> : <?php echo $pager_html ?>
                </div>
            </td>                   
        </tr>
        <tr id="trLine" style="display:<?php echo $timer_display ?>">
            <td colspan="2"><hr></td>
        </tr>
        <tr>
            <td colspan="2">
                  <div align="center" id="divQst" style="display:<?php echo $app_display ?>">
                        <?php echo $qst_html ?>
                  </div>
            </td>
        </tr>
    </table>
    </div>
    &nbsp;
    <div align="center" id="divMsg" style="display:<?php echo $msg_display ?>">
        <p><label class="empty_data">&nbsp;<?php echo $msg_text ?></label></p>
    </div>    
    
</form>

<table id="tblTip" style="display:none" cellspacing="0" cellpadding="0" border=0>
  <tr>
    <td align="right" style="width:1px;height:1px;line-height:5px;"><img border="0" src="tooltip_files/t1.gif" /></td>
  </tr>
	<tr >
		<td>		
			<table width="400px" cellspacing="0" cellpadding="0" style="border:0;border-width:2;border-color:#ED7C36" border=0 >
				<tr >
					<td style="width:1px;height:1px;line-height:5px;" align=left valign=bottom ><img src="i/tool/tb_l.gif"></img></td>
					<td style="width:400px;height:1px;line-height:5px;" bgcolor="#F9DD93"></td>
					<td style="width:2px;height:1px;line-height:5px;"  align="left" ><img src="i/tool/tb_r.gif"></img></td>
				</tr>
				<tr bgcolor="#F9DD93">
					<td colspan=3 align=center>
                                            <font face="arial" size="2" color="#63665B">&nbsp;<span id="divText"></span></font>
					</td>
				</tr>
				<tr valign="top">
					<td style="width:1px;height:1px;line-height:5px;" align="left"><img src="i/tool/tb_l_b.gif"></img></td>
					<td style="width:400px;height:1px;line-height:5px;" bgcolor="#F9DD93"></td>
					<td style="width:2px;line-height:5px;" align="left" ><img src="i/tool/tb_r_b.gif"></img></td>
				</tr>
			</table>
		</td>
	</tr>	
</table>


<div  style="display:none;width:400px;-webkit-border-radius: 24px;-moz-border-radius: 24px;border-radius: 24px;background:rgba(249,221,147,0.6);-webkit-box-shadow: #B3887D 4px 4px 4px;-moz-box-shadow: #B3887D 4px 4px 4px; box-shadow: #B3887D 4px 4px 4px;"><br><br><span id="divText2"></span><br><br></div>


<script language="javascript">
        TimerRunning = false;

        function Init_Timer(quiz_time, seconds) //call the Init function when u need to start the timer
        {            
            mins = quiz_time;
            secs = seconds;
            StopTimer();
            StartTimer();
        }

        function StopTimer() {
            if (TimerRunning)
                clearTimeout(TimerID);
            TimerRunning = false;
        }

        function StartTimer() {

          //  if (document.getElementById('<%=txtTimerState.ClientID %>').value == "0")
          //   return;

            TimerRunning = true;
            document.getElementById('lblTimer').innerHTML = Pad(mins) + ":" + Pad(secs);
            TimerID = setTimeout("StartTimer()", 1000);

            Check();

            if (mins == 0 && secs == 0)
                StopTimer();

            if (secs == 0) {
                mins--;
                secs = 60;
            }
            secs--;

        }

        function Check() {
            if (mins == 5 && secs == 0) {

            }
            else if (mins == 0 && secs == 0)
            {
                alert("Time ended !");
                StopTimer();
                TimerRunning = false;
               // HideTable();
                window.location.reload(false);
            }
        }

        function Pad(number) //pads the mins/secs with a 0 if its less than 10
        {
            if (number < 10)
                number = 0 + "" + number;
            return number;
        }
</script>

<script language="JavaScript">
function onlyNumbers(evt)
{
	var e = event || evt; // for trans-browser compatibility
	var charCode = e.which || e.keyCode;

	if (charCode > 31 && (charCode < 48 || charCode > 57))
		return false;

	return true;

}
</script>

<?php echo $timer_script ?>
