<?php
/**
 * Template Name: Testimonial Display Functions
 *
 * Various style related functions to support displaying testimonials
 *
 * @package     handsometestimonials
 * @copyright   Copyright (c) 2014, Kevin Marshall
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 *
 */


//Paser for shortcode functions
function hndtst_shorcode_parser ( $atts ) {

	// extract shortcode arguments, default settings for Template 1
    $tst_shortcode = 
		shortcode_atts(
			array(
				'id' => '',
				'orientation' => '',
				'img_shadow' => '',
				'img_round' => '',
				'img_size' => '',
				'img_align' => 'center',
				'img_loc' => 'before',
				'template' => '1',
				'title_color' => '',
				'title_size' => '1.2em',
				'tst_color' => '',
				'tst_size' => '',
				'tst_all' => 'no', // Default value for all testimonials and if not checked then single testimonial - KKAIS
				'tst_interval' => '5',  // Default testimonials rotation interval 5 seconds - KKAIS
				'txt_align' => '',
				'subtitle_color' => '',
				'subtitle_size' => '0.8em',
				'subtitle_italic' => '',
				'bg_color' => '',
				'border' => 'yes',
				'border_width' => '1px',
				'border_color' => '',
				'round_corners' => 'yes',
				'width' => '',
				'height' => '',
				'align' => 'center',
				'category' => ''
			),
			$atts
		);

		//Update Default Settings for Templates
	   	switch ( $tst_shortcode['template'] ){
				case '1' :
						if ($tst_shortcode['orientation'] == '') {$tst_shortcode['orientation'] = 'portrait';}
						if ($tst_shortcode['img_shadow'] == '') {$tst_shortcode['img_shadow'] = 'yes';}
						if ($tst_shortcode['img_size'] == '') {$tst_shortcode['img_size'] = 'medium';}
						if ($tst_shortcode['img_round'] == '') {$tst_shortcode['img_round'] = 'yes';}
						if ($tst_shortcode['txt_align'] == '') {$tst_shortcode['txt_align'] = 'center';}
						if ($tst_shortcode['bg_color'] == '') {$tst_shortcode['bg_color'] = '#f9f9f9';}
						if ($tst_shortcode['border_color'] == '') {$tst_shortcode['border_color'] = '#cccccc';}
						if ($tst_shortcode['subtitle_italic'] == '') {$tst_shortcode['subtitle_italic'] = 'false';}
					break;
				case '2' :
						if ($tst_shortcode['orientation'] == '') {$tst_shortcode['orientation'] = 'landscape';}
						if ($tst_shortcode['img_shadow'] == '') {$tst_shortcode['img_shadow'] = 'no';}
						if ($tst_shortcode['img_size'] == '') {$tst_shortcode['img_size'] = 'small';}
						if ($tst_shortcode['img_round'] == '') {$tst_shortcode['img_round'] = 'no';}
						if ($tst_shortcode['txt_align'] == '') {$tst_shortcode['txt_align'] = 'left';}
						if ($tst_shortcode['bg_color'] == '') {$tst_shortcode['bg_color'] = '#edf8ff';}
						if ($tst_shortcode['border_color'] == '') {$tst_shortcode['border_color'] = '#c8cfd1';}
						if ($tst_shortcode['subtitle_italic'] == '') {$tst_shortcode['subtitle_italic'] = 'true';}
					break;

		}

	return $tst_shortcode;

}

