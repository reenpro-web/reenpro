jQuery(function ($) {
  var $banner = $('.home-banner');

  if (!$banner.length) {
    return;
  }

  var slideCount = $banner.children('.home-intro').length;
  var autoplaySpeed = 20000;

  if (slideCount <= 1) {
    return;
  }

  var slickOptions = {
    slidesToShow: 1,
    slidesToScroll: 1,
    infinite: false,
    arrows: false,
    dots: true,
    appendDots: $('.slick-slide__nav'),
    autoplay: true,
    autoplaySpeed: autoplaySpeed,
  };

  if ($banner.hasClass('slick-initialized')) {
    $banner.slick('slickSetOption', slickOptions, true);
    return;
  }

  $banner.slick(slickOptions);

  // Loop autoplay without Slick's infinite clones (which duplicate slides in the DOM).
  $banner.on('afterChange', function (event, slick, currentSlide) {
    if (currentSlide === slideCount - 1) {
      setTimeout(function () {
        $banner.slick('slickGoTo', 0);
      }, autoplaySpeed);
    }
  });
});
