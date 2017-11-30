<?php
class access
{
    public static function allow($user_type)
    {
	if(!isset($_SESSION['user_type'])) header("location:login.php");
        
        $user_types_arr = explode(",",$user_type);
        $found = false;                
        for($i=0;$i<count($user_types_arr);$i++)
        {
          //  echo $user_types_arr[$i];
            if($user_types_arr[$i]==$_SESSION['user_type'])
            {    
                $found = true;
                break;
            }
        }
        
        if(!$found)
        {
            header("location:login.php");
			exit();
        }        
    }
}
?>
