<?php
// Block direct requests
if (!defined('ABSPATH'))
    die('-1');

add_action('wally_modules_init', array('Wally_Editor', '_init'));

class Wally_Editor
{

    public function __construct()
    {
        add_action('add_meta_boxes', array($this, '_w_editor_modes'), 9);
        add_action('add_meta_boxes', array($this, '_w_editor_shortcuts'), 9);
        add_action('admin_enqueue_scripts', function () {
            wp_register_script('wally_editor_modes', plugin_dir_url(__FILE__) . '../static/js/editor-modes.js');
            wp_enqueue_script('wally_editor_modes', false, false, false, true);
        });

        add_filter('media_send_to_editor', array($this, '_w_media_send_to_editor'), 3, 10);

    }

    public static function _init()
    {
        $class = __CLASS__;
        new $class;
    }

    /**
     * Adds a meta box to pages for selecting editor mode. (Easy, drag'n'drop or default.)
     *
     * @param $post_type
     */
    public function _w_editor_modes($post_type)
    {
	    //limit meta box to certain post types
	    $post_types = apply_filters('_w_editor_mode_post_types', array('page'));
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                'wally_editor_mode'
                , __('Redigeringsläge', 'fw')
                , array($this, '_w_editor_modes_content')
                , $post_type, 'side', 'high'
            );
        }
    }

    /**
     * @param $post
     */
    public function _w_editor_modes_content($post)
    {

        // Use get_post_meta to retrieve an existing value from the database.
        $value = get_option('wally_editor_mode', 0);

        // Display the form, using the current value.
        ?>
        <p>Genom att byta redigeringsläge kan du välja på vilket sätt du vill lägga in sidinnehåll.</p>
        <table>
            <tr>
                <td class="wally_editor_mode_easy_wrap">
                </td>
                <td class="wally_editor_mode_default_wrap">
                </td>
                <td class="wally_editor_mode_advanced_wrap">
                </td>
            </tr>
        </table>
        <?php
    }

    /**
     * @param $post_type
     */
    public function _w_editor_shortcuts($post_type)
    {
        $post_types = array('post', 'page'); //limit meta box to certain post types
        if (in_array($post_type, $post_types)) {
            add_meta_box(
                'wally_editor_shortcuts'
                , __('Tangentbordsgenvägar', 'fw')
                , array($this, '_w_editor_shortcuts_content')
                , $post_type, 'normal', 'high'
            );
        }
    }

    /**
     * Check if a image really has a alt tag stored in the DB when adding it to the WYSIWYG-Editor
     * Wordpress uses the title as Alt if no Alt is provided.
     * And that's bad practice for screen readers.
     *
     * This function should fire on the media_send_to_editor filter
     * @internal
     * @param $html
     * @param $id
     * @param $attachment
     * @return mixed
     */
    public function _w_media_send_to_editor($html, $id, $attachment)
    {
        $provided_alt = $attachment['image_alt'];
        $alt_in_db = get_post_meta($id, '_wp_attachment_image_alt', true);

        //If the alt tag we got don't match the one we have in our db. Remove it from the <img />
        if ($provided_alt != $alt_in_db) {
            $html = preg_replace('/(alt="|\')(' . $provided_alt . ')("|\')/', 'alt=""', $html);
        }

        return $html;
    }

    /**
     * @param $post
     */
    public function _w_editor_shortcuts_content($post)
    {

        ?>

        <div class="wally-editor-shortcuts">

            <div class="fw-row">


                <div class="fw-col-xs-12 fw-col-sm-6 fw-col-lg-3">

                    <h4>
                        <span>Standardgenvägar</span><br>
						<span id="meta-keys">
							<kbd aria-label="Cmd">Cmd</kbd> + Tangent
						</span>
                    </h4>

                    <table class="wally-shortcut-table" id="wally-editor-shortcuts-meta">
                        <tbody>
                        <tr>
                            <th>Tangent</th>
                            <th style="text-align: left">Åtgärd</th>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + C">C</kbd></td>
                            <td>Kopiera</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + X">X</kbd></td>
                            <td>Klipp ut</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + V">V</kbd></td>
                            <td>Klistra in</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + A">A</kbd></td>
                            <td>Välj alla</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + Z">Z</kbd></td>
                            <td>Ångra</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + Y">Y</kbd></td>
                            <td>Gör om</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + B">B</kbd></td>
                            <td>Fet</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + I">I</kbd></td>
                            <td>Kursiv</td
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + U">U</kbd></td>
                            <td>Understreck</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Ctrl + K">K</kbd></td>
                            <td>Infoga/redigera länk</td>
                        </tr>
                        </tbody>
                    </table>

                </div>

                <div class="fw-col-xs-12 fw-col-sm-6 fw-col-lg-4 fw-col-lg-push-5">

                    <h4>
                        <span>Fokusgenvägar</span><br>
                        <kbd aria-label="Alt">Alt</kbd> + Tangent
                    </h4>
                    <table class="wally-shortcut-table">
                        <tbody>
                        <tr>
                            <th>Tangent</th>
                            <th>Åtgärd</th>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Alt + F8">F8</kbd></td>
                            <td>Inbäddad verktygsrad (när en bild, länk eller förhandsvisning är markerad)</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Alt + F9">F9</kbd></td>
                            <td>Meny för redigerare (när aktiverad)</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Alt + F10">F10</kbd></td>
                            <td>Verktygsfält för redigerare</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="Alt + F11">F11</kbd></td>
                            <td>Elementsökväg</td>
                        </tr>
                        </tbody>
                    </table>

                    <p class="tip">För att flytta fokus till andra knappar, använd Tab- eller piltangenterna. För att
                        flytta tillbaka fokus till redigeraren, använd ESC-tangenten eller någon av knapparna.</p>

                </div>

                <div class="fw-col-xs-12 fw-col-lg-5 fw-col-lg-pull-4" id="wally-editor-shortcuts-access">

                    <h4>
                        <span>Ytterligare genvägar</span><br>
						<span id="access-keys">
							<kbd aria-label="Ctrl">Ctrl</kbd> + <kbd aria-label="Alt">Alt</kbd> + Tangent
						</span>
                    </h4>
                    <table class="wally-shortcut-table">
                        <tbody>
                        <tr>
                            <th>Tangent</th>
                            <th>Åtgärd</th>
                            <th>Tangent</th>
                            <th>Åtgärd</th>
                        </tr>
                        <tr>
                            <td><kbd aria-label="1">1</kbd></td>
                            <td>Rubrik 1</td>
                            <td><kbd aria-label="2">2</kbd></td>
                            <td>Rubrik 2</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="3">3</kbd></td>
                            <td>Rubrik 3</td>
                            <td><kbd aria-label="4">4</kbd></td>
                            <td>Rubrik 4</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="5">5</kbd></td>
                            <td>Rubrik 5</td>
                            <td><kbd aria-label="6">6</kbd></td>
                            <td>Rubrik 6</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="L">L</kbd></td>
                            <td>Vänsterställ</td>
                            <td><kbd aria-label="C">C</kbd></td>
                            <td>Centrera</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="R">R</kbd></td>
                            <td>Högerställ</td>
                            <td><kbd aria-label="J">J</kbd></td>
                            <td>Justera</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="D">D</kbd></td>
                            <td>Genomstruken</td>
                            <td><kbd aria-label="Q">Q</kbd></td>
                            <td>Citering</td>
                        </tr>
                        <tr>
                            <td><kbd aria-label="U">U</kbd></td>
                            <td>Punktlista</td>
                            <td><kbd aria-label="O">O</kbd></td>
                            <td>Numrerad lista</td>
                        </tr>
                        <tr>
                            <td>
                        <tr>
                            <td><kbd aria-label="M">M</kbd></td>
                            <td>Infoga/redigera media (bild, video, ljud)</td>
                            <td><kbd aria-label="H">H</kbd></td>
                            <td>Tangentbords&shy;genvägar</td>
                        </tr>
                        </tbody>
                    </table>

                </div>


            </div>


        </div>

        <?php
    }

}