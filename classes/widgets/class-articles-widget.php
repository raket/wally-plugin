<?php

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

add_action( 'widgets_init', function(){
	register_widget('Articles_Widget');
});

/**
 * Adds Articles_Widget widget.
 */
class Articles_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Articles_Widget',
			__('Klistrade artiklar', 'fw'),
			array( 'description' => __( 'Visa klistrade artiklar med bild och rubrik.', 'fw' ), )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * * TODO: This should not have explicit markup here, but rather include a generic template file from the theme. But that's hard, man! So hard.
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance ) {
		if (!empty($instance['number-of-posts'])) {
			echo '<h2 class="page-title">'.__('Klistrade artiklar').'</h2>';
			$articles = get_posts(
				array('posts_per_page' => $instance['number-of-posts'],
					'post__in' => get_option('sticky_posts'),
					'order' => 'ASC')
			);
			foreach($articles as $article): ?>
				<?php //var_dump($article) ?>
				<?php $thumbnail_small = wp_get_attachment_image_src(get_post_thumbnail_id($article->ID), 'thumbnail')[0]; ?>
				<article class="article-box" role="article" aria-labelledby="post-<?php $article->ID ?>">
					<?php if(has_post_thumbnail($article->ID)): ?>
					<div class="image thumbnail thumbnail--small" data-image="<?= $thumbnail_small; ?>" >
						<img src="<?= $thumbnail_small ?>" alt="<?php ?>">
					</div>
					<?php endif; ?>
					<a href="<?php echo get_the_permalink($article->ID); ?>">
						<div class="article-box__header--below-figure">
							<h3 id="post-<?php echo $article->ID ?>"><?php echo $article->post_title; ?></h3>
						</div>
					</a>
				</article>

			<?php endforeach;
		}
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		$post_title = __( 'Artiklar', 'fw' );

		if(!array_key_exists('number-of-posts', $instance)) {
			$instance['number-of-posts'] = '';
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'number-of-posts' ); ?>"><?php _e( 'Max antal artiklar:', 'fw' ); ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'number-of-posts' ); ?>" name="<?php echo $this->get_field_name( 'number-of-posts' ); ?>" type="number" value="<?php echo ($instance['number-of-posts']); ?>" value="5" placeholder="5">
		</p>
		<?php
	}

	/**
	 * Sanitize widget form values as they are saved.
	 *
	 * @see WP_Widget::update()
	 *
	 * @param array $new_instance Values just sent to be saved.
	 * @param array $old_instance Previously saved values from database.
	 *
	 * @return array Updated safe values to be saved.
	 */
	public function update( $new_instance, $old_instance ) {
		$instance = array();
		$instance['number-of-posts'] = ( ! empty( $new_instance['number-of-posts'] ) ) ? ( strip_tags($new_instance['number-of-posts'] )) : '';

		return $instance;
	}

}