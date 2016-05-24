<?php
// Block direct requests
if ( !defined('ABSPATH') )
	die('-1');

add_action( 'widgets_init', function(){
	register_widget('Facebook_Feed');
});

/**
 * Adds Facebook_Feed widget.
 */
class Facebook_Feed extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	function __construct() {
		parent::__construct(
			'Facebook_Feed',
			__('Inlägg från Facebook', 'fw'),
			array( 'description' => __( 'Visar ett flöde från en sida på Facebook.', 'text_domain' ), ) // Args
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
		if ( !empty( $instance['page'] ) ) {

			echo '<div id="fb-root"></div>
<script>(function(d, s, id) {
		var js, fjs = d.getElementsByTagName(s)[0];
		if (d.getElementById(id)) return;
		js = d.createElement(s); js.id = id;
		js.src = "//connect.facebook.net/sv_SE/sdk.js#xfbml=1&version=v2.5&appId=600056770025296";
		fjs.parentNode.insertBefore(js, fjs);
	}(document, "script", "facebook-jssdk"));</script>';

			echo '<div class="facebook-feed"><div class="fb-page" data-href="' . $instance['page'] . '" data-small-header="true" data-adapt-container-width="true" data-hide-cover="true" data-show-facepile="false" data-show-posts="true"></div></div>';
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
		$title = __( 'Inlägg från Facebook', 'fw' );

		if(!array_key_exists('page', $instance)) {
			$instance['page'] = 'http://www.facebook.com/facebook';
		}

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'page' ) ?>"><?php _e( 'Sida att hämta inlägg från:', 'fw' ) ?></label>
			<input class="widefat" id="<?php echo $this->get_field_id( 'page' ) ?>" name="<?php echo $this->get_field_name( 'page' ) ?>" type="url" value="<?php echo esc_attr($instance['page']) ?>" placeholder="<?php echo esc_attr($instance['page']) ?>>">
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
		$instance['page'] = ( ! empty( $new_instance['page'] ) ) ? strip_tags( $new_instance['page'] ) : '';

		return $instance;
	}

}