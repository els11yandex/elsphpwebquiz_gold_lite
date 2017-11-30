<?php

class users_db {
    public static function GetUsersQuery($where="")
    {
        $sql ="select * from users u left join user_types ut on u.user_type=ut.id [{where}] order by added_date desc";
	if($where!="") $sql=str_replace("[{where}]" ,$where, $sql);

        return $sql;
    }

    public static function GetImportedUsersQuery()
    {
        $sql ="select * from v_imported_users order by name,surname";
        return $sql;
    }
	
	public static function AddPaypalUser($email,$name,$surname)
	{
		$email=db::clear($email);
		$sql= "select * from users where app_type=1 and email='".$email."'";
		$results = db::exec_sql($sql);
		if(db::num_rows($results)==0) 
		{
			if(PAYPAL_LOGIN_ONLY_PAID=="yes") return -1;
			else
			{
				users_db::AddPaidUser($email,$name,$surname);
				db::exec_sql($query);
				$results = db::exec_sql($sql);
				return db::fetch($results);
			}
		}
		else 
		{
			$query = "update users set Name='".$name."',Surname='".$surname."' where app_type=1 and email='".$email."'";
			db::exec_sql($query);
			$results = db::exec_sql($sql);
			return db::fetch($results);
		}
	}
	
	public static function AddPaidUser($email,$name="",$surname="")
	{
		$email=db::clear($email);
		$name=db::clear($name);
		$surname=db::clear($surname);
		
		$sql= "select * from users where app_type=1 and email='".$email."'";
		$results = db::exec_sql($sql);
		if(db::num_rows($results)==0) 
		{
				$sql = "INSERT into users 
(
   Password,
   Name,
   Surname,
   added_date,
   user_type,
   address,
   phone,
   approved,
   disabled,
   app_type,
   UserName,
   email
)
VALUES
(
    'pwd',
    '".$name."',
    '".$surname."',
    CURRENT_DATE(),
    2,
    '',
    '',
    1,
    0,
    1,
    '".$email."',
    '".$email."'
)";

		db::exec_sql($sql);

		}
		
	}
}
?>
