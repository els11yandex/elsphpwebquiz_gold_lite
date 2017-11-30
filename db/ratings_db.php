<?php

class ratings_db {

    public static function GetRatingsQuery()
    {
        $sql = " select r.*,rp.active_img from ratings r ".
               " left join rating_temps rp on r.temp_id=rp.id ".
               " order by r.added_date desc ";
        return $sql;
    }
    
     public static function GetRatingsQueryByID2($id)
    {
        $sql = " select r.*,rp.active_img from ratings r ".
               " left join rating_temps rp on r.temp_id=rp.id ".
                " where r.id=$id".
               " order by r.added_date desc ";
        return $sql;
    }
    /*
    public static function GetRatingsQueryByID($id,$product,$ip,$user_id)
    {
        $sql = "  select r.id,r.header_text,r.footer_text,r.img_count,r.show_results,r.restrict_user,r.bgcolor,r.status,".
               "        rp.active_img,rp.half_active_img,rp.inactive_img,r.lang,".
               "        ifnull(sum(ur.point)/count(ur.point),0) avarage_point,".
               "        (case restrict_user when 1 then (select count(*) from user_ratings where ip_address='$ip') ".
               "                            when 2 then (select count(*) from user_ratings where user_id='$user_id') ".
               "                            else 0 end ".
               "        ) is_rated, ".
               " count(ur.point) total_rate ". 
               " from ratings r ".
               " left join rating_temps rp on r.temp_id=rp.id ".
               " left join user_ratings ur on ur.rate_id=r.id and product_id='$product' ".
               "  where r.id=$id ".
               " order by r.added_date desc";        
        return $sql;
    }
    */
    public static function GetRatingsQueryByID($id,$product,$ip,$user_id)
    {
        $sql = "  select r.id,r.header_text,r.footer_text,r.img_count,r.show_results,r.restrict_user,r.bgcolor,r.status,".
               "        rp.active_img,rp.half_active_img,rp.inactive_img,r.lang,".
               "        ifnull(sum(ur.point)/count(ur.point),0) avarage_point,".          
               " count(ur.point) total_rate ". 
               " from ratings r ".
               " left join rating_temps rp on r.temp_id=rp.id ".
               " left join user_ratings ur on ur.rate_id=r.id and product_id='$product' ".
               "  where r.id=$id ".
               " group by r.id,r.header_text,r.footer_text,r.img_count,r.show_results,r.restrict_user,r.bgcolor,r.status,rp.active_img,rp.half_active_img,rp.inactive_img,r.lang";        
        return $sql;
    }
    
    
    public static function GetRatingsTotalByProduct($rate_id)
    {
        $sql = "select round(ifnull(sum(ur.point)/count(ur.point),0),2) avarage_point, ".
                "   count(ur.point) total_rate , ".
                "   product_id, ".
                "   r.img_count ".
                " from user_ratings ur ".
                " left join ratings r on r.id=ur.rate_id ".
                " where rate_id=$rate_id ".
                " group by product_id ";
        return $sql;
    }


    public static function HasRated($product_id,$rate_id,$check_value)
    {
        $sql = "select * from user_ratings ur ".
        " left join ratings r on r.id=ur.rate_id ".
        " where product_id='$product_id' and rate_id=$rate_id ".
        " and (case r.restrict_user when 1 then ip_address else user_id end)='$check_value'";
        return db::exec_sql($sql);
    }
    
    public static function GetRatingDetails($rate_id,$product_id)
    {
        $sql = "select rate_id,product_id,point,ip_address,UserName ".
               " from user_ratings ur ".
               " left join ratings r on r.id=ur.rate_id ".
               " left join users u on u.UserID=ur.user_id".
               " where r.id=$rate_id and ur.product_id='$product_id' ";
        return $sql;
    }
    
}

?>
