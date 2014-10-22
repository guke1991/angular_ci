<div class="row">
    <div class="col-sm-8 col-sm-offset-2">
        <?php
        echo form_open_multipart('/admin/product/add', array("class" => "form-horizontal", "id" => "product-add-form"));
        ?>
        <h1>Добавить продукт</h1>

        <div class="form-group">
            <label for="title" class="control-label col-sm-2">Название: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="title" id="title" placeholder="Название"/>
                <span class="help-block" id="title_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="model" class="control-label col-sm-2">Модель: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="model" id="model" placeholder="Модель"/>
                <span class="help-block" id="model_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="price" class="control-label col-sm-2">Цена: </label>
            <div class="col-sm-4 ">
                <div class="input-group">
                    <input type="number" min="1" step="any" class="form-control" name="price" id="price" placeholder="Цена"/>
                    <span class="input-group-addon">$</span>
                </div>
                <span class="help-block" id="price_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="amount" class="control-label col-sm-2">Количество: </label>
            <div class="col-sm-4">
                <input type="number" min="0" class="form-control" name="amount" id="amount" placeholder="Количество" />
                <span class="help-block" id="amount_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="manufacturer" class="control-label col-sm-2">Производитель: </label>
            <div class="col-sm-10">
                <select id="manufacturer" name="manufacturer" class="form-control">
                    <?php foreach ($manufacturers as $manufacturer) {
                        echo "<option value = ".$manufacturer['id'].">".$manufacturer['name']."</option>";
                    } ?>
                </select>
                <span class="help-block" id="manufacturer_name_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label for="image" class="control-label col-sm-2">Фото: </label>
            <div class="col-sm-10">
                <input type="file" class="form-control" name="image" id="image" placeholder="Добавить картинку"/>
                <span class="help-block" id="image_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2">Характеристики: </label>
            <div class="col-sm-10">
                <textarea class="form-control" name="specs" id="specs" placeholder="Добавить характеристики"></textarea>
                <span class="help-block" id="specs_error"></span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-xs-2">Описание: </label>
            <div class="col-xs-10">
                <textarea class="form-control" name="description" id="description" placeholder="Добавить описание"></textarea>
                <span class="help-block" id="description_error"></span>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-10 col-sm-offset-2">
                <a href="/admin/product" class="btn btn-primary">Назад</a>
                <button class="btn btn-primary" id="save" type="submit">Сохранить</button>
            </div>
        </div>

        <?php echo form_close(); ?>
    </div>
</div>

