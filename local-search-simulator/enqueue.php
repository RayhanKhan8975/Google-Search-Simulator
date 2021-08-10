<?php 

function local_search_enqueue()
{
wp_register_style( 'local_style', plugins_url('style.css', __FILE__ ));
wp_enqueue_style( 'local_style' );
}