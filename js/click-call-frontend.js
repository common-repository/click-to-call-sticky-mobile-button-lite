jQuery(document).ready(function() {
  foot_cont_bar_movement();
  jQuery(window).scroll(function(){ foot_cont_bar_movement(); });
  jQuery(window).resize(function(){ foot_cont_bar_movement(); });

  jQuery('footer').addClass(' main-footer-margin-bottom-30px');
  jQuery('#up-arrow-foot').on('click',function() {
    jQuery('#up-arrow-foot').removeClass(' shutter-up');
    jQuery('#up-arrow-foot').addClass(' shutter-down');
    jQuery('#mobile-contact-div').removeClass(' shutter-down');
    jQuery('#mobile-contact-div').addClass(' shutter-up');
    jQuery('footer').removeClass(' main-footer-margin-bottom-30px');
    jQuery('footer').addClass(' main-footer-margin-bottom-60px');
  });
  jQuery('#mobile-contact-div span.da-span').on('click',function() {
    jQuery('#mobile-contact-div').removeClass('shutter-up');
    jQuery('#mobile-contact-div').addClass('shutter-down');
    jQuery('#up-arrow-foot').removeClass('shutter-down');
    jQuery('#up-arrow-foot').addClass('shutter-up');
    jQuery('footer').removeClass('main-footer-margin-bottom-60px');
    jQuery('footer').addClass('main-footer-margin-bottom-30px');
  });

  //toggle icons on click 
  jQuery(document).on('click', function(event) {
  // Check if the clicked element is not within '.moreiconbtn' or '.iconmore-list'
  if (!jQuery(event.target).closest('.moreiconbtn').length && !jQuery(event.target).closest('.iconmore-list').length) {
    // If not, remove the 'active' class from '.iconmore-list'
    jQuery('.iconmore-list').removeClass('active');
  }
});

jQuery('.moreiconbtn').on('click', function() {
  jQuery('.iconmore-list').toggleClass('active');  
});

});
function foot_cont_bar_movement(){
	var scr_width = jQuery(window).width();
	var scroll_vl = jQuery(window).scrollTop();
  if (scroll_vl >= 200 && scr_width < 980) {
    jQuery('#foot-cont-div').css("display","block");
    var curr_shutter_cls = jQuery('#up-arrow-foot').attr('class');
    if(curr_shutter_cls == 'shutter-up'){
	    jQuery('#mobile-contact-div').removeClass('shutter-up');
	    jQuery('#mobile-contact-div').addClass('shutter-down');
	    jQuery('#up-arrow-foot').removeClass('shutter-down');
	    jQuery('#up-arrow-foot').addClass('shutter-up');
	    jQuery('footer').removeClass('main-footer-margin-bottom-60px');
	    jQuery('footer').addClass('main-footer-margin-bottom-30px');
	    
    }else{
	    jQuery('#up-arrow-foot').removeClass('shutter-up');
	    jQuery('#up-arrow-foot').addClass('shutter-down');
	    jQuery('#mobile-contact-div').removeClass('shutter-down');
	    jQuery('#mobile-contact-div').addClass('shutter-up');
	    jQuery('footer').removeClass('main-footer-margin-bottom-30px');
	    jQuery('footer').addClass('main-footer-margin-bottom-60px');
	  }
  } else {
    jQuery('#foot-cont-div').css("display","none");
  }
}