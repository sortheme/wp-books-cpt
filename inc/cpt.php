<?php 
namespace SorthBooks\CPT;
defined('ABSPATH') or die();

/**
 * class to register our custom cpt name "book"
 */
class cpt {
    private static $instance = null;
    public static function instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
        }	
        return self::$instance;
    }

    function __construct(){
        add_action( 'init', array($this, 'register_cpt') );
        add_action( 'init', array($this, 'register_tax') );
    }

    function register_cpt(){
        $labels = array(
            'name'                  => __('Books', 'sorth_book'),
            'singular_name'         => __('Book', 'sorth_book'),
            'name_admin_bar'        => __( 'Book', 'sorth_book' ),
            'add_new'               => __( 'Add New', 'sorth_book' ),
            'add_new_item'          => __( 'Add New Book', 'sorth_book' ),
            'new_item'              => __( 'New Book', 'sorth_book' ),
            'edit_item'             => __( 'Edit Book', 'sorth_book' ),
            'view_item'             => __( 'View Book', 'sorth_book' ),
            'all_items'             => __( 'All Books', 'sorth_book' ),
            'search_items'          => __( 'Search Books', 'sorth_book' ),
        );
        register_post_type('sorth_books',
            array(
                'labels'                => $labels,
                'public'                => true,
                'has_archive'           => true,
                'show_in_rest'          => true,
                'capability_type'       => 'post',
                'menu_icon'             => 'dashicons-book-alt',
                'supports'              => array('title', 'editor', 'thumbnail'),
                'taxonomies'            => array('author', 'genre'),
                'rewrite'               => array('slug' => 'books'),
                'register_meta_box_cb'  => array('SorthBooks\MetaBox\MetaBox', 'metabox_cb'),
                )
            );
    }

    function register_tax(){ 

        // TODO :: use $labels as array

        register_taxonomy( 'author', 'book', array(
            'rewrite'      => array( 'slug' => 'books/author' )
        ) );

        register_taxonomy( 'genre', 'book', array(
            'rewrite'      => array( 'slug' => 'books/genre' )
        ) );
    }

}
cpt::instance();
