( function( $ ) {
    wp.customize( 'fw_options[color_theme]', function( value ) {
        value.bind( function( newval ) {
            /**
             * An array of collected html inputs
             * [{'name':'input[name]','value':'input value'}]
             * or
             * [{'name':'input[name]','value':'input value'},{'name':'input[name]','value':'input value'},...]
             */
            newval = JSON.parse(newval);
            $( 'body' ).removeClass(function (index, css) {
                return (css.match (/(^|\s)theme-\S+/g) || []).join(' ');
            }).addClass( 'theme-' + newval[0].value );
        } );
    } );
} )( jQuery );