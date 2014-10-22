/**
 * Created by Maxim Papezhuk on 19.09.14.
 * @Version 1.0.2
 */
(function($){
    $.fn.modal = function(method, fadeSpd)
    {
        // Available methods
        var model = {
            'show'  : showAction,
            'hide'  : hideAction,
            'fix'   : fixAction,
            'toggle': toggleAction
        };

        // Parameters
        method = model[method] ? method : 'fix';
        fadeSpd = fadeSpd > 0 ? fadeSpd : 300;

        /*
         * Run method
         */
        for ( var i = 0; i < this.length; i ++ ) {
            model[method](this[i]);
        }

        /*
         * Toggle action
         */
        function toggleAction(target)
        {
            $('.modal-active').modal('hide');
            if ( $(target).hasClass('modal-active') ) {
                hideAction(target);
            } else {
                showAction(target);
            }
        }

        /*
         * Showing modal
         */
        function showAction(target)
        {
            $('.modal-active').not(target).hide();
            $(target).addClass('modal-active');
            fixAction(target);
            $(target).fadeIn(fadeSpd);
        }

        /*
         * Hide modal
         */
        function hideAction(target)
        {
            $(target).removeClass('modal-active');
            $(target).fadeOut(fadeSpd);
        }

        /*
         * Fix action
         */
        function fixAction(target)
        {
            var size = {
                "x" : $(target).width(),
                "y" : $(target).height()
            };

            var pos = {
                "x" : ( $(window).width() - size.x ) / 2,
                "y" : ( $(window).height() - size.y ) / 2
            };

            $(target).css({
                "left"  : pos.x,
                "top"   : pos.y
            });
        }

        return this;
    }
})(jQuery);
