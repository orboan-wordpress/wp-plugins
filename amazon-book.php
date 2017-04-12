<?php 
/*
Plugin Name: Shorcodes for books from Amazon
Plugin URI: orboan.io/wp/amazon-book
Description: Replace [amazon asin="xxx"]book title[/amazon]
Version: 1.0
Author: Oriol Boix Anfosso <dev@orboan.com>
Author URI: orboan.com
License: GPLv2
*/

//Register a new shorcode: [amazon asin="xxx"]book title[/amazon]
add_shorcode('amazon', 'orb_iaw_amazon');

//Callback function for the [amazon] shortcode
function orb_iaw_amazon($attr, $content) {
    //Get ASIN (Amazon Standard Identification Number)
    if(isset($attr['asin'])){
        //preg_replace — Perform a regular expression search and replace
        //'/[^\d]/' stands for all non numerical characters
        $asin = preg_replace('/[^\d]/', '', $attr['asin']);
    } else {
        $asin = '1633430235';
    }
    
    //Sanitize content, or set default
    if(!empty($content)) {
        $content = esc_html($content);
    } else {
        if($asin == '1633430235'){
            $content = 'Docker in action';
        } else {
            $content = 'no book';
        }
    }
    
    return "<a href='https://www.amazon.co.uk/dp/$asin' target='_blank'>$content</a>";
}