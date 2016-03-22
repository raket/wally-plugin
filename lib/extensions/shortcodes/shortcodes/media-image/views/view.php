<?php if ( ! defined( 'FW' ) ) {
	die( 'Forbidden' );
}

/**
 * @var array $atts
 */

if ( empty( $atts['image'] ) ) {
	return;
}

$image = $atts['image']['url'];
$size = $atts['size'] ? $atts['size'] : '';
$fit = $atts['fit'] ? $atts['fit'] : '';
$caption = get_post_meta($atts['image']['attachment_id'], '_wp_attachment_image_alt', true);

$alt = ($atts['advanced'] && !empty($caption)) ? fw_html_tag('figcaption', array('class' => 'image__caption'), $caption) : '';
$button = ($atts['advanced']) ? fw_html_tag('div', array('class' => 'image__buttons'), fw_html_tag('button', array(
	'class'=>'image__button make-fullscreen',
	'data-mfp-src' => $image
), '<i class="material-icons">&#xE5D0;</i> '. __('Visa i helskärm', 'fw'))) : '';

if(!empty($atts['link'])) {
	$link = fw_html_tag('a', array(
		'class' => 'image__link',
		'href' => $atts['link'],
		'target' => '_blank',
	), '<span>' . $caption . '</span>');
} else {
	$link = '';
}

echo fw_html_tag('figure', array(
	'class' => ($atts['link']) ? 'image image--' . $size . ' '.$fit : 'image image--' . $size . ' '.$fit,
	'data-image' => $image
), $button.$alt.$link);