(function($) {


    /**
     * Add a skiplink to the keyboard shortcuts metabox.
     */
    var $adminMenuMain = $('#adminmenumain'),
        $editorShortcuts = $('#wally_editor_shortcuts');
    if($editorShortcuts.length) {

        var shortcutsSkiplink = $('<a/>', {
            "href": "#wally_editor_shortcuts",
            "class": "screen-reader-shortcut"
        });
        shortcutsSkiplink.html("Hoppa till tangentbordsgenvägar");

        shortcutsSkiplink.insertAfter(
            $adminMenuMain.find('.screen-reader-shortcut').last()
        );
    }

    $(window).load(function() {
        var tinymce = window.tinymce;

        /**
         * Set correct buttons depending on OS
         */
        if(typeof tinymce !== 'undefined') {
            var access = tinymce.Env.mac ? '<kbd>Ctrl</kbd> + <kbd>Alt</kbd> + Tangent' : '<kbd>Shift</kbd> + <kbd>Alt</kbd> + Tangent',
                meta = tinymce.Env.mac ? '<kbd>Cmd</kbd> + Tangent' : '<kbd>Ctrl</kbd> + Tangent';
            $('#access-keys').html(access);
            $('#meta-keys').html(meta);

            /**
             * Add better aria-labels to <kbd> elements.
             */
            var accessKeys = $("<div/>").html(access).text().replace('+', 'och');
            var metaKeys = $("<div/>").html(meta).text().replace('+', 'och');

            $('.wally-editor-shortcuts kbd').each(function(i, key) {
                var ariaLabel = $(key).attr('aria-label');
                if($(key).parents('#wally-editor-shortcuts-meta').length) {
                    $(key).attr('aria-label', metaKeys.replace('Tangent', ariaLabel));
                } else if($(key).parents('#wally-editor-shortcuts-access').length) {
                    $(key).attr('aria-label', accessKeys.replace('Tangent', ariaLabel));
                }
            });

        }


    });




})(jQuery);