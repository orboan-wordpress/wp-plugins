<?php 
/*
Plugin Name: RSS Dashboard Widget
Plugin URI: orboan.io/wp/rss-dashboard
Description: A simple plugin to create a dashboard widget for rss
Version: 1.0
Author: Oriol Boix Anfosso <dev@orboan.com>
Author URI: orboan.com
License: GPLv2
*/

add_action('wp_dashboard_setup', 'orb_rss_dashboard_widget');

function orb_rss_dashboard_widget() {
    //create a custom dashboard widget
    wp_add_dashboard_widget('dashboard_custom_feed', 'RSS feed',
    'orb_rss_dashboard_display', 'orb_rss_dashboard_setup');
}

function orb_rss_dashboard_setup() {
    
    //check if option is set before saving
    if(isset($_POST['orb_rss_feed'])) {
        //retrieve the option value from the form
        $orb_rss_feed = esc_url_raw($_POST['orb_rss_feed']);
        //save the value as an option
        update_option('orb_rss_dashboard_widget', $orb_rss_feed);
    }
    
    //load the saved feed if it exists
    $orb_rss_feed = get_option('orb_rss_dashboard_widget');
    
?>
    <label for="feed">
        RSS feed URL: <input type="text" name="orb_rss_feed"
        id="orb_rss_feed" 
        value="<?php echo esc_url($orb_rss_feed); ?>"
        size="50" />
    </label>
    
<?php
    
}

function orb_rss_dashboard_display() {
    //load our widget option
    $orb_option = get_option('orb_rss_dashboard_widget');
    //if option is empty, set a default
    $default_feed = 'http://orboan.com/category/Java/feed';
    $orb_rss_feed = ($orb_option) ? $orb_option : $default_feed;
    
    //retrieve the RSS feed and display it
    echo '<div class="rss-widget">';
    wp_widget_rss_output( array(
        'url' => $orb_rss_feed,
        'title' => 'RSS feed news',
        'items' => 2,
        'show_summary' => 1,
        'show_author' => 0,
        'show_date' => 1
        ));
    echo '</div>';
}
?>