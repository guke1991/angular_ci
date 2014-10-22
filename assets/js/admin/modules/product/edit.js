/**
 * Created by danieldemon on 9/27/14.
 */
$(document).ready(function () {
    $('#manufacturer-edit-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            type : 'POST',
            url : '/admin/manufacturer/edit/'+$('#manufacturer-id').val(),
            data :$('#manufacturer-edit-form').serialize(),
            dataType: 'json',
            error : function() {
                alert("Ajax error!");
            },
            success :function(data){
                if(data === "success") {
                    alert('Update success!');
                    document.location.href = "/admin/manufacturer";
                } else if (data['system'] != "") {
                    alert(data['system']);
                } else {
                    $.each(data, function (key, val) {
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