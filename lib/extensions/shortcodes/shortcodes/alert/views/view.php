<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
} ?>

<div class="alert alert--<?php echo $atts['type'] ?>">
	<?php echo wpautop($atts['text']); ?>
</div>