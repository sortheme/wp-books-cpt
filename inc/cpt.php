<?php 
namespace SorthBooks\CPT;
defined('ABSPATH') or die();

/**
 * class to register our custom cpt name "book" and our custom taxonomies "Genre" and "Author"
 */
class CPT {
    private static $instance = null;
    public static function instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
        }	
        return self::$instance;
    }

    function __construct(){
        add_action( 'init', array($this, 'register_cpt') );
        add_action( 'init', array($this, 'register_tax'), 15 );
    }

    /**
     * register our cpt, since "books" is very common we avoid it, and we use "sorth_books" instead.
     * but we use "books" as slug for front 
     */
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
                'taxonomies'            => array('book_author', 'genre'),
                'rewrite'               => array('slug' => 'books'),
                // 'register_meta_box_cb'  => array('SorthBooks\MetaBox\MetaBox', 'metabox_cb'),
                'register_meta_box_cb'  => array(\SorthBooks\MetaBox\MetaBox::instance(), 'metabox_cb'),
                )
            );
    }

    /**
     * register our custom taxonomies
     */
    function register_tax(){ 

        // TODO :: use $labels as array

        // author is a builtin in wordpress, so we should avoid it.
        register_taxonomy( 'book_author', 'sorth_books', array(
            'labels'      => array(
                'name'              => __('Book Authors', 'sorth_book'),
                'singular_name'     => __('Book Author', 'sorth_book'),
                'menu_name'         => __('Authors', 'sorth_book'),
                'all_items'         => __( 'All Authors', 'sorth_book' ),
                'edit_item'         => __( 'Edit Author', 'sorth_book' ),
                'update_item'       => __( 'Update Author', 'sorth_book' ),
                'add_new_item'      => __( 'Add New Author', 'sorth_book' ),
                'new_item_name'     => __( 'New Author Name', 'sorth_book' ),
            ),
            'public'     => true,
            'show_in_rest' => true,   
            'rewrite'      => array( 'slug' => 'book_author' )
        ) );

        register_taxonomy( 'genre', 'sorth_books', array(
            'labels'      => array(
                'name'              => __('Genres', 'sorth_book'),
                'singular_name'     => __('Genre', 'sorth_book'),
                'menu_name'         => __('Genres', 'sorth_book'),
                'all_items'         => __( 'All Genres', 'sorth_book' ),
                'edit_item'         => __( 'Edit Genre', 'sorth_book' ),
                'update_item'       => __( 'Update Genre', 'sorth_book' ),
                'add_new_item'      => __( 'Add New Genre', 'sorth_book' ),
                'new_item_name'     => __( 'New Genre Name', 'sorth_book' ),
            ),
            'public'     => true,
            'show_in_rest' => true,   
            'rewrite'      => array( 'slug' => 'genre' )
        ) );

    }

}
cpt::instance();
