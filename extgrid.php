<?php
    
    class extgrid
    {
        var $id_column = "id";
        var $page_name = "";
        var $grid_control_name ="div_grid";

        var $table = "<table border=1 class=tblGrid id='table-3'>";
        var $edit = true;
        var $edit_attr="";        
        var $delete = true;
        var $edit_text = EDIT;
        var $edit_link ="";
        var $delete_text = DELETE;
        var $checkbox = false;

        var $add_links = false;
        var $links ;
        var $jslinks ;
        var $id_links ;
        var $id_link_key="id";
        var $id_link_checks;
        var $commands;

        var $process_id = 0;

        var $message = ARE_YOU_SURE;

        var $_columns ;
        var $_headers;
        var $identity = "";
        var $selected_ids=array();

        var $process_command_override = "";
        var $edit_attr_override = "";
        var $edit_link_override = "";
        var $process_html_command="";
        var $empty_data_text=NO_RECORDS;
        var $column_override = array();
        var $auto_id = false;
	var $chk_class = "chk";
		
	var $search_headers;
	var $search_columns;
             
	var $main_table = "";
	var $auto_perform_commands = true;
	var $auto_delete = false;
	var $search = false;

        public function SetEdit($value)
        {
            $edit = $value;
        }

        public function SetDelete($value)
        {
            $delete = $value;
        }

        public function extgrid($headers, $columns, $page)
        {
            $this->_columns = $columns;
            $this->_headers = $headers;
            $this->page_name= $page;
            $this->table.="<tr class=c_list_head>";
            foreach($headers as $header)
            {
                $this->table.="<td id=gridhead>&nbsp;".$header."</td>";
            }
            $this->table.="</tr>";
        }		
		
		public function DrowSearch($search_headers,$search_columns)
		{	
			if(count($search_headers)==0)
			{
				$this->search_headers=$this->_headers;
				$this->search_columns=$this->_columns;
			}
			else
			{
				$this->search_headers=$search_headers;
				$this->search_columns=$search_columns;		
			}			
			
			$search_html="<form name=frmSearch id=frmSearch><table cellpadding=0 cellspacing=0 border=0><tr>";
			foreach($this->search_headers as $header)
            {
				$search_html.="<td class=c_list_item>$header</td>";
			}
			$search_html.="<td>&nbsp;</td></tr><tr>";
			foreach($this->search_columns as $key=>$value)
            {
				$search_html.="<td><input type=text name=txt$value /></td>";				
			}
			$search_html.="<td><input style='width:100px' type=button onclick='javascript:grd_search(\"".$this->page_name."\",\"".$this->grid_control_name."\")' value='".SEARCH."'><input style='width:100px' type=button onclick='grd_show_all(\"".$this->page_name."\",\"".$this->grid_control_name."\")' value='".SHOW_ALL."'></td></tr>";
			$search_html.="</table><br></form>";
			return $search_html;
		}
		
		public function SearchGrd($query)
		{			

			if($this->IsClickedBtn("grd_show_all")) unset($_SESSION[$this->page_name]);
			
			if(!isset($_POST['search_grd'])) 
			{

				if(!isset($_SESSION[$this->page_name])) return str_replace("[{where}]","", $query);		
				else return $_SESSION[$this->page_name];
			}
		
			$search_grd = $_POST['search_grd'];								
			$perfs = explode("&", $search_grd);
			
			$where = "";

			foreach($perfs as $perf) 
			{
					$perf_key_values = explode("=", $perf);
					$key = urldecode($perf_key_values[0]);
					$value = urldecode($perf_key_values[1]);	

					if(trim($value)!="")
					{
						$where.=" and lower(".substr($key,3).") like lower('".$value."%') ";					
					}
			}

			if($where == "" ) return str_replace("[{where}]","", $query);	
			
			$where_key = $this->search==true ? " and " : " where " ;
			$where = $where_key.substr($where , 4);

			$query = str_replace("[{where}]" ,$where, $query);
			$_SESSION[$this->page_name]=$query;

			return $query;
			
		}

        public function DrowTable($query)
        {            
          //  db::connect();

			$this->CheckCommands();
			$query = $this->SearchGrd($query);
			$query_grd = $this->GetPagedQuery($query);

            $rows = db::exec_sql($query_grd);
            $found = false;
            //$r_count=db::num_fields($rows);
            $i = 1;
            while($row=db::fetch($rows))
            {                
                $this->table.="<tr >";
                $this->AddCheckbox($row);
                if($this->auto_id==true)
                {
                    $this->table.="<td class=grd_auto_id>$i</td>";
                }
                foreach($this->_columns as $key=>$value)
                {				
                    $this->table.="<td class=c_list_item id=griditem>&nbsp;".trim($this->FormatColumn($key,$value,$row[$key],$row))."&nbsp;</td>";
                }
                $this->AddLinks();
                $this->AddJsLinks($row);
                $this->AddIdLinks($row);
                $this->ProcessCommands($row);
                $this->ProcessHTML($row);
                $this->ProcessEdit($row);
                $this->ProcessDelete($row);				
               $this->table.="</tr>";
               $found = true;
               $i++;
            }

            if(!$found)
            {
                $this->table.="<tr><td class=empty_data colspan=".count($this->_headers).">&nbsp;".$this->empty_data_text."</td></tr>";
            }
			
			$this->table.=$this->AddPager($query);			
            $this->table.="</table>";
            $this->DrowJs();
          //  db::close_connection();

        }
		
		public function GetPagedQuery($query)
		{
			$page_number = 0;
			if(isset($_POST["hdnEventMode"]) && $_POST["hdnEventMode"]=="pager")
            {
				$page = $_POST["hdnEventArgs"];
				$page_number = ($page-1) * PAGING;
			}
			
			$sql = "select * from ($query) table2 LIMIT $page_number, ".PAGING;
			return $sql;
		}
		
		public function GetCurrentPage()
		{
			$page = 1;
			if(isset($_POST["hdnEventMode"]) && $_POST["hdnEventMode"]=="pager")
            {
				$page = $_POST["hdnEventArgs"];
			}			
			return $page;
		}
		
		public function AddPager($query)
		{		
			$pager_html = "";
			$results = db::exec_sql(orm::GetPagingCountQuery($query));
			$row = db::fetch($results);
			$count  = $row['page_count'];
			if($count<=PAGING) return $pager_html;			
			
			$pager_html.="<tr><td align=right colspan='".sizeof($this->_headers)."'><label class=c_list_item>".PAGES." : </label>";
			
			$paging = PAGING;
			$pages = $count % PAGING == 0 ? intval($count / PAGING) : intval($count / PAGING)+1;
			
			$current_page = $this->GetCurrentPage();			
			for($i=1;$i<=$pages;$i++)
			{		
			
				if($i!=$current_page) { $u_start = "<u>" ; $u_end = "</u>";}
				else {$u_start = "" ; $u_end = "";}
				
				$pager_html.="$u_start<a style='cursor:pointer' onclick='grd_go_to_page(".$i.",\"".$this->page_name."\",\"".$this->grid_control_name."\")'>$i</a>$u_end&nbsp;";
			}
			$pager_html.="</td></tr>";
			return $pager_html;
		}

        private function FormatColumn($key , $format , $results , $row)
        {
            $delete_tags=true;
            if($format=="short date")
            {                
                $results = date('F d, Y ', strtotime($results));
            }

            if(count($this->column_override)!=0)
            {                
                if(isset($this->column_override[$key]))
                {                    
                    $override=$this->column_override[$key];
                    $results=$override($row);
                    $delete_tags=false;
                }
            }

            if($delete_tags==true) $results = strip_tags($results);
            
            return $results;
        }

		public function CheckCommands()
		{
			if($this->auto_perform_commands==false) return ;
			
			if($this->IsClickedBtnDelete() && $this->auto_delete==true)
			{
				orm::Delete($this->main_table,array($this->id_column=>$this->process_id));
			}			
			else if($this->IsClickedBtn("up"))
			{
				
			}
		}
		
        public function IsClickedBtnDelete()
        {
            if(isset($_POST["hdnEventMode"]) && $_POST["hdnEventMode"]=="delete")
            {
                $this->process_id=intval($_POST["hdnEventArgs"]);
                return true;
            }
            return false;
        }

        public function IsClickedBtnEdit()
        {
            if(isset($_POST["hdnEventMode"]) && $_POST["hdnEventMode"]=="edit")
            {
                $this->process_id=intval($_POST["hdnEventArgs"]);
                return true;
            }
            return false;
        }

        public function IsClickedBtn($btn)
        {
            if(isset($_POST["hdnEventMode"]) && $_POST["hdnEventMode"]==$btn)
            {
                $this->process_id=intval($_POST["hdnEventArgs"]);
                return true;
            }
            return false;
        }

        public function DrowJs()
        {
            $this->table.="<input type=hidden id=hdnEventArgs /><input type=hidden id=hdnEventMode />";
        }

        private function ProcessEdit($row)
        {
            if(!$this->edit) return ;

            $edit_attr= $this->edit_attr;
            $edit_attr_override = $this->edit_attr_override;
            $edit_link_override = $this->edit_link_override;

            if($edit_attr_override!="")
            {
                $edit_attr=$edit_attr_override($row);
            }

            $edit_link = "<a $edit_attr href='".$this->edit_link."&id=".$row[$this->id_column]."'>$this->edit_text</a>";

            if($edit_link_override!="")
            {                 
                $edit_link=$edit_link_override($row);
            }            

            $this->table.="<td>&nbsp;$edit_link</td>";

        }

        public static function EditCommandTemplate($row,$grd)
        {
            $html = "&nbsp;<a href='".$grd->edit_link."&id=".$row[$grd->id_column]."'>$grd->edit_text</a>";
            return $html;
        }

        private function ProcessDelete($row)
        {
            if(!$this->delete) return ;

            $id = $this->id_column;
            $this->table.="<td>&nbsp;<a href='javascript:jsProcessDelete(\"$this->message\",$row[$id], \"$this->page_name\", \"$this->grid_control_name\" )'>$this->delete_text</a></td>";

        }

        public static function ProcessCommandTemplate($row,$value,$key,$grd)
        {
            $html = "<td>&nbsp;<a href='javascript:jsProcessCommand(".$row[$grd->id_column].", \"$grd->page_name\", \"$grd->grid_control_name\", \"$value\" )'>$key</a></td>";
            return $html;
        }

        private function ProcessHTML($row)
        {
            if($this->process_html_command=="") return ;

            $process_html_command = $this->process_html_command;
            $this->table.=$process_html_command($row);

        }
      
        private function ProcessCommands($row)
        {
            if(count($this->commands)==0) return ;

            $process_command_override = $this->process_command_override;
            //$process_command_override();

            $id = $this->id_column;
            foreach($this->commands as $key=>$value)
            {
                 if($process_command_override!="")
                 {
                     $this->table.=$process_command_override($row);
                 }
                 else
                 {
                     $this->table.="<td><a href='javascript:jsProcessCommand($row[$id], \"$this->page_name\", \"$this->grid_control_name\", \"$value\" )'>$key</a></td>";
                 }
            }
        }

        private function AddCheckbox($row)
        {
            if(!$this->checkbox) return ;

            $checked = "";
            if(in_array($row[$this->id_column], $this->selected_ids, true))
            {
                $checked="checked";
            }

            $identity = $this->identity;
			$chk_class = $this->chk_class;
            $this->table.="<td>&nbsp;<input $checked type=checkbox class=".$chk_class." id=chkgrd name=chkgrd".$identity."[] value=".$row[$this->id_column]." /></td>";
        }
        
        private function AddLinks()
        {
            if(count($this->links)==0) return ;

            foreach($this->links as $key=>$value)
            {
                 $this->table.="<td>&nbsp;<a href='$value'>$key</a></td>";
            }
        }

        private function AddJsLinks($row)
        {
            if(count($this->jslinks)==0) return ;

            foreach($this->jslinks as $key=>$value)
            {
                 $value=str_replace("[id]", $row[$this->id_column], $value);
                 $this->table.="<td>&nbsp;<a href='#' onclick='$value'>$key</a></td>";
            }
        }

        private function AddIdLinks($row)
        {
            if(count($this->id_links)==0) return ;
            if($row[$this->id_column]=="")
            {
                    $this->table.="<td>&nbsp;</td>";
                    return;
            }

            foreach($this->id_links as $key=>$value)
            {
                 $this->table.="<td>&nbsp;<a href='$value&".$this->id_link_key."=".urldecode($row[$this->id_column])."'>$key</a></td>";
            }
        }
        
        
        

    }

?>
