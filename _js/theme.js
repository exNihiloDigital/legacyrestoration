// @ts-check

jQuery(function ($) {
    // Menus
    desktopMenu($);
    mobileMenu($);

    // Default Functionality
    accordion($);
    modals($);

    // Custom Functionality
});

/**
 * Mobile Menu - Sets the dropdown animation for our mobile-menu on mobile
 * @param {JQueryStatic} $ Provdes jQuery types
 */
const mobileMenu = ($) => {
    const body = document.querySelector('body');
    const burgerBtn = document.querySelector('.burgerBtn');
    const dropdowns = /** @type {NodeListOf<HTMLElement>} */ (
        document.querySelectorAll('#mobile-hidden-menu .parent .dropdown')
    );
    const menuParent = /** @type {NodeListOf<HTMLElement>} */ (
        document.querySelectorAll('#mobile-hidden-menu ul li.parent')
    );
    const mobileSide = /** @type {HTMLElement} */ (document.querySelector('#mobile-hidden-menu'));
    const mobileWrapper = /** @type {HTMLElement} */ (document.querySelector('.mobile'));
    const pageHeight = document.body.scrollHeight;

    let open = false;

    burgerBtn.addEventListener('click', () => {
        burgerBtn.classList.toggle('active');

        if (!open) {
            open = true;

            body.style.overflowY = 'hidden';
            mobileSide.classList.add('mobile-active');
            mobileSide.style.height = pageHeight.toString();
        } else {
            const activeCaret = document.querySelector('.fa-caret-right.active');

            open = false;

            body.style.overflowY = 'scroll';
            mobileSide.classList.remove('mobile-active');

            // wait 225 ms to account for the closing time of the menu
            setTimeout(() => {
                activeCaret && activeCaret.classList.toggle('active');
                mobileWrapper.style.height = 'auto';
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
    $('.accordion li h3').on('click', function () {
        // Test all li. If active, close tab
        if ($(this).hasClass('active')) {
            $(this).toggleClass('active').siblings('.accordion-content').slideToggle(200);
        } else {
            $('.accordion li').each(function () {
                if ($(this).find('h3').hasClass('active')) {
                    $(this).find('h3').removeClass('active').siblings('.accordion-content').slideToggle(200);
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

    $('.modal-content i.fa-times').on('click', function () {
        $(this).parent().parent().fadeOut(250);
    });
};

/**
 *
 * Custom Functionality
 */
