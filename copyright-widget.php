<?php 
/*
Plugin Name: Copyright Widget
Plugin URI: http://orboan.com/wp/copyright-widget/
Description: A widget plugin to create copyrigt lines in Wordpress
Version: 1.0
Author: Oriol Boix Anfosso <dev@orboan.com>
Author URI: http://orboan.com/contact/
License: GPLv2
*/

//Use widgets_init action hook to execute custom function
add_action('widgets_init', 'orb_wex_register_widgets');

//Register this widget
function orb_wex_register_widgets(){
    register_widget('orb_wex_widget_example');
}

//orb_wex_widget_example class
class orb_wex_widget_example extends WP_Widget {
    //Process the new widget (constructor)
    function __construct () {
        $widget_ops = array(
            'classname' => 'orb_wex_widget_copyright',
            'description' => 'This widget easilly adds the copyright.'
            );
        parent::__construct('orb_wex_widget_copyright', 'Copyright Widget', $widget_ops);
    }
    
    //Build the widget settings form
    function form($instance) {
        $defaults = array(
            'title' => 'Copyright widget',
            'name' => '',
            'year' => '');
        $instance = wp_parse_args((array)$instance, $defaults);
        $title = $instance['title'];
        $name = $instance['name'];
        $year = $instance['year'];
        ?>
            <p><?php echo esc_attr($title); ?></p>
            <p>Personal or business name: <input class="widefat" 
            name="<?php echo $this->get_field_name('name'); ?>"
            type="text" value="<?php echo esc_attr($name); ?>"
            /></p>
            <p>Year(s): <input class="widefat" 
            name="<?php echo $this->get_field_name('year'); ?>"
            type="text" value="<?php echo esc_attr($year); ?>"
            /></p>            
        <?php
    }
    
    //save the widget settings
    function update($new_instance, $old_instance) {
        $instance = $old_instance;
        $instance['name'] = strip_tags($new_instance['name']);
        $instance['year'] = strip_tags($new_instance['year']);
        return $instance;
    }
    
    //display the widget
    function widget($args, $instance) {
        extract($args);
        echo $before_widget;
        $title = apply_filters('widget_title', $instance['title']);
        $name = empty($instance['name']) ? '&nbsp;' : $instance['name'];
        $year = empty($instance['year']) ? '&nbsp;' : $instance['year'];
        
        if(!empty($title)) {
            echo $before_title . $title . $after_title;
        };
        echo '<p>&copy; ' . $year . ' ' . $name . ' | All rights reserved.</p>';
        echo $after_widget;
    }
}
?>