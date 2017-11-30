<?php	
	
    class qst_viewer
    {
        var $html = "";
        var $show_next = true;
        var $show_prev = true;
        var $page_name = "";
        var $show_finish = false;
        var $show_correct_answers = false;

        var $read_only_text = "";

        var $user_quiz_id=-1;
        var $ans_priority="1";
        var $control_unq;

        public function qst_viewer($page)
        {
            $this->page_name = $page;
        }

        private function BuildButtons($template,$row)
        {
            $buttons_html = "<tr><td>";
            if($this->show_prev==true)
            {
                $prev_js = "javascript:PrevQst('".$this->page_name."',$row[question_type_id],$row[prev_priority],$row[id])";
                $buttons_html .= "<input type=button onclick=".$prev_js." style='width:110px' value='< ".PREVIOUS."'>&nbsp;";
            }
            if($this->show_next==true)
            {
                $next_js = "javascript:NextQst('".$this->page_name."',$row[question_type_id],$row[next_priority],$row[id],0)";
                $buttons_html .= "<input type=button onclick=".$next_js." style='width:110px' value='".NEXT." >'>";
            }
            if($this->show_finish==true)
            {
                $finish_js = "javascript:NextQst('".$this->page_name."',$row[question_type_id],$row[next_priority],$row[id],1)";
                $buttons_html .="<input onclick=".$finish_js." type=button style='width:110px' value='".FINISH."'>";
            }
            $buttons_html .= "</td></tr>";
            $template = str_replace("[buttons]", $buttons_html, $template);
            return $template;
        }

        public function BuildQuestion($row)
        {         
            if($this->user_quiz_id>-1)
            {
                $ans_results = questions_db::GetAnswersByQstID2($row['id'],$this->user_quiz_id, $this->ans_priority);
            }
            else
            {
                $ans_results = questions_db::GetAnswersByQstID($row['id']);
            }

            $template = qst_viewer::ReadTemplate();
            $template = str_replace("[question_text]", qst_viewer::get_answer_text($row['question_text']), $template);
            $template = str_replace("[footer_text]", $row['footer_text'], $template);
            $template = str_replace("[header_text]", $row['header_text'], $template);
            $template = str_replace("[group_name]", $row['group_name'], $template);
//	    $this->show_correct_answers == true ? 	

            $answers_html = $this->BuildAnswers($ans_results, $row['question_type_id']);
            $template = str_replace("[answers]", $answers_html, $template);
            $template = $this->BuildButtons($template,$row);

            $hiddens = "<input type=hidden name=hdnPriority id=hdnPriority value=".$row['priority']."><input type=hidden name=hdnNextPriority id=hdnNextPriority value=".$row['next_priority'].">";
            $template = str_replace("[hiddens]", $hiddens, $template);

            $this->html =  $template;

            return $row;

        }
		
		public static function get_answer_text($answer_text)
		{
			$results = $answer_text;
			if(USE_MATH=="yes")
			{
				$results=mathfilter($answer_text,"14","mathpublisher/img/");				
			}
			return $results;
		}
        
        public function BuildQuestionWithQuery($query)
        {
             $rows = db::exec_sql($query);
             $row=db::fetch($rows);
             $this->BuildQuestion($row);
        }

        public function BuildQuestionWithResultset($resultset)
        {
            $this->BuildQuestion($resultset);
        }

        public function BuildAnswers($ans_results,$question_type)
        {
             $control_unq = $this->control_unq;             
             $answers_html="";
             $tabs = "&nbsp;&nbsp;&nbsp;";
             while($row=db::fetch($ans_results))
             {                 
                  $correct_answer = "";
                  $answers_val="";
                  switch($question_type) {
                  case 0:                      
                      if($this->show_correct_answers==true && $row['correct_answer']=="1") $correct_answer = "<font color=red>$tabs (".CORRECT_ANSWER.")</font>";
                      if($this->user_quiz_id>-1 && $row['user_answer_id']!="") $answers_val = "checked";
                      $answers_html.= "<tr><td><input ".$answers_val." type=checkbox id=chkAns ".$this->read_only_text." name=chkAns value='".$row['a_id']."'></td><td align=left style=\"width:99%\" class=desc_text_bg>".qst_viewer::get_answer_text($row['answer_text'])."$correct_answer</td></tr>";
                  break;
                  case 1:
                      if($this->show_correct_answers==true && $row['correct_answer']=="1") $correct_answer = "<font color=red>$tabs (".CORRECT_ANSWER.")</font>";
                      if($this->user_quiz_id>-1 && $row['user_answer_id']!="") $answers_val = "checked";
                      $answers_html.=  "<tr><td><input ".$answers_val." type=radio id=rdAns$control_unq ".$this->read_only_text." name=rdAns$control_unq value='".$row['a_id']."'></td><td align=left style=\"width:99%\" class=desc_text_bg>".qst_viewer::get_answer_text($row['answer_text'])."$correct_answer</td></tr>";
                  break;
                  case 3:
                      if($this->show_correct_answers==true) $correct_answer = "<br><font color=red>".CORRECT_ANSWER." : ".$row['correct_answer_text']."</font>";
                      if($this->user_quiz_id>-1 && $row['user_answer_text']!="") $answers_val = $row['user_answer_text'];
                      $answers_html.=  "<tr><td class=desc_text_bg><textarea style='width:350px;height:100px' id=txtFree ".$this->read_only_text." name=txtFree value='".$row['a_id']."'>".$answers_val."</textarea>$correct_answer".
                                       "<input type=hidden name=txtFreeId id=txtFreeId value='".$row['a_id']."'></td></tr>";
                  break;
                  case 4:
                      if($this->show_correct_answers==true) $correct_answer = "$tabs<font color=red>".CORRECT_ANSWER." : ".$row['correct_answer_text']."</font>";
                      if($this->user_quiz_id>-1 && $row['user_answer_text']!="") $answers_val = $row['user_answer_text'];
                      $answers_html.=  "<tr><td  class=desc_text_bg>".qst_viewer::get_answer_text($row['answer_text'])."</td><td class=desc_text_bg align=left ><input type=text onkeypress='return onlyNumbers();' id=txtMultiAns ".$this->read_only_text." name=txtMultiAns value='".$answers_val."' >".
                                       "<input type=hidden id=txtMultiAnsId name=txtMultiAnsId value='".$row['a_id']."' >$correct_answer</td></tr>";
                  break;
                        }
             }
             return $answers_html;
        }


        public static function ReadTemplate()
        {
            $file = file_get_contents('tmps/question_template.xml', true);
            return $file;
        }

        public function SetReadOnly()
        {
            $this->read_only_text="disabled";
        }

        public function GetPriority()
         {
             $priority = 1;
             if(isset($_POST['hdnPriority']))
             {
                 $priority = intval($_POST['hdnPriority']);
             }
             return $priority;
         }

        public function GetNextPriority()
         {
             $priority = 1;
             if(isset($_POST['next_priority']))
             {
                 $priority = $_POST['next_priority'];
             }
             return $priority;
         }

         public function GetPrevPriority()
         {
             $priority = 1;
             if(isset($_POST['prev_priority']))
             {
                 $priority = $_POST['prev_priority'];
             }
             return $priority;
         }
        
    }

?>
