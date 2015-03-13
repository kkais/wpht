<?php
/**
 * Template Name: Admin Alerts and Notices
 *
 * Displays various alerts and communications for plugin in the backend
 *
 * @package     handsometestimonials
 * @copyright   Copyright (c) 2014, Kevin Marshall
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */

//Display request to view get started screen

add_action('admin_notices', 'htst_admin_notice_getstarted');

function htst_admin_notice_getstarted() {
    global $current_user ;
        $user_id = $current_user->ID;
        /* Check that the user hasn't already clicked to ignore the message */
    if ( ! get_user_meta($user_id, 'htst_ignore_notice') ) {
        echo '<div class="updated"><p>'; 
        printf(__('<a href="edit.php?post_type=testimonial&page=htst_getting_started">Get Started</a> with Handsome Testimonials. <span style="float: right;"><i><a href="%1$s">Dismiss</a></i></span>'), '?htst_nag_ignore_getstarted=0');
        echo "</p></div>";
    }
}

add_action('admin_init', 'htst_nag_ignore_getstarted');

function htst_nag_ignore_getstarted() {
    global $current_user;
        $user_id = $current_user->ID;
        /* If user clicks to ignore the notice, add that to their user meta */
        if ( isset($_GET['htst_nag_ignore_getstarted']) && '0' == $_GET['htst_nag_ignore_getstarted'] ) {
             add_user_meta($user_id, 'htst_ignore_notice', 'true', true);
    }
}

?>