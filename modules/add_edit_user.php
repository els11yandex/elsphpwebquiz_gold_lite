<?php if(!isset($RUN)) { exit(); } ?>
<?php

access::allow("1");

    $val = new validations("btnSave");
    $val->AddValidator("txtLogin", "empty", LOGIN_VAL,"");
    $val->AddValidator("txtPassword", "empty", PASSWORD_VAL,"");
    $val->AddValidator("drpUserType", "notequal", USER_TYPE_VAL , "-1");

    $selected="-1";
    $pswlbl_display="none";
    $psw_display="";
    $login_disabled="";
    $mode="add";
    $chkApproved = "checked";
    if(isset($_GET["id"]))
    {
        $pswlbl_display="";
        $psw_display="none";
        $login_disabled="read-only";
        $mode="edit";
        $id = util::GetID("?module=local_users");
        $rs_users=orm::Select("users", array(), array("UserID"=>$id), "");

        if(db::num_rows($rs_users) == 0 ) header("location:?module=local_users");

        $row_users=db::fetch($rs_users);
        $txtName = $row_users["Name"];
        $txtSurname = $row_users["Surname"];
        $txtEmail = $row_users["email"];
        $txtLogin = $row_users["UserName"];
        $selected = $row_users["user_type"];

        $txtPasswordValue="********";

	$txtAddr = $row_users["address"];
	$txtPhone = $row_users["phone"];
        $chkApproved = $row_users["approved"] == "1" ? "checked" : "";
	$chkDisabled = $row_users["disabled"] == "1" ? "checked" : "";
    }
    
    $results = orm::Select("user_types", array(), array() , "id");
    //$user_type_options = webcontrols::GetOptions($results, "id", "type_name",$selected);
    $user_type_options = webcontrols::BuildOptions($USER_TYPE, $selected);

    if(isset($_POST["btnSave"]) && $val->IsValid())
    {
        if(!isset($_GET["id"]))
        {
            orm::Insert("users", array("Name"=>trim($_POST["txtName"]),
                                    "Surname"=>trim($_POST["txtSurname"]),
                                    "UserName"=>trim($_POST["txtLogin"]),
                                     "Password"=>md5(trim($_POST["txtPassword"])),
                                     "added_date"=>util::Now(),
                                     "email"=>trim($_POST["txtEmail"]),
                                     "address"=>trim($_POST["txtAddr"]),
                                     "phone"=>trim($_POST["txtPhone"]),
  				     "approved"=>isset($_POST["chkApproved"]) ? 1:0,
				     "disabled"=>isset($_POST["chkDisabled"]) ? 1:0,
                                     "user_type"=>trim($_POST["drpUserType"])
                                   ));
        }
        else
        {
            $arr_columns=array("Name"=>trim($_POST["txtName"]),
                                    "Surname"=>trim($_POST["txtSurname"]),
                                     "email"=>trim($_POST["txtEmail"]),
				     "address"=>trim($_POST["txtAddr"]),
                                     "phone"=>trim($_POST["txtPhone"]),
  				     "approved"=>isset($_POST["chkApproved"]) ? 1:0,
				     "disabled"=>isset($_POST["chkDisabled"]) ? 1:0,
                                     "user_type"=>trim($_POST["drpUserType"])
                                   );
            if(isset($_POST["chkEdit"]))
            {
                $arr_columns["Password"]=md5(trim($_POST["txtPassword"]));
            }
            orm::Update("users", $arr_columns, array("UserID"=>$id));
        }

        header("location:?module=local_users");
    }


    if(isset($_POST["ajax"]))
    {
         $results = orm::Select("users", array(), array("UserName"=>$_POST["login_to_check"]) , "");
         $count = db::num_rows($results);
         echo $count;
    }

    function desc_func()
    {
        return ADD_EDIT_USER;
    }

?>
