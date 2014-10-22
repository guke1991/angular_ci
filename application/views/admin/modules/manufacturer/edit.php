<div class="row">
    <div class="col-sm-6 col-sm-offset-3">
        <div class="panel panel-default panel-form">
            <div class="panel-heading">
                <h1 class="panel-title">Изменить производителя</h1>
            </div>
            <div class="panel-body">
                <?php
                echo form_open('', array("class" => "form-horizontal", "id" => "manufacturer-edit-form"));
                ?>

                <input type="hidden" name="id" id="id" value="<?php echo $manufacturer['id']?>">
                <div class="form-group">
                    <div class="col-sm-2">
                        <label for="name" class="control-label">Название: </label>
                    </div>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name="name" id="name" value="<?php echo $manufacturer['name']?>" placeholder="Name"/>
                        <span class="help-block" id="name_error"></span>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-2">
                        <label for="category" class="control-label">Категория:</label>
                    </div>
                    <div class="col-sm-10">
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
                    <div class="col-sm-10 col-sm-offset-2">
                        <a href="/admin/manufacturer" class="btn btn-black">Назад</a>
                        <button class="btn btn-black" type="submit">Сохранить</button>
                    </div>
                </div>

                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>



	