//CSS style generator to display single testimonial when called 
function hndtst_shortcode_single_css( $tst_shortcode, $tstiditr ) {
	/****************************************
	Define Variables
	*****************************************/

	$tst_width = $tst_shortcode['width'];
	$tst_height = $tst_shortcode['height'];
	$tst_align = $tst_shortcode['align'];
	$bgcolor = $tst_shortcode['bg_color'];
	$borderwidth = $tst_shortcode['border_width'];
	$bordercolor = $tst_shortcode['border_color'];
	$img_align = $tst_shortcode['img_align'];
	$ttlcolor = $tst_shortcode['title_color'];
	$txt_align = $tst_shortcode['txt_align'];
	$title_size	= $tst_shortcode['title_size'];
    $shrtcolor = $tst_shortcode['subtitle_color'];
    $subtitle_size = $tst_shortcode['subtitle_size'];
    $subtitle_italic = $tst_shortcode['subtitle_italic'];
    $tstcolor = $tst_shortcode['tst_color'];
    $tst_size = $tst_shortcode['tst_size'];
    $tst_all = $tst_shortcode['tst_all']; // Get the value for all testimonials checkbox - KKAIS   
    $tst_interval = $tst_shortcode['tst_interval']; // Get the value for testimonials rotation interval text box - KKAIS   
    $template = $tst_shortcode['template'];
    $tst_template2_after = '';
	$tst_template2_before = '';
	$tst_template2_div = '';


	/****************************************
	General Styling of Testimonial Elements
	*****************************************/

	//Alter $tst_align if center argument is specified in shortcode
	if ( $tst_shortcode['align'] == 'center') {
		$tst_align = "
			margin-left: auto; 
			margin-right: auto;
		";
	} else {
		$tst_align = "		
			display: inline-block;
		";
	}

	$tst_div_css = "
			width: $tst_width;
			height: $tst_height;
			$tst_align;
        ";

	//Testimonial Background Color
	$tst_div_css .= "
			background-color: $bgcolor;
		";

	//Testimonial Round Corners
	if ( $tst_shortcode['round_corners'] == 'yes' || $tst_shortcode['round_corners'] == 'true' ) {

		$tst_div_css .= "
				border-radius: 15px;
				-webkit-border-radius: 15px;
				-moz-border-radius: 15px;
			";
	}			

	//Testimonial Border
	if ( $tst_shortcode['border'] == 'yes' || $tst_shortcode['border'] == 'true' ) {

		$tst_div_css .= "
				border-style: solid;
				border-width: $borderwidth;
				border-color: $bordercolor;
			";
	}

	//Set $tst_css styling to include tst_div_css 
	$tst_css = "#tst_$tstiditr { $tst_div_css }";


	/******* Styling for Testimonial Image *******/

	//Set image size
	if ($tst_shortcode['img_size'] == 'small') {
		$img_size = '95px';
	} elseif ($tst_shortcode['img_size'] == 'medium') {
		$img_size = '150px';
	} elseif ($tst_shortcode['img_size'] == 'large') {
		$img_size = '235px';
	} else {
		$img_size = $tst_shortcode['img_size'];
	}

	$tst_image_css = "
			width: $img_size;
			height: $img_size;
		";

	//Round testimonial image
	if ($tst_shortcode['img_round'] == 'yes' || $tst_shortcode['img_round'] == 'true') {
	$tst_image_css .= "
			border-radius: 50%;
			-webkit-border-radius: 50%;
			-moz-border-radius: 50%;
		";
	}

	//Shadow around testimonial image
	if ($tst_shortcode['img_shadow'] == 'yes' || $tst_shortcode['img_shadow'] == 'true') {
	$tst_image_css .= "
			box-shadow: 0 0 8px rgba(0, 0, 0, .8);
			-webkit-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
			-moz-box-shadow: 0 0 8px rgba(0, 0, 0, .8);
		";
	}

	// Testimonial Image Alignment
	$tst_image_css_outer = "
			text-align: $img_align;
		";

	// Testimonial Text Margins
	$tst_css_txt_outer = "
			margin: 2% 3% 3% 2%;
		";

	// Testimonial Outer Div Styling for Orientation mode
	if ($tst_shortcode['orientation'] == 'landscape') {
		$tst_image_css_outer .= "
			display: inline-block;
			vertical-align: top;
			";
		$tst_css_txt_outer .= "
			display: inline-block;
			width: calc(95% - $img_size);
		";
	} else {
		$tst_image_css_outer .= "";
		$tst_css_txt_outer .= "";
	}


	//Set $tst_css styling to include tst_image_outer & tst_image_css
    $tst_css .= "
    	#tst_image_outer_$tstiditr { $tst_image_css_outer }
    	#tst_image_$tstiditr { $tst_image_css }
    	";

	/******* Styling for Testimonial Text *******/

	// Testimonial Title Styling
	$tst_title_css = "
			margin: 2% 0;
            color: $ttlcolor;
            font-size: $title_size;
            font-weight: bold;
            text-align: $txt_align;
        ";

    //Set $tst_css styling to include tst_txt_outer & tst_title
    $tst_css .= "
    	#tst_txt_outer_$tstiditr { $tst_css_txt_outer }
    	#tst_title_$tstiditr { $tst_title_css }
    	";

    // Testimonial Subtitle Styling
    $tst_subtitle_css = "
        	color: $shrtcolor;
        	font-size: $subtitle_size;
        	margin: 2% 0;
        	text-align: $txt_align;
    		";

    // Testimonial Subtitle Italics
    if ($tst_shortcode['subtitle_italic'] == 'yes' || $tst_shortcode['subtitle_italic'] == 'true') {
    $tst_subtitle_css .= "
        	font-style: italic;
    		";
    }

	/*** Testimonial Text Styling ***/
	$tst_short_css = "
			margin-top: 5px;            
            color: $tstcolor;
            font-size: $tst_size;
			text-align: $txt_align;
        ";

    //Set $tst_css styling to include tst_short & tst_subtitle
    $tst_css .= "
    	#tst_short_$tstiditr { $tst_short_css }
    	";
    $tst_css .= "
    	a#tst_subtitle_$tstiditr { $tst_subtitle_css }
    	#tst_subtitle_$tstiditr { $tst_subtitle_css }
    	";

	/****************************************
	Template Styling
	*****************************************/

	switch ( $template ){
		case '2' :
			//Template 2 Styling
			$bottom_before = (-25 - (2 * $borderwidth)).'px';
			$borderwidth_before = (12 + $borderwidth).'px';
			$left_before = (30 - $borderwidth).'px';

		  	/**** Set tst_css for testimonial block: tst_div_css ***/
		    //CSS Callout
		    $tst_template2_after = "
				    position: absolute;
				    bottom: -25px;
				    left: 30px;
				    margin: 0;
				    border-top: 13px solid $bgcolor;
				    border-left: 13px solid $bgcolor;
				    border-right: 13px solid transparent;
				    border-bottom: 13px solid transparent;
				    padding: 0;
				    width: 0;
				    height: 0;
				    content: '';
				";
			//Add border to callout if setting enabled
			if ( $tst_shortcode['border'] == 'yes' || $tst_shortcode['border'] == 'true' ) {
				$tst_template2_before = "
					    position: absolute;
					    bottom: $bottom_before;
					    left: $left_before;
					    margin: 0;
					    border-top: $borderwidth_before solid $bordercolor;
					    border-left: $borderwidth_before solid $bordercolor;
					    border-right: $borderwidth_before solid transparent;
					    border-bottom: $borderwidth_before solid transparent;
					    padding: 0;
					    width: 0;
					    height: 0;
					    content: '';
					";
				}

			//Add space at bottom in case testimonials get stacked
		  	$tst_template2_div = "
					margin-bottom: 30px;
		    	";

		   	//Set $tst_css styling to include tst_template2_css
		    $tst_css .= "
		    	#tst_$tstiditr { $tst_template2_div }
		    	#tst_$tstiditr:before { $tst_template2_before }
		    	#tst_$tstiditr:after { $tst_template2_after }
		    	";

	    	break;

		case '3' :
			//Template 1 Styling

	} //End Switch


	/*********************************************************
	Return Styling Elements to Appropriate Shortcode Function
	**********************************************************/

    return array(
    	//FrontEnd CSS Output
    	'tst_css' => $tst_css,

    	//Preview CSS Output Variables
    	'tst_div_css' => $tst_div_css, 
    	'tst_image_css' => $tst_image_css, 
    	'tst_title_css' => $tst_title_css, 
    	'tst_short_css' => $tst_short_css, 
    	'tst_image_css_outer' => $tst_image_css_outer,
    	'tst_css_txt_outer' => $tst_css_txt_outer,
    	'tst_subtitle_css' => $tst_subtitle_css,
    	'tst_template2_before' => $tst_template2_before,
    	'tst_template2_after' => $tst_template2_after,
    	);
	
}

?>