jQuery(document).ready(function ($) {
    var isLoading = false;
    var hasReachedMaxPosts = false;

    // Define thresholds for Desktop and Mobile
    var desktopThreshold = 300;
    var mobileThreshold = 900;

    function getThreshold() {
        return $(window).width() <= 768 ? mobileThreshold : desktopThreshold;
    }

    function loadMorePosts(container, ajaxAction, config) {
        if (isLoading || hasReachedMaxPosts) {
            return;
        }
        isLoading = true;

        var offset = $(container).children().length;

        $.ajax({
            url: ajax_params.ajax_url,
            type: 'POST',
            data: {
                action: ajaxAction,
                offset: offset,
                posts_per_load: config.postsPerLoad,
                max_posts: config.maxPosts,
                current_post_id: config.currentPostId || 0,
            },
            success: function (response) {
                var data = JSON.parse(response);

                if (data.success && data.content) {
                    var $newPosts = $(data.content).addClass('newly-loaded');
                    $(container).append($newPosts);

                    $newPosts.each(function (index) {
                        $(this).css({
                            'opacity': '0',
                            'transform': 'translateY(20px)'
                        });

                        var delay = 80 + (index * 160);
                        setTimeout(function () {
                            $(this).css({
                                'opacity': '1',
                                'transform': 'translateY(0)',
                                'transition': 'all 0.5s ease-out'
                            });
                            $(this).removeClass('newly-loaded');
                        }.bind(this), delay);
                    });

                    if (data.reached_max) {
                        hasReachedMaxPosts = true;
                        console.log('Reached max posts limit.');
                    }
                } else {
                    hasReachedMaxPosts = true;
                    console.log('No more posts to load.');
                }

                isLoading = false;
            }
        });
    }

    // Home Page Infinite Scroll
    if ($('.single-post-row').length > 0) {
        $(window).scroll(function () {
            var threshold = getThreshold();
            if ($(window).scrollTop() + $(window).height() > $(document).height() - threshold) {
                loadMorePosts('.row.gy-4', 'load_more_posts_home', {
                    postsPerLoad: 3,
                    maxPosts: 100
                });
            }
        });
    }

    // Content Single Infinite Scroll
    if ($('#other-news-container').length > 0) {
        var currentPostId = $('#other-news-container').data('current-post-id');
        $(window).scroll(function () {
            var threshold = getThreshold();
            if ($(window).scrollTop() + $(window).height() > $(document).height() - threshold) {
                loadMorePosts('#other-news-container', 'load_more_posts_single', {
                    postsPerLoad: 3,
                    maxPosts: 9,
                    currentPostId: currentPostId
                });
            }
        });
    }
});
