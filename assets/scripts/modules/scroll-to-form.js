jQuery(function($){
  // helper to smooth-scroll to #mainForm
  function scrollToMain(){
    jQuery('html, body').animate({
      scrollTop: $('#mainForm').offset().top
    }, 400);
  }
  // delegate all CTAs with hrefs beginning "#mainForm"
  jQuery(document).on('click', 'a[href^="#mainForm"]', function(e){
    var href = jQuery(this).attr('href');
    // 1) If they clicked “#mainForm-business”, open the Business tab + scroll
    if (href === '#mainForm-business') {
      e.preventDefault();
      // activate the “Verslo klientas” tab
      jQuery('#heading-business').tab('show'); 
      // scroll down to the form
      scrollToMain();
    }
    // 2) else if it’s any other non-“#mainForm” hash (e.g. you provided index_intro_cta_url = some #anchor),
    //    just let the browser handle it (no interception)
    else if (href && href !== '#mainForm') {
      // do nothing special—allow default link behavior
      return;
    }
    // 3) else it must be the plain “#mainForm” CTA: just scroll
    else {
      e.preventDefault();
  console.log("testing");
      scrollToMain();
    }
  });
});
