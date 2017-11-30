<?php 

class cmail 
{
	var $subject = "";
	var $body = "";
	public function cmail($key,$row ,$replace=true)
	{
		$results = orm::Select("email_templates", array(), array("name"=>$key), "");
		$mrow = db::fetch($results);
		$this->subject = $mrow['subject'];
		$this->body = $mrow['body'];
		
		$vars = explode(",", $mrow['vars']);
	
		if($replace) 
		{
		foreach($vars as $var) 
		{
			$rvar = str_replace("[","",trim($var));
			$rvar = str_replace("]","",$rvar);

			if(!isset($row[$rvar])) continue;

			$replace_with = isset($row[$rvar]) ? $row[$rvar] : "";
			$this->subject = str_replace($var ,$replace_with, $this->subject);
			$this->body = str_replace($var ,$replace_with, $this->body);

		}
		}
	}
}

?>
