<?php

class validations {

    var $is_valid = true;
    var $_event;
    var $controls;
    var $modes;
    var $errmsgs;
    var $errors;
    var $values;

    var $i = 0;

    public function validations($event)
    {
        $this->_event = $event;
    }

    public function AddValidator($control_to_validate, $validation_mode, $errmsg, $value_to_compare)
    {
        $this->values[$this->i] = $value_to_compare;
        $this->controls[$this->i] = $control_to_validate;
        $this->modes[$this->i] = $validation_mode;
        $this->errmsgs[$this->i] = $errmsg;
        $this->i++;
    }

    public function Check()
    {        
        if(isset($_POST[$this->_event]))
        {
            $this->is_valid = true;            
            for($i=0;$i<count($this->controls);$i++)
            {
                switch ($this->modes[$i])
                {
                    case "empty":                        
                        if(strlen(trim($_POST[$this->controls[$i]]))==0)
                        {
                           $this->errors[$this->controls[$i]] = $this->errmsgs[$i];
                           $this->is_valid = false;
                        }
                        break ;
                    case "numeric":
                        if(!is_numeric(trim($_POST[$this->controls[$i]])))
                        {
                            $this->errors[$this->controls[$i]] = $this->errmsgs[$i];
                            $this->is_valid = false;
                        }
                        break;
                    case "notequal":
                        if(trim($_POST[$this->controls[$i]])==$this->values[$i])
                        {
                            $this->errors[$this->controls[$i]] = $this->errmsgs[$i];
                            $this->is_valid = false;
                        }
                        break;
  		    case "email":
                        if(strlen(trim($_POST[$this->controls[$i]]))==0 || validations::VerifyEmail(trim($_POST[$this->controls[$i]]))==false)
                        {
                            $this->errors[$this->controls[$i]] = $this->errmsgs[$i];
                            $this->is_valid = false;
                        }
                        break;
		    case "an":
                        if(strlen(trim($_POST[$this->controls[$i]]))==0 || validations::IsAlphanumeric(trim($_POST[$this->controls[$i]]))==false)
                        {
                            $this->errors[$this->controls[$i]] = $this->errmsgs[$i];
                            $this->is_valid = false;
                        }
                        break;

                }
            }
        }
    }

    public function IsValid()
    {
        $this->Check();
        return $this->is_valid;
    }

    public function GetMsgs()
    {
        $text = "";        
        foreach($this->errors as $key=>$value)
        {
            $text.=$value."\n";
        }
        return $text;
    }

    public function DrowJsArrays()
    {
        $js = "<script language=javascript>";
        $controls="";
        $modes="";
        $errmsgs="";
        $values="";
        for($i=0;$i<count($this->controls);$i++)
        {
            $controls.=",'".$this->controls[$i]."'";
            $modes.=",'".$this->modes[$i]."'";
            $errmsgs.=",'".$this->errmsgs[$i]."'";
            $values.=",'".$this->values[$i]."'";
        }
        $js.="var controls = new Array(".substr($controls,1).");";
        $js.="var modes = new Array(".substr($modes,1).");";
        $js.="var errmsgs = new Array(".substr($errmsgs,1).");";
        $js.="var values = new Array(".substr($values,1).");";
        $js.="</script>";
        return $js;
    }
    
    public static function VerifyEmail($email)
    {
	if (!eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email))
	{
   		return FALSE;
	}
	return true;
    }

    public static function IsAlphanumeric($inputtxt)
    {
	if (!ctype_alnum($inputtxt))
	{
   		return FALSE;
	}
	return true;
    }

}
?>
