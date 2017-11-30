<?php


class questions_db {


    public static function GetQuestionsQuery($quiz_id)
    {
        $sql = "select q.*, qt.question_type from questions q left join question_types qt on q.question_type_id=qt.id where quiz_id=$quiz_id order by priority";
        return $sql;
    }

    public static function GetQuestionsByPriority($priority,$asg_id,$user_id,$qst_order,$quiz_id)
    {
        $table = "questions";        
        if($qst_order=="2")
        {
            $table = questions_db::GetQstTable($quiz_id, $user_id);
        }
        $sql = "select qs.* , qg.group_name, ".
        "ifnull((select priority from ".questions_db::ConfigQuery($table, 1)." qs2 where qs2.priority>qs.priority and qs2.quiz_id=qs.quiz_id order by priority limit 0,1),-1) next_priority,".
        "(select priority from ".questions_db::ConfigQuery($table, 3)."  qs3 where qs3.priority<qs.priority and qs3.quiz_id=qs.quiz_id order by priority desc limit 0,1) prev_priority".
        " from ".questions_db::ConfigQuery($table, 2)."   qs ".
        " left join quizzes q on q.id=qs.quiz_id ".
        " left join assignments asg on asg.quiz_id=q.id ".
        " inner join assignment_users au on au.assignment_id=asg.id and au.user_id=$user_id ".
        " left join question_groups qg on qg.question_id=qs.id ".
        " where asg.id=$asg_id ".
        " and qs.priority=$priority ";  
        return $sql;
    }
    
    public static function GetQstTable($quiz_id,$user_id)
    {
        return "(select @row := @row + 1 AS priority, q2.* from ( select id,question_text,question_type_id,quiz_id,point,added_date,parent_id,header_text,footer_text from questions   q where quiz_id=$quiz_id order by rand($user_id) ) q2 ,  (SELECT @row := 0) r)";
    }
    
    public static function ConfigQuery($query,$id)
    {
        return str_replace("@row", "@row".$id, $query);
    }

    public static function GetQuestionsByID($ID)
    {
        $sql = "select qs.* , qg.group_name, ".
        "ifnull((select priority from questions qs2 where qs2.priority>qs.priority and qs2.quiz_id=q.id order by priority limit 0,1),-1) next_priority,".
        "(select priority from questions qs3 where qs3.priority<qs.priority and qs3.quiz_id=q.id order by priority desc limit 0,1) prev_priority".
        " from questions qs ".
        " left join quizzes q on q.id=qs.quiz_id ".         
        " left join question_groups qg on qg.question_id=qs.id ".        
        " where qs.id=$ID";
        return $sql;
    }

    public static function GetQuestionsByUserQuizId($user_quiz_id)
    {
        $sql = "select qs.* , qg.group_name, ".
        "ifnull((select priority from questions qs2 where qs2.priority>qs.priority and qs2.quiz_id=q.id order by priority limit 0,1),-1) next_priority,".
        "(select priority from questions qs3 where qs3.priority<qs.priority and qs3.quiz_id=q.id order by priority desc limit 0,1) prev_priority".
        " from questions qs ".
        " inner join quizzes q on q.id=qs.quiz_id ".
        " inner join assignments asg on asg.quiz_id=q.id ".
        " left join question_groups qg on qg.question_id=qs.id ".
        " inner join user_quizzes uq on uq.assignment_id=asg.id ".
        " where uq.id=$user_quiz_id order by priority ";
        //echo $sql;
        return db::exec_sql($sql);
    }

    public static function MoveQuestion($direction,$question_id)
    {
        $sql = "CALL move_question(\"$direction\", $question_id);";
        db::exec_sql($sql);
    }

    public static function GetAnswerDeleteQuery($question_id)
    {
        $sql = "delete from answers where group_id in (select id from question_groups where question_id=$question_id)";
        return $sql;
    }

    public static function GetAnswersByQstID($question_id)
    {
        $sql = "select a.id as a_id,a.*,qg.* from answers a ".
        " left join question_groups qg on a.group_id=qg.id ".
        " where qg.question_id = $question_id ";
        //echo $sql;
        return db::exec_sql($sql);
    }

    public static function GetAnswersByQstID2($question_id,$user_quiz_id,$ans_priority)
    {
        $sql = "select a.id as a_id,a.*,qg.*,ua.user_answer_id,ua.user_answer_text from answers a ".
        " left join question_groups qg on a.group_id=qg.id ".
        " left join user_answers ua on ua.answer_id=a.id and ua.user_quiz_id=".$user_quiz_id.
        " where qg.question_id = $question_id ";
        if($ans_priority=="2")
        {
            $sql.=" order by rand($user_quiz_id) ";
        }
        //echo $sql;
        return db::exec_sql($sql);
    }

    public static function GetQuestionsByAsgIdQuery($asg_id,$quiz_id, $user_id,$qst_order)
    {
        $table = "questions";        
        if($qst_order=="2")
        {
            $table = questions_db::GetQstTable($quiz_id, $user_id);
        }        
        $sql = "select q.* from assignments a left join $table q on q.quiz_id=a.quiz_id where a.id=".$asg_id." order by priority";                
        return $sql;
    }

    public static function GetGroupDeleteQuery($question_id)
    {
        $sql = "delete from question_groups where question_id=$question_id";
        return $sql;
    }

    public static function DeleteQuestion($question_id)
    {
        //$sql = "delete from answers where group_id in (select id from question_groups where question_id=$question_id) ;";
        //$sql.= " delete from question_groups where question_id=$question_id ;";
        $sql=" delete from questions where id=$question_id";
        
        db::exec_sql($sql);
    }

    public static function UpdatePriority($quiz_id,$priority)
    {
	$sql = " update questions set priority = 1 where quiz_id = $quiz_id and priority = $priority ";
	db::exec_sql($sql);
    }

    public static function GetMinPriority($quiz_id)
    {
	$sql = "select ifnull(min(priority),-1) as minp from questions where quiz_id=$quiz_id";
	$results = db::exec_sql($sql);
	$row=db::fetch($results);
	return $row['minp'];
    }

    public static function UpdatePriorityQuery($quiz_id,$question_id)
    {
        $sql = "update questions ,(select ifnull(max(priority)+1,1) as priority from questions where quiz_id=$quiz_id) questions2 set questions.priority = questions2.priority where questions.id=$question_id";
        return $sql ; 
    }

}
?>
