<?php

//Add Options Page
function htst_getstarted_page() {
	global $pagenow;
	?>
	
	<div class="wrap">
		<h2><?php echo 'Getting Started</h2>'; ?>
		
 		<?php
			// if ( 'true' == esc_attr( $_GET['updated'] ) ) echo '<div class="updated" ><p>Theme Settings updated.</p></div>';
			
			if ( isset ( $_GET['tab'] ) ) htst_getstarted_tabs($_GET['tab']); else htst_getstarted_tabs('getstarted');
		?>

		<div id="poststuff">
				<?php
				
				if ( $pagenow == 'edit.php' && $_GET['page'] == 'htst_getting_started' ){ 
				
					if ( isset ( $_GET['tab'] ) ) $tab = $_GET['tab']; 
					else $tab = 'getstarted'; 
					
					echo '<table class="form-table">';
					switch ( $tab ){
						case 'getstarted' :
							?>
							<h2>Thanks for trying out Handsome Testimonials!</h2>

							<p>As a way to say thanks, we'd like to offer you our <b>Tried & True Testimonial Request Template</b> for collecting testimonials from your clients.
							We've used this exact template to send to hundreds of our past clients for all of our companies and it's succeeded at encouraging the
							majority of our clients to send us their testimonials.</p>

							<p>Once you receive our Tried & True Testimonial Request Template, just insert you or your company's name and email
							it out to either 
							your mailing list or any past clients.</p>

							<h3>Great testimonials should start coming back.</h3>


							<h4>Join Our Email List Below to Receive Our <i>Tried & True Testimonial Request Template</i></h4>
							<p>
								<?php echo file_get_contents( TSTMT_PLUGIN_DIR. "/assets/email-optin.html" ); ?>
							</p>
							<?php
						break; 
						case 'howtouse' : 
							?>
							<h2>How do I display a testimonials I've entered on my site?</h2>
							<h4>The Easy Way</h4>
							<ol style="padding-left:20px">
								<li>Add a new testimonial by going to Dashboard->Testimonials->Add New</li>
								<li>Now go to the post or page you want to insert your testimonial on and click the <b>Insert Testimonial</b> button</li>
								<li>Customize your testimonial to your liking and click the Generate Shortcode</li>
							</ol>

							<h4>The Manual Way</h4>
							<ul style="padding-left:20px">
								<li>Add a new testimonial by going to Testimonials->Add New. Make note of the id by viewing Testimonials->All Testimonials</li>
								<li>Paste the following shortcode anywhere in a post or page with the appropriate id: [testimonial_single id=""]</li>
								<li>Customize your testimonial to your liking adding the <a href="edit.php?post_type=testimonial&page=htst_getting_started&tab=faqs">shortcode arguments</a> to your shortcode</li>
							</ul>

							Remember, the basic shortcode should look as follows: [testimonial_single id="3"] 

							<?php
						break; 
						case 'faqs' : 
							?>

							<h2>Can I use this in Sidebar Widgets?</h2>
							Absolutely. An easy way to do this to generate your testimonial to your liking in a new post using the Insert Testimonial button, then click Generate Shortcode to create a shortocde
							in your post. Now simply cut and paste this shortcode into a new "Text" Widget type in Dashboard->Appearance->Widgets. You may want to make sure you set a custom width for your testimonial
							which matches the width of your column by adding the argument to your shortcode. ( ex: width="250px" )

							<h2>How do I change the displayed image size of the testimonial?</h2>
							You can designate a specific pixel size or % by using the shortcode option: img-size="" For example: [testimonial_single id="5" img-size="50px"]
						
							<h2>Can I add more than one testimonial per row?</h2>
							Yes, but for the moment, only 2 testimonials per row are supported. You'll need to insert 2 shortcodes, one after another, then reduce 
							the width of each testimonial to a bit less than half of the width of the content area. 
							<br />(For instance, for 2 testimonials in one row, set width to 45% each)
							<br />Next, you'll set Testimonial Alignment for each testimonial in the row to the appropriate position. <br />(For instance, set one to left and the other to right)
							
							<h2>What are all the customizations can I make to my testimonials?</h2>
							Use the following shortcode options after inserting the standards shortcode: [testimonial_single id="#" ]
							<ul style="padding-left:20px">
								<li>id="" - Testimonial id to display</li>
								<li>img_shadow="" - Testimonial image shadow - (yes/no)</li>
								<li>img_size="" - Size for testimonial image - (px/%)</li>
								<li>txt_align="" - Alignment of all text in testimonial block - (left/center/right)</li>
								<li>title_color="" - Color of title - (hex)</li>
								<li>title_size="" - Font size of title - (px/em)</li>
								<li>tst_color="" -  Color of testimonial body text - (hex)</li>
								<li>tst_size="" - Font size of body text - (px/em)</li>
								<li>subtitle_size="" - Font size of subtitle - (px/em)</li>
								<li>subtitle_color="" - Color of subtitle text - (hex)</li>
								<li>border="" - Choose whether to have a boder around testimonial block</li>
								<li>border_width="" - Border width if border is enabled - (px/em)</li>
								<li>border_color="" - Color of boder around testimonial block - (hex)</li>
								<li>bg_color="" - Color of background - (hex)</li>
								<li>round_corners="" - Round corners or testimonial block - (yes/no)</li>
								<li>border="" - Add a border around testonial</li>
								<li>border_width="" - Sets the width of the border - (px/em)</li>
								<li>border_color="" - Sets the color of the border - (px/em)</li>
								<li>width="" - Width of testimonial block - (hex)</li>
								<li>height="" - Height of testimonial block - (px/%)</li>
								<li>align="" - Alignment of testimonial block - (left/center/right)</li>
							</ul>
							
							<i>Here's an example: </i>
							<br />[testimonial_single id="5" title_color="red" title_size="15px" tst_color="darkred" shadow="no" subtitle_color="darkred" bg_color="grey" round_corners="yes"]

							<h2>What if there's something about how my testimonial is displayed that I want to change?</h2>
							Perhaps you want to make the text of your testimonial italic or bold or you want to change the
							margins of your testimonial. Simply find the specific css id tag of the testimonial on your page you wish to make changes to and add these css changes to your theme's custom css file. 
							The easiest way to find the specific css id selector for the testimonial you want to change is by using the "developer" function of your browser or a browser extension such as <a href="http://getfirebug.com" target="blank">Firebug</a>.	

							<?php
						break; 
						case 'feedback' : 
							?>
							<iframe src="https://docs.google.com/forms/d/1gj7-NBKkpp7FTxusxspYhTcjMYidlIpSUR8T46cEqs0/viewform?embedded=true" 
							width="750" height="1200" frameborder="0" marginheight="0" marginwidth="0">Loading...</iframe>
							<?php
					}
					echo '</table>';
				}
				?>		
		
		</div>

	</div>
	<?php

}	

function htst_add_getstarted_link() {

	 add_submenu_page( 'edit.php?post_type=testimonial', 'Getting Started', 'Getting Started', 'manage_options', 'htst_getting_started', 'htst_getstarted_page' );
}

add_action('admin_menu', 'htst_add_getstarted_link');

//** Move to Settings Area when built **
//Register Settings
function htst_register_settings() {

	register_setting('handsometestimonials_settings_group', 'handsometestimonials_settings');
}
add_action('admin_init', 'htst_register_settings');

function htst_getstarted_tabs( $current = 'getstarted' ) {
    $tabs = array( 'getstarted' => 'Get More Testionials', 'howtouse' => 'How To Use', 'faqs' => 'FAQs', 'feedback' => 'Got Feedback?' ); 
    $links = array();
    echo '<div id="icon-themes" class="icon32"><br></div>';
    echo '<h2 class="nav-tab-wrapper">';
    foreach( $tabs as $tab => $name ){
        $class = ( $tab == $current ) ? ' nav-tab-active' : '';
        echo "<a class='nav-tab$class' href='edit.php?post_type=testimonial&page=htst_getting_started&tab=$tab'>$name</a>";
        
    }
    echo '</h2>';
}

?>