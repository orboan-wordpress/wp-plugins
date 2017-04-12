<?php 
/*
Plugin Name: IAW Dashboard Widget
Plugin URI: iaw.io
Description: A simple plugin to create a dashboard widget
Version: 1.0
Author: Oriol Boix Anfosso <dev@orboan.com>
Author URI: orboan.com
License: GPLv2
*/

add_action('wp_dashboard_setup', 'orb_iaw_dashboard_widget');

function orb_iaw_dashboard_widget(){
    //create a custom dashboard widget
    wp_add_dashboard_widget('dashboard_custom_iaw', 'IAW info',
    'orb_iaw_dashboard_display');
}

function orb_iaw_dashboard_display() {
    echo '<p>Implantació d\'Aplicacions Web a <a href="http://iaw.io" 
    target="_blank">iaw.io</a></p>';
}
?>