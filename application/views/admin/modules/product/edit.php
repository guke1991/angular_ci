<?php
echo form_open('', array("class" => "form-horizontal", "id" => "manufacturer-edit-form"));
?>
<legend>Изменить производителя</legend>
<input type="hidden" name="manufacturer-id" id="manufacturer-id" value="<?php echo $manufacturer['id']?>">
<div class="form-group">
    <label for="name" class="control-label col-xs-1">Название: </label>
    <div class="col-xs-4">
        <input type="text" class="form-control" name="name" id="name" value="<?php echo $manufacturer['name']?>" placeholder="Name"/>
        <span class="help-block" id="name_error"></span>
    </div>
</div>
<div class="form-group">
    <div class="col-xs-1">
        <label for="category" class="control-label col-xs-1">Категория:</label>
    </div>
    <div class="col-xs-4">
        <select id="category" name="category" class="form-control">
            <?php foreach ($categories as $category) {
                if($manufacturer['category_id'] == $category['id']){
                    echo "<option selected value = ".$category['id'].">".$category['name']."</option>";
                }else{
                    echo "<option value = ".$category['id'].">".$category['name']."</option>";
                }
            }?>
        </select>
        <span class="help-block" id="category_error"></span>
    </div>
</div>
<div class="form-group">
    <div class="col-xs-2 col-xs-offset-1">
        <a href="/admin/manufacturer" class="btn btn-primary">Назад</a>
        <button class="btn btn-primary" type="submit">Сохранить</button>
    </div>
</div>

<?php echo form_close(); ?>




	