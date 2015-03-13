<?php
/**
 * Template Name: Testimonial Post Type & Taxonomies
 *
 * Sets up the main post type
 *
 * @package     handsometestimonials
 * @copyright   Copyright (c) 2014, Kevin Marshall
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */

/************ [Register Testimonials Post Type] *************/

add_action( 'init', 'testiment_testimonial_register', 0 );

function testiment_testimonial_register() {

	$labels = array(
		'name'                => _x( 'Testimonials', 'Post Type General Name', 'hndtst_loc' ),
		'singular_name'       => _x( 'testimonial', 'Post Type Singular Name', 'hndtst_loc' ),
		'menu_name'           => __( 'Testimonials', 'hndtst_loc' ),
		'parent_item_colon'   => __( 'Parent Item:', 'hndtst_loc' ),
		'all_items'           => __( 'All Testimonials', 'hndtst_loc' ),
		'view_item'           => __( 'View Item', 'hndtst_loc' ),
		'add_new_item'        => __( 'Add New Testimonial', 'hndtst_loc' ),
		'add_new'             => __( 'Add New', 'hndtst_loc' ),
		'edit_item'           => __( 'Edit Item', 'hndtst_loc' ),
		'update_item'         => __( 'Update Item', 'hndtst_loc' ),
		'search_items'        => __( 'Search Testimonials', 'hndtst_loc' ),
		'not_found'           => __( 'Not found', 'hndtst_loc' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'hndtst_loc' ),
	);
	$args = array(
		'label'               => __( 'testimonial', 'hndtst_loc' ),
		'description'         => __( 'Testimonials or Customer Reviews', 'hndtst_loc' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'thumbnail', 'page-attributes' /*, 'editor' */ ),
		'taxonomies'          => array( 'category' ), /* Remove until 'list testimonials by category' feature */
		'hierarchical'        => false,
        'rewrite'             => array( 'slug' => 'testimonial' ),
		'public'              => false,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'show_in_nav_menus'   => true,
		'show_in_admin_bar'   => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-testimonial',
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'page',
	);
	register_post_type( 'testimonial', $args );

}


/************ [ Add/Edit Testimonial Admin Screen ] *************/

//Hide Page-Attributes Box from Sidebar
add_action('do_meta_boxes', 'rm_handsometestimonials_page_attributes_box');

function rm_handsometestimonials_page_attributes_box() {

    remove_meta_box( 'pageparentdiv', 'testimonial', 'side' );
}

//Move Featured Image Meta Box to Main Column
add_action('do_meta_boxes', 'handsometestimonials_image_box');

function handsometestimonials_image_box() {

    remove_meta_box( 'postimagediv', 'testimonial', 'side' );
    add_meta_box('postimagediv', __('Testimonial Image'), 'post_thumbnail_meta_box', 'testimonial', 'normal', 'high');
}
     

//---------- Testimonial Meta Box ----------//
/**
 * Adds a box to the main column on the Post and Page edit screens.
 */
function handsometestimonials_add_meta_box() {

    $screens = array( 'testimonial' );

    foreach ( $screens as $screen ) {

        add_meta_box(
            'handsometestimonials_meta_box',
            __( 'Testimonial Info', 'hndtst_loc' ),
            'handsometestimonials_meta_box_callback',
            $screen
        );
    }
}
add_action( 'add_meta_boxes', 'handsometestimonials_add_meta_box' );

/**
 * Prints the box content.
 * 
 * @param WP_Post $post The object for the current post/page.
 */
