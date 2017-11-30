<?php

@session_start();

  $_SESSION['txtLogin'] = null;
  $_SESSION['txtPass'] = null;
  $_SESSION['txtPassImp'] = null;
  $_SESSION['user_id'] = null;

  header("location:login.php");

?>
