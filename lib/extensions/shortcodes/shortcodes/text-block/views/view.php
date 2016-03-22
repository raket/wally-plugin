<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $atts
 */
?>
<?php echo (isset($atts['columns']) && $atts['columns'] != "") ? '<div class="fw-textbox '.$atts['columns'].'">' : ''; ?>
<?php echo do_shortcode( $atts['text'] ); ?>
<?php echo (isset($atts['columns']) && $atts['columns'] != "") ? '</div>' : ''; ?>