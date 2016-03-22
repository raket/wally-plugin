<?php if (!defined('FW')) die('Forbidden');
$class = fw_ext_builder_get_item_width('page-builder', $atts['width'] . '/frontend_class');
$boxed_columns = get_post_meta(get_queried_object_id(), 'boxed_columns', true);
?>
<div class="<?php echo esc_attr($class); ?>">
	<?php if($boxed_columns): ?><div class="box-wrapper" data-mh="boxes"><?php endif; ?>
		<?php echo do_shortcode($content); ?>
	<?php if($boxed_columns): ?></div><?php endif; ?>
</div>
