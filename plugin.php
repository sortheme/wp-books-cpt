<?php 
namespace SorthBooks;
class main {
    private static $instance = null;
    public static function instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
        }	
        return self::$instance;
    }

    function __construct(){
    }
}
main::instance();

/**
 * including other classes
 */
require_once WPBOOKPATH.'inc/cpt.php';
require_once WPBOOKPATH.'inc/metabox.php';