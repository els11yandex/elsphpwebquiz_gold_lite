<?php 

require "../lib/util.php";

	$view_access=false;
	$procedure_access=false;
	$connected = true;
	
	$website_url = str_replace("install/install.php","",util::GetCurrentUrl());	

	if(isset($_POST['install'])) 
	{
		$formstr = $_POST['formstr'];								
		$perfs = explode("&", $formstr);	
		$posted = array();		

		foreach($perfs as $perf) 
		{
			$perf_key_values = explode("=", $perf);
			$key = urldecode($perf_key_values[0]);
			$value = urldecode($perf_key_values[1]);	
			$posted[$key]=$value;			
		}
	

		if (!function_exists('mysqli_connect')) {
  			echo "Mysqli library has not been installed on your server . Please, ask service provider to install it \n";
		}  
		else
		{
			
			$link=@mysqli_connect($posted['txtHost'],$posted['txtUser'],$posted['txtPass'],$posted['txtDB']) or databaseerror();						
			@mysqli_close($link);
		}
		
		if($connected==true) // && $writeable==true
		{
		check_privilegies();

		if($view_access==false)
		{
			echo "You don't have access for creating views . Please, ask your service provider to give access for creating views \n";
		}

		if($procedure_access==false)
		{
			echo "You don't have access for creating stored procedures . Please, ask your service provider to give access for creating stored procedures \n";
		}

                $installation_type = $posted['inpt1'];
		$res = execute_database_scripts($installation_type);
		
		setup_config_file($posted);						
				
		
		echo "1";

		}
		

		exit();
	}

function setup_config_file($posted)
{
	$url = $posted['txtURL'];
	if (substr(rtrim($url), -1) != '/')
	{
		$url=$url."/";
	}
	$file_content = file_get_contents("config_install.php");
	$file_content = str_replace("[mysql_host]", trim($posted['txtHost']), $file_content);
	$file_content = str_replace("[mysql_user]", trim($posted['txtUser']), $file_content);
	$file_content = str_replace("[mysql_pass]", trim($posted['txtPass']), $file_content);
	$file_content = str_replace("[mysql_db]", trim($posted['txtDB']), $file_content);
	$file_content = str_replace("[url]", trim($url), $file_content);
	$file_content = str_replace("[use_math]", trim($posted['rdMath']), $file_content);
	$file_content = str_replace("[paging]", trim($posted['txtPaging']), $file_content);
	$file_content = str_replace("[show_menu]", trim($posted['rdShowmenu']), $file_content);
	$file_content = str_replace("[show_menu_login]", trim($posted['rdMenulogin']), $file_content);
	$file_content = str_replace("[template]", trim($posted['rdTemp']), $file_content);
	$file_content = str_replace("[header]", trim($posted['txtHeader']), $file_content);
	$file_content = str_replace("[header_link]", trim($url), $file_content);
	$file_content = str_replace("[sub_header]", trim($posted['txtSubHeader']), $file_content);
	$file_content = str_replace("[footer]", trim($posted['txtFooter']), $file_content);

	@session_start();

	$_SESSION['fcontent']=$file_content;
	


}

function execute_database_scripts($installation_type)
{
global $posted;
global $mylink;
$mylink=mysqli_connect($posted['txtHost'],$posted['txtUser'],$posted['txtPass'],$posted['txtDB']);

if($installation_type=="1")
{
    runfile("tables_and_data.sql");
    runfilep("procedures.sql");
}
else
{
    runfile("removing_from_free_to_gold1.2.sql");
}

$query = "insert into pages (id,page_name,page_content,priority) values (100000,'".base64_decode('QnJpbGxpYW50IHZlcnNpb24=')."','".addslashes(base64_decode('PGgyPg0KCVRoaXMgc29mdHdhcmUgaGFzIGJlZW4gZGV2ZWxvcGVkIGJ5Jm5ic3A7IDxhIGhyZWY9Imh0dHA6Ly9waHBleGFtc2NyaXB0Lm5ldCI+UGhwRXhhbVNjcmlwdC5uZXQ8L2E+PC9oMj4NCjxwPg0KCSZuYnNwOzwvcD4NCjxociAvPg0KPGgzPg0KCSZuYnNwOzwvaDM+DQo8aDM+DQoJPGEgaHJlZj0iaHR0cDovL3BocGV4YW1zY3JpcHQubmV0Lz9tb2R1bGU9b25saW5lX2RlbW8iPjxmb250IGNvbG9yPSJibHVlIj5EZW1vIG9mIEJyaWxsaWFudCB2ZXJzaW9uPC9mb250PjwvYT48L2gzPg0KPHA+DQoJJm5ic3A7PC9wPg0KPGgzPg0KCTxhIGhyZWY9Imh0dHA6Ly9waHBleGFtc2NyaXB0Lm5ldC8/bW9kdWxlPWZlYXR1cmVzIj48Zm9udCBjb2xvcj0iYmx1ZSI+VGhlIGxpc3Qgb2YgZmVhdHVyZXM8L2ZvbnQ+PC9hPjwvaDM+DQo8cD4NCgkmbmJzcDs8L3A+DQo8aDM+DQoJPGEgaHJlZj0iaHR0cDovL3BocGV4YW1zY3JpcHQubmV0Lz9tb2R1bGU9cHJpY2VzIj48Zm9udCBjb2xvcj0iYmx1ZSI+UHJpY2VzPC9mb250PjwvYT48L2gzPg0KPHA+DQoJJm5ic3A7PC9wPg=='))."',100000) ";
		
//mysqli_query($mylink,$query);

mysqli_close($mylink);
return true;
}

