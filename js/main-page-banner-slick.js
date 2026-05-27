jQuery(function($){
  var $banner = $('.home-banner');

  if ( $banner.hasClass('slick-initialized') ) {
    $banner.slick('slickSetOption', {
	  infinite:       true,
      autoplay:       true,
      autoplaySpeed:  5000,
    }, /* refresh = */ true );
  }
});