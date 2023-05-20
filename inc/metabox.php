<?php 
namespace SorthBooks\MetaBox;
defined('ABSPATH') or die();
class MetaBox {
    private static $instance = null;
    public static function instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
    }	
        return self::$instance;
        }
    
    function __construct(){
        
    }

   static function metabox_cb($post){
    
    }

}
MetaBox::instance();