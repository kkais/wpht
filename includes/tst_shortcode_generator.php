<?php 
/**
 * Template Name: Shortcode Generator
 *
 * this file contains the contents of the popup window
 *
 * @package     handsometestimonials
 * @copyright   Copyright (c) 2014, Kevin Marshall
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */

//Enqueu Admin Scripts for Popup and ColorPicker
add_action( 'admin_enqueue_scripts', 'mw_enqueue_color_picker' );

function mw_enqueue_color_picker( $hook_suffix ) {
global $pagenow;
  //Test to make sure we're on an add/edit post/page/post-type screen
  if( !in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) )
    return;

  //Enqueue Script for Ajax Search function inside of Insert Testimonial Popup
  wp_enqueue_script( 'hndtst_tst_popup', plugins_url( 'includes/js/admin-scripts.js' , dirname(__FILE__) ), array( 'wp-color-picker' ), false, true );
  wp_localize_script('hndtst_tst_popup', 'hndtst_tst_vars', array ('hndtst_tst_nonce' => wp_create_nonce('hndtst_tst_nonce')));  

  wp_enqueue_style( 'wp-color-picker' );
}

//Display Media Button
add_action('media_buttons_context', 'hndtst_shortcode_btn');

function hndtst_shortcode_btn ($context) {

  global $pagenow;
  //Test to make sure we're on an add/edit post/page/post-type screen
  if( !in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) )
    return;

  // Button Text & Image
  $img = 'Insert Testimonial';//plugins_url( 'images/cooltext1307086819.png' , __FILE__ );

  $container_id = 'hndtst-dialog';

  //title of the popup window
  $title = 'Handsome Testimonial Shortcode Generator';

  $context .= "<a class='button thickbox' title='{$title}'href='#TB_inline?width=800&inlineId={$container_id}'>{$img}</a>";

  return $context;

} //End 'hndtst_shortcode_btn'

//Add Insert Testimonial Popup Content Function
add_action('admin_footer', 'hndtst_popup_content');

