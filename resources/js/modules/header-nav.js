jQuery(function ($) {
    var $header    = $('#header');
    var $burger    = $('#headerBurger');
    var $mobileNav = $('#headerMobileNav');
    var $blur      = $('#headerBlur');
    var $views     = $mobileNav.find('[data-mobile-nav-view]');
    var scrollPosition = 0;

    function hasHeroHeader() {
        return $('body').hasClass('home')
            || $('body').hasClass('front-page')
            || $('body').hasClass('has-hero-header');
    }

    function lockBodyScroll() {
        scrollPosition = window.pageYOffset || document.documentElement.scrollTop || 0;
        $('body').addClass('header-nav-locked').css('top', '-' + scrollPosition + 'px');
    }

    function unlockBodyScroll() {
        $('body').removeClass('header-nav-locked').css('top', '');
        window.scrollTo(0, scrollPosition);
    }

    function updateHeaderMode() {
        if ($mobileNav.hasClass('is-open')) {
            return;
        }

        if (hasHeroHeader()) {
            if ($(window).scrollTop() > 10) {
                $header.addClass('header--scrolled').removeClass('header--dark');
            } else {
                $header.addClass('header--dark').removeClass('header--scrolled');
            }
        } else {
            $header.addClass('header--scrolled').removeClass('header--dark');
        }
    }

    function showMobileView(viewId) {
        $views.each(function () {
            var $view = $(this);
            var isTarget = $view.data('mobile-nav-view') === viewId;

            $view.toggleClass('is-active', isTarget);
            $view.prop('hidden', !isTarget);
        });

        $header.toggleClass('header--menu-sub', viewId !== 'root');
    }

    function resetMobileNav() {
        showMobileView('root');
    }

    function closeMobileNav() {
        $burger.removeClass('is-open');
        $header.removeClass('header--menu-open header--menu-sub');
        $mobileNav.removeClass('is-open').attr('aria-hidden', 'true');
        $blur.removeClass('is-visible');
        unlockBodyScroll();
        resetMobileNav();
        updateHeaderMode();
    }

    function openMobileNav() {
        $burger.addClass('is-open');
        $header.addClass('header--menu-open');
        $mobileNav.addClass('is-open').attr('aria-hidden', 'false');
        $blur.addClass('is-visible');
        lockBodyScroll();
        resetMobileNav();
    }

    updateHeaderMode();
    $(window).on('scroll.header', updateHeaderMode);

    $burger.on('click', function () {
        if ($mobileNav.hasClass('is-open')) {
            closeMobileNav();
        } else {
            openMobileNav();
        }
    });

    $blur.on('click', closeMobileNav);

    $(document).on('click', '.header-mobile-nav__drill', function () {
        var target = $(this).data('mobile-nav-target');
        if (target) {
            showMobileView(target);
        }
    });

    $(document).on('click', '.header-mobile-nav__back', function () {
        showMobileView('root');
    });

    $(document).on('click', '.header-mobile-nav__close', closeMobileNav);

    $(window).on('resize.header', function () {
        if ($(window).width() > 992) {
            closeMobileNav();
        }
    });
});
