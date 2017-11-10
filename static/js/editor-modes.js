if (
    typeof fwEvents !== 'undefined' &&
    typeof fw_option_type_page_builder_editor_integration_data !== 'undefined'
) {

    (function ($, fwe, data) {

        /**
         * Functionality for the wally_editor_modes-buttons
         */
        var gui = {
            events: _.extend({}, Backbone.Events),
            getWPEditorContent: function () {
                if (this.elements.$wpContentWrap.hasClass('tmce-active')) {
                    return tinyMCE.get('content').getContent();
                } else {
                    return this.elements.$wpContentWrap.find('#content').val();
                }
            },
            clearWPEditorContent: function () {
                if (this.elements.$wpContentWrap.hasClass('tmce-active')) {
                    return tinyMCE.get('content').setContent('');
                } else {
                    return this.elements.$wpContentWrap.find('#content').val('');
                }
            },
            showAdvancedMode: function () {
                this.elements.$wpPostStuff.addClass('wally-advanced-mode-visible');
                this.elements.$wpPostBodyContent.addClass('page-builder-visible');

                this.elements.$wpPostDivRich.hide();
                this.elements.$builderBox.show();

                //Check the checkbox
                this.elements.$metaBox.find('#wally_editor_mode_advanced').attr('checked', true);

                window.editorExpand && window.editorExpand.off && window.editorExpand.off();
                this.elements.$builderActiveHidden.val('true');

                this.events.trigger('show');
            },
            hideAdvancedMode: function () {
                this.elements.$wpPostStuff.removeClass('wally-advanced-mode-visible');
                this.elements.$wpPostBodyContent.removeClass('page-builder-visible');

                this.elements.$builderBox.hide();
                this.elements.$wpPostDivRich.show();

                window.editorExpand && window.editorExpand.on && window.editorExpand.on();

                //Uncheck the checkbox
                this.elements.$metaBox.find('#wally_editor_mode_advanced').attr('checked', false);


                // set the hidden to store that the builder is inactive
                this.elements.$builderActiveHidden.val('false');

                this.events.trigger('hide');
            },
            showEasyMode: function () {

                this.elements.$wpPostStuff.addClass('wally-easy-mode-visible');
                $('#edit-slug-box').hide();

                // Disable opened toolbars
                if (!this.elements.$wpContentWrap.hasClass('tmce-active')) {
                    $('#content-tmce').click();
                }

                //Check the checkbox
                this.elements.$metaBox.find('#wally_editor_mode_easy').attr('checked', true);

                var editor = tinyMCE.get(window.wpActiveEditor),
                    toolbars = editor.theme.panel.find('.toolbar:not(.menubar)');
                if (toolbars.length > 1 && toolbars[1].visible()) {
                    editor.execCommand('wp_adv');
                }

            },
            hideEasyMode: function () {
                this.elements.$wpPostStuff.removeClass('wally-easy-mode-visible');
                $('#edit-slug-box').show();

                //Uncheck the checkbox
                this.elements.$metaBox.find('#wally_editor_mode_easy').attr('checked', false);

            },
            fixOnFirstShowOrHide: function (isShow) {
                var initialStateIsShow = data.renderInBuilderMode;

                if (initialStateIsShow == isShow) {
                    /**
                     * Do nothing, this happens when the same state is set again and again,
                     * for e.g. the builder is enabled/shown, but the this.showBuilder() is still called.
                     *
                     * We need to take an action when the state will be changed (shown->hidden or hidden->shown)
                     */
                    return;
                }

                if (initialStateIsShow) {
                    /*
                     * If the page has to render with the builder being active,
                     * clear the wp editor textarea because the user wants to write the content from scratch
                     */
                    this.clearWPEditorContent();
                    this.elements.$wpContentWrap.find('#content-tmce').trigger('click');
                } else {
                    /*
                     * If the page has to render with wp editor active
                     * get the content from the wp editor textarea
                     * and create a text_block in the builder that contains that content
                     */
                    var wpEditorContent = this.getWPEditorContent();
                    if (wpEditorContent) {
                        optionTypePageBuilder.initWithTextBlock(wpEditorContent);
                    }
                }

                /**
                 * This method must be called only once
                 * Prevent call again
                 */
                this.fixOnFirstShowOrHide = function () {
                };
            },
            initButtons: function () {
                // insert the custom buttons
                $('.wally_editor_mode_easy_wrap').append(this.elements.$easyButton);
                $('.wally_editor_mode_default_wrap').append(this.elements.$defaultButton);
                $('.wally_editor_mode_advanced_wrap').append(this.elements.$advancedButton);

                // hide unyson's default button
                var $unysonButton = $('#wp-content-media-buttons .button.button-primary');
                $unysonButton.each(function () {
                    if ($(this).text() == data.l10n.showButton) {
                        $(this).remove();
                    }
                });
                $('.page-builder-hide-button').hide();

                console.log(data.renderInBuilderMode);
                console.log(data);
                if (data.renderInBuilderMode) {
                    this.showAdvancedMode();
                } else {
                    this.hideAdvancedMode();
                }
            },

            //@todo: Fix bug which causes all events to fire twice
            bindEvents: function () {
                var self = this;
                var userSetting = getUserSetting('editor');

                var currentState;
                if (data.renderInBuilderMode === "1") {
                    currentState = 'advanced';
                } else {
                    currentState = userSetting;
                }

                /**
                 * Bind click on easy editor button
                 */
                this.elements.$easyButton.on('click', function (e) {
                    e.preventDefault();

                    if (data.renderInBuilderMode === "1" && currentState === "advanced") {
                        self.openDialog('Den här sidan är byggd med en avancerad sidbyggare. Är du säker på att du vill fortsätta?').then(
                            function () {
                                self.hideAdvancedMode();
                                self.showEasyMode();
                                currentState = 'easy';
                            }
                        );
                    } else {
                        self.hideAdvancedMode();
                        self.showEasyMode();
                        currentState = 'easy';
                    }

                });

                /**
                 * Bind click on default editor button
                 */
                this.elements.$defaultButton.on('click', function (e) {
                    e.preventDefault();
                    if (data.renderInBuilderMode === "1" && currentState === "advanced") {
                        self.openDialog('Den här sidan är byggd med en avancerad sidbyggare. Är du säker på att du vill fortsätta?').then(
                            function () {
                                self.hideAdvancedMode();
                                self.hideEasyMode();
                                $('#wally_editor_mode_default').attr('checked', true);
                                currentState = 'default';
                            }
                        );
                    } else {
                        self.hideAdvancedMode();
                        self.hideEasyMode();
                        $('#wally_editor_mode_default').attr('checked', true);
                        currentState = 'default';
                    }
                });
                /**
                 * Bind click on advanced editor button
                 */
                this.elements.$advancedButton.on('click', function (e) {
                    e.preventDefault();
                    if (data.renderInBuilderMode !== "1" && currentState !== 'advanced') {
                        self.openDialog('Den här sidan är <strong>inte</strong> byggd med en avancerad sidbyggare. Är du säker på att du vill fortsätta?').then(
                            function () {
                                self.showAdvancedMode();
                                self.hideEasyMode();
                                currentState = 'advanced';
                            }
                        );
                    } else {
                        self.showAdvancedMode();
                        self.hideEasyMode();
                        currentState = 'advanced';
                    }
                });

            },
            openDialog: function (question) {
                var html = '<div id="confirm-dialog" role="dialog" aria-labelledby="confirmDialogTitle" tabindex="0"><h2 id="confirmDialogTitle">' + question + '</h2><button class="action-confirm button button-large" tabindex="0">Ja</button><button class="action-cancel button button-primary button-large" tabindex="0">Nej, avbryt</button></div><div id="confirm-dialog-overlay"></div>',
                    $body = $('body');

                // Dont print multiple dialogs
                if ($body.find('#confirm-dialog').length > 0) {
                    console.log('return false!');
                    return false;
                }

                $body.prepend(html);
                var $confirmDialog = $('body').find('#confirm-dialog');
                $confirmDialog.focus();

                //Return a promise telling the calling function if the user confirmed or not
                return new Promise(function (resolve, reject) {

                    // Add event listener to confirm button
                    $confirmDialog.find('.action-confirm')
                        .on('click', function () {
                            $body.find('#confirm-dialog, #confirm-dialog-overlay').remove();
                            resolve('User confirmed');
                        });

                    // Add event listener to cancel button
                    $confirmDialog.find('.action-cancel')
                        .on('click', function () {
                            $body.find('#confirm-dialog, #confirm-dialog-overlay').remove();
                            reject('User declined');
                        });


                });


            },
            setDefaultEditor: function () {
                var self = this;
                var initialStateIsShow = data.renderInBuilderMode,
                    userSetting = getUserSetting('editor');
                var intervalId = setInterval(function () {
                    if (
                        typeof tinyMCE != 'undefined'
                        &&
                        tinyMCE.get('content')
                    ) {
                        clearInterval(intervalId);

                        // If page is built with the page builder and the user isn't advanced
                        if (initialStateIsShow && userSetting !== 'advanced') {

                            self.openDialog('Den här sidan är byggd med en avancerad sidbyggare. Är du säker på att du vill fortsätta?').then(
                                // If user confirmed
                                function () {
                                    self.showAdvancedMode();
                                    self.hideEasyMode();
                                },
                                //If they declined
                                function () {
                                    window.history.back();
                                }
                            );

                        } else {

                            switch (userSetting) {
                                case 'easy':
                                    //self.elements.$easyButton.click();
                                    self.hideAdvancedMode();
                                    self.showEasyMode();
                                    break;
                                case 'advanced':
                                    //self.elements.$advancedButton.click();
                                    self.showAdvancedMode();
                                    self.hideEasyMode();
                                    break;
                                default:
                                    //self.elements.$defaultButton.click();
                                    self.hideAdvancedMode();
                                    self.hideEasyMode();
                                    break;
                            }

                        }

                    }
                }, 30);
            }
        };

        // This is not very sexy
        // We should only have to wait for Unyson to add its button for us to remove it
        $(window).load(function () {
            initUI();
        });

        /**
         * Initialize UI.
         * Recursive function, fires until the DOM is ready
         */
        function initUI() {
            var builderActiveNodeExists = $('[name="page-builder-active"]').length > 0;

            if(!builderActiveNodeExists) {
                setTimeout(function () {
                    requestAnimationFrame(function() {
                        initUI();
                    });
                },100);
                return;
            }

            gui.elements = {

                $easyButton: $('<input type="radio" name="wally_editor_mode" id="wally_editor_mode_easy" value="0"><label for="wally_editor_mode_easy" class="button button-primary">Förenklad</label>'),
                $defaultButton: $('<input type="radio" name="wally_editor_mode" id="wally_editor_mode_default" value="0" checked><label for="wally_editor_mode_default" class="button button-primary">Standard</label>'),
                $advancedButton: $('<input type="radio" name="wally_editor_mode" id="wally_editor_mode_advanced" value="0"><label for="wally_editor_mode_advanced" class="button button-primary">Avancerad</label>'),

                $metaBox: $('#wally_editor_mode'),
                $builderBox: $('#' + data.optionId).closest('.postbox'),
                $builderActiveHidden: $('[name="page-builder-active"]'),
                $wpPostStuff: $('#poststuff'),
                $wpPostBodyContent: $('#post-body-content'),
                $wpPostDivRich: $('#postdivrich'),
                $wpContentWrap: $('#wp-content-wrap'),
                $wpTemplatesSelect: $('select[name="page_template"]:first')

            };

            // Apparently, we have to have this - otherwise editors dont load
            {
                gui.events.once('show', _.bind(function () {
                    gui.fixOnFirstShowOrHide(true);
                }, gui));

                gui.events.once('hide', _.bind(function () {
                    gui.fixOnFirstShowOrHide(false);
                }, gui));
            }

            gui.initButtons();
            gui.bindEvents();
            //gui.setDefaultEditor();
        }


    })(jQuery, fwEvents, fw_option_type_page_builder_editor_integration_data);

}

