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
 * run on plugin activate and deactivate
 */
function sorth_books_flush_rewrite(){
    flush_rewrite_rules();
}
register_activation_hook( __FILE__ , 'sorth_books_flush_rewrite' );
register_deactivation_hook( __FILE__ , 'sorth_books_flush_rewrite' );