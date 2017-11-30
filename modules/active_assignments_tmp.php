<?php if(!isset($RUN)) { exit(); } ?>
<script language="javascript">
     window.setTimeout("StartTimer()", 30000);

     function StartTimer()
     {
         //alert('ok');
         jsPostGrid(-1, "updategrid","index.php?module=active_assignments","div_grid");
         window.setTimeout("StartTimer()", 30000);
     }

</script>

<div id="div_grid"><?php echo $grid_html ?></div>
    <br>
    <hr />

