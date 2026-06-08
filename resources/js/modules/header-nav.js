jQuery(function ($) {
    var $header  = $('#header');
    var $burger  = $('#headerBurger');
    var $mobileNav = $('#headerMobileNav');
    var $blur    = $('#headerBlur');

    // ── Dark/light mode on scroll (front page only) ──────────────────────────
    function updateHeaderMode() {
        if ($('body').hasClass('home') || $('body').hasClass('front-page')) {
            if ($(window).scrollTop() > 10) {
                $header.addClass('header--scrolled').removeClass('header--dark');
            } else {
                $header.addClass('header--dark').removeClass('header--scrolled');
            }
        } else {
            $header.addClass('header--scrolled').removeClass('header--dark');
        }
    }

    updateHeaderMode();
    $(window).on('scroll.header', updateHeaderMode);

    // ── Mobile burger ─────────────────────────────────────────────────────────
    $burger.on('click', function () {
        var open = $mobileNav.hasClass('is-open');
        $burger.toggleClass('is-open', !open);
        $mobileNav.toggleClass('is-open', !open);
        $blur.toggleClass('is-visible', !open);
        $('body').toggleClass('overflow-hidden', !open);
    });

    $blur.on('click', function () {
        $burger.removeClass('is-open');
        $mobileNav.removeClass('is-open');
        $blur.removeClass('is-visible');
        $('body').removeClass('overflow-hidden');
    });

    // ── Mobile sub-menu toggles ───────────────────────────────────────────────
    $(document).on('click', '.header-mobile-nav__toggle', function () {
        var $btn = $(this);
        var $sub = $btn.siblings('.header-mobile-nav__sub');
        $btn.toggleClass('is-open');
        $sub.toggleClass('is-open');
    });

    // ── Close mobile menu on resize ───────────────────────────────────────────
    $(window).on('resize.header', function () {
        if ($(window).width() > 992) {
            $burger.removeClass('is-open');
            $mobileNav.removeClass('is-open');
            $blur.removeClass('is-visible');
            $('body').removeClass('overflow-hidden');
        }
    });
});
