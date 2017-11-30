<?php

  /*  
		This code has been developed by Els . Email : elshanb@gmail.com    		
			
   */

  define("SQL_IP", "[mysql_host]"); // ip address of mysql database 
  define("SQL_USER", "[mysql_user]");  // username for connecting to mysql
  define("SQL_PWD","[mysql_pass]"); // password for connecting to mysql
  define("SQL_DATABASE","[mysql_db]"); // database where you have executed sql scripts

  define("WEB_SITE_URL","[url]"); // the url where you installed this script . do not delete last slash  
  define("USE_MATH", "[use_math]"); // yes , no . if you want to use math symbols , you have to enable it
  define("DEBUG_SQL","no"); // enable it , if you want to view sql queries .
  define("PAGING","[paging]");  // paging for all grids
  define("SHOW_MENU","[show_menu]"); // all = all users , registered = registered users  , nobody = menu will be disabled
  define("SHOW_MENU_ON_LOGIN_PAGE", "[show_menu_login]"); // yes , no

  define("SITE_TEMPLATE", "[template]"); // gold  , standard
  
  define("MAIL_FROM", ""); // 
  define("MAIL_CHARSET", "UTF-8");
  define("MAIL_USE_SMTP", "yes");
  define("MAIL_SERVER", ""); // only if smtp enabled
  define("MAIL_USER_NAME", ""); // only if smtp enabled
  define("MAIL_PASSWORD", ""); // only if smtp enabled
  define("MAIL_PORT", "25"); // only if smtp enabled
  
  // http://phpexamscript.net/els_odessa_content_sharing/?module=cms_cats_viewer&id=98
  define("PAYPAL_LOGIN","no"); // yes , no . If you want to enable Login with paypal , turn it to "yes"
  define("PAYPAL_SCOPE","openid email profile"); // do not change 
  define("PAYPAL_CLIENTID",""); // Client ID of Paypal application
  define("PAYPAL_SECRET",""); // Secret code of Paypal application
  define("PAYPAL_LOGIN_USE_SANDBOX","yes"); // yes , no . After testing , turn it to "no"
  define("PAYPAL_SHOW_ERROR","yes"); // yes , no . Displays error that comes from Paypal
  define("PAYPAL_LOGIN_ONLY_PAID","yes"); // yes , no . Turn it to "yes" if you want to restrict access only to paid users , and turn it to no if you want all paypal users to be able to login
  define("PAYPAL_ERROR","You need to pay before logining in");
  
  define("PAYPAL_ENABLED","no"); //  yes , no . Turn it to yes if you want to receive payments from paypal
  define("PAYPAL_SHOW_BUY_BUTTON","no"); // yes , no . Shows "Buy now" button on login page
  define("PAYPAL_SELLER_EMAIL",""); // enter your business e-mail of your paypal account
  define("PAYPAL_NOTIFY_SUCCESS_PAYMENT","no"); // yes , no . sends e-mail on success payment : but you need to configurate your mail settings
  define("PAYPAL_NOTIFY_FAIL_PAYMENT","no"); // yes , no . sends e-mail on success payment : but you need to configurate your mail settings
  define("PAYPAL_ACCEPT_AMOUNT","100"); // amount that you want to receive for the login . if amount will be less than 
  define("PAYPAL_CURRENCY","USD"); // currency in which you want to receive money
  define("PAYPAL_DATA_NAME","Quiz payment"); // service name
  define("PAYPAL_USE_SANDBOX","yes"); // yes , no . After testing , turn it to "no"

  $PAGE_HEADER_TEXT= "[header]"; //only in gold and green templates
  define("HEADER_TEXT_LINK", "[header_link]");
  $PAGE_SUB_HEADER_TEXT="[sub_header]"; //only in gold and green templates
  $PAGE_FOOTER_TEXT="[footer]"; //only in gold and green templates

  function Imported_Users_Password_Hash($entered_password,$password_from_db)
  {
      return md5($entered_password);
  }

  @session_start();

  // LANGUAGE CONFIGURATION
  
  // if you translate this script to another language , please send copy of translated file to me also : elshanb@gmail.com . Thanks :-)
  $LANGUAGES = array("english.php"=>"English","russian.php"=>"Russian","dutch.php"=>"Dutch","espanol.php"=>"Espanol");
  $DEFAULT_LANGUAGE_FILE="english.php";

  //----------------------------do not touch the code below--------------------------------
  
  if(isset($_SESSION['lang_file']))
  {
      $DEFAULT_LANGUAGE_FILE = $_SESSION['lang_file'];
  }
  
  if(isset($_GET['lang']))
  {
      $lang_arr = util::translate_array($LANGUAGES);
      if(isset($lang_arr[$_GET['lang']])) $DEFAULT_LANGUAGE_FILE = $lang_arr[$_GET['lang']];
  }

  require "lang/".$DEFAULT_LANGUAGE_FILE;

  ini_set ('magic_quotes_gpc', 0);
  ini_set ('magic_quotes_runtime', 0);
  ini_set ('magic_quotes_sybase', 0);
  ini_set('session.bug_compat_42',0);
  ini_set('session.bug_compat_warn',0);  
  
  error_reporting(E_ERROR);
  
  //----------------------------------------------------------------------
  
  
  /*
  
		Visit our web site for documentation and for other versions 
		
		http://aspnetpower.com/elsphpwebquiz/index.php?module=online_demo
		http://phpexamscript.net
  
  
  */
  
?>
