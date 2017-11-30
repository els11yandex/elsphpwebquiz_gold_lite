<?php if(!isset($RUN)) { exit(); } ?>
<br />
<br />
<br />
<br />


<html>
    <head><META http-equiv="content-type" content="text/html; charset=utf-8">
            <link href="style/index.css" type="text/css" rel="stylesheet" />
            <title>Login</title>

    </head>
    <body bgcolor="#9B9EA5">
        <form method="post" action="login.php">

    <table align="center" border="0" style="width: 100%; height: 600px">
        <tr>
            <td>
                <table align=center  style="width:827px;height:433px;">
                    <tr>
                        <td>
                            <table cellpadding=0 cellspacing=0 align="center" width="410px">
                                <tr>
                                     <td >&nbsp;</td>
                                    <td ></td>
                                    <td </td>
                                </tr>
                                <tr bgcolor="#E7EEF8">
                                    <td bgcolor="#E7EEF8">

                                    </td>
                                    <td bgcolor="#E7EEF8" colspan=2>
                                        <table bgcolor="#E7EEF8" align="center">
                                            <tr>
                                                <td colspan="2" valign="middle">
                                                    <img src="<?php echo LOGIN_PAGE_LOGO_FILE ?>" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_txt_lt" align=right>
                                                    <?php echo LOGIN ?> :
                                                </td>
                                                <td>
                                                   <input type="text" name="txtLogin" class="login_box"  />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_txt_lt" align=right>
                                                    <?php echo PASSWORD ?> :
                                                </td>
                                                <td>
                                                    <input type="password" class="login_box" name="txtPass"  />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="main_txt_lt" align=right>
                                                    <?php echo LANGUAGE ?> :
                                                </td>
                                                <td>
                                                    <select name="drpLang" class="login_box">
                                                        <?php echo $language_options ?>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan=2 align=center><input type="submit" value="<?php echo LOG_IN ?>" name="btnSubmit" style="width:100px" /></td>
                                            </tr>
                                             <tr>
                                    <td colspan=3 align=center class="main_txt_lt"><br>
                                         <?php echo $msg ?>
                                    </td>
					
                                </tr>				
                                        </table>
                                    </td>
                                </tr>
				
                                <tr>
                                    <td >&nbsp;</td>
                                    <td ></td>
                                    <td </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
        </form>
    </body>
</html>
