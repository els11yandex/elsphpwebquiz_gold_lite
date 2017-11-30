<?php if(!isset($RUN)) { exit(); } ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Quizzes and Surveys</title>
<meta http-equiv="Content-Language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script language ="javascript" src="jquery.js"></script>
<script language ="javascript" src="extgrid.js"></script>
<script src="cms.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="style/index_gold.css" media="screen" />
<link rel="stylesheet" type="text/css" href="style/grid.css" />
</head>
<body>

    <script language="javascript">

         window.onscroll = function()
         {
            MoveLoadingMessage("loadingDiv");
         }

         jQuery.ajaxSetup({
            beforeSend: function() {            
            $('#loadingDiv').show()
         },
            complete: function(){
            $('#loadingDiv').hide()
         },
            success: function() {}
         });
         
        </script>
        
              <table style="display:none" id="loadingDiv" style="position: absolute; left: 10px; top: 10px">
                    <tr>
                        <td>
                            <table>
                                <tr>
                                    <td bgcolor="red">
                                        <font color="white" size="3"><b>&nbsp;<?php echo PLEASE_WAIT ?>&nbsp;</b></font>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
               </table>

	<script language="javascript">
            MoveLoadingMessage("loadingDiv");
        </script>


<div id="wrap" >

<div id="header">
<h1><a href="<?php echo HEADER_TEXT_LINK ?>"><?php echo $PAGE_HEADER_TEXT ?></a></h1>
<h2><?php echo $PAGE_SUB_HEADER_TEXT ?></h2>
</div>

<div id="menu">
<ul>
<?php 
if(SHOW_MENU=="all" || (SHOW_MENU=="registered" && $autorized==true)) {
while($row = db::fetch($menus)) {
$pagename = $row['id'] !="100000" ? $row['page_name'] : "<font color=blue>".$row['page_name']."</font>";
echo "<li><a href='?module=show_page&id=".$row['id']."'>".$pagename."</a></li>";
} } ?>
</ul>
</div>

<div id="content">
<div class="right"> 
<div align=right><a border=0 href="logout.php"><img border=0 src="style/i/logout.gif" /></a></div>
<h2><?php echo desc_func() ?></h2><hr /><br>
<?php
	include "modules/".$module_name."_tmp.php";
?>
</div>

<div class="left"> 

<?php
if($expand == true) {
for($z=0;$z<sizeof($main_modules);$z++)
{
?>
<h2><?php echo isset($MODULES[$main_modules[$z]['module_name']]) ? $MODULES[$main_modules[$z]['module_name']] : $main_modules[$z]['module_name'] ?></h2>
<ul>
<?php for($y=0;$y<sizeof($child_modules[$main_modules[$z]['id']]);$y++) {
$file_name = $child_modules[$main_modules[$z]['id']][$y]["file_name"];
$child_menu = isset($MODULES[$child_modules[$main_modules[$z]['id']][$y]["module_name"]]) ? $MODULES[$child_modules[$main_modules[$z]['id']][$y]["module_name"]] : $child_modules[$main_modules[$z]['id']][$y]["module_name"];
echo "<li><a href='index.php?module=$file_name'>".$child_menu."</a></li> ";
 } ?>
</ul>
<?php } }?>

</div>

<div style="clear: both;"> </div>

</div>

<div id="bottom"> </div>
<div id="footer">
<?php echo $PAGE_FOOTER_TEXT ?>
</div>

</div>



</body>
</html>
