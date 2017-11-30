<?php

class catsDB
{
    public static function GetCatsQuery()
    {
        $sql = "select * from cats";
        return $sql;
    }

    public static function DeleteCategoryById($id)
    {
        $sql = "delete from cats where id=$id";        
        db::exec_sql($sql);
    }

     public static function AddNewCat($name)
    {
        $name = db::clear($name);
        $sql = "insert into cats(cat_name) values('$name')";
        db::exec_sql($sql);
    }

      public static function EditCat($name,$id)
    {
        $name = db::clear($name);
        $id = db::clear($id);
        $sql = "update cats set cat_name='$name' where id='$id'";        
        db::exec_sql($sql);
    }
}

?>
