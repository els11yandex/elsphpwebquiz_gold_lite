<?php

class asgDB
{
    public static function GetAsgQuery()
    {
        $sql = "select asg.*, q.quiz_name from assignments asg left join quizzes q on q.id=asg.quiz_id order by asg.added_date desc";
        return $sql;
    }

    public static function GetAsgQueryById($id)
    {
        $sql = "select * from assignments asg left join quizzes q on q.id=asg.quiz_id where asg.id=$id";
        return db::exec_sql($sql);
    }

    public static function DeleteAsgById($id)
    {
        //$sql = "delete from assignment_users where assignment_id=$id ;";
        //$sql = "delete from quizzes where parent_id<>0 and id in (select quiz_id from assignments where id=$id) ;";
        $sql = " delete from assignments where id=$id";
        db::exec_sql($sql);
    }

    public static function DeleteRelatedQuiz($asg_id)
    {
	$sql = "delete from quizzes where parent_id<>0 and id in (select quiz_id from assignments where id=$asg_id) ";
	db::exec_sql($sql);
    }

    public static function ChangeStat($stat,$id)
    {
        $sql = "update assignments set status=$stat where id=$id";
        return db::exec_sql($sql);
    }

    public static function GetActAsgByUserIDQuery($user_id)
    {
        $sql="select a.id as asg_id,a.*,".
	" q.* ,ifnull(ua.status,0) as user_quiz_status ".
        " from assignments a ".
        " left join quizzes q on a.quiz_id = q.id ".
        " left join user_quizzes ua on ua.assignment_id=a.id and ua.archived=0 and ua.user_id=".$user_id.
        " where a.status = 1 and a.id in  (".
        " select assignment_id from assignment_users where user_id = ".$user_id.
        ") order by a.added_date desc";
       // echo $sql;
        return $sql;
    }

    public static function GetActAsgByUserID($user_id, $asg_id)
    {
        $sql="select a.id as asg_id,a.*,q.quiz_name,".
	" q.* ,ifnull(ua.status,0) as user_quiz_status , ua.id as user_quiz_id ,  ua.finish_date as uq_finish_date, ua.added_date as uq_added_date".
        " from assignments a ".
        " left join quizzes q on a.quiz_id = q.id ".
        " left join user_quizzes ua on ua.assignment_id =a.id and ua.archived=0 and ua.user_id=".$user_id.
        " where a.status = 1 and  a.id in  (".
        " select assignment_id from assignment_users where user_id = ".$user_id.
        ") and a.id=".$asg_id."  order by a.added_date desc";
        //echo $sql;
        return db::exec_sql($sql);
    }

    public static function GetOldAssignmentsQuery($user_id,$mode)
    {
        $sql ="select uq.*,q.quiz_name,asg.quiz_type,asg.results_mode,asg.show_results ,asg.allow_review,uq.status as uq_status,".
        " (case show_results when 1 then asg.pass_score  else '' end) pass_score,".
        " (CASE show_results when 2 then 'Not enabled' ELSE (case success when 1 then 'Yes' else 'No' end) end) is_success ,".
        " (CASE show_results when 1 then (case results_mode when 1 THEN pass_score_point else pass_score_perc end) else '' end) total_point".
        " from user_quizzes uq left join assignments asg on asg.id=uq.assignment_id ".
        " left join quizzes q on q.id=asg.quiz_id ".
        " where asg.quiz_type=$mode and uq.user_id=$user_id order by uq.added_date desc";        
        return $sql;
        //return db::exec_sql($sql);
    }

    public static function GetAsgById($asg_id)
    {
        $sql="select c.cat_name, q.quiz_name,a.*".
        " from assignments a ".
        " left join quizzes q on a.quiz_id=q.id ".
        " left join cats c on c.id=q.cat_id ".
        " where a.id=$asg_id ";        
        return db::exec_sql($sql);
    }
    
    public static function GetUserQuizById($user_quiz_id)
    {
        $sql ="select uq.*,a.*,uq.status as uq_status from user_quizzes uq ".
        " left join assignments a on a.id=uq.assignment_id ".
        " where uq.id = $user_quiz_id ";
        return db::exec_sql($sql);
    }

    public static function GetUserResultsQuery($asg_id,$user_type)
    {
      $table_name = "users";
      if($user_type=="2") $table_name="v_imported_users";
      
      $sql = "select asg.id,u.user_id,Name,".
                "Surname, ".
                "UserName, ".
                "ifnull(ua.status,0) as status_id, ".
                "(case ifnull(ua.status,0) ".
                "when 0 then 'Not started' when 1 then 'Started' when 2 then 'Finished' ".
                "when 3 then 'Time ended' when 4 then 'Manually stopped' ".
                "    end ) as status_name, ".
                "ua.pass_score_point, ".
                "ua.pass_score_perc, ".
                "(CASE quiz_type when 2 then 'Not enabled' ELSE (case success when 1 then 'Yes' else 'No' end) end) is_success, ".
                "(CASE quiz_type when 1 then (case results_mode when 1 THEN pass_score_point else pass_score_perc end) else '' end) total_point, ".
                "ua.id as user_quiz_id ".                
            "from assignment_users u	 ".
            "left join $table_name lu on lu.UserID = u.user_id ".
            
            "left join user_quizzes ua on ua.user_id = lu.UserID and ua.assignment_id = u.assignment_id ".
            
            "left join assignments asg on asg.id=u.assignment_id ".
            "where u.assignment_id=$asg_id and u.user_type=$user_type  " ;
      
        return $sql;
    }

     public static function UpdateUserQuiz($user_quiz_id,$status,$date)
     {
        $quiz_res = db::exec_sql("CALL p_quiz_results(\"$user_quiz_id\");");
        $row = db::fetch($quiz_res);


        $query = orm::GetUpdateQuery("user_quizzes",
                                          array("success"=>$row['quiz_success'],
                                                "status"=>$status,
                                                "finish_date"=>$date,
                                                "pass_score_point"=>$row['total_point'],
                                                "pass_score_perc"=>$row['total_perc'],
                                                ),
                                          array("id"=>$user_quiz_id));
        db::exec_sql($query);

        return $row;
    }

    public static function GetUserInfoByAsgId($asg_id,$user_id,$user_type,$user_quiz_id)
    {
	$users ="users";
	$user_quiz_where = "";
	if($user_type=="2") $users ="v_imported_users";
	if($user_quiz_id!="") $user_quiz_where = " and uq.id=$user_quiz_id ";
	$query = "select usr.*,q.*,asg.*,uq.id as user_quiz_id , uq.added_date,uq.finish_date,pass_score_point,pass_score_perc,uq.success from  $users usr, assignments asg left join user_quizzes uq on uq.assignment_id=asg.id and uq.user_id = $user_id $user_quiz_where left join quizzes q on q.id=asg.quiz_id where usr.UserID=$user_id and asg.id=$asg_id";

	return db::exec_sql($query);
    }

    public static function AcceptNewUser($user_id)
    {
	$sql = "insert into assignment_users  (assignment_id,user_type,user_id)".
	"select id, 1, $user_id from assignments ".
	"where accept_new_users = 1 and status in (0,1)";
	db::exec_sql($sql);
     
    }

}
?>
