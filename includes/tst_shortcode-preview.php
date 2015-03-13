<?php
/**
 * Template Name: Shortcodes
 *
 * This class extension replaces the shortcode_options
 *
 * @package     handsometestimonials
 * @copyright   Copyright (c) 2014, Kevin Marshall
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */

	class handsometestimonials_shortcode_preview extends handsometestimonials_shortcode {

		//Define Variables
		private $tst_shortcode;

	    public function __construct()
	    {

	    		add_shortcode( 'testimonial_preview', array( $this, 'dsply_testimonial' ));

	    }


	    function dsply_testimonial($atts) {

 			//Call function to parse shortcode attributes
 			$tst_shortcode = hndtst_shorcode_parser( $atts );

			//Set Variables
			$tstid = $tst_shortcode['id'];
			$template = $tst_shortcode['template'];

			//Call function to display single testimonial 
			$returned_css = hndtst_shortcode_single_css( $tst_shortcode, $tstid );

			$tst_div_css = $returned_css['tst_div_css'];
			$tst_image_css = $returned_css['tst_image_css'];
			$tst_title_css = $returned_css['tst_title_css'];
			$tst_short_css = $returned_css['tst_short_css'];
    		$tst_image_css_outer = $returned_css['tst_image_css_outer'];
    		$tst_css_txt_outer = $returned_css['tst_css_txt_outer'];
			$tst_subtitle_css = $returned_css['tst_subtitle_css'];
			$tst_template2_before = $returned_css['tst_template2_before'];
			$tst_template2_after = $returned_css['tst_template2_after'];
			$img_loc = $tst_shortcode['img_loc'];

		 	//Enque Specified Template CSS Style
			wp_register_style( 'handsometestimonials_style', TSTMT_PLUGIN_URL . 'includes/css/template.css' );
			wp_enqueue_style( 'handsometestimonials_style');

        	//********* Display Testionial ***********//

			//Start output buffer
			ob_start();

			//Define Variables for Testimonial Elements
			$tst = '';

			//Loop to obtain specific testimonial based on ID
			$tst_args = array(
				'post_type' => 'testimonial',
				'p' => $tstid
			);

			//Start Loop to display specified testimonial
			$tst_query = new WP_Query($tst_args);

		    //if subtitle_link exists, display subtitle hyperlinked
		    $tst_subtitle = get_post_meta( $tstid, '_subtitle_meta_value_key', true );
		    $tst_subtitle_link = get_post_meta( $tstid, '_subtitle_link_meta_value_key', true );

		    if ($tst_subtitle_link != null) {
		    	//Testimonial subtitle has a link
		        $display_tst_subtitle = '<div id="tst_subtitle_'.$tstid.'" style="'.$tst_subtitle_css.'"><a href="'.$tst_subtitle_link.'" id="tst_subtitle_'.$tstid.'" target="blank" style="'.$tst_subtitle_css.'">'.$tst_subtitle.'</a></div>';
		    } else {
		    	//Testimonial subtitle has no link
		        $display_tst_subtitle = '<div id="tst_subtitle_'.$tstid.'" style="'.$tst_subtitle_css.'">'.$tst_subtitle.'</div>';
		    }

		    //If no id present, substitute default Handsome Guy elements in testimonial display blocks
		   	if ( $tstid != '' ) {
		   		$tst_image = get_the_post_thumbnail( $tstid, 'thumbnail', array( 'id' => 'tst_image_'.$tstid.'', 'style' => ''.$tst_image_css.'' ) );
		   		$tst_title = get_the_title( $tstid );
		   		$tst_short = get_post_meta( $tstid, '_testimonialshort_meta_value_key', true );
		   		$display_tst_subtitle;
		   	} else {
		   		$tst_image = '<img src="'.TSTMT_PLUGIN_URL.'/assets/images/handsomeguy.png" style="'.$tst_image_css.'" />';
		   		$tst_title = 'This Handsome Guy';
		   		$tst_short = 'Handsome Guy has come through for me hundreds of times. I can\'t thank him enough!';
		   		$display_tst_subtitle = '<div id="tst_subtitle_'.$tstid.'" style="'.$tst_subtitle_css.'">Head Barista, Ristretto Coffee</div>';

		   	}

			//Display Testimonial based upon template chosen
		   	switch ( $template.$img_loc ){
						
					case '1before' :

	            		//Testimonial Template 1 Display
							$tst .= '<div class="hndtst" style="'.$tst_div_css.'">';

								$tst .= '<div style="'.$tst_image_css_outer.'">'.$tst_image.'</div>';

								$tst .= '<div style="'.$tst_css_txt_outer.'">';	

									$tst .= '<div style="'.$tst_title_css.'">'.$tst_title.'</div>';

									$tst .= $display_tst_subtitle;

									$tst .= '<div style="'.$tst_short_css.'">'.$tst_short.'</div>';

								$tst .= '</div>';
				 
						$tst .= '</div>'; //End div class='hntst'

					break;
					case '1after' :

	            		//Testimonial Template 1 Display
							$tst .= '<div class="hndtst" style="'.$tst_div_css.'">';

								$tst .= '<div style="'.$tst_css_txt_outer.'">';	

									$tst .= '<div style="'.$tst_title_css.'">'.$tst_title.'</div>';

									$tst .= $display_tst_subtitle;

									$tst .= '<div style="'.$tst_short_css.'">'.$tst_short.'</div>';

								$tst .= '</div>'; //end tst_css_txt_outer

								$tst .= '<div style="'.$tst_image_css_outer.'">'.$tst_image.'</div>';
				 
						$tst .= '</div>'; //End div class='hntst'

					break; 
					case '2before' : 

	            		//Testimonial Template 2 Display
						$tst .= '<div class="hndtst" style="'.$tst_div_css.'">';

								$tst .= '<div style="'.$tst_image_css_outer.'">'.$tst_image.'</div>';

								$tst .= '<div class="tst_preview_txt" style="'.$tst_css_txt_outer.'">';	

									$tst .= '<br /><div style="'.$tst_short_css.'">'.$tst_short.'</div>';

									$tst .= '<div style="'.$tst_title_css.'">'.$tst_title.'</div>';

									$tst .= $display_tst_subtitle;

								$tst .= '</div>'; // End tst_txt_outer

								$tst .= '<span style="'.$tst_template2_before.'"></span><span style="'.$tst_template2_after.'"></span>'; // CSS Callout
				 
						$tst .= '</div>'; //End div class='hntst'
					break;
					case '2after' : 

	            		//Testimonial Template 2 Display
						$tst .= '<div class="hndtst" style="'.$tst_div_css.'">';

								$tst .= '<div class="tst_preview_txt" style="'.$tst_css_txt_outer.'">';	

									$tst .= '<br /><div style="'.$tst_short_css.'">'.$tst_short.'</div>';

									$tst .= '<div style="'.$tst_title_css.'">'.$tst_title.'</div>';

									$tst .= $display_tst_subtitle;

								$tst .= '</div>'; // End tst_txt_outer

								$tst .= '<div style="'.$tst_image_css_outer.'">'.$tst_image.'</div>';

								$tst .= '<span style="'.$tst_template2_before.'"></span><span style="'.$tst_template2_after.'"></span>'; // CSS Callout
				 
						$tst .= '</div>'; //End div class='hntst'

			}
				           
				echo $tst;
		 
		 	//Return output and end output buffer
			return ob_get_clean();
		
	    }

}
	 
	 new handsometestimonials_shortcode_preview();

?>