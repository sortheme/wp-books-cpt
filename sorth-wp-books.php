<?php 
/**
 * Plugin Name: BookStore books cpt
 * Author: Saeed Taheri
 * Version: 1.0
 * Author uri: http://#
 * Text Domain : sorth_book
 * Domain path: /languages
 */
if(!defined('ABSPATH')){
    die(); // no direct access
}

/**
 * define needed constants
 */
if(!defined('WPBOOKPATH')){
    define('WPBOOKPATH', plugin_dir_path(__FILE__));
}
if(!defined('WPBOOKURL')){
    define('WPBOOKURL', plugin_dir_url(__FILE__));
}

// including main file
require_once WPBOOKPATH . 'plugin.php';

/**
 * run on plugin activate 
 */
function sorth_books_plugin_activate(){
    $cpt_obj = \SorthBooks\CPT\cpt::instance();
    $cpt_obj->register_cpt();
    $cpt_obj->register_tax();
    flush_rewrite_rules();
}
register_activation_hook( __FILE__ , 'sorth_books_plugin_activate' );
/**
 * run on plugin deactivate
 */
function sorth_books_plugin_deactivate(){
    unregister_post_type( 'sorth_books' );
    unregister_taxonomy('book_author');
    unregister_taxonomy('genre');
    flush_rewrite_rules();
}
register_deactivation_hook( __FILE__ , 'sorth_books_plugin_deactivate' );