function hndtst_popup_content() {
  global $pagenow;
  //Test to make sure we're on an add/edit post/page/post-type screen
  if( !in_array( $pagenow, array( 'post.php', 'page.php', 'post-new.php', 'post-edit.php' ) ) )
    return;
?>
    <!--Popup Form HTML -->
    <div id="hndtst-dialog" style="display:none;">
      <div class="hndtst-dialog_Col_1">
        <form action="/" method="get" accept-charset="utf-8" name="htst_shortcode" >
          <div>
            <input type="text" name="tst-tst_id" value="" id="tst-tst_id" style="display:none;" /><br />
            <label class="description" for="hndtst_tst"><?php _e('Search Testimonials', 'hndtst_loc'); ?></label>
            <input id="hndtst_tst" name="testimonial" type="text" class="text-regular hndtst-tst-search" />
            <img class="hndtst-ajax waiting" src="<?php echo admin_url('images/wpspin_light.gif'); ?>" style="display:none;" />
            <div id="hndtst_tst_search_results"></div>
          </div>

          <div style="font-size: 18px; font-weight: bold; margin: 8px 0 5px;">General Style Settings</div>
            <div style="margin-top: 5px;">
                <label for="tst-bg_color">Background Color</label><br />
                <input type="text" name="tst-bg_color[color]" value="" id="tst-bg_color" class="tst_colorpicker" />
            </div>
            <div style="margin-top: 7px;">
                <label for="tst-round_corners">Round Corners</label>
                <input type="checkbox" name="tst-round_corners" id="tst-round_corners" value="" checked />
            </div>
            <div style="margin-top: 7px;">
                <label for="tst-border">Border</label>
                  <input type="checkbox" name="tst-border" id="tst-border" checked />
            </div>
            <div style="font-size: 16px; font-weight: bold; margin: 8px 0 5px;">Image Settings</div>
            <div style="margin-top: 5px;">
                <label for="tst-img_shadow">Image Shadow</label><br />
                  <input type="radio" name="tst-img_shadow" id="tst-img_shadow" value="yes"> Yes &nbsp;&nbsp;
                  <input type="radio" name="tst-img_shadow" id="tst-img_shadow" value="no"> No &nbsp;&nbsp;
            </div>
            <div style="margin-top: 5px;">
                <label for="tst-img_round">Round Image</label><br />
                  <input type="radio" name="tst-img_round" id="tst-img_round" value="yes" > Yes &nbsp;&nbsp;
                  <input type="radio" name="tst-img_round" id="tst-img_round" value="no" > No &nbsp;&nbsp;
            </div>

            <div style="margin-top: 5px;">
              <label for="tst-img_size">Image Size</label><br />
              <select name="tst-img_size" id="tst-img_size" size="1">
                <option value="" selected="selected">--select--</option>
                <option value="small">small</option>
                <option value="medium" >medium</option>
                <option value="large">large</option>
                <option value="specify">specify (advanced)</option>
              </select>
            </div>
          <i><h3 id="clickadvanced">Advanced Options</h3></i>
          <span id="advancedsettings">

          <h4>Text Settings</h4>
            <div>
              <label for="txt-align">Text Alignment</label><br />
              <select name="txt-align" id="txt-align" size="1">
                <option value="" selected="selected">--select--</option>
                <option value="left">left</option>
                <option value="center">center</option>
                <option value="right">right</option>
              </select>
            </div>
            <br />
            <div>
                <label for="tst-title_size">Title Font Size</label><br />
                <input type="text" name="tst-title_size" value="" id="tst-title_size" placeholder="px / em" />
            </div>
            <br />
            <div>
                <label for="tst-title_color">Title Color</label><br />
                <input type="text" name="tst-title_color[color]" value="" id="tst-title_color" class="tst_colorpicker" />
            </div>
            <div>
                <label for="tst-subtitle_size">Subtitle Size</label><br />
                <input type="text" name="tst-subtitle_size" value="" id="tst-subtitle_size" placeholder="px / em" />
            </div>
            <br />
            <div>
                <label for="tst-subtitle_color">Subtitle Color</label><br />
                <input type="text" name="tst-subtitle_color[color]" value="" id="tst-subtitle_color" class="tst_colorpicker" />
            </div>            
            <p>
                <label for="tst-subtitle_italic">Subtitle Italics</label>
                  <input type="checkbox" name="tst-subtitle_italic" id="tst-subtitle_italic" checked />
                <br />
            </p>
            <div>
                <label for="tst_size">Testimonial Font Size</label><br />
                <input type="text" name="tst_size" value="" id="tst_size" placeholder="px / em" />
            </div>
            <br />
            <div>
                <label for="tst_color">Testimonial Font Color</label><br />
                <input type="text" name="tst_color[color]" value="" id="tst_color" class="tst_colorpicker"/>
            </div>

          <h4>Display Settings</h4>
            <div style="margin-top: 10px;">
                <label for="tst-orientation">Orientation</label><br />
                  <input type="radio" name="tst-orientation" id="tst-orientation" value="portrait"> Portrait &nbsp;&nbsp;
                  <input type="radio" name="tst-orientation" id="tst-orientation" value="landscape"> Landscape &nbsp;&nbsp;
            </div>
            <div style="margin-top: 10px;" id="tst-img_loc">
                <label for="tst-img_loc">Image Location</label><br />
                  <input type="radio" name="tst-img_loc" id="tst-img_loc" value="before"><label for="tst-img_loc"> Before Text &nbsp;&nbsp;</label>
                  <input type="radio" name="tst-img_loc" id="tst-img_loc" value="after"><label for="tst-img_loc"> After Text &nbsp;&nbsp;</label>
            </div>
            <br />
            <div>
              <label for="tst-img_align">Image Alignment</label><br />
              <select name="tst-img_align" id="tst-img_align" size="1">
                <option value="" selected="selected">--select--</option>
                <option value="left">left</option>
                <option value="center">center</option>
                <option value="right">right</option>
              </select>
            </div>
            <br />
            <div>
                <label for="tst-img_size_px">Image Width</label><br />
                <input type="text" name="tst-img_size_px" value="" id="tst-img_size_px" placeholder="px" />
                <br /><span style="font-size: 8px; color: darkgrey; font-style: italic">Select "Specify" in Image Size above</span>
            </div>
            <br />
            <div>
                <label for="tst-width">Testimonial Width</label><br />
                <input type="text" name="tst-width" value="" id="tst-width" placeholder="px / %" />
            </div>
            <br />
            <div>
                <label for="tst-height">Testimonial Height</label><br />
                <input type="text" name="tst-height" value="" id="tst-height" placeholder="px / %" />
            </div> 
            <br />
            <div>
              <label for="tst-align">Testimonial Alignment</label><br />
              <select name="tst-align" id="tst-align" size="1">
                <option value="" selected="selected">none</option>
                <option value="left">left</option>
                <option value="center">center</option>
                <option value="right">right</option>
              </select>
              <br /><span style="font-size: 8px; color: darkgrey; font-style: italic">Doesn't affect preview</span>
            </div>
            <br />
            <div>
              <label for="tst-border_width">Border Width</label><br />
                <input type="text" name="tst-border_width" value="" id="tst-border_width" placeholder="px / em" />
            </div>
            <br /> 
            <div>
              <label for="tst-border_color">Border Color</label><br />
                <input type="text" name="tst-border_color[color]" value="" id="tst-border_color" class="tst_colorpicker" />
            </div>
            <br />
            <div>
              <label for="tst_all">Show All Testimonials</label><br />
                <input type="checkbox" name="tst_all" value="1" id="tst_all" />
            </div>
            <!-- // Field added for show all testimonials - KKAIS    -->            
            <br />
            <div>
              <label for="tst_interval">Testimonial Transition Interval</label><br />
                <input type="text" name="tst_interval" value="" id="tst_interval" placeholder="sec" />
            </div>
            <!-- // Field added for testimonials Transition interval - KKAIS -->
          </span>
          <div style="padding:15px 15px 0 0;">
            <input type="button" class="button-primary" value="Generate ShortCode" onclick="window.send_to_editor(insertHndtst_Code());">
          </div>
        </form>
      </div> <!-- End 'hndtst-dialog_Col_1' -->
      <div class="hndtst-dialog_Col_2">
            <div>
              <label for="tst-template">Select: </label>
              <select name="tst-template" id="tst-template" size="1">
                <option value="1" selected="selected">Design 1</option>
                <option value="2">Design 2</option>
              </select>
            </div>
            <br />
            <div id="hndtst_preview">
              <?php echo do_shortcode( '[testimonial_preview]' ); ?>
            </div>
      </div>
     </div> <!--End 'hndtst_dialog' -->
      <?php

} //End 'hndtst_popup_content'

