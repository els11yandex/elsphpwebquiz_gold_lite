<?php

class quizDB{


    public static function GetQuizQuery()
    {
        $sql = "select * from quizzes where parent_id=0";
        return $sql;
    }

    public static function DeleteQuizById($id)
    {        
        db::exec_sql(quizDB::DeleteQuizByIdQuery($id));
    }

    public static function DeleteQuizByIdQuery($id)
    {
        $sql = "delete from quizzes where id=$id";
        return $sql;
    }

    public static function AddNewQuiz($name,$desc,$show_into,$into_text)
    {
        $name = db::clear($name);
        $desc = db::clear($desc);
        $sql = "insert into cats(cat_name) values('$name')";
        db::exec_sql($sql);
    }
}
?>
