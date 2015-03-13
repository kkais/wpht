
//---------- Insert Shortcode Popup Form  ----------//
//Collect information from Insert Testimonial popup, insert into the TinyMCE editor

function insertHndtst_Code(){
     
    // set up variables to contain our input values
    var id = jQuery('#tst-tst_id').val();
    var template = jQuery('#tst-template').val();
    var orientation = jQuery('#tst-orientation:checked').val();
    var img_shadow = jQuery('#tst-img_shadow:checked').val();
    var img_round = jQuery('#tst-img_round:checked').val();
    var img_size = jQuery('#tst-img_size').val();
    var img_size_px = jQuery('#tst-img_size_px').val();
    var img_align = jQuery('#tst-img_align').val();
    var img_loc = jQuery('#tst-img_loc:checked').val();
    var txt_align = jQuery('#txt-align').val();
    var title_color = jQuery('#tst-title_color').val();     
    var title_size = jQuery('#tst-title_size').val();     
    var tst_color = jQuery('#tst_color').val();     
    var tst_size = jQuery('#tst_size').val();
    var tst_all = 0; // Added by Khurram default and if not checked then single testimonial
    var tst_interval; // Added by Khurram
    if(jQuery("#tst_all").is(':checked')) { 
      tst_all = 1; // Added by Khurram if checked then all testimonials
      tst_interval = jQuery('#tst_interval').val(); // Added by Khurram
    }  
    var subtitle_size = jQuery('#tst-subtitle_size').val();     
    var subtitle_color = jQuery('#tst-subtitle_color').val();         
    var subtitle_italic = jQuery('#tst-subtitle_italic').is(':checked');     
    var bg_color = jQuery('#tst-bg_color').val();
    var border = jQuery('#tst-border').is(':checked');
    var border_width = jQuery('#tst-border_width').val();     
    var border_color = jQuery('#tst-border_color').val();     
    var round_corners = jQuery('#tst-round_corners').is(':checked');    
    var width = jQuery('#tst-width').val();     
    var height = jQuery('#tst-height').val();     
    var align = jQuery('#tst-align').val();    
 
    var output = '';
 
    // setup the output of our shortcode
    output = '[testimonial_single ';

      // check to see if the TEXT field is blank
      if(id) 
        output += 'id="' + id + '" ';      

      if(template) 
        output += 'template="' + template + '" ';

      if(img_size == 'specify') {
        output += 'img_size="' + img_size_px + '" ';
      } else {
          if(img_size != '')
            output += 'img_size="' + img_size + '" ';
      }

      if(img_align)
        output += 'img_align="' + img_align + '" ';       

      if(img_loc)
        output += 'img_loc="' + img_loc + '" ';      

      if(!border)
        output += 'border="' + border + '" ';

      if(border_width)
        output += 'border_width="' + border_width + '" ';

      if(border_color)
        output += 'border_color="' + border_color + '" ';

      if(title_color)
        output += 'title_color="' + title_color + '" ';

      if(title_size)
        output += 'title_size="' + title_size + '" ';

      if(tst_color)
        output += 'tst_color="' + tst_color + '" ';

      if(tst_size)
        output += 'tst_size="' + tst_size + '" ';

      if(tst_all) {
        output += 'tst_all="true" '; // Added by Khurram

        if(tst_interval)
          output += 'tst_interval="' + tst_interval + '" '; // Added by Khurram
      }

      if(subtitle_size)
        output += 'subtitle_size="' + subtitle_size + '" ';

      if(subtitle_color)
        output += 'subtitle_color="' + subtitle_color + '" ';      

      if(bg_color)
        output += 'bg_color="' + bg_color + '" ';

      if(!round_corners)
        output += 'round_corners="' + round_corners + '" ';

      if(width)
        output += 'width="' + width + '" ';      

      if(height)
        output += 'height="' + height + '" ';

      if(align)
        output += 'align="' + align + '" ';

      //Design Specific
    switch (template) {
      case '1':
        if(img_shadow == 'no')
          output += 'img_shadow="' + img_shadow + '" ';
        if(img_round == 'no')
          output += 'img_round="' + img_round + '" ';
        if(orientation == 'landscape')
          output += 'orientation="' + orientation + '" ';
        if(txt_align)
          output += 'txt_align="' + txt_align + '" ';
        if(!subtitle_italic)
          output += 'subtitle_italic="' + subtitle_italic + '" ';
            break;
      case '2':
        if(img_shadow == 'yes')
          output += 'img_shadow="' + img_shadow + '" ';
        if(img_round == 'yes')
          output += 'img_round="' + img_round + '" ';
        if(orientation == 'portrait')
          output += 'orientation="' + orientation + '" ';
        if(txt_align != 'left')
          output += 'txt_align="' + txt_align + '" ';
        if(subtitle_italic)
          output += 'subtitle_italic="' + subtitle_italic + '" ';
            break;
          break;
    }

    output += ']';

// Create the shortcode and insert it into the editor
//window.send_to_editor(output);

return output;

}


