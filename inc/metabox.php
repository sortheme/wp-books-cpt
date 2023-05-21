<?php 
namespace SorthBooks\MetaBox;
defined('ABSPATH') or die();
/**
 * class for render and showing custom meta box with custom meta data
 */
class MetaBox {
    private static $instance = null;
    public static function instance(){
        if( is_null(self::$instance) ){
            self::$instance = new self();
    }	
        return self::$instance;
        }
    
    function __construct(){
        add_action( 'save_post', array( $this, 'save_book') );
    }

    function metabox_cb($post){
        if($post->post_type != 'sorth_books') return;
        add_meta_box(
            'book information',
            __( 'Book Information', 'sorth_book' ),
            array( $this, 'meta_box_content' ),
            'sorth_books',
            'advanced',
            'high'
        );
    }

    /**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
    function meta_box_content($post){
        // get saved meta data
        $book_author_name = get_post_meta($post->ID, 'book_author_name', true);
        $book_isbn = get_post_meta($post->ID, 'book_isbn', true);
        $book_price = get_post_meta($post->ID, 'book_price', true);

        // print a nonce field to check in save hook
        wp_nonce_field( 'sorth_books_meta', 'sorth_books_meta_nonce' );

        ?>
        <table>
            <tr>
                <th><label for="book_author_name"><?php _e( 'Author Name', 'sorth_book' ); ?></label></th>
                <td><input type="text" id="book_author_name" name="book_author_name" value="<?php echo esc_attr( $book_author_name ); ?>" size="25" /></td>
            </tr>
            <tr>
                <th><label for="book_isbn"><?php _e( 'ISBN', 'sorth_book' ); ?></label></th>
                <td><input type="text" id="book_isbn" name="book_isbn" value="<?php echo esc_attr( $book_isbn ); ?>" size="25" /></td>
            </tr>
            <tr>
                <th><label for="book_price"><?php _e( 'Price', 'sorth_book' ); ?></label></th>
                <td><input type="number" id="book_price" name="book_price" value="<?php echo esc_attr( $book_price ); ?>" size="25" min="0" /></td>
            </tr>
        </table>
		<?php
    }

    /**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
    function save_book($post_id){
        // Check if our nonce is set.
		if ( ! isset( $_POST['sorth_books_meta_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['sorth_books_meta_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'sorth_books_meta' ) ) {
			return $post_id;
		}

        /*
		 * If this is an autosave, our form has not been submitted,
		 * so we don't want to do anything.
		 */
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

        
        // check user permissions        
        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return $post_id;
        }

        // get posted meta data
        $book_author_name = sanitize_text_field( $_POST['book_author_name'] );
        $book_isbn = sanitize_text_field( $_POST['book_isbn'] );
        $book_price = intval($_POST['book_price']);

        // save and update meta data
        update_post_meta( $post_id, 'book_author_name', $book_author_name );
        update_post_meta( $post_id, 'book_isbn', $book_isbn );
        update_post_meta( $post_id, 'book_price', $book_price );

        
    }
}
MetaBox::instance();