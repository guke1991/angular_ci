$(document).ready(function () {
    $('#save').click(function(e) {
        e.preventDefault();
        for (instance in CKEDITOR.instances) {
            CKEDITOR.instances[instance].updateElement();
        }
        $("#product-add-form").ajaxSubmit({
            url: '/api/product/create',
            type: 'post',
            dataType: 'json',
            error : function() {
                alert("Ajax");
            },
            success :function(data) {
                if (data['status'] === "success") {
                    alert('Продукт успешно добавлен!');
                    document.location.href = "/admin/product";
                } else {
                    console.log(data);
                    $.each(data['errors'],function(key,val) {
                        if(val.length !== 0) {
                            setMessage(key,val,"error");
                        } else {
                            setMessage(key,val,"success");
                        }
                    });
                }
            }
        });
    });

    CKEDITOR.replace('description');
    CKEDITOR.replace('specs');

});