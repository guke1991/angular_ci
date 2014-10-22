/**
 * Created by Maxim Papezhuk on 19.09.14.
 */
(function($){
    $.fn.pretty_check = function()
    {
        return this.each(function(i, e){
            // Checkbox data
            var el_data = {
                'name'      : $(e).attr('name'),
                'checked'   : e.checked ? 'active' : '',
                'value'     : $(e).attr('value'),
                'label'     : $(e).attr('data-label')
            };

            // Make hidden
            $(e).hide().attr('id', 'pretty-check-' + el_data.name);

            // Make pretty checkbox
            var pretty = $(
                '<label onclick="$(this).toggleClass(\'active\')" class="pretty-check-label ' + el_data.checked + '" for="pretty-check-' + el_data.name + '">' +
                    '<div class="pretty-check-box"></div>' +
                     el_data.label + '' +
                '</label>'
            );

            // Append to parent of checkbox
            $(e).parent().append(pretty);

            return e;
        });
    }
})(jQuery);