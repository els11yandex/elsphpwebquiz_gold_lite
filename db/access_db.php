<?php

class access_db {
    
    public static function GetModules($txtLogin,$txtPass,$txtPassImp,$check_pass=true)
    {
        $query= "select m.*, u.UserID as user_id, u.user_type,u.password,u.Name,u.Surname,u.email, 0 as imported from users u " .
                "left join roles_rights rr on rr.role_id = u.user_type " .
                "left join modules m on m.id= rr.module_id ".
                "where u.UserName='$txtLogin' and disabled=0 and approved=1 ";
        if($check_pass==true) $query.="and Password='$txtPass' ";
        $query.=" union ";
        $query.="select m.*, u.UserID as user_id, 2 as user_type,u.password,u.Name,u.Surname,u.email, 1 as imported from v_imported_users u ".
                " left join roles_rights rr on rr.role_id = 2 ".
                " left join modules m on m.id= rr.module_id ".
                " where u.UserName='$txtLogin' ";
        if($check_pass==true) $query.=" and u.Password='$txtPassImp' ";
        $query="select * from (".$query.") m order by priority";
        return db::exec_sql($query);
    }   
    
    public static function HasAccess($txtLogin,$txtPass)
    {
        $user_id=-1;
        $results = access_db::GetModules($txtLogin, "", "", false);
        $has_result = db::num_rows($results);      
        if($has_result!=0)
        {
            $row = db::fetch($results);
            if($row['imported']=="0") $password = md5($txtPass) ;
            else $password = Imported_Users_Password_Hash(trim($_POST['txtPass']), $row['password']);

            if($password==$row['password'])
            {                
                $user_id=$row['user_id'];
            }
        }
        return $user_id;
    }

}
?>
