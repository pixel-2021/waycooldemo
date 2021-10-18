/*!
 * Start Bootstrap - Creative Bootstrap Theme (http://startbootstrap.com)
 * Code licensed under the Apache License v2.0.
 * For details, see http://www.apache.org/licenses/LICENSE-2.0.
 */

(function($) {
    "use strict"; // Start of use strict

    // jQuery for page scrolling feature - requires jQuery Easing plugin
    $('a.page-scroll').bind('click', function(event) {
        var $anchor = $(this);
        $('html, body').stop().animate({
            scrollTop: ($($anchor.attr('href')).offset().top - 50)
        }, 1250, 'easeOutCubic');
        event.preventDefault();
    });

    // Highlight the top nav as scrolling occurs
    $('body').scrollspy({
        target: '.navbar-fixed-top',
        offset: 51
    })

    // Closes the Responsive Menu on Menu Item Click
    $('.navbar-collapse ul li a').click(function() {
        $('.navbar-toggle:visible').click();
    });

    // Fit Text Plugin for Main Header
    //$("h1").fitText(
//        1.2, {
//            minFontSize: '35px',
//            maxFontSize: '65px'
//        }
//    );

    // Offset for Main Navigation
    $('#mainNav').affix({
        offset: {
            top: 100
        }
    })



    // Initialize WOW.js Scrolling Animations
    new WOW().init();

})(jQuery); // End of use strict


// var winwidth1 = jQuery(window).width();
 // if(winwidth1 > 300){
 //  jQuery(window).scroll(function(){
	//  if (jQuery(window).scrollTop() > 100) {
	//	   jQuery('#header').addClass('navheig');
	//	  jQuery('#navbar').addClass('site-navbar-bg');
							//jQuery('.mainlogo img').attr('src','images/logo-small.jpg');
							//jQuery('.mainlogo').addClass('logosmall');
							//jQuery('.navbar-brand-logo').css('top','0px');
							//jQuery('.navbar-brand-logo').css('transition',' all 0.2s ease-in-out 0s');
	 // }
	 // else {
		//  jQuery('#header').removeClass('navheig');
		//   jQuery('#navbar').removeClass('site-navbar-bg');
							//jQuery('.mainlogo img').attr('src','images/logo.png');
							//jQuery('.mainlogo').removeClass('logosmall');
							//jQuery('.navbar-brand-logo').css('top','-45px');
							//jQuery('.navbar-brand-logo').css('transition',' all 0.2s ease-in-out 0s');
	//  }

 // }); 
  
 //  }