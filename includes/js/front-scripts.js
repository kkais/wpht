tsts_dimentions=[];
jQuery(document).ready(function($) { //Begin jQuery(document)
// get all testimonials
var tsts = $('#rotating-item-wrapper').children();

// if there are more than one testimonials then
if(tsts.length > 1) {
    // Loop through testimonials
    $(tsts).each(function(index){
      
      $this = $(this);

      id = $this.attr('id');
      
      // get hidden element actual width
      width = $( '#rotating-item-wrapper div#'+id ).actual( 'width' );
      
      // get hidden element actual height
      height = $( '#rotating-item-wrapper div#'+id ).actual( 'height' );

      tsts_dimention = {'id':id, 'height':height ,'width':width};
      tsts_dimentions.push(tsts_dimention);
      
    });

    // console.log(tsts_dimentions);
}
// get hidden element actual innerWidth
// $( '.hidden' ).actual( 'innerWidth' );

// get hidden element actual outerWidth
// $( '.hidden' ).actual( 'outerWidth' );
// console.log('hit');

}); //End jQuery(document) 



