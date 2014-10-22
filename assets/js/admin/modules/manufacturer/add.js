$(document).ready(function () {
    $('#manufacturer-add-form').submit(function(e){
        e.preventDefault();
        $.ajax({
            type : 'POST',
            url : '/api/manufacturer/create',
            data :$('#manufacturer-add-form').serialize(),
            dataType: 'json',
            error : function()
            {
                alert("Ajax");
            },
            success :function(data){
                if(data['status'] === "success"){
                    alert('Производитель успешно добавлен!');
                    document.location.href = "/admin/manufacturer";
                }else{
                    $.each(data['errors'],function(key,val){
                        if(val.length !== 0)
                        {
                            setMessage(key,val,"error");
                        }
                        else
                        {
                            setMessage(key,val,"success");
                        }
                    });
                }

            }
        });
    });
});