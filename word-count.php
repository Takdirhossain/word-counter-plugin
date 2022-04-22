<?php
/*
plugin name: Word counter
plugin URI: https://takdirhossain.com/
Description: This plugin count any post word.
Version: 1.0
Author: Takdir
Author URI: https://takdirhossain.com/
License: GPLv2 or later
Text Domain: word count
Domain path: /laguages/
*/ 

function wordcount_activation_hook(){

}
register_activation_hook( __FILE__, "wordcount_activation_hook");

function wordcount_deactivation_hook(){

}
register_deactivation_hook( __FILE__, "wordcount_deactivation_hook");

function wordcount_loadtext_domain(){
    load_plugin_textdomain( 'wordcount', false, dirname (__FILE__). "/languages");
}
add_action("plugins_loaded", 'wordcount_loadtext_domain' );
 
function wordcount_count_word($content){
    $stripped_content = strip_tags($content);
    $wordn = str_word_count($stripped_content);
    $label = __('The Number Of Word', 'word-count');
    $content .=sprintf ('<h2> %s: %s</h2>', $label, $wordn);
    return $content;

}
add_filter( 'the_content', 'wordcount_count_word');
 
function wordcount_reading_time($content){
    $stripped_content = strip_tags ($content);
    $wordn = str_word_count($stripped_content);
    $reading_menits = floor($wordn / 200);
    $reading_seconds = floor($wordn % 200 / (200 % 60));
    $is_visibal = apply_filters( 'wordcount_display_reading_time', 1 );
    if($is_visibal){
        $label = __('Total Reading time', 'word-count');
        $label = apply_filters( 'Wordcount_readingtime_heading', $label );
        $tag = apply_filters( 'Wordcount_readingtime_tag', 'h4' );
        $content .= sprintf('<%s>%s:  %s Minutes %s seconds</%s>', $tag, $label, $reading_menits, $reading_seconds, $tag);

    }
    return $content;
}
add_filter( 'the_content', 'wordcount_reading_time' );