//---------- Ajax Search Results  ----------//
//Display messages driven by jQuery script in admin-scripts.js
add_action( 'wp_ajax_hndtst_tst_search', 'hndtst_tst_search'); 

function hndtst_tst_search() {
  if( wp_verify_nonce( $_POST['hndtst_nonce'], 'hndtst_tst_nonce')) {
      $search_query = trim($_POST['hndtst_tst']);

      if ($search_query != null) {

        $args = array(
          'post_type' => 'testimonial',
          's' => $search_query,
        );

        $found_testimonials = get_posts( $args );

        if ( $found_testimonials ) {
          $tst_list = '<ul>';
            foreach ( $found_testimonials as $testimonial ) {
              $id = $testimonial->ID;
              $title = get_the_title( $id );
              $tst_list .= '<li><a href="#" data-testimonial="' . $title . '" data-tst_id="'. $id . '">' . $title .'</a></li>';
            }
          $tst_list .= '</ ul>';
          echo json_encode( array( 'results' => $tst_list, 'id' => 'found' ));

        } else {
          echo json_encode( array( 'msg' => __('No testimonials found', 'hndtst_loc'), 'results' => 'none', 'id' => 'fail' ));
        }
      
      } else { 
      
         die();
      }
  } // End If

  die();
}

//Retrieve Live Preview from Javascript Generated Shortcode

add_action( 'wp_ajax_hndtst_previewShortcode', 'hndtst_action_callback' );

function hndtst_action_callback() {

  $hndtst_preview = ( $_POST['hndtst_previewShortcode'] );
  echo do_shortcode(str_replace('testimonial_single', 'testimonial_preview', stripslashes($hndtst_preview)));
  wp_die();
  
}

?>