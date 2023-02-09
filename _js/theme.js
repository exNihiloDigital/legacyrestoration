// @ts-check

jQuery(function ($) {
    // Menus
    desktopMenu($);
    mobileMenu($);

    // Default Functionality
    accordion($);
    modals($);

    // Flex Functionality
    flexTabs($);
    flexVideoEmbed($);
    flexSlider($);
    flexCarousel($);
    flexMultiDirectional($);
    flexAtAGlance($);
    flexLargeImageSlider($);
    flexTestimonialSlider($);
    flexFeaturedContentSlider($);
    flexTestimonialCards($);
});

/**
 * Mobile Menu - Sets the dropdown animation for our mobile-menu on mobile
 * @param {JQueryStatic} $ Provdes jQuery types
 */
const mobileMenu = ($) => {
    $('.topbar .menu-icon').on('click', function () {
        $(this).parent().toggleClass('mobile-menu-active');
    });

    //open with hamburger icon
    $('.mobile .topbar .menu-icon').on('click', function () {
        $(this).parent().find('.block').slideToggle(400);
    });

    //close with X icon
    $('.mobile .block i.fal.fa-times').on('click', function () {
        $(this).parent().slideToggle(400);
    });

    $('.mobile ul li.parent').on('click', function () {
        $(this).find('span').toggleClass('selected').siblings('.dropdown').slideToggle(200);
    });
};

/**
 * Desktop Menu - Sets the dropdown animation for our header menu on desktop
 * @param {JQueryStatic} $ Provdes jQuery types
 */
const desktopMenu = ($) => {
    $('nav ul li')
        .on('mouseenter', function () {
            $(this).children('.dropdown').stop(false, true).slideDown(200);
        })
        .on('mouseleave', function () {
            $(this).children('.dropdown').stop(false, true).slideUp(200);
        });
};

/**
 * Accordion
 * @param {JQueryStatic} $ Provdes jQuery types
 */
const accordion = ($) => {
    $('.accordion .acc-tab h3').on('click', function () {
        // Test all li. If active, close tab
        if ($(this).hasClass('active')) {
            $(this).toggleClass('active').siblings('.accordion-content').slideToggle(200);
        } else {
            $('.accordion .acc-tab').each(function () {
                if ($(this).find('h3').hasClass('active')) {
                    $(this)
                        .find('h3')
                        .removeClass('active')
                        .siblings('.accordion-content')
                        .slideToggle(200);
                }
            });
            $(this).toggleClass('active').siblings('.accordion-content').slideToggle(200);
        }
    });
};

/**
 * Modal Functionality
 * @param {JQueryStatic} $ Provdes jQuery types
 */
const modals = ($) => {
    $('.modal-block .modal-img').on('click', function () {
        $(this).next('.modal-popup').fadeIn(250);
    });

    $('.modal-bg').on('click', function () {
        $(this).parent().fadeOut(250);
    });

    $('.modal-content i.fa-light').on('click', function () {
        $(this).parent().parent().fadeOut(250);
    });
};

/**
 *
 * Flex Functionality
 */
const flexTabs = ($) => {
    // Number the Resource Blocks
    let tabID = 1;
    $('.tabs-block').each(function () {
        // initial content height
        let initialHeight = $(this).find('.active-content').height() + 50;

        console.log(initialHeight);

        //set unique id for each block
        $(this)
            .parent()
            .parent()
            .attr('id', 'tab-set-' + tabID);
        tabID++;

        // set initial content height on load
        $(this).find('.tab-content-spacer').css('height', initialHeight);
    });

    // click functionality
    $('.tab').on('click', function () {
        //get tab set ID
        let tabSetID = '#' + $(this).parent().parent().parent().attr('id');
        let tabSetIDtab = tabSetID + ' .tab';
        let tabSetIDcontent = tabSetID + ' .tabs-block .tab-content';
        //get clicked ID
        let tabID = $(this).attr('data-tab');
        // set target content ID
        let contentID = 'content-' + tabID;
        // get contentID height
        let contentHeight = $(tabSetID).find(`[data-content='${contentID}']`).height();

        console.log(contentHeight);
        //remove active tab class from all
        $(tabSetIDtab).each(function () {
            $(this).removeClass('active-tab');
        });

        //add active class to clicked tab
        $(this).addClass('active-tab');

        //remove active content class from all
        $(tabSetIDcontent).each(function () {
            $(this).removeClass('active-content');
        });

        //add active content class to appropriate content block
        $(tabSetID).find(`[data-content='${contentID}']`).addClass('active-content');

        console.log(contentHeight);
        //set #tab-content-spacer to content height
        $(tabSetID).find('.tab-content-spacer').css('height', contentHeight);
    });
};
const flexVideoEmbed = ($) => {
    $('.modal-button').on('click', function () {
        // show the modal
        $(this).next().fadeIn(250);
        // get parent ID
        const parentID = $(this).parent('.flex-block').attr('id');
    });
};
const flexSlider = ($) => {
    var slider = new Swiper('.slider-type-slider', {
        slidesPerView: 1,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        spaceBetween: 40,
    });
};
const flexCarousel = ($) => {
    var slider = new Swiper('.slider-type-carousel', {
        slidesPerView: 1,
        loop: true,
        spaceBetween: 20,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
                spaceBetween: 20,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
        },
    });
};
const flexMultiDirectional = ($) => {
    var mdSliderImg = new Swiper('.md-slider-img', {});
    var mdSliderContent = new Swiper('.md-slider-content', {
        direction: 'vertical',
        spaceBetween: 80,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction',
        },
    });
    var mobileProjectSliderContent = new Swiper('.mobile-multidirectional-slider', {
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
    mdSliderImg.controller.control = mdSliderContent;
    mdSliderContent.controller.control = mdSliderImg;
};
const flexAtAGlance = ($) => {
    var glanceSlider = new Swiper('.glance-slider', {
        slidesPerView: 1,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
    });
};
const flexLargeImageSlider = ($) => {
    var photoSlider = new Swiper('.photo-slider', {
        slidesPerView: 1,
        autoHeight: true,
        effect: 'fade',
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        pagination: {
            el: '.swiper-pagination',
            type: 'fraction',
            clickable: true,
        },
    });
};
const flexTestimonialSlider = ($) => {
    var testimonialSlider = new Swiper('.testimonial-slider', {
        slidesPerView: 1,
        loop: true,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
    });
};
const flexFeaturedContentSlider = ($) => {
    var featuredContentSlider = new Swiper('.featured-content-slider', {
        slidesPerView: 1,
        loop: true,
        spaceBetween: 80,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
    });
};
const flexTestimonialCards = ($) => {
    var slider = new Swiper('.testimonial-cards', {
        slidesPerView: 1,
        loop: true,
        spaceBetween: 40,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        autoplay: {
            delay: 4000,
            disableOnInteraction: false,
        },
        breakpoints: {
            640: {
                slidesPerView: 2,
            },
            768: {
                slidesPerView: 3,
                spaceBetween: 40,
            },
        },
    });
};
