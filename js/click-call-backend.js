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