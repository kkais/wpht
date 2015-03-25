<?php

/**
 * Template Name: Shortcodes
 *
 * Shortcode functions for testimonial display 
 *
 * @package     handsometestimonials
 * @copyright   Copyright (c) 2014, Kevin Marshall
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */
class handsometestimonials_shortcode {

    //Define Variables
    private $tst_shortcode;

    public function __construct() {

        add_shortcode('testimonial_single', array($this, 'dsply_testimonial'));
        add_filter('widget_text', 'do_shortcode'); //Allow for use in text box shortcodes
    }

    function dsply_testimonial($atts) {

        // Added by Khuram
        $tst_class_wraper = 'hndtst rotating-item'; // Set the variable with default css class names;
        $length = 140; // Shorten string/text length

        //Enqueue Script for rotation
        wp_register_script('hndtst_tst_rotation', TSTMT_PLUGIN_URL . 'includes/js/infinite-rotator.js', array(), false, true);
        wp_enqueue_script('hndtst_tst_rotation', TSTMT_PLUGIN_URL . 'includes/js/infinite-rotator.js', array(), false, true);

        //Enque Specified Template CSS Style
        wp_register_style('handsometestimonials_style', TSTMT_PLUGIN_URL . 'includes/css/template.css');
        wp_enqueue_style('handsometestimonials_style');

        //Assign a numerical id to the number of times the shortcode is called on the page
        static $i = 1;
        $iteration = $i;
        $i++;

        //Call function to parse shortcode
        $tst_shortcode = hndtst_shorcode_parser($atts);

        //Set Variables for call to function 'shortcode_options'
        $tstid = $tst_shortcode['id'];
        $tstiditr = $tstid . '-' . $iteration;
        $template = $tst_shortcode['template'];
        $img_loc = $tst_shortcode['img_loc'];

        
        //Set Variables for testimonials rotation query call - KKAIS
        $tst_all = $tst_shortcode['tst_all']; // Check for multiple testimonials display for rotations - KKAIS
        $tst_interval = $tst_shortcode['tst_interval']; // Get the value of rotation interval among testimonials - KKAIS
        $tst_interval *= 1000; // Convert the interval value to meet javascript function milliseconds requirements. - KKAIS

        //********* Display Testionial ***********//
        //Start output buffer
        ob_start();

        //Define Variables for Testimonial Elements - KKAIS
        $tst = '';


        //Loop to obtain testimonials - KKAIS
        $tst_args = array(
            'post_type' => 'testimonial',
        );

        // Check if single testimonial is needed - KKAIS
        //Query to obtain specific testimonial based on ID - KKAIS
        if (strtolower($tst_all) !== "yes") {

            // Set the specific testimonial id - KKAIS
            $tst_args['p'] = $tstid;

            // Remove the rotation-item class when there's only one testimonial to display - KKAIS
            $tst_class_wraper = trim(str_replace('rotating-item', '', $tst_class_wraper));
        }

        //Start Loop to display testimonial(s)
        $tst_query = new WP_Query($tst_args);

        // If pulling all the testimonials (Rotation) - KKAIS
        if ($tst_all === 'yes' ) {

            // If there are posts then - KKAIS
            if ($tst_query->have_posts()) {

                // Loop through the posts - KKAIS
                while ($tst_query->have_posts()) {

                    // Pull the post out for the current iteration - KKAIS
                    $tst_query->the_post();

                    // Update the variables with the current post values - KKAIS
                    $tstid = $tst_query->post->ID;
                    $tstiditr = $tstid . '-' . $iteration;

                    //Call function to display single testimonial 
                    $returned_css = hndtst_shortcode_single_css($tst_shortcode, $tstiditr);

                    //Set Variables after values returned from function 'shortcode_options'
                    $tst_css = $returned_css['tst_css'];

                    //Overwrite styles based upon above options
                    wp_add_inline_style('handsometestimonials_style', $tst_css);

                    //if subtitle_link exists, display subtitle hyperlinked
                    $tst_subtitle = get_post_meta($tstid, '_subtitle_meta_value_key', true);
                    $tst_subtitle_link = get_post_meta($tstid, '_subtitle_link_meta_value_key', true);

                    if ($tst_subtitle_link != null) {
                        //Testimonial subtitle has a link
                        $display_tst_subtitle = '<div id="tst_subtitle_' . $tstiditr . '"><a href="' . $tst_subtitle_link . '" id="tst_subtitle_' . $tstiditr . '" target="blank">' . $tst_subtitle . '</a></div>';
                    } else {
                        //Testimonial subtitle has no link
                        $display_tst_subtitle = '<div id="tst_subtitle_' . $tstiditr . '">' . $tst_subtitle . '</div>';
                    }

                    //If no id present, substitute default Handsome Guy elements in testimonial display blocks
                    if ($tstid != '') {
                        $tst_image = get_the_post_thumbnail($tstid, 'thumbnail', array('id' => 'tst_image_' . $tstiditr . ''));
                        $tst_title = get_the_title($tstid);
                        $tst_short = '<div id="tst_short_' . $tstiditr . '">' . get_post_meta($tstid, '_testimonialshort_meta_value_key', true) . '</div>';
                        $display_tst_subtitle;
                    } else {
                        $tst_image = '<img src="' . TSTMT_PLUGIN_URL . '/assets/images/handsomeguy.png" id="tst_image_' . $tstiditr . '" />';
                        $tst_title = 'This Handsome Guy';
                        $tst_short = 'Handsome Guy has come through for me hundreds of times. I can\'t thank him enough!';
                        $display_tst_subtitle = '<div id="tst_subtitle_' . $tstiditr . '">Barista, Handsome Coffee</div>';
                    }

                    //Display Testimonial based upon template chosen and whether 'image before/after text' was chosen
                    switch ($template . $img_loc) {

                        case '1before' :

                            //Testimonial Template 1 Display
                            $tst .= '<div class="' . $tst_class_wraper . '" id="tst_' . $tstiditr . '">';

                            $tst .= '<div id="tst_image_outer_' . $tstiditr . '">' . $tst_image . '</div>';

                            $tst .= '<div id="tst_txt_outer_' . $tstiditr . '">';

                            $tst .= '<div id="tst_title_' . $tstiditr . '">' . $tst_title . '</div>';

                            $tst .= $display_tst_subtitle;

                            $tst .= '<div id="tst_short_' . $tstiditr . '">' . $this->shorten_text_words($tst_short, $length)  . '</div>';

                            $tst .= '</div>'; //End tst_txt_outer

                            $tst .= '</div>'; //End div class='handsometestimonials'

                            break;
                        case '1after' :

                            //Testimonial Template 1 Display
                            $tst .= '<div class="' . $tst_class_wraper . '" id="tst_' . $tstiditr . '">';

                            $tst .= '<div id="tst_txt_outer_' . $tstiditr . '">';

                            $tst .= '<div id="tst_title_' . $tstiditr . '">' . $tst_title . '</div>';

                            $tst .= $display_tst_subtitle;

                            $tst .= '<div id="tst_short_' . $tstiditr . '">' . $tst_short . '</div>';

                            $tst .= '</div>'; //End tst_txt_outer

                            $tst .= '<div id="tst_image_outer_' . $tstiditr . '">' . $tst_image . '</div>';

                            $tst .= '</div>'; //End div class='handsometestimonials'

                            break;
                        case '2before' :

                            //Testimonial Template 2 Display
                            $tst .= '<div class="' . $tst_class_wraper . '" id="tst_' . $tstiditr . '">';

                            $tst .= '<div id="tst_image_outer_' . $tstiditr . '">' . $tst_image . '</div>';

                            $tst .= '<div id="tst_txt_outer_' . $tstiditr . '">';

                            $tst .= '<div id="tst_short_' . $tstiditr . '">' . $tst_short . '</div>';

                            $tst .= '<div id="tst_title_' . $tstiditr . '">' . $tst_title . '</div>';

                            $tst .= $display_tst_subtitle;

                            $tst .= '</div>'; //End tst_txt_outer

                            $tst .= '</div>'; //End div class='handsometestimonials'
                            break;
                        case '2after' :

                            //Testimonial Template 2 Display
                            $tst .= '<div class="' . $tst_class_wraper . '" id="tst_' . $tstiditr . '">';

                            $tst .= '<div id="tst_txt_outer_' . $tstiditr . '">';

                            $tst .= '<div id="tst_short_' . $tstiditr . '">' . $tst_short . '</div>';

                            $tst .= '<div id="tst_title_' . $tstiditr . '">' . $tst_title . '</div>';

                            $tst .= $display_tst_subtitle;

                            $tst .= '</div>'; //End tst_txt_outer

                            $tst .= '<div id="tst_image_outer_' . $tstiditr . '">' . $tst_image . '</div>';

                            $tst .= '</div>'; //End div class='handsometestimonials'
                    }
                } // End posts While loop - KKAIS

                
                // Added the rotating-item-wrapper - KKAIS
                $tst = '<div id="rotating-item-wrapper">' . $tst . '</div>';

                // Passing the rotating-item interval to javascript script - KKAIS
                $tst .= '<script type="text/javascript">var interval=' . $tst_interval . ';</script>';

            }

        } else { // otherwise - KKAIS

            //Call function to display single testimonial 
            $returned_css = hndtst_shortcode_single_css($tst_shortcode, $tstiditr);

            //Set Variables after values returned from function 'shortcode_options'
            $tst_css = $returned_css['tst_css'];

            //Overwrite styles based upon above options
            wp_add_inline_style('handsometestimonials_style', $tst_css);

            //if subtitle_link exists, display subtitle hyperlinked
            $tst_subtitle = get_post_meta($tstid, '_subtitle_meta_value_key', true);
            $tst_subtitle_link = get_post_meta($tstid, '_subtitle_link_meta_value_key', true);

            if ($tst_subtitle_link != null) {
                //Testimonial subtitle has a link
                $display_tst_subtitle = '<div id="tst_subtitle_' . $tstiditr . '"><a href="' . $tst_subtitle_link . '" id="tst_subtitle_' . $tstiditr . '" target="blank">' . $tst_subtitle . '</a></div>';
            } else {
                //Testimonial subtitle has no link
                $display_tst_subtitle = '<div id="tst_subtitle_' . $tstiditr . '">' . $tst_subtitle . '</div>';
            }

            //If no id present, substitute default Handsome Guy elements in testimonial display blocks
            if ($tstid != '') {
                $tst_image = get_the_post_thumbnail($tstid, 'thumbnail', array('id' => 'tst_image_' . $tstiditr . ''));
                $tst_title = get_the_title($tstid);
                $tst_short = '<div id="tst_short_' . $tstiditr . '">' . get_post_meta($tstid, '_testimonialshort_meta_value_key', true) . '</div>';
                $display_tst_subtitle;
            } else {
                $tst_image = '<img src="' . TSTMT_PLUGIN_URL . '/assets/images/handsomeguy.png" id="tst_image_' . $tstiditr . '" />';
                $tst_title = 'This Handsome Guy';
                $tst_short = 'Handsome Guy has come through for me hundreds of times. I can\'t thank him enough!';
                $display_tst_subtitle = '<div id="tst_subtitle_' . $tstiditr . '">Barista, Handsome Coffee</div>';
            }

            //Display Testimonial based upon template chosen and whether 'image before/after text' was chosen
            switch ($template . $img_loc) {

                case '1before' :

                    //Testimonial Template 1 Display
                    $tst .= '<div class="' . $tst_class_wraper . '" id="tst_' . $tstiditr . '">';

                    $tst .= '<div id="tst_image_outer_' . $tstiditr . '">' . $tst_image . '</div>';

                    $tst .= '<div id="tst_txt_outer_' . $tstiditr . '">';

                    $tst .= '<div id="tst_title_' . $tstiditr . '">' . $tst_title . '</div>';

                    $tst .= $display_tst_subtitle;

                    $tst .= '<div id="tst_short_' . $tstiditr . '">' . $this->shorten_text_words($tst_short, $length)  . '</div>';

                    $tst .= '</div>'; //End tst_txt_outer

                    $tst .= '</div>'; //End div class='handsometestimonials'

                    break;
                case '1after' :

                    //Testimonial Template 1 Display
                    $tst .= '<div class="' . $tst_class_wraper . '" id="tst_' . $tstiditr . '">';

                    $tst .= '<div id="tst_txt_outer_' . $tstiditr . '">';

                    $tst .= '<div id="tst_title_' . $tstiditr . '">' . $tst_title . '</div>';

                    $tst .= $display_tst_subtitle;

                    $tst .= '<div id="tst_short_' . $tstiditr . '">' . $tst_short . '</div>';

                    $tst .= '</div>'; //End tst_txt_outer

                    $tst .= '<div id="tst_image_outer_' . $tstiditr . '">' . $tst_image . '</div>';

                    $tst .= '</div>'; //End div class='handsometestimonials'

                    break;
                case '2before' :

                    //Testimonial Template 2 Display
                    $tst .= '<div class="' . $tst_class_wraper . '" id="tst_' . $tstiditr . '">';

                    $tst .= '<div id="tst_image_outer_' . $tstiditr . '">' . $tst_image . '</div>';

                    $tst .= '<div id="tst_txt_outer_' . $tstiditr . '">';

                    $tst .= '<div id="tst_short_' . $tstiditr . '">' . $tst_short . '</div>';

                    $tst .= '<div id="tst_title_' . $tstiditr . '">' . $tst_title . '</div>';

                    $tst .= $display_tst_subtitle;

                    $tst .= '</div>'; //End tst_txt_outer

                    $tst .= '</div>'; //End div class='handsometestimonials'
                    break;
                case '2after' :

                    //Testimonial Template 2 Display
                    $tst .= '<div class="' . $tst_class_wraper . '" id="tst_' . $tstiditr . '">';

                    $tst .= '<div id="tst_txt_outer_' . $tstiditr . '">';

                    $tst .= '<div id="tst_short_' . $tstiditr . '">' . $tst_short . '</div>';

                    $tst .= '<div id="tst_title_' . $tstiditr . '">' . $tst_title . '</div>';

                    $tst .= $display_tst_subtitle;

                    $tst .= '</div>'; //End tst_txt_outer

                    $tst .= '<div id="tst_image_outer_' . $tstiditr . '">' . $tst_image . '</div>';

                    $tst .= '</div>'; //End div class='handsometestimonials'
            }

        }

        echo $tst;

        //Return output and end output buffer
        return ob_get_clean();
    }

    /**
     * Function to shorten the string to a certain length with complete words and elipses
     * 
     * @access public
     * @param string $text
     * @param integer $length
     * @return string
     * @author KKAIS
     */
    function shorten_text_words($text, $length) {

        // If there are characters in the string then
        if (strlen($text) > $length) {

            // Start shortening the string from the begining for each complete word up to a given length
            $text = substr($text, 0, strpos($text, ' ', $length));
        }

        // Return the shorten string with elipses
        return $text . '...';
    }

}

new handsometestimonials_shortcode();
?>
