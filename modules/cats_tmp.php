<?php if(!isset($RUN)) { exit(); } ?>
<script language="javascript">
    function AddNewCat()
    {
        var adding = "adding";
        var T= document.getElementById('hdnT').value;
        if(T!="add") adding="editing";
       // alert(T);
        var cat_name = document.getElementById('txtName').value;
         $.post("index.php?module=cats", {  ajax: "yes", add : adding, name : cat_name, hdnT : T },
         function(data){
             document.getElementById('div_grid').innerHTML=data;
             document.getElementById('hdnT').value='add';
             document.getElementById('btnAdd').value="<?php echo ADD; ?>";
        });
    }
    function EditCat(cat_name,cat_id)
    {
        document.getElementById('txtName').value=cat_name;
        document.getElementById('hdnT').value=cat_id;
        document.getElementById('btnAdd').value="<?php echo SAVE; ?>";
       // jsProcessCommand(cat_id,"edit","index.php?module=cats","div_grid");
    }
</script>

    <div id="div_grid"><?php echo $grid_html ?></div>
    <br>
    
    <hr />

    <table>
        <tr>
            <td class="desc_text">
                <?php echo CAT_NAME ?> : <input type="text" id="txtName" name="txtName" /> <input type="button" class="st_button" id="btnAdd" onclick ="AddNewCat()" value ="<?php echo ADD ;?>">
                <input type="hidden" id="hdnT" name="hdnT" value="add">
            </td>
        </tr>
    </table>

