<?php

    class webcontrols
    {
        public static function GetOptions($results, $key,$text,$selected)
        {
            $options = "<option value=-1>".NOT_SELECTED."</option>";
            while($row=db::fetch($results))
            {
                $selected_text = "";
                if($selected==$row[$key])
                {
                    $selected_text="selected";
                }                
                $options.= "<option $selected_text value=\"$row[$key]\">$row[$text]</option>";
            }
            return $options;
        }

        public static function BuildOptions($options_arr,$selected)
        {
            $options = "";            
            foreach($options_arr as $key=>$value)
            {
                $selected_text = "";
                if($selected==$key)
                {
                    $selected_text="selected";
                }
                $options.= "<option $selected_text value=\"$key\">$value</option>";
            }

            return $options;
        }
        
        public static function BuildOptionsByValue($options_arr,$selected)
        {
            $options = "";            
            foreach($options_arr as $key=>$value)
            {
                $selected_text = "";
                if($selected==$value)
                {
                    $selected_text="selected";
                }
                $options.= "<option $selected_text value=\"$value\">$value</option>";
            }

            return $options;
        }

         public static function GetDropDown($drpID,$results, $key,$text,$selected)
        {
            $dropdown = "<select id=$drpID name=$drpID >";
            $options = "<option value=-1>".NOT_SELECTED."</option>";
            while($row=db::fetch($results))
            {
                $selected_text = "";
                if($selected==$row[$key])
                {
                    $selected_text="selected";
                }
                $options.= "<option $selected_text value=\"$row[$key]\">$row[$text]</option>";
            }
            $dropdown = $dropdown.$options."</select>";
            return $dropdown;
        }
    }

?>