function databaseerror()
{
	global $connected;
	$connected = false;
	echo "Cannot connect to mysql database . \n";
	
}

function check_privilegies()
{
global $view_access,$procedure_access,$posted;
$link = @mysqli_connect($posted['txtHost'],$posted['txtUser'],$posted['txtPass'],$posted['txtDB']) ;

$results = mysqli_query($link,"SHOW PRIVILEGES");

while($row=mysqli_fetch_array($results))
{
	if($row['Privilege']=="Create view")
	{
		$view_access = true;
	}
	else if($row['Privilege']=="Create routine")
	{
		$procedure_access =true;
	}
}

@mysqli_close($link);
}

function runfile($file)
{
global $mylink;
$file_content = file($file);
$query = "";
foreach($file_content as $sql_line){
if(trim($sql_line) != "" && strpos($sql_line, "--") === false){
 $query .= $sql_line;
 if (substr(rtrim($query), -1) == ';'){
 //  echo $query;
   $result = mysqli_query($mylink,$query)or die(mysqli_error($mylink));
   $query = "";
  }
 }
}
}

function runfilep($file)
{
global $mylink;
	$file_content = file_get_contents($file);

	$queries = explode("$$", $file_content);
	foreach($queries as $query)
	{
		if(trim($query)=="") continue ;

		$pos = strpos($query,"DELIMITER");
		if($pos!== false) continue;
		//echo $query."<br><br><br>";
		$result = mysqli_query($mylink,$query)or die(mysqli_error($mylink));

	} 
}


?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Quizzes and Surveys</title>
<meta http-equiv="Content-Language" content="English" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script language ="javascript" src="../jquery.js"></script>
<script language ="javascript" src="../extgrid.js"></script>
<script src="cms.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="../style/login_gold.css" media="screen" />

<script language="javascript">
function install()
{

	document.getElementById('btnInstall').disabled="disabled";
	var str = $("form").serialize();	

	 $.post("install.php", { formstr : str , install : 1 },
         function(data){       
	    if(data!="1")
	    {     
            	alert(data);
	    	document.getElementById('btnInstall').disabled="";
	    }
	    else
	    {
		window.location.href="installed.php"; 
            }
        });
}
function ShowBackupMsg(inst_type)
{
    if(inst_type=="1")
    {
         document.getElementById('backupmsg').style.display="none";
    }
    else
        {
            document.getElementById('backupmsg').style.display="";
        }
}
</script>

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
                                        <font color="white" size="3"><b>&nbsp;Please, wait&nbsp;</b></font>
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
<h1><a href="#">Quizzes and Surveys</a></h1>
<h2>Web based quiz software allowing to create quizzes and surveys</h2>
</div>

<div id="menu">
<ul>

</ul>
</div>

<?php 
$yes = "<font color=green>yes</font>";
$no = "<font color=green>no</font>";
$writable = false;
if (is_writable("config.php")) 
{
	$writable = true;
}

?>

