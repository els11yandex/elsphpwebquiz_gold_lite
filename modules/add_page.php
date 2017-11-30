<?php if(!isset($RUN)) { exit(); } ?>
<?php 


    access::allow("1");

    $txtPagecontent="";
    $txtName="";
    $txtPriority="";

    $val = new validations("btnSubmit");
    $val->AddValidator("txtName", "empty", MENU_NAME_VAL,"");
    $val->AddValidator("txtPriority", "numeric", MENU_PRIORITY_VAL,"");
    $val->AddValidator("txtPriority", "empty", MENU_PRIORITY_E_VAL,"");

    if(isset($_GET["id"]))
    {
		if($_GET["id"]=="100000")  header("location:?module=cms");
        $id = util::GetID("?module=cms");
        $res=orm::Select("pages", array(), array("id"=>$id), "");
        
        if(db::num_rows($res) == 0 ) header("location:?module=cms");

        $row=db::fetch($res);
        $txtName = $row["page_name"];
        $txtPagecontent = $row["page_content"]; 
	$txtPriority = $row["priority"]; 
    }


    if(isset($_POST["btnSubmit"]) && $val->IsValid())
    {
	if(!isset($_GET["id"]))
        {
	 	orm::Insert("pages", array(
                                "page_name"=>$_POST["txtName"],
				"priority"=>trim($_POST["txtPriority"])=="" ? 0 : trim($_POST["txtPriority"]),
                                "page_content"=>$_POST["editor1"]
                                ));
	}
        else 
        {
 		orm::Update("pages", array(
                                "page_name"=>$_POST["txtName"],
                                "priority"=>trim($_POST["txtPriority"])=="" ? 0 : trim($_POST["txtPriority"]),
                                "page_content"=>$_POST["editor1"]
                                ), 
				array("id"=>$id)				
				);	
    	}	
	header("location:?module=cms");
    }


    include_once "ckeditor/ckeditor.php";     
    $CKEditor = new CKEditor();
    $CKEditor->config['filebrowserBrowseUrl']='ckeditor/kcfinder/browse.php?type=files';
    $CKEditor->config['filebrowserImageBrowseUrl']='ckeditor/kcfinder/browse.php?type=images';
    $CKEditor->config['filebrowserFlashBrowseUrl']='ckeditor/kcfinder/browse.php?type=flash';
    $CKEditor->basePath = 'ckeditor/';

function desc_func() { return ADD_PAGE;}

?>
