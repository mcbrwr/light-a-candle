<?php
/*
Plugin Name: Light a candle
Plugin URI: https://github.com/mcbrwr/light-a-candle
Description: Show virtual candles for people in a sidebarwidget, based on posts in a category.
Author: Art & Flywork
Version: 1
Author URI: http://artandflywork.com
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

function renderCandles($cat) {
	echo "<ul>candles from cat $cat</ul>";
}

function widget_candles($args) {
 extract($args);
 echo $before_widget;
 echo $before_title;
 echo $after_title;
 renderCandles(9); // render alle candles uit category 9
 echo $after_widget;
}

function candlesInit() {
  wp_register_sidebar_widget(
    'light_a_candle',
    'Light A Candle',
    'widget_candles',
    array(
        'description' => 'Show candles for people in the sidebar based on titles in a specific post categorie'
    )
	);
}

add_action("plugins_loaded", "candlesInit");
