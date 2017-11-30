<?php
	
    class util
    {
        public static function Now()
        {
            return date('Y-m-d H:i:s');
        }

        public static function GetID($invalid_location)
        {
            if(!is_numeric($_GET["id"]))
            {
                header("Location: $invalid_location");
            }
            return $_GET["id"];
        }
		
		   public static function GetCurrentUrl()
        {
             $pageURL = 'http';
             if(isset($_SERVER["HTTPS"]))
             {
             if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
             $pageURL .= "://";
             }
             if ($_SERVER["SERVER_PORT"] != "80") {
              $pageURL .= '://'.$_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
             } else {
              $pageURL .= '://'.$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
             }
             return $pageURL;
        }

        public static function GetKeyID($key,$invalid_location)
        {
            if(!isset($_GET[$key])) header("Location: $invalid_location");
                        
            if(!is_numeric($_GET[$key]))
            {
                header("Location: $invalid_location");
            }
            return $_GET[$key];
        }

        public static function GetData($control_id)
        {
            return htmlspecialchars(util::GetHtmlData($control_id));
        }

        public static function GetHtmlData($control_id)
        {
            global $$control_id;
            if(!isset($$control_id))
            {
                return "";
            }
            else
            {
                return $$control_id;
            }

        }
        
        public static function translate_array($arr)
        {
            $tarr ;
            foreach($arr as $key=>$value)
            {      
                $tarr[$value] = $key;
            }
            return $tarr;
        }

	public static function GUID()
	{
    		if (function_exists('com_create_guid') === true)
    		{
        		return trim(com_create_guid(), '{}');
    		}

   	 	return sprintf('%04X%04X-%04X-%04X-%04X-%04X%04X%04X', mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), 	mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
	}
		

       public static function getFormattedSQL($sql_raw)
        {
         if( empty($sql_raw) || !is_string($sql_raw) )
         {
          return false;
         }

         $sql_reserved_all = array (
             'ACCESSIBLE', 'ACTION', 'ADD', 'AFTER', 'AGAINST', 'AGGREGATE', 'ALGORITHM', 'ALL', 'ALTER', 'ANALYSE', 'ANALYZE', 'AND', 'AS', 'ASC',
             'AUTOCOMMIT', 'AUTO_INCREMENT', 'AVG_ROW_LENGTH', 'BACKUP', 'BEGIN', 'BETWEEN', 'BINLOG', 'BOTH', 'BY', 'CASCADE', 'CASE', 'CHANGE', 'CHANGED',
             'CHARSET', 'CHECK', 'CHECKSUM', 'COLLATE', 'COLLATION', 'COLUMN', 'COLUMNS', 'COMMENT', 'COMMIT', 'COMMITTED', 'COMPRESSED', 'CONCURRENT',
             'CONSTRAINT', 'CONTAINS', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_TIMESTAMP', 'DATABASE', 'DATABASES', 'DAY', 'DAY_HOUR', 'DAY_MINUTE',
             'DAY_SECOND', 'DEFINER', 'DELAYED', 'DELAY_KEY_WRITE', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV',
             'DO', 'DROP', 'DUMPFILE', 'DUPLICATE', 'DYNAMIC', 'ELSE', 'ENCLOSED', 'END', 'ENGINE', 'ENGINES', 'ESCAPE', 'ESCAPED', 'EVENTS', 'EXECUTE',
             'EXISTS', 'EXPLAIN', 'EXTENDED', 'FAST', 'FIELDS', 'FILE', 'FIRST', 'FIXED', 'FLUSH', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULL', 'FULLTEXT',
             'FUNCTION', 'GEMINI', 'GEMINI_SPIN_RETRIES', 'GLOBAL', 'GRANT', 'GRANTS', 'GROUP', 'HAVING', 'HEAP', 'HIGH_PRIORITY', 'HOSTS', 'HOUR', 'HOUR_MINUTE',
             'HOUR_SECOND', 'IDENTIFIED', 'IF', 'IGNORE', 'IN', 'INDEX', 'INDEXES', 'INFILE', 'INNER', 'INSERT', 'INSERT_ID', 'INSERT_METHOD', 'INTERVAL',
             'INTO', 'INVOKER', 'IS', 'ISOLATION', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LAST_INSERT_ID', 'LEADING', 'LEFT', 'LEVEL', 'LIKE', 'LIMIT', 'LINEAR',
             'LINES', 'LOAD', 'LOCAL', 'LOCK', 'LOCKS', 'LOGS', 'LOW_PRIORITY', 'MARIA', 'MASTER', 'MASTER_CONNECT_RETRY', 'MASTER_HOST', 'MASTER_LOG_FILE',
             'MASTER_LOG_POS', 'MASTER_PASSWORD', 'MASTER_PORT', 'MASTER_USER', 'MATCH', 'MAX_CONNECTIONS_PER_HOUR', 'MAX_QUERIES_PER_HOUR',
             'MAX_ROWS', 'MAX_UPDATES_PER_HOUR', 'MAX_USER_CONNECTIONS', 'MEDIUM', 'MERGE', 'MINUTE', 'MINUTE_SECOND', 'MIN_ROWS', 'MODE', 'MODIFY',
             'MONTH', 'MRG_MYISAM', 'MYISAM', 'NAMES', 'NATURAL', 'NOT', 'NULL', 'OFFSET', 'ON', 'OPEN', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR',
             'ORDER', 'OUTER', 'OUTFILE', 'PACK_KEYS', 'PAGE', 'PARTIAL', 'PARTITION', 'PARTITIONS', 'PASSWORD', 'PRIMARY', 'PRIVILEGES', 'PROCEDURE',
             'PROCESS', 'PROCESSLIST', 'PURGE', 'QUICK', 'RAID0', 'RAID_CHUNKS', 'RAID_CHUNKSIZE', 'RAID_TYPE', 'RANGE', 'READ', 'READ_ONLY',
             'READ_WRITE', 'REFERENCES', 'REGEXP', 'RELOAD', 'RENAME', 'REPAIR', 'REPEATABLE', 'REPLACE', 'REPLICATION', 'RESET', 'RESTORE', 'RESTRICT',
             'RETURN', 'RETURNS', 'REVOKE', 'RIGHT', 'RLIKE', 'ROLLBACK', 'ROW', 'ROWS', 'ROW_FORMAT', 'SECOND', 'SECURITY', 'SELECT', 'SEPARATOR',
             'SERIALIZABLE', 'SESSION', 'SET', 'SHARE', 'SHOW', 'SHUTDOWN', 'SLAVE', 'SONAME', 'SOUNDS', 'SQL', 'SQL_AUTO_IS_NULL', 'SQL_BIG_RESULT',
             'SQL_BIG_SELECTS', 'SQL_BIG_TABLES', 'SQL_BUFFER_RESULT', 'SQL_CACHE', 'SQL_CALC_FOUND_ROWS', 'SQL_LOG_BIN', 'SQL_LOG_OFF',
             'SQL_LOG_UPDATE', 'SQL_LOW_PRIORITY_UPDATES', 'SQL_MAX_JOIN_SIZE', 'SQL_NO_CACHE', 'SQL_QUOTE_SHOW_CREATE', 'SQL_SAFE_UPDATES',
             'SQL_SELECT_LIMIT', 'SQL_SLAVE_SKIP_COUNTER', 'SQL_SMALL_RESULT', 'SQL_WARNINGS', 'START', 'STARTING', 'STATUS', 'STOP', 'STORAGE',
             'STRAIGHT_JOIN', 'STRING', 'STRIPED', 'SUPER', 'TABLE', 'TABLES', 'TEMPORARY', 'TERMINATED', 'THEN', 'TO', 'TRAILING', 'TRANSACTIONAL',
             'TRUNCATE', 'TYPE', 'TYPES', 'UNCOMMITTED', 'UNION', 'UNIQUE', 'UNLOCK', 'UPDATE', 'USAGE', 'USE', 'USING', 'VALUES', 'VARIABLES',
             'VIEW', 'WHEN', 'WHERE', 'WITH', 'WORK', 'WRITE', 'XOR', 'YEAR_MONTH'
         );

         $sql_skip_reserved_words = array('AS', 'ON', 'USING');
         $sql_special_reserved_words = array('(', ')');

         $sql_raw = str_replace("\n", " ", $sql_raw);

         $sql_formatted = "";

         $prev_word = "";
         $word = "";

         for( $i=0, $j = strlen($sql_raw); $i < $j; $i++ )
         {
          $word .= $sql_raw[$i];

          $word_trimmed = trim($word);

          if($sql_raw[$i] == " " || in_array($sql_raw[$i], $sql_special_reserved_words))
          {
           $word_trimmed = trim($word);

           $trimmed_special = false;

           if( in_array($sql_raw[$i], $sql_special_reserved_words) )
           {
            $word_trimmed = substr($word_trimmed, 0, -1);
            $trimmed_special = true;
           }

           $word_trimmed = strtoupper($word_trimmed);

           if( in_array($word_trimmed, $sql_reserved_all) && !in_array($word_trimmed, $sql_skip_reserved_words) )
           {
            if(in_array($prev_word, $sql_reserved_all))
            {
             $sql_formatted .= '<b>'.strtoupper(trim($word)).'</b>'.'&nbsp;';
            }
            else
            {
             $sql_formatted .= '<br/>&nbsp;';
             $sql_formatted .= '<b>'.strtoupper(trim($word)).'</b>'.'&nbsp;';
            }

            $prev_word = $word_trimmed;
            $word = "";
           }
           else
           {
            $sql_formatted .= trim($word).'&nbsp;';

            $prev_word = $word_trimmed;
            $word = "";
           }
          }
         }

         $sql_formatted .= trim($word);

         return $sql_formatted;
        }

       
    
    
    public static function GetColors()
    {
        $colors = array("-1"=>"Default color","AliceBlue"=>"AliceBlue",
"AntiqueWhite"=>"AntiqueWhite",
"Aqua"=>"Aqua",
"Aquamarine"=>"Aquamarine",
"Azure"=>"Azure",
"Beige"=>"Beige",
"Bisque"=>"Bisque",
"Black"=>"Black",
"BlanchedAlmond"=>"BlanchedAlmond",
"Blue"=>"Blue",
"BlueViolet"=>"BlueViolet",
"Brown"=>"Brown",
"BurlyWood"=>"BurlyWood",
"CadetBlue"=>"CadetBlue",
"Chartreuse"=>"Chartreuse",
"Chocolate"=>"Chocolate",
"Coral"=>"Coral",
"CornflowerBlue"=>"CornflowerBlue",
"Cornsilk"=>"Cornsilk",
"Crimson"=>"Crimson",
"Cyan"=>"Cyan",
"DarkBlue"=>"DarkBlue",
"DarkCyan"=>"DarkCyan",
"DarkGoldenRod"=>"DarkGoldenRod",
"DarkGray"=>"DarkGray",
"DarkGreen"=>"DarkGreen",
"DarkKhaki"=>"DarkKhaki",
"DarkMagenta"=>"DarkMagenta",
"DarkOliveGreen"=>"DarkOliveGreen",
"Darkorange"=>"Darkorange",
"DarkOrchid"=>"DarkOrchid",
"DarkRed"=>"DarkRed",
"DarkSalmon"=>"DarkSalmon",
"DarkSeaGreen"=>"DarkSeaGreen",
"DarkSlateBlue"=>"DarkSlateBlue",
"DarkSlateGray"=>"DarkSlateGray",
"DarkTurquoise"=>"DarkTurquoise",
"DarkViolet"=>"DarkViolet",
"DeepPink"=>"DeepPink",
"DeepSkyBlue"=>"DeepSkyBlue",
"DimGray"=>"DimGray",
"DodgerBlue"=>"DodgerBlue",
"FireBrick"=>"FireBrick",
"FloralWhite"=>"FloralWhite",
"ForestGreen"=>"ForestGreen",
"Fuchsia"=>"Fuchsia",
"Gainsboro"=>"Gainsboro",
"GhostWhite"=>"GhostWhite",
"Gold"=>"Gold",
"GoldenRod"=>"GoldenRod",
"Gray"=>"Gray",
"Green"=>"Green",
"GreenYellow"=>"GreenYellow",
"HoneyDew"=>"HoneyDew",
"HotPink"=>"HotPink",
"Ivory"=>"Ivory",
"Khaki"=>"Khaki",
"Lavender"=>"Lavender",
"LavenderBlush"=>"LavenderBlush",
"LawnGreen"=>"LawnGreen",
"LemonChiffon"=>"LemonChiffon",
"LightBlue"=>"LightBlue",
"LightCoral"=>"LightCoral",
"LightCyan"=>"LightCyan",
"LightGoldenRodYellow"=>"LightGoldenRodYellow",
"LightGreen"=>"LightGreen",
"LightPink"=>"LightPink",
"LightSalmon"=>"LightSalmon",
"LightSeaGreen"=>"LightSeaGreen",
"LightSkyBlue"=>"LightSkyBlue",
"LightSteelBlue"=>"LightSteelBlue",
"LightYellow"=>"LightYellow",
"Lime"=>"Lime",
"LimeGreen"=>"LimeGreen",
"Linen"=>"Linen",
"Magenta"=>"Magenta",
"Maroon"=>"Maroon",
"MediumAquaMarine"=>"MediumAquaMarine",
"MediumBlue"=>"MediumBlue",
"MediumOrchid"=>"MediumOrchid",
"MediumPurple"=>"MediumPurple",
"MediumSeaGreen"=>"MediumSeaGreen",
"MediumSlateBlue"=>"MediumSlateBlue",
"MediumSpringGreen"=>"MediumSpringGreen",
"MediumTurquoise"=>"MediumTurquoise",
"MediumVioletRed"=>"MediumVioletRed",
"MidnightBlue"=>"MidnightBlue",
"MintCream"=>"MintCream",
"MistyRose"=>"MistyRose",
"Moccasin"=>"Moccasin",
"NavajoWhite"=>"NavajoWhite",
"Navy"=>"Navy",
"OldLace"=>"OldLace",
"Olive"=>"Olive",
"OliveDrab"=>"OliveDrab",
"Orange"=>"Orange",
"OrangeRed"=>"OrangeRed",
"Orchid"=>"Orchid",
"PaleGoldenRod"=>"PaleGoldenRod",
"PaleGreen"=>"PaleGreen",
"PaleTurquoise"=>"PaleTurquoise",
"PaleVioletRed"=>"PaleVioletRed",
"PapayaWhip"=>"PapayaWhip",
"PeachPuff"=>"PeachPuff",
"Peru"=>"Peru",
"Pink"=>"Pink",
"Plum"=>"Plum",
"PowderBlue"=>"PowderBlue",
"Purple"=>"Purple",
"Red"=>"Red",
"RosyBrown"=>"RosyBrown",
"RoyalBlue"=>"RoyalBlue",
"SaddleBrown"=>"SaddleBrown",
"Salmon"=>"Salmon",
"SandyBrown"=>"SandyBrown",
"SeaGreen"=>"SeaGreen",
"SeaShell"=>"SeaShell",
"Sienna"=>"Sienna",
"Silver"=>"Silver",
"SkyBlue"=>"SkyBlue",
"SlateBlue"=>"SlateBlue",
"SlateGray"=>"SlateGray",
"Snow"=>"Snow",
"SpringGreen"=>"SpringGreen",
"SteelBlue"=>"SteelBlue",
"Tan"=>"Tan",
"Teal"=>"Teal",
"Thistle"=>"Thistle",
"Tomato"=>"Tomato",
"Turquoise"=>"Turquoise",
"Violet"=>"Violet",
"Wheat"=>"Wheat",
"White"=>"White",
"WhiteSmoke"=>"WhiteSmoke",
"Yellow"=>"Yellow",
"YellowGreen"=>"YellowGreen"        
) ;
        return $colors;
    }
 }
 
 class ppages 
{
	public static function getqueryu()
	{
		return "select * from pages order by priority";
	}
	public static function getquerya()
	{
		return "select * from pages order by priority";
	}
}


?>
