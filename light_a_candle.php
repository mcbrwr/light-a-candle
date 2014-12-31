<?php
/*
Plugin Name: Light a candle
Plugin URI: https://github.com/mcbrwr/light-a-candle
Description: Show virtual candles for people in a sidebarwidget, based on posts in a category.
Author: Art & Flywork
Version: 1
Author URI: http://artandflywork.com
*/

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}

class light_a_candle extends WP_Widget {

	/**
	 * Register widget with WordPress.
	 */
	public function __construct() {
		parent::__construct(
	 		'light_a_candle',
			'Light A Candle',
			array( 'description' => 'Show candles for people in the sidebar based on titles in a specific post categorie', )
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
	public function widget( $args, $instance ) {
		extract( $args );
		$title = apply_filters( 'widget_title', $instance['title'] );

		echo $before_widget;
		if ( ! empty( $title ) )
			echo $before_title . $title . $after_title;
		
		// THE WIDGET STUFF
		echo "render candles here..";

		echo $after_widget;
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
		$instance['title'] = strip_tags( $new_instance['title'] );

		return $instance;
	}

	/**
	 * Back-end widget form.
	 *
	 * @see WP_Widget::form()
	 *
	 * @param array $instance Previously saved values from database.
	 */
	public function form( $instance ) {
		if ( isset( $instance[ 'title' ] ) ) {
			$title = $instance[ 'title' ];
		}
		else {
			$title = 'Light A Candle';
		}
		?>
		<p>
		<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
		<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<?php wp_dropdown_categories( 'show_count=1&hierarchical=1' ); ?>
		</p>
		<?php 
	}

}

// run the widget
add_action( 'widgets_init', create_function( '', 'register_widget("light_a_candle");' ) );