<div id="content">
<div  align=center> <br /><br />
   <form method="post" >

	<table style="width:500px">
		<tr>
			<td colspan=2><font size=3>Installation</font><hr /><br /> </td>
		</tr>
		<tr style="display:none">
			<td>Config file writable : </td>
			<td><?php echo $writable == true ?  $yes :  $no ;?></td>
		</tr>
		<tr>
			<td align=right>MYSQL Host : </td>
			<td><input type=text name=txtHost id=txtHost /></td>
		</tr>
		<tr>
			<td align=right>MYSQL User : </td>
			<td><input type=text name=txtUser id=txtUser /></td>
		</tr>
		<tr>
			<td align=right>MYSQL Password : </td>
			<td><input type=text name=txtPass id=txtPass /></td>
		</tr>
		<tr>
			<td align=right>MYSQL Database : </td>
			<td><input type=text name=txtDB id=txtDB /></td>
		</tr>
                <tr>
			<td align=right>Installation type : </td>
                        <td><input type="radio" name="inpt1" onclick="ShowBackupMsg(1)"  value="1" checked></input>New installation                        
                        </td>
		</tr>
		<tr>
			<td colspan=2><br /><hr /><br /> </td>
		</tr>
		<tr>
			<td align=right>Are you going to use Mathematic symbols ? : </td>
			<td><input type=radio name=rdMath value="yes" />Yes
				<input type=radio name=rdMath checked value="no" />No
			</td>
		</tr>
		<tr>
			<td align=right>Grid page size : </td>
			<td><input type=text name=txtPaging id=txtPaging value="30" /></td>
		</tr>
<tr>
			<td colspan=2><br /><hr /></td>
		</tr>
		<tr>
			<td align=right>Show menu : </td>
			<td><input type=radio name=rdShowmenu checked value="registered" />Only to registered users<br>
				<input type=radio name=rdShowmenu value="all" />To all<br>
				<input type=radio name=rdShowmenu value="nobody" />Do not show menu to anybody
			</td>
		</tr>
<tr>
			<td align=right>Show menu on Login page : </td>
			<td><input type=radio name=rdMenulogin value="yes" />Yes
				<input type=radio name=rdMenulogin checked value="no" />No
			</td>
		</tr>


		</tr>
<tr>
			<td align=right>Web site template : </td>
			<td><input type=radio name=rdTemp checked  value="gold" />Gold
				<input type=radio name=rdTemp value="standard" />Standard
			</td>
		</tr>

<tr>
			<td colspan=2><br /><hr /><br /> </td>
		</tr>
<tr>
			<td align=right>Your web site URL : </td>
			<td><input type=text name=txtURL id=txtURL value="<?php echo $website_url  ?>" /></td>
		</tr>
<tr>
			<td align=right>Page header text (only if gold template selected) : </td>
			<td><input type=text name=txtHeader id=txtHeader value="Quizzes and Surveys" /></td>
		</tr>
<tr>
			<td align=right>Page sub header text (only if gold template selected) : </td>
			<td><input type=text name=txtSubHeader id=txtSubHeader value="Web based quiz software allowing to create quizzes and surveys" /></td>
		</tr>
<tr>
			<td align=right>Page footer text (only if gold template selected) : </td>
			<td><input type=text name=txtFooter id=txtFooter value="Contact mail : " /></td>
		</tr>
<tr>
			<td colspan=2><br /><hr /><br /> </td>
			<tr>
				<td colspan=2 align=center>
					<font face=tahoma size=2 color=red>If you want users to be able to login with Paypal account , or if you want to receive payments via Paypal - <a target='_blank' href='http://phpexamscript.net/php_exam_script_forum/index.php?board=3.0'> Read here </a></font>
				</td>				
			</tr>
		
			
			<td colspan=2><br /><hr /><br /> </td>
			
		</tr>

		<tr><td colspan=2 align=center><input onclick="install()" type=button name=btnInstall id=btnInstall value="Install" style="width:150px"></td></tr>
	</table>

     </form>
	 
	 <br>
	 <br>
	 <br>
	 <hr />
	 <br>
	 <br>
	 <br>
	 
	 <div style="display:none" align=center style='width:400px'>
		<font face=tahoma color=green size=2>
		Say, "He is Allah , [who is] One,<br />
		Allah , the Eternal, Absolute. <br />
		He neither begets nor is born, <br />
		Nor is there to Him any equivalent." <br /> (112 - Al-'Ikhlas)
		</font>
	 </div>
	 
</div>

<div class="left"> 



</div>

<div style="clear: both;"> </div>

</div>

<div id="bottom"> </div>
<div id="footer">
Created by <a href="http://phpexamscript.net">PhpExamScript.net</a>
</div>

</div>

</body>
</html>