function handsometestimonials_meta_box_callback( $post ) {

    // Add an nonce field so we can check for it later.
    wp_nonce_field( 'handsometestimonials_meta_box', 'handsometestimonials_meta_box_nonce' );

    /*
     * Use get_post_meta() to retrieve an existing value
     * from the database and use the value for the form.
     */
    $testimonial_subtitle = get_post_meta( $post->ID, '_subtitle_meta_value_key', true );
    $testimonial_subtitle_link = get_post_meta( $post->ID, '_subtitle_link_meta_value_key', true );
    $testimonial_short = get_post_meta( $post->ID, '_testimonialshort_meta_value_key', true );



    //Subtitle Field
    echo '<label for="testimonial_subtitle">';
    _e( 'Testifier\'s Title, Position, or Location: ', 'hndtst_loc' );
    echo '</label> ';
    echo '<input type="text" id="testimonial_subtitle" name="testimonial_subtitle" placeholder="CEO, Acme Corporation" value="' . esc_attr( $testimonial_subtitle ) . '" size="25" />';

    //Subtitle Link Field
        echo '<br /><label for="testimonial_subtitle_link">';
        _e( 'Testifier\'s URL: ', 'hndtst_loc' );
        echo '</label> ';
        echo '<input type="text" id="testimonial_subtitle_link" name="testimonial_subtitle_link" placeholder="http://website.com" value="' . esc_attr( $testimonial_subtitle_link ) . '" size="25" />';

    //Short Testimonial Field
    echo '<p><label for="testimonial_short">';
    _e( '<b>Testimonial: </b>', 'hndtst_loc' );
    echo '</label></p> ';
    wp_editor( $testimonial_short, 'testimonial_short', $settings = array( 'textarea_rows' => 5, 'media_buttons' => false ) );
}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function handsometestimonials_save_meta_box_data( $post_id ) {

    /*
     * We need to verify this came from our screen and with proper authorization,
     * because the save_post action can be triggered at other times.
     */

    // Check if our nonce is set.
    if ( ! isset( $_POST['handsometestimonials_meta_box_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['handsometestimonials_meta_box_nonce'], 'handsometestimonials_meta_box' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'testimonial' == $_POST['testimonial'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    } else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */
    
    // Make sure that these fields are set.
    if ( ! isset( 
            $_POST['testimonial_subtitle'] ,
            $_POST['testimonial_short'] 
                ) 
        ) {
        return;
    }

    // Sanitize user input.
    $my_data_testimonial_subtitle = wp_kses_post( $_POST['testimonial_subtitle'] );
    $my_data_testimonial_subtitle_link = wp_kses_post( $_POST['testimonial_subtitle_link'] );
    $my_data_testimonial_short = wp_kses_post( $_POST['testimonial_short'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_subtitle_meta_value_key', $my_data_testimonial_subtitle );
    update_post_meta( $post_id, '_subtitle_link_meta_value_key', $my_data_testimonial_subtitle_link );
    update_post_meta( $post_id, '_testimonialshort_meta_value_key', $my_data_testimonial_short );
}
add_action( 'save_post', 'handsometestimonials_save_meta_box_data' );


/************ [ALL Testimonials Edit Screen] *************/


// Edit and Manage Testimonial Post Type Columns
add_filter ( 'manage_edit-testimonial_columns', 'set_custom_edit_handsometestimonials_columns' );
function set_custom_edit_handsometestimonials_columns ($columns, $post_id ) {
    $columns = array(
        'cb' => '<input type="checkbox" />',        
        'title' => 'Testifier\'s Name',
        'tst_id' => 'ID',
        'shortcode' => 'Shortcode',
        'featured_image' => 'Featured Image',
        'date' => 'Date',
        'menu_order' => 'Custom Order',
        );
    return $columns;
}

// GET FEATURED IMAGE  
function handsometestimonials_get_featured_image($post_ID) {  
    $post_thumbnail_id = get_post_thumbnail_id($post_ID);  
    if ($post_thumbnail_id) {  
        $post_thumbnail_img = wp_get_attachment_image_src($post_thumbnail_id, 'featured_preview');  
        return $post_thumbnail_img[0];  
    }  
} 

//Set Column Styling
add_action('admin_head', 'testimonial_edit_column_styling');
function testimonial_edit_column_styling() {
    echo '<style type="text/css">';
    echo '.column-tst_id { width: 80px; }';
    echo '.column-menu_order { width: 130px; text-align: center;}';
    echo '.column-featured_image { width: 120px; text-align: center;}';
    echo '</style>';
}

//Get Content From Columns on Testimonial Edit Screen
add_action( 'manage_testimonial_posts_custom_column' , 'custom_testimonial_column', 10, 2 );
function custom_testimonial_column( $column, $post_ID ) {
    global $post;
    switch ( $column ) {

        case 'menu_order' :
            $order = '<span class="dashicons dashicons-sort"></span>';
            //$order = $post -> menu_order; //uncomment to display actual numerical order
            echo $order;
            break;        
        case 'tst_id' :
            echo $post_ID;
            break;
        case 'shortcode' :
            $shortcode = '[testimonial_single id="'.$post_ID.'"]';
            echo $shortcode;
            break;        
        case 'featured_image' :
            $post_featured_image = handsometestimonials_get_featured_image($post_ID);  
            if ($post_featured_image) {  
                echo '<img width="100px" src="' . $post_featured_image . '" />';  
            }
            break;
            
   }
}

//Make testimonial 'order' column sortable
add_filter( 'manage_edit-testimonial_sortable_columns', 'sort_testimonial_order_column' );
function sort_testimonial_order_column( $columns ) {
    $columns['menu_order'] = 'menu_order';
 
    //To make a column 'un-sortable' remove it from the array
    //unset($columns['date']);
 
    return $columns;
}


//Sort Testimonial Admin Page to Ascending 'Order' by Default
add_action( 'pre_get_posts', 'testimonial_sort_orderby' );

    function testimonial_sort_orderby( $query ) {
        // check if we're in admin, if not exit
        if ( ! 'is_admin' ) {
            return;
        }
 
        $post_type = $query->get('post_type');
 
        if ( $post_type == 'testimonial' ) {
            /* Post Column: e.g. title */
            if ( $query->get( 'orderby' ) == '' ) {
                $query->set( 'orderby', 'menu_order' );
            }
            /* Post Order: ASC / DESC */
            if( $query->get( 'order' ) == '' ){
                $query->set( 'order', 'ASC' );
            }
        }
    }


// Changes Title from "Enter title here" to "Enter Person's name" for Testimonials
add_filter('gettext', 'testimonial_custom_rewrites', 10, 4);

function testimonial_custom_rewrites($translation, $text, $domain) {
    global $post;
        if ( ! isset( $post->post_type ) ) {
            return $translation;
        }
    $translations = get_translations_for_domain($domain);
    $translation_array = array();
 
    switch ($post->post_type) {
        case 'testimonial': // enter your post type name here
            $translation_array = array(
                'Enter title here' => "Name of Testifier"
            );
            break;
    }
 
    if (array_key_exists($text, $translation_array)) {
        return $translations->translate($translation_array[$text]);
    }
    return $translation;
}

/************ [ Testimonial Template ] *************/
add_filter( 'template_include', 'include_template_handsometestimonials', 1 );

function include_template_handsometestimonials( $template_path ) {
    if ( get_post_type() == 'testimonial' ) {
        if ( is_single() ) {
            // checks if the file exists in the theme first,
            // otherwise serve the file from the plugin
            if ( $theme_file = locate_template( array ( 'single-handsometestimonials.php' ) ) ) {
                $template_path = $theme_file;
            } else {
                $template_path = plugin_dir_path( __FILE__ ) . 'single-handsometestimonials.php';
            }
        }
    }
    //write_log('template-path'.$template_path);
    return $template_path;
}
?>