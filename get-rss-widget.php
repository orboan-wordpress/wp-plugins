<?php 
/*
Plugin Name: Get RSS Widget
Plugin URI: http://orboan.com/wp/get-rss-widget/
Description: A widget plugin to retrieve
Version: 1.0
Author: Oriol Boix Anfosso <dev@orboan.com>
Author URI: http://orboan.com/contact/
License: GPLv2
*/

//Use widgets_init action hook to execute custom function
add_action('widgets_init', 'orb_register_widgets');

//Register this widget
function orb_register_widgets(){
    register_widget('orb_get_rss');
}

//orb_get_rss class
class orb_get_rss extends WP_Widget {
    //Process the new widget (constructor)
    function __construct () {
        $widget_ops = array(
            'classname' => 'orb_get_rss_class',
            'description' => 'This widget retrieves and displays an RSS feed.'
            );
        parent::__construct('orb_get_rss', 'Get RSS Widget', $widget_ops);
    }
    
    //Build the widget settings form
    function form($instance) {
        $defaults = array(
            'title' => 'RSS Feed',
            'rss_feed' => 'http://orboan.com/?feed=rss2',
            'rss_items' => '2');
        $instance = wp_parse_args((array)$instance, $defaults);
        $title = $instance['title'];
        $rss_feed = $instance['rss_feed'];
        $rss_items = $instance['rss_items'];
        $rss_date = $instance['rss_date'];
        $rss_summary = $instance['rss_summary'];
        ?>
            <p>Title: <input class="widefat" 
            name="<?php echo $this->get_field_name('title'); ?>"
            type="text"
            value="<?php echo esc_attr($title); ?>"
            /></p>
            <p>RSS Feed: <input class="widefat" 
            name="<?php echo $this->get_field_name('rss_feed'); ?>"
            type="text" value="<?php echo esc_attr($rss_feed); ?>"
            /></p>
            <p>Items to display: <select
            name="<?php echo $this->get_field_name('rss_items'); ?>">
                <option value="1" <?php selected($rss_items,1); ?>>1</option>
                <option value="2" <?php selected($rss_items,2); ?>>2</option>
                <option value="3" <?php selected($rss_items,3); ?>>3</option>
                <option value="4" <?php selected($rss_items,4); ?>>4</option>
                <option value="5" <?php selected($rss_items,5); ?>>5</option>
            </select>
            </p> 
            <p>Show date?: <input type="checkbox" 
            name="<?php echo $this->get_field_name('rss_date') ?>"
            <?php checked($rss_date, 'on'); ?>
            /></p>
            <p>Show summary?: <input type="checkbox"
            name="<?php echo $this->get_field_name('rss_summary') ?>"
            <?php checked($rss_summary, 'on'); ?>
            </p>
        <?php
    }
    
    //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['rss_feed'] = strip_tags($new_instance['rss_feed']);
        $instance['rss_items'] = strip_tags($new_instance['rss_items']);
        $instance['rss_date'] = strip_tags($new_instance['rss_date']);
        $instance['rss_summary'] = strip_tags($new_instance['rss_summary']);       
        return $instance;
    }
    
    //display the widget
    function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        
        //load the widget settings
        $title = apply_filters('widget_title', $instance['title']);
        $rss_feed = empty($instance['rss_feed']) ? '' : $instance['rss_feed'];
        $rss_items = empty($instance['rss_items']) ? 2 : $instance['rss_items'];
        $rss_date = empty($instance['rss_date']) ? 0 : 1;
        $rss_summary = empty($instance['rss_summary']) ? 0 : 1;
        if(!empty($title)) {
            echo $before_title . $title . $after_title;
        };
        if($rss_feed){
            //Display the RSS feed
            wp_widget_rss_output(array(
                'url' => $rss_feed,
                'title' => $title,
                'items' => $rss_items,
                'show_summary' => $rss_summary,
                'show_author' => 0,
                'show_date' => $rss_date
                ));
        }
        echo $after_widget;
    }
}
?>