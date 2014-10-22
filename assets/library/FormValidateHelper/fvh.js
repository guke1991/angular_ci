function setMessage(id,msg,msgType)
{
    switch (msgType)
    {
        case "error":
            $('#'+id+'_error').html(msg);
            $('#'+id+'_error').closest(".form-group").removeClass("has-warning has-success").addClass("has-error");
            break;
        case "warning":
            $('#'+id+'_error').html(msg);
            $('#'+id+'_error').closest(".form-group").removeClass("has-error has-success").addClass("has-warning");
            break;
        case "success":
            $('#'+id+'_error').html(msg);
            $('#'+id+'_error').closest(".form-group").removeClass("has-warning has-error").addClass("has-success");
            break;
    }
}