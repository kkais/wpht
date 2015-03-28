jQuery(document).ready(function () { //start after HTML, images have loaded
    //console.log(tsts_dimentions);
    
    var InfiniteRotator =
            {
                init: function (itemInterval)
                {
                    //initial fade-in time (in milliseconds)
                    var initialFadeIn = 1000;

                    //interval between items (in milliseconds)
                    var itemInterval = itemInterval;

                    //cross-fade time (in milliseconds)
                    var fadeTime = 2500;

                    //count number of items
                    var numberOfItems = jQuery('.rotating-item').length;

                    //set current item
                    var currentItem = 0;

                    //set extra height
                    var extra_height = 20;

                    //set extra width
                    var extra_width = 10;

                    id = jQuery('.rotating-item').eq(currentItem).attr('id');

                    jQuery(tsts_dimentions).each(function(index,val){
                        if (val.id == id) {
                            jQuery('.rotating-item').eq(currentItem).parent().css('height',val.height+extra_height).css('width',val.width+extra_width);
                        }
                    });

                    //show first item
                    jQuery('.rotating-item').eq(currentItem).fadeIn(initialFadeIn);

                    //loop through the items
                    var infiniteLoop = setInterval(function () {

                        jQuery('.rotating-item').eq(currentItem).fadeOut(fadeTime);

                        if (currentItem == numberOfItems - 1) {
                            currentItem = 0;
                        } else {
                            currentItem++;
                        }

                        id = jQuery('.rotating-item').eq(currentItem).attr('id');
    
                        jQuery(tsts_dimentions).each(function(index,val){
                            if (val.id == id) {
                                jQuery('.rotating-item').eq(currentItem).parent().css('height',val.height+extra_height).css('width',val.width+extra_width);
                            }
                        });

                        jQuery('.rotating-item').eq(currentItem).fadeIn(fadeTime);

                    }, itemInterval);
                }
            };

    InfiniteRotator.init(interval);

});
