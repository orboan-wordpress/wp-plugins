<?php 
/*
Plugin Name: Simple debug
Plugin URI: orboan.io/wp/simple-debug
Description: Append ?debug=1 to display debug info if you are an admin
Version: 1.0
Author: Oriol Boix Anfosso <dev@orboan.com>
Author URI: orboan.com
License: GPLv2
*/

add_action('init', 'orb_iaw_debug_check');

function orb_iaw_debug_check(){
    if(isset($_GET['debug']) && current_user_can('manage_options')){
       if(!defined('SAVEQUERIES')){
           define('SAVEQUERIES', true);
       } 
       add_action('wp_footer', 'orb_iaw_debug_output');
    }
}

function orb_iaw_debug_output() {
    global $wpdb;
    echo "<pre>";
    print_r($wpdb->queries);
    echo "</pre>";
}
?>