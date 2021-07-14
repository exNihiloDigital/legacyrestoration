jQuery(function ($) {
    // Menus
    mobileMenu($);
    desktopMenu($);

    // Default Functionality
    accordion($);
    modals($);

    // Custom Functionality
    // homeServices($);
    // projectGallery($);
    // singleArticleCopyBtn();
    // smoothScroll($);
});

/**
 *
 * Menu Functionality
 */
const mobileMenu = ($) => {
    /**
     *
     * Sets the dropdown animation for our mobile-menu
     *
     */
    const body = document.querySelector('body');
    const burgerBtn = document.querySelector('.burgerBtn');
    const dropdowns = document.querySelectorAll('#mobile-hidden-menu .parent .dropdown');
    const mobileSide = document.querySelector('#mobile-hidden-menu');
    const menuParent = document.querySelectorAll('#mobile-hidden-menu ul li.parent');
    const mobileWrapper = document.querySelector('.mobile');
    const overflow = document.querySelector('.mobile-overflow');
    const pageHeight = document.body.scrollHeight;
    let open = false;

    burgerBtn.addEventListener('click', () => {
        burgerBtn.classList.toggle('active');

        if (!open) {
            open = true;
            mobileSide.classList.add('mobile-active').css('height', pageHeight);
            body.style.overflowY = 'hidden';
            mobileWrapper.style.height = '100%';
            overflow.style.height = '100vh';
        } else {
            open = false;
            mobileSide.classList.remove('mobile-active');
            body.style.overflowY = 'scroll';

            // wait 250 ms to account for the closing time of the menu
            setTimeout(() => {
                mobileWrapper.style.height = 'auto';
                overflow.style.height = 'auto';
            }, 225);

            // on menu close, also close all open submenus for a fresh start every time
            dropdowns.forEach((drop) => {
                drop.style.display = 'none';
            });
        }
    });

    menuParent.forEach((parent) => {
        parent.addEventListener('click', () => {
            $(parent).find('.fa-caret-right').toggleClass('active');
            $(parent).find('ul.dropdown').slideToggle(200);
            $(parent).siblings().find('ul.dropdown').slideUp(200);
            $(parent).siblings().find('.fa-caret-right').removeClass('active');
        });
    });
};

/**
 *
 * Default Functionality
 */
const desktopMenu = ($) => {
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
};

//Accordion
const accordion = ($) => {
    $('.accordion li h3').on('click', function () {
        // Test all li. If active, close tab
        if ($(this).hasClass('active')) {
            $(this).toggleClass('active').siblings('.accordion-content').slideToggle(200);
        } else {
            $('.accordion li').each(function () {
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

const modals = ($) => {
    //modals
    // $('#vid-placeholder').on('click', () => $('.modal-popup').fadeIn(250));

    // $('.project-img').on('click', function () {
    //     $(this).parent().find($('.modal-popup')).fadeIn(250);
    // });

    $('.modal-block .modal-img').on('click', function () {
        console.log('click');
        $(this).next('.modal-popup').fadeIn(250);
    });

    $('.modal-bg').on('click', function () {
        $(this).parent().fadeOut(250);
    });

    $('.modal-content i.fa-times').on('click', function () {
        $(this).parent().parent().fadeOut(250);
    });
};

/**
 *
 * Custom Functionality
 */
