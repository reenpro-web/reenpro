jQuery(function($){
  var $banner = $('.home-banner');

  if ( $banner.hasClass('slick-initialized') ) {
    $banner.slick('slickSetOption', {
	  infinite:       true,
      autoplay:       true,
      autoplaySpeed:  20000,
    }, /* refresh = */ true );
  }
});
