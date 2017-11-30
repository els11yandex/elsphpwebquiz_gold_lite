<?php if(!isset($RUN)) { exit(); } ?>
<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

?>
<script language="javascript">

</script>
<form name=form1 id=form1 >
<table class="desc_text_bg">
    <tr>
        <td width="280px">
            <?php echo CAT ?> :
        </td>
        <td>
            <?php echo $cat_name ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo TEST ?> :
        </td>
        <td>
            <?php echo $test_name ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo TYPE ?> :
        </td>
        <td>
            <?php echo $quiz_type ?>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php echo QUESTIONS_ORDER ?> :
        </td>
        <td>
            <?php echo $questions_order ?>
        </td>
    </tr>
    
    <tr>
        <td>
            <?php echo ANSWERS_ORDER ?> :
        </td>
        <td>
            <?php echo $answer_order ?>
        </td>
    </tr>
    
    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo REVIEW_ANSWERS ?> :
        </td>
        <td>
            <?php echo $review_answers ?>
        </td>
    </tr>
    
    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo SHOW_RESULTS ?> :
        </td>
        <td>
            <?php echo $show_results ?>
        </td>
    </tr>
    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo RESULTS_BY ?> :
        </td>
        <td>
            <?php echo $results_by ?>
        </td>
    </tr>
   <tr >
        <td>
            <?php echo ASG_HOW_MANY ?> :
        </td>
        <td>
            <?php echo $asg_how_many ?>
        </td>
    </tr>
   <tr>
   
   

    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo SUCCESS_POINT_PERC ?> :
        </td>
        <td>
            <?php echo $pass_score ?>
        </td>
    </tr>
    <tr style="display:<?php echo $srv_display ?>">
        <td>
            <?php echo TEST_TIME ?> :
        </td>
        <td>
            <?php echo $test_time ?>
        </td>
    </tr>   
</table>

<br>
<table width="98%">
    <tr>
        <td><br></td>
    </tr>
    <tr>
       <td class="desc_text_bg2"><?php echo LOCAL_USERS ?></td>
    </tr>
    <tr>
        <td>
<div id="divLU">
    <?php echo $grid_lu_html ?>
</div>
        </td>
    </tr>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td class="desc_text_bg2"><?php echo IMPORTED_USERS ?></td>
    </tr>
    <tr>
        <td>
<div id="divIU">
    <?php echo $grid_iu_html ?>
</div>
        </td>
    </tr>
 <tr>
        <td><br></td>
    </tr>
  
</table>
</form>
<br>

<a href="#" onclick="javascript:window.location.href='?module=assignments'"><?php echo BACK ?></a>

<br>
<br>
<br>
<br>
<br>


