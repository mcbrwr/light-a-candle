<?php
/*
Plugin Name: Light a candle
Plugin URI: https://github.com/mcbrwr/light-a-candle
Description: Show virtual candles for people in a sidebarwidget, based on posts in a category.
Author: Art & Flywork
Version: 1.0
Author URI: http://artandflywork.com
*/

// Prevent direct file access
if ( ! defined ( 'ABSPATH' ) ) {
	exit;
}


/**
 * Include scripts & CSS for the plugin
 */
function candle_assets() {
  wp_enqueue_style( 'candles-styles',  plugin_dir_url( __FILE__ ) . 'assets/css/candles.css' );
  wp_enqueue_style( 'flexslider-styles',  plugin_dir_url( __FILE__ ) . 'assets/vendor/flexslider/flexslider.css' );
  wp_enqueue_script( 'flexslider' , plugin_dir_url( __FILE__ ) . 'assets/vendor/flexslider/jquery.flexslider-min.js', array('jquery'));
  wp_enqueue_script('candles-script', plugin_dir_url( __FILE__ ) . 'assets/js/candles.js', array('flexslider'));
  //wp_enqueue_script( 'candles-script' );
}
add_action( 'wp_enqueue_scripts', 'candle_assets' );

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
		$cat  = $instance['cat'];
		$names = get_posts( array('category' => $cat, 'orderby' => 'rand') );
		echo '<div class="flexslider light-a-candle--candlebox">';
		echo '<ul class="slides light-a-candle--candlelist">';
		foreach ( $names as $post ) : setup_postdata( $post );			
			echo '<li class="light-a-candle--candle slide">'. $post->post_title . '</li>';
		endforeach;
		echo '</ul>';
		echo '</div>';
		wp_reset_postdata();

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
		$instance['cat'] = strip_tags( $new_instance['cat'] );
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

		$title = ! empty( $instance['title'] ) ? $instance['title'] : "Light A Candle";
		$cat = ! empty( $instance['cat'] ) ? $instance['cat'] : 0;

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label><br>
			<input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />
		</p>
		<p>
			<label for="<?php echo $this->get_field_id( 'cat' ); ?>">Select a posts category, titles of the posts in that category should be the names to present</label><br>
			<?php wp_dropdown_categories( 'hide_empty=0&hierarchical=1&selected='.$cat."&name=".$this->get_field_name( 'cat' )."&id=".$this->get_field_id( 'cat' ) ); ?>
		</p>
		<?php 
	}

}

// run the widget
add_action( 'widgets_init', create_function( '', 'register_widget("light_a_candle");' ) );





