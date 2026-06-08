jQuery(function ($) {
  $(document).on('click', '.t-energy__play-btn', function () {
    var $wrapper = $(this).closest('.t-energy__video-wrapper');
    var videoId  = $wrapper.data('video-id');

    if (! videoId) return;

    $wrapper.html(
      '<iframe' +
        ' src="https://www.youtube.com/embed/' + videoId + '?autoplay=1&rel=0"' +
        ' frameborder="0"' +
        ' allow="autoplay; encrypted-media; fullscreen"' +
        ' allowfullscreen' +
      '></iframe>'
    );
  });
});
