<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $atts
 */

global $wp_embed;

$width  = ( is_numeric( $atts['width'] ) && ( $atts['width'] > 0 ) ) ? $atts['width'] : '300';
$height = ( is_numeric( $atts['height'] ) && ( $atts['height'] > 0 ) ) ? $atts['height'] : '200';
$title = $atts['title'];

?>
<div class="video-wrapper shortcode-container">
<? if($atts['video']['video-type'] === 'upload') {
	$url = $atts['video']['upload']['video']['url'];
	$iframe = wp_video_shortcode(array(
		'src' => trim($url),
		'width' => $width,
		'height' => $height
	));
	if(!empty($title)) {
		echo w_add_title_to_video($title, $iframe);
	} else {
		echo $iframe;
	}
} else {
	$url = $atts['video']['url']['video'];
	$iframe = $wp_embed->run_shortcode( '[embed  width="' . $width . '" height="' . $height . '"]' . $url . '[/embed]');
	echo w_add_title_to_video($title, do_shortcode( $iframe ));
} ?>
</div>
