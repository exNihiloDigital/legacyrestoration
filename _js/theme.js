jQuery(function ($) {
    /**
     * Sets the dropdown animation for our mobile-menu
     *
     * Hide the dropdown by default
     * slideToggle the dropdown if the topbar is clicked
     * Properly slideToggle the li.parent's dropdown's if the caret icon is clicked
     */
    $('mobile .block').hide();

    $('.mobile .topbar').on('click', function () {
        $(this).next().slideToggle(200);
    });

    $('.mobile ul li.parent span').on('click', function () {
        $(this).toggleClass('selected').siblings('.dropdown').slideToggle(200);
    });

    /**
     * Sets the dropdown animation when you hover the header menu
     */
    $('nav ul li')
        .on('mouseenter', function () {
            $(this).children('.dropdown').stop(true, false, true).slideDown(200);
        })
        .on('mouseleave', function () {
            $(this).children('.dropdown').stop(true, false, true).slideUp(200);
        });
});