jQuery(document).ready(function($) { //Begin jQuery(document)

  // Toggle Advanced Setttings on click
  $("#advancedsettings").hide();
  $("#clickadvanced").hover(function(){
    $(this).css("text-decoration", "underline");
  }, function(){
      $(this).css("text-decoration", "none");
  });
  $("#clickadvanced").click(function(){
    $("#advancedsettings").toggle();
  });


  //Testimonial Search Box for Shortcode UI
  $('.hndtst-tst-search').keyup(function(){
  	var tst_search = $(this).val();

  	$('.hndtst-ajax').show(); //Show ajax gif

  	data = {
  		action: 'hndtst_tst_search',
  		hndtst_tst: tst_search,
  		hndtst_nonce: hndtst_tst_vars.hndtst_tst_nonce 
  	};
  	$.ajax({
  		type: "POST",
  		data: data,
  		dataType: "json",
  		url: ajaxurl,
  		success: function( search_response ) {
  			$('.hndtst-ajax').hide(); //Hide ajax gif

  			$('#hndtst_tst_search_results').html(''); //Clear div first

  			if(search_response.id == 'found') {
  				$(search_response.results).appendTo('#hndtst_tst_search_results');
  			} else if (search_response.id == 'fail') { 
  				$('#hndtst_tst_search_results').text(search_response.msg);
  			}

  		}
  	});

  });


  //Populate Search Box on click of results from search query above
  $('body').on('click.hndtstSearchTestimonial', '#hndtst_tst_search_results a', function(e) {
    e.preventDefault();

    var tst_id = $(this).data('tst_id');
    var testimonial = $(this).data('testimonial');

    $('#tst-tst_id').val(tst_id);
    $('#hndtst_tst').val(testimonial);
    $('#hndtst_tst_search_results').html('');
  });


  //Live Preview Render

  //Variable for Update Preview function
  var update_preview = function update_preview() {

    var hndtst_shortcode = insertHndtst_Code();

    data = {
      action: 'hndtst_previewShortcode',
      hndtst_previewShortcode: hndtst_shortcode,
    };

    // We can also pass the url value separately from ajaxurl for front end AJAX implementations
    $.post(ajaxurl, data, function(response) {
      $('#hndtst_preview').html(response);
    });
  }

var hndtst_colorpicker_options = {
    defaultColor: false,
    // a callback to fire whenever the color changes to a valid color
    change: function(event, ui) {
      //First set specific field to selected color chosen by colorpicker
      var setcolor = '#' + event.target.id;
      $(setcolor).val(ui.color.toString());
          
      //Now re-render preview based upon updated field above
      update_preview();
    },
    // a callback to fire when the input is emptied or an invalid color
    clear: function(event, ui) {
      //First set specific field to selected color chosen by colorpicker
      var setcolor = '#' + event.target.id;
      $(setcolor).val('');

      //Now re-render preview based upon updated field above
      update_preview();
    },
    // hide the color picker controls on load
    hide: true,

    // show a group of common colors beneath the square
    palettes: true
};


  //Update Preview when any field is changed
  $('body').ready(update_preview);
  $('.tst_colorpicker').wpColorPicker(hndtst_colorpicker_options);
  $('body').on('click.hndtstSearchTestimonial', '#hndtst_tst_search_results a', update_preview);
  $('input').on('change.hndtstChangeField', update_preview);
  $('select').on('change.hndtstChangeField', update_preview);



}); //End jQuery(document) 



