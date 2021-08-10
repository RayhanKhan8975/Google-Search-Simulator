<?php 
/**
 * Plugin Name:       Local Search Simulator
 * Description:       Gives search results based on the choosen location
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Code Reliable and Aman Khan
 * Author URI:        https://www.upwork.com/freelancers/~014023f820b4940974
 */
//includes

include('enqueue.php');
include('main.php');
//actions
add_action('wp_enqueue_scripts', 'local_search_enqueue');
add_action('wp_loaded', 'ls_shortcode',100);
function ls_shortcode(){
add_shortcode('local_simulator','show_local_simulator');   
}