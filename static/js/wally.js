(function ($) {

    "use strict";

    tinymce.PluginManager.add('fw', function(editor, link) {

        /**
         * This plugin adds extra functionality to the TinyMCE editor
         */
        if(typeof fw_option_shortcode_globals !== 'undefined') {

            var shortcodeList = fw_option_shortcode_globals.shortcode_list,
                shortcodeTags = [];

            for (var i in shortcodeList) {
                if (shortcodeList.hasOwnProperty(i)) {
                    shortcodeTags.push(i);
                }
            }


            /**
             * Hijack the creation of the Unyson shortcode button.
             */
            editor.on("init", function(e) {

                var unysonButton = editor.buttons.simple_builder_button;

                /**
                 * Make sure the buttons actually are buttons and not divs.
                 * @returns {string}
                 */
                unysonButton.panel.html = function() {

                    var shortcodeMenuHtml = '';

                    tinymce.each(shortcodeList, function (shortcode, key) {
                        {
                            var iconHtml = '';

                            if (shortcode.icon) {
                                if (typeof FwBuilderComponents.ItemView.iconToHtml == "undefined") {
                                    iconHtml = '<img src="' + shortcode.icon + '"/>';
                                } else {
                                    iconHtml = FwBuilderComponents.ItemView.iconToHtml(shortcode.icon);
                                }
                            }
                        }

                        shortcodeMenuHtml += '' +
                            '<button tabindex="0" class="fw-shortcode-item" data-shortcode-tag="' + key + '">' +
                            '<div class="inner">' +
                            iconHtml +
                            '<p><span>' + shortcode.title + '</span></p>' +
                            '</div>' +
                            '</button>';
                    });

                    return shortcodeMenuHtml;

                };
                //
                //unysonButton.onPostRender = function() {
                //    var ctrl = this;
                //    editor.on('MyCustomEvent', function(e) {
                //        ctrl.active(e.state);
                //        console.log("event received");
                //    });
                //};
                //
                editor.shortcuts.add('ctrl+u', 'test', function(e) {
                    console.log(unysonButton.onclick());
                });

            });

            /**
             * Open shortcode modals when inserted into the editor.
             */
            editor.on("ExecCommand", function (e) {
                // Listen to all editor events

                $('.fw-shortcode-item').each(function() {
                    $(this).attr('tabindex', 0);
                });

                switch(e.command) {
                    case 'mceInsertContent':
                        // The event was mceInsertContent - proceed!

                        var currentElement = e.value,
                            id,
                            tag;

                        if ($(currentElement).hasClass('fw-shortcode')) {
                            id = $(currentElement).data('id'),
                                tag = $(currentElement).data('shortcode-tag');

                            if (typeof shortcodeList[tag] !== 'undefined') {
                                editor.execCommand("openFwModal", false, {item: shortcodeList[tag], tag: tag, id: id});
                            }
                        } else if ($(currentElement).parents('[data-shortcode-tag]').length) {

                            id = $(currentElement).parents('[data-shortcode-tag]').data('id'),
                                tag = $(currentElement).parents('[data-shortcode-tag]').data('shortcode-tag');

                            if (typeof shortcodeList[tag] !== 'undefined') {
                                editor.execCommand("openFwModal", false, {item: shortcodeList[tag], tag: tag, id: id});
                            }
                        }

                }

            });

        }

        /**
         * ???
         */
        var lastContainer;
        var bootstrapElements = ["noneditable"];

        editor.on('keydown', function(evt) {

            var node            = editor.selection.getNode();
            var range           = editor.selection.getRng();
            var startOffset     = range.startOffset;
            var currentWrapper  = range.endContainer.parentElement.className;

            // if delete Keys pressed
            if (evt.keyCode == 8 || evt.keyCode == 46){

                if (startOffset == "0" && bootstrapElements.indexOf(lastContainer)>-1 ){
                    evt.preventDefault();
                    evt.stopPropagation();
                    return false;
                }

            }
            lastContainer = currentWrapper;
        });



    });

    tinyMCE.addI18n("sv_SE", {
        "Editor shortcodes": "Edit Image"
    });

})(jQuery);