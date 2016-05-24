<?php

// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

add_action( 'widgets_init', function(){
	register_widget('Twitter_Widget');
});

/**
 * Adds Twitter_Widget widget.
 */
class Twitter_Widget extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Twitter_Widget',
			__('Tidslinje från Twitter', 'fw'),
			array( 'description' => __( 'Visar en tidslinje från en användare på Twitter.', 'fw' ), )
		);
	}

	/**
	 * Front-end display of widget.
	 *
	 * @see WP_Widget::widget()
	 *
	 * @param array $args     Widget arguments.
	 * @param array $instance Saved values from database.
	 */
	public function widget($args, $instance ) {
		if (!empty($instance['widget-id']) && !empty($instance['timeline'])) {

			echo '<script>window.twttr = (function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0],
    t = window.twttr || {};
  if (d.getElementById(id)) return t;
  js = d.createElement(s);
  js.id = id;
  js.src = "https://platform.twitter.com/widgets.js";
  fjs.parentNode.insertBefore(js, fjs);

  t._e = [];
  t.ready = function(f) {
    t._e.push(f);
  };

  return t;
}(document, "script", "twitter-wjs"));</script>';

			echo '<a class="twitter-timeline" data-dnt="true" href="' . $instance['timeline'] . '" data-widget-id="' . $instance['widget-id'] . '">Tweets by @twitter</a>
<script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?"http":"https";if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
';
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
		$title = __( 'Inlägg från Twitter', 'fw' );

		if(!array_key_exists('widget-id', $instance)) {
			$instance['widget-id'] = '';
		}
		if(!array_key_exists('timeline', $instance)) {
			$instance['timeline'] = '';
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'widget-id' ) ?>"><?php _e( 'Twitter-widget ID:', 'fw' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'widget-id' ) ?>" name="<?php echo $this->get_field_name( 'widget-id' ) ?>" type="number" value="<?php echo ($instance['widget-id']) ?>" placeholder="661829263294922752">
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'timeline' ) ?>"><?php _e( 'URL till Twitter-användare:', 'fw' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'timeline' ) ?>" name="<?php echo $this->get_field_name( 'timeline' ) ?>" type="url" value="<?php echo ($instance['timeline']) ?>" placeholder="https://twitter.com/twitter">
		</p>
		<p><?php echo sprintf(__('För att skapa en widget klickar du <a href="%s" target="_blank">här</a>.'), 'https://twitter.com/settings/widgets/new') ?></p>
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
		$instance['widget-id'] = ( ! empty( $new_instance['widget-id'] ) ) ? ( strip_tags($new_instance['widget-id'] )) : '';
		$instance['timeline'] = ( ! empty( $new_instance['timeline'] ) ) ? ( strip_tags($new_instance['timeline'] )) : '';

		return $instance;
	}

}