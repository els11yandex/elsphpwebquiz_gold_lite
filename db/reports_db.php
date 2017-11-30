<?php

class reports_db {
    public static function GetQuestionsForReports($asg_id)
    {
        $sql ="select qs.* from questions qs ".
              "  LEFT join quizzes q on q.id=qs.quiz_id ".
              "  left join assignments a on a.quiz_id=q.id ".
              "  where a.id=$asg_id and question_type_id in (0,1)";
        return $sql;
    }

    public static function GetAnswersReport($question_id,$asg_id)
    {
        $sql = "select answer_text, sum( (case when ua.id is null then 0 else 1 end) ) as rate,".
              // " (select count(*) from answers where group_id=qg.id) answer_count ".
               " ( ".
               " select count(*) from user_answers ua2 ".
               "  left join user_quizzes uq2 on uq2.id=ua2.user_quiz_id ".
               "  inner join assignments asg on asg.id ".
               "  where ua2.question_id=q.id and asg.id=uq.assignment_id ".
               "  ) as acount ".
               " from answers a ".
               " left join question_groups qg on qg.id=a.group_id ".
               " left join questions q on q.id=qg.question_id ".
               "  left join user_quizzes uq on uq.assignment_id=$asg_id ".
               "  left join user_answers ua on ua.user_quiz_id=uq.id and ua.user_answer_id=a.id ".
               "  where q.id=$question_id ".
               "  group by answer_text order by a.priority " ;
      //echo $sql."<br>";
        return $sql;
    }
}
?>