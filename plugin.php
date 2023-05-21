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
        add_action( 'init', array($this, 'load_text_domain') );
        add_filter('the_content', array($this, 'add_meta_info_at_the_end_of_content'));
    }

    /**
     * Load plugin textdomain.  
     */
    function load_text_domain() {
        load_plugin_textdomain( 'sorth_book', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }


    /**
     * sample function to show our custom meta data in front
     * we can use custom templates for our cpt if we want but for now we dont need.
     * @param String $content content that will print in front
     */
    function add_meta_info_at_the_end_of_content($content){
        // check if we are in front
        if(is_admin()) return $content;

        // check if we are in single post (sorth_books cpt)
        global $post;
        if($post->post_type != 'sorth_books') return $content;

        // get saved meta data
        $book_author_name = get_post_meta($post->ID, 'book_author_name', true);
        $book_isbn = get_post_meta($post->ID, 'book_isbn', true);
        $book_price = get_post_meta($post->ID, 'book_price', true);
        ob_start();
        ?>
        <table>
            <tr>
                <th><?php _e( 'Author Name', 'sorth_book' ); ?></th>
                <td><?php echo esc_html( $book_author_name ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'ISBN', 'sorth_book' ); ?></th>
                <td><?php echo esc_html( $book_isbn ); ?></td>
            </tr>
            <tr>
                <th><?php _e( 'Price', 'sorth_book' ); ?></th>
                <td><?php echo esc_html( $book_price ); ?></td>
            </tr>
        </table>
		<?php
        return $content.ob_get_clean();

    }
}
main::instance();

/**
 * including other classes
 */
require_once WPBOOKPATH.'inc/cpt.php';
require_once WPBOOKPATH.'inc/metabox.php';