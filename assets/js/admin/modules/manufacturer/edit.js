/**
 * Created by danieldemon on 9/27/14.
 */
$(document).ready(function () {
    $('#manufacturer-edit-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            type : 'POST',
            url : '/api/manufacturer/update',
            data :$('#manufacturer-edit-form').serialize(),
            dataType: 'json',
            error : function() {
                alert("Ajax error!");
            },
            success :function(data){
                if(data['status'] === "success") {
                    alert('Данные успешно обновлены!');
                    document.location.href = "/admin/manufacturer";
                } else if (data['errors']['system'] != "") {
                    alert(data['errors']['system']);
                } else {
                    $.each(data['errors'], function (key, val) {
                        if (val.length !== 0) {
                            setMessage(key, val, "error");
                        } else {
                            setMessage(key, val, "success");
                        }
                    });
                }
            }
        });
    });
});