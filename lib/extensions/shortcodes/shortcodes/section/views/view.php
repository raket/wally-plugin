<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}
$table_class = ( isset( $atts['border'] ) && $atts['border'] ) ? 'border' : '';
$container_class = ( isset( $atts['is_fullwidth'] ) && $atts['is_fullwidth'] ) ? 'fw-container-fluid' : 'fw-container';
?>
<section class="fw-main-row <?php echo $table_class; ?>">
	<div class="<?php echo $container_class; ?>">
		<?php echo do_shortcode( $content ); ?>
	</div>
</section>
