jQuery(document).ready(function($) {
	/**
	 * Sets the dropdown animation for our mobile-menu
	 *
	 * Hide the dropdown by default
	 * slideToggle the dropdown if the topbar is clicked
	 * Properly slideToggle the li.parent's dropdown's if the caret icon is clicked
	 */
	$('mobile .block').hide();

	$('.mobile .topbar').click(function() {
		$(this).next().slideToggle(200);
	});

	$('.mobile ul li.parent span').click(function() {
		$(this).toggleClass('selected').siblings('.dropdown').slideToggle(200);
	});

	/**
	 * Sets the dropdown animation when you hover the header menu
	 */
	$('nav ul li').hover(
		function() {
			$(this).children('.dropdown').stop(true, false, true).slideDown(200);
		},
		function() {
			$(this).children('.dropdown').stop(true, false, true).slideUp(200);
		}
	);
});