$(document).on('ready', function(){
    /*
     * Modal actions
     */
    $(window).resize(function(){
        $('.modal.modal-active').modal('fix');
    });

    $('[data-modal]').on('click', function(){
        var modal = $(this).attr('data-modal').split('#');
        $( '#' + modal[1] ).modal(modal[0]);
    });

    /*
     * Pretty checkbox
     */
    $('[type="checkbox"]').pretty_check();

    /*
     * Additional actions
     */
    $('[href]:not(a)').on('click', function(){
        document.location = $(this).attr('href');
    });
});