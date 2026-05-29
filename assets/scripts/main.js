/* ========================================================================
 * DOM-based Routing
 * Based on http://goo.gl/EUTi53 by Paul Irish
 *
 * Only fires on body classes that match. If a body class contains a dash,
 * replace the dash with an underscore when adding it to the object below.
 *
 * .noConflict()
 * The routing is enclosed within an anonymous function so that you can
 * always reference jQuery with $, even when in .noConflict() mode.
 * ======================================================================== */

(function ($) {

  // Use this variable to set up the common and page specific functions. If you
  // rename this variable, you will also need to rename the namespace below.
  var Sage = {
    // All pages
    'common': {
      init: function () {
        // JavaScript to be fired on all pages

        // Compatibility shim: older Select2 builds expect $.isArray.
        if (typeof $.isArray !== 'function' && typeof Array.isArray === 'function') {
          $.isArray = Array.isArray;
        }
        // Compatibility shim: older Slick builds expect $.type.
        if (typeof $.type !== 'function') {
          $.type = function (obj) {
            if (obj === null) {
              return 'null';
            }
            if (obj === undefined) {
              return 'undefined';
            }
            return Object.prototype.toString.call(obj).slice(8, -1).toLowerCase();
          };
        }
        // Compatibility shim: older Select2 builds expect $.trim.
        if (typeof $.trim !== 'function') {
          $.trim = function (value) {
            if (value === null || value === undefined) {
              return '';
            }
            return String(value).trim();
          };
        }


        /**
         * Button to top
         */

        $(document).scroll(function () {
          var y = $(this).scrollTop();
          if (y > 600) {
            $('#toTopButton').addClass('d-block');
          } else {
            $('#toTopButton').removeClass('d-block');
          }
        });

        $('#toTopButton').on('click', function (e) {
          e.preventDefault();
          $('html, body').animate({scrollTop: $('body').offset().top}, '200');
        });


        /**
         * Header burger
         */

        var headerBurger = $('#headerBurger');
        var headerBlur = $('#headerBlur');
        headerBurger.click(function () {
          $(this).toggleClass('header-burger--is-active');
          $('#headerMenu').toggleClass('header-wrapper--active');
          $('#header').toggleClass('header--active');
          setTimeout(function () {
            $('.header-buttons').toggleClass('header-buttons--is-active');
          }, 300);
          headerBlur.toggleClass('header-blur--active');
          $('body').toggleClass('menu-is-open');
        });


        $(document).on('click', '#headerBlur', function () {
          headerBurger.click();
        });

        function handleMenuItemClick($menuItem) {
          if ($(window).width() < 1360) {
            var $subMenuWrapper = $menuItem.find('.sub-menu__wrapper');
            var $subMenuClose = $menuItem.find('.close-menu');
            var $subMenuArrow = $menuItem.find('.sub-menu__arrow');

            $('#headerMenu').toggleClass('header-wrapper--active--top');
            $subMenuWrapper.toggleClass('sub-menu__wrapper--is-active');
            $menuItem.toggleClass('menu-item-has-children--is-active');
            $subMenuArrow.toggleClass('sub-menu__arrow--is-active');
            $subMenuClose.toggleClass('close-menu--is-active');
          }
        }

        $(".menu-item-has-children > a").click(function (e) {
          if ($(window).width() < 1360) {
            e.preventDefault();
            handleMenuItemClick($(this).closest(".menu-item-has-children"));
            return false;
          }
        });

        $(".menu-item-has-children .sub-menu__arrow").click(function (e) {
          if ($(window).width() < 1360) {
            e.preventDefault();
            console.log('closed');
            handleMenuItemClick($(this).closest(".menu-item-has-children"));
            return false;
          }
        });

        $(document).on('click', '.close-menu--is-active', function () {
          if ($(window).width() < 1360) {
            var $menuItem = $(this).closest(".menu-item-has-children");
            handleMenuItemClick($menuItem);
            headerBurger.click();
          }
        });


        if ($(window).width() < 1360) {
          $(".getMainOfferHeader").click(function (e) {
            headerBurger.click();
            e.preventDefault();
            $('html, body').animate({
              scrollTop: $('#mainForm').offset().top - 150
            }, 500);
          });
        } else {
          $(".getMainOfferHeader").click(function (e) {
            e.preventDefault();
            $('html, body').animate({
              scrollTop: $('#mainForm').offset().top - 150
            }, 500);
          });
        }


        $(".getMainOffer").click(function (e) {
          e.preventDefault();
          $('html, body').animate({
            scrollTop: $('#mainForm').offset().top - 150
          }, 500);
        });

        $('a[href="/#"]').click(function (e) {
          e.preventDefault();
        });


        // Check if the page was reloaded with the mouse over a menu item
        // if ($(".menu-item-has-children:hover").length > 0) {
        //   $(".header--top").addClass("header--top--white");
        // }


        function checkOpacity() {
          if ($('.menu-item-has-children:hover').length > 0) {
            $('#header').addClass('header--top--white');
          } else {
            $('#header').removeClass('header--top--white');
          }
        }

        // Hover effect on .menu-item-has-children
        $(".menu-item-has-children").hover(
          function () {
            $(".header--top").addClass("header--top--white");
            checkOpacity(); // Check opacity on hover
          },
          function () {
            $(".header--top").removeClass("header--top--white");
            checkOpacity(); // Check opacity on mouse leave
          }
        );

        // Check opacity on page load
        checkOpacity();


        /**
         * Sticky header
         */

        var headroom = new Headroom(document.querySelector("#header"), {
          offset: 50,
          tolerance: {
            up: 5,
            down: 0
          },
          classes: {
            initial: "header",
            pinned: "header--pinned",
            unpinned: "header--unpinned",
            top: "header--top",
            notTop: "header--scrolled",
            bottom: "header--bottom",
            notBottom: "header--not-bottom"
          },
          scroller: window,
        });
        headroom.init();

        /**
         * Modal js
         */

        $("#displaySolarForm").click(function () {
          $("#solarForm").toggleClass("d-none");
          $("#formButtons").toggleClass("d-none");
        });

        $("#displayCarForm").click(function () {
          $("#carForm").toggleClass("d-none");
          $("#formButtons").toggleClass("d-none");
        });

        $("#leaveToggle").click(function () {
          $("#formButtons").removeClass("d-none");
          $("#solarForm, #carForm").addClass("d-none");
        });

        jQuery('#offerModal').on('hide.bs.modal hidden.bs.modal', function () {
          jQuery("#leaveToggle").click();
        });


        /**
         * Main Auto calculator js
         */


        // $('#hiddenMainPostSelect option:first').prop('disabled', true);
        // $('#hiddenMainPostSelect').addClass('first-child');
        //
        // $('#hiddenMainPostSelect').change(function () {
        //   $('#hiddenMainPostSelect').removeClass('first-child');
        // });

        $('#hiddenMainPostSelect').prop('disabled', true);

        // $('#hiddenMainTaxSelect option:first').prop('disabled', true);
        // $('#hiddenMainTaxSelect').addClass('first-child');
        //
        // $('#hiddenMainTaxSelect').change(function () {
        //   $('#hiddenMainTaxSelect').removeClass('first-child');
        // });

        $("#hiddenMainTaxSelect").select2({
          placeholder: "Automobilio gamintojas",
          allowClear: false,
          minimumResultsForSearch: -1,
        });

        $("#hiddenMainPostSelect").select2({
          placeholder: "Automobilio modelis",
          allowClear: false,
          minimumResultsForSearch: -1,
        });

        $('#hiddenMainTaxSelect').on('change', function () {
          var selectedDataId = $(this).find(':selected').data('id');
          $('#hiddenMainPostSelect option').each(function () {
            if ($(this).data('id') === selectedDataId || selectedDataId === undefined) {
              $(this).removeAttr('disabled');
              $(this).show();
            } else {
              // var value = $(this).val();
              // $('#hiddenMainPostSelect option[value="' + value + '"]').hide();
              $(this).hide();
              $(this).prop('disabled', true);
              $(this).attr("disabled", "disabled");
            }
          });
          $('#hiddenMainPostSelect').prop('disabled', false);
        });

        $('#calcError').hide();

        $('#calcCar').on('click', function () {
          if ($('#hiddenMainTaxSelect').val() && $('#hiddenMainPostSelect').val()) {
            $('#calcData').removeClass('d-none');
            var selectedCarId = $('#hiddenMainPostSelect option:selected').attr('id');
            $('.selected-car').addClass('d-none');
            $('.selected-car').each(function () {
              if ($(this).attr('id') === selectedCarId) {
                $(this).removeClass('d-none');
              }
            });
            $('#calcError').hide();

          } else {

            $('#calcError').show();
            $('#calcError').removeClass('hide');
            // alert('Pasirinkite automobilį');
          }
        });


        /**
         * CF7 Auto page js
         */

        // $('#donationSelect option:first').text('Parama');
        // $('#donationSelect option:first').prop('disabled', true);
        //
        // if ($('#donationSelect option:first').is(':selected')) {
        //   $('#donationSelect').addClass('first-child');
        // }
        // $('#donationSelect').change(function () {
        //   $('#donationSelect').removeClass('first-child');
        // });


        $("#donationSelect").select2({
          placeholder: "Parama",
          allowClear: false,
          minimumResultsForSearch: -1,
        });

        $(".solutionSelect").select2({
          placeholder: "Pasirinkite sprendimą",
          allowClear: false,
          minimumResultsForSearch: -1,
        });

// change active tab in form
        const hash = window.location.hash;
        // Check if the hash corresponds to #tab-business
        if (hash === '#versloklientas') {
          // Deactivate the personal tab link
          $('#heading-personal').removeClass('active').attr('aria-selected', 'false');

          // Activate the business tab link
          $('#heading-business').addClass('active').attr('aria-selected', 'true');

          // Hide the personal tab content
          $('#tab-personal').removeClass('show active');

          // Show the business tab content
          $('#tab-business').addClass('show active');
        }



        // change placeholder depend on which form is selected

        // $(document).ready(function () {
        //   $('input[name="radio"]').change(function () {
        //     var selectedRadio = $(this);
        //     var formSection = selectedRadio.closest('.contact-form');
        //     var relatedInput = formSection.find('input[name="your-name"]');
        //     if (selectedRadio.val() === 'Verslo klientas') {
        //       relatedInput.attr('placeholder', 'Vardas pavardė, Įmonė*');
        //     } else {
        //       relatedInput.attr('placeholder', 'Vardas pavardė*');
        //     }
        //   });
        // });


        // $('#locationSelect option:first').text('Įkrovimo stotelės vieta');
        // $('#locationSelect option:first').prop('disabled', true);
        //
        // if ($('#locationSelect option:first').is(':selected')) {
        //   $('#locationSelect').addClass('first-child');
        // }
        // $('#locationSelect').change(function () {
        //   $('#locationSelect').removeClass('first-child');
        // });

        $("#locationSelect").select2({
          placeholder: "Įkrovimo stotelės vieta",
          allowClear: false,
          minimumResultsForSearch: -1,
        });


        var optionsPost = $('#hiddenPostSelect').html();
        $('#postSelect').html(optionsPost);

        // $('#postSelect option:first').prop('disabled', true);
        // $('#postSelect').addClass('first-child');
        //
        // $('#postSelect').change(function () {
        //   $('#postSelect').removeClass('first-child');
        // });

        var optionsTax = $('#hiddenTaxSelect').html();
        $('#taxSelect').html(optionsTax);

        // $('#taxSelect option:first').prop('disabled', true);
        // $('#taxSelect').addClass('first-child');
        //
        // $('#taxSelect').change(function () {
        //   $('#taxSelect').removeClass('first-child');
        // });
        $('#postSelect').prop('disabled', true);
        //
        $("#taxSelect").select2({
          placeholder: "Automobilio gamintojas",
          allowClear: false,
          minimumResultsForSearch: -1,
        });

        $("#postSelect").select2({
          placeholder: "Automobilio modelis",
          allowClear: false,
          minimumResultsForSearch: -1,
        });


        $('#taxSelect').on('change', function () {
          var selectedDataId = $(this).find(':selected').data('id');
          $('#postSelect option').each(function () {
            if ($(this).data('id') === selectedDataId || selectedDataId === undefined) {
              $(this).removeAttr('disabled');
              $(this).show();
            } else {
              $(this).hide();
              $(this).prop('disabled', true);
              $(this).attr("disabled", "disabled");
            }
          });
          $('#postSelect').prop('disabled', false);
        });

        /**
         * Projects js
         */

        var totalProjects = $('.projects-wrapper').length;


        function initializeSlick() {
          $('.projects-card__slider').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            autoplaySpeed: 3000,
            arrows: false,
            dots: true,
          });
        }

        function destroySlick() {
          $('.projects-card__slider').slick('unslick');
        }

        initializeSlick();


        function updateLoadMoreVisibility() {
          if ($('.projects-wrapper.d-none').length === 0) {
            $('#loadMore').hide();
          } else {
            $('#loadMore').show();
          }
        }


        function fetchProjectItems(category) {
          $.ajax({
            url: '/wp-admin/admin-ajax.php',
            data: {action: 'fetch_project_items', category: category},
            type: 'GET',

            success: function (data) {
              $('#mainProjecsSlider').html(data);
              $("#overlay").fadeOut(300);
              initializeSlick();
              // console.log($('.projects-wrapper.d-none').length);
              updateLoadMoreVisibility();

            },
            error: function (error) {
              console.error('Error fetching project items:', error);
            }
          });
        }


        $(document).on('click', '.projects-category', function () {
          $('.projects-category').removeClass('active');
          $(this).addClass('active');
          $('.project-item').addClass('project-item--hidden');
          var category = $(this).data('cat');
          $('.cat-' + category).removeClass('project-item--hidden');
          destroySlick();
          $("#overlay").fadeIn(0);
          fetchProjectItems(category);
        });


        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('cat')) {
          var catValue = urlParams.get('cat');
          var matchingElement = $('.projects-category[data-slug="' + catValue + '"]');
          if (matchingElement.length > 0) {
            matchingElement.click();
          } else {
            // console.log('The element with data-slug="' + catValue + '" does not exist.');
          }
        } else {
          // console.log('The "cat" parameter does not exist in the URL.');
        }


        var visibleProjects = 6;
        $('.projects-wrapper').slice(visibleProjects).addClass('d-none');
        $('#loadMore').on('click', function () {
          $("#overlay").fadeIn(0);

          $('.projects-wrapper.d-none').slice(0, 2).removeClass('d-none');
          visibleProjects += 6;
          destroySlick();
          initializeSlick();
          $("#overlay").fadeOut(300);
          if ($('.projects-wrapper.d-none').length === 0) {
            $('#loadMore').hide();
          }
        });


        /**
         * About video
         */

        // Function to pause all videos except the one being played
        function pauseAllVideos(except) {
          $('.wi-video-player').each(function () {
            if (this !== except) {
              this.pause();
              $(this).removeAttr('controls');
              $(this).siblings('.playVideo').removeClass('fade d-none');
              $(this).siblings('.bgVideo').removeClass('d-none fade');
            }
          });
        }


        // Event delegation for play button
        $(document).on('click', '.playVideo', function () {
          console.log('play');
          var video = $(this).siblings('.wi-video-player')[0];
          pauseAllVideos(video);
          video.play();
          video.setAttribute('controls', 'controls');
          $(this).addClass('fade d-none');
          $(this).siblings('.bgVideo').addClass('d-none fade');
        });

        // Event delegation for video click to pause
        $(document).on('click', '.wi-video-player', function () {
          console.log('stop');
          // this.pause(); // 'this' refers to the clicked video element
          // $(this).removeAttr('controls'); // Remove controls from the video
          //
          // $(this).siblings('.playVideo').removeClass('opacity-none fade d-none');
          // $(this).siblings('.bgVideo').removeClass('d-none fade');
        });


        /**
         * Sliders
         */

        $('.about-cards__slider').slick({
          infinite: false,
          slidesToShow: 3,
          slidesToScroll: 1,
          autoplay: false,
          autoplaySpeed: 3000,
          arrows: true,
          dots: false,
          focusOnSelect: false,
          responsive: [
            {
              breakpoint: 1359,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 575,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            }
          ]
        });

        // Pause video on slide change
        $('.about-cards__slider').on('beforeChange', function (slick) {
          $('.wi-video-player').each(function () {
            this.pause();
            // $(this).removeAttr('controls');
            // $(this).siblings('.playVideo').removeClass('fade d-none');
            // $(this).siblings('.bgVideo').removeClass('d-none fade');
          });
        });

        $('.about-partners__slider').slick({
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          autoplay: false,
          autoplaySpeed: 3000,
          arrows: true,
          dots: true,
          focusOnSelect: false,
          responsive: [
            {
              breakpoint: 1359,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 575,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            }
          ]
        });

        $('.about-logos__slider').slick({
          rows: 2,
          infinite: true,
          dots: true,
          arrows: true,
          autoplay: false,
          autoplaySpeed: 3000,
          slidesPerRow: 4,
          slidesToShow: 1,
          slidesToScroll: 1,
          responsive: [
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 767,
              settings: {
                rows: 2,
                slidesToShow: 2,
                slidesPerRow: 2,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 575,
              settings: {
                rows: 1,
                slidesToShow: 2,
                slidesPerRow: 1,
                slidesToScroll: 1,
              }
            }
          ]
        });

        $('.about-reviews__slider').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: false,
          autoplaySpeed: 3000,
          arrows: true,
          dots: true,
        });

        $('.donation-projects__cards').slick({
          infinite: true,
          slidesToShow: 3,
          slidesToScroll: 1,
          autoplay: false,
          autoplaySpeed: 3000,
          arrows: true,
          dots: false,
          focusOnSelect: false,
          responsive: [
            {
              breakpoint: 1359,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 575,
              settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
              }
            }
          ]
        });

        /**
         * Product archive JS
         */

        $('#productSlide').slick({
          infinite: true,
          slidesToShow: 1,
          slidesToScroll: 1,
          autoplay: false,
          autoplaySpeed: 3000,
          arrows: true,
          dots: false,
          adaptiveHeight: true,
          appendArrows: '.products-slider__arrows',
        });

        $('#productSlide').on('afterChange', function (event, slick, currentSlide) {
          if (slick.$slider.attr('id') === 'productSlide') {
            $('.products-title').removeClass('active');
            $('.products-title[data-index="' + currentSlide + '"]').addClass('active');
          }
        });

        $('.products-gallery').each(function () {
          $(this).slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            arrows: false,
            fade: true,
            dots: true,
            swipe: false,
            touchMove: false,
            draggable: false,
          });
        });


        $(document).on('click', '.products-title', function () {
          $('.products-title').removeClass('active');
          $(this).addClass('active');
          var slideNumber = $(this).data('index');
          $('#productSlide').slick('slickGoTo', slideNumber);
        });

        if ($(window).width() < 768) {

          $('#categoriesButtons').slick({
            infinite: false,
            slidesToShow: 2,
            slidesToScroll: 1,
            autoplay: false,
            arrows: false,
            dots: false,
          });
          $('.projects-category').on('click', function () {
            var targetCat = $(this).data('slide');
            $('#categoriesButtons').slick('slickGoTo', targetCat);
          });

          $('#installationCategories').slick({
            infinite: false,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: false,
            arrows: false,
            dots: false,
          });
          $('.products-title').on('click', function () {
            var targetCat = $(this).data('index');
            $('#installationCategories').slick('slickGoTo', targetCat);
          });
          $('#productSlide').on('afterChange', function (event, slick, currentSlide) {
            if (slick.$slider.attr('id') === 'productSlide') {
              $('#installationCategories').slick('slickGoTo', currentSlide);
            }
          });

        }


      },
      finalize: function () {
        // JavaScript to be fired on all pages, after page specific JS is fired
      }
    },
    // Home page
    'home': {
      init: function () {
        // JavaScript to be fired on the home page

        $('.home-banner').slick({
          slidesToShow: 1,
          slidesToScroll: 1,
          infinite: true,
          arrows: false,
          dots: true,
          appendDots: $(".slick-slide__nav"),
        });

        $('.home-logos__slider').slick({
          infinite: true,
          slidesToShow: 4,
          slidesToScroll: 1,
          autoplay: true,
          autoplaySpeed: 3000,
          arrows: false,
          dots: false,
          focusOnSelect: false,
          responsive: [
            {
              breakpoint: 1359,
              settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 991,
              settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 767,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              }
            },
            {
              breakpoint: 575,
              settings: {
                slidesToShow: 2,
                slidesToScroll: 1,
              }
            }
          ]
        });


      },
      finalize: function () {
        // JavaScript to be fired on the home page, after the init JS
      }
    },
    // About us page, note the change from about-us to about_us.
    'about_us': {
      init: function () {
        // JavaScript to be fired on the about us page
      }
    }
  };

  // The routing fires all common scripts, followed by the page specific scripts.
  // Add additional events for more control over timing e.g. a finalize event
  var UTIL = {
    fire: function (func, funcname, args) {
      var fire;
      var namespace = Sage;
      funcname = (funcname === undefined) ? 'init' : funcname;
      fire = func !== '';
      fire = fire && namespace[func];
      fire = fire && typeof namespace[func][funcname] === 'function';

      if (fire) {
        namespace[func][funcname](args);
      }
    },
    loadEvents: function () {
      // Fire common init JS
      UTIL.fire('common');

      // Fire page-specific init JS, and then finalize JS
      $.each(document.body.className.replace(/-/g, '_').split(/\s+/), function (i, classnm) {
        UTIL.fire(classnm);
        UTIL.fire(classnm, 'finalize');
      });

      // Fire common finalize JS
      UTIL.fire('common', 'finalize');
    }
  };

  // Load Events
  $(document).ready(UTIL.loadEvents);

})(jQuery); // Fully reference jQuery after this point.
