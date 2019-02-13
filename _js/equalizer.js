// Copyright: Eric Van Ness
// Title: Height equalizer
// Version: 2.0.1

// This script is free for use and distribution.
// All I ask is that you leave this comment.
// If you modify the script, please modify the comment to reflect the changes.

// This script requires jQuery

// To use the script, simply add either the attribute equalize-height-up or
// equalize-height-down to the elements you would like equalized.
// Set the attribute equal to an integer to associate the element with
// the other elements to be equalized.
// For efficiency, begin with 0.
// For example, if you have two divs you would like to be of equal height:
// <div id="div-1" equalize-height-up="0"></div><div id="div-2" equalize-height-up="0"></div>.
// The script re-evaluates the elements on page re-size.

// Version 2.0.1 added a responsive element to equalize-up
// It will still work as described above, but you can now add a min and/or max window width
// that will determine whether or not the equalize is performed.
// The format is equalize-height-up="group-index, min-window-width, max-window width"
// For example:
// <div id="div-1" equalize-height-up="0,500,1000"></div><div id="div-2" equalize-height-up="0"></div>.
// This will equalize when the window width is between 500px and 1000px inclusive.
// <div id="div-1" equalize-height-up="0,700"></div><div id="div-2" equalize-height-up="0"></div>.
// This will equalize when the window width is greater or equal to 700px.

// Include the min and max values in only one element in a group. You can actually include
// values in more than one element in a group, but only the last value set will be used if
// both values are declared and the min value will be used if only it is declared and a
// previously defined max value will be used.

(function ($) {
	window.addEventListener("load", function () {
		var equalize_up_groups = [];
		var equalize_up_responsive = [];
		var equalize_down_groups = [];
		var equalize_down_responsive = [];
		var equalize_up_elements = $('[equalize-height-up]');
		var equalize_down_elements = $('[equalize-height-down]');

		function reset_heights() {
			if (equalize_up_groups.length > 0) {
				for (var i = 0; i < equalize_up_groups.length; i++) {
					var height = 0;
					if (equalize_up_groups[i] !== undefined) {
						var group = equalize_up_groups[i];
						for (var j = 0; j < group.length; j++) {
							$(group[j]).height('auto');
						} // end group loop
					} // end group not undefined
				} // end loops to set element heights to auto
			} // end if equalize up elements
			if (equalize_down_groups.length > 0) {
				for (var i = 0; i < equalize_down_groups.length; i++) {
					var height = 0;
					if (equalize_down_groups[i] !== undefined) {
						var group = equalize_down_groups[i];
						for (var j = 0; j < group.length; j++) {
							$(group[j]).height('auto');
						} // end group loop
					} // end group not undefined
				} // end loops to set element heights to auto
			} // end if equalize down elements
		} // end reset_heights()

		function equalize_up() {
			if (equalize_up_elements.length > 0) {
				var index = -1;
				for (var i = 0; i < equalize_up_elements.length; i++) {
					var attributes = equalize_up_elements[i].getAttribute("equalize-height-up").split(',');
					if (attributes[0] !== undefined && attributes[0] != '') {
						index = attributes[0];
					}

					// sets the responsive min and max for the group
					var responsive = {
						min: -1,
						max: -1
					};
					if (attributes[1] !== undefined) {
						responsive.min = attributes[1];
					}
					if (attributes[2] !== undefined) {
						responsive.max = attributes[2];
					}

					if (equalize_up_responsive[index] === undefined) {
						equalize_up_responsive[index] = responsive;
					} else {
						if (responsive.min != -1) {
							equalize_up_responsive[index].min = responsive.min;
						}
						if (responsive.max != -1) {
							equalize_up_responsive[index].max = responsive.max;
						}
					}

					// add the element to the group
					if (equalize_up_groups[index] !== undefined) {
						equalize_up_groups[index].push(equalize_up_elements[i]);
					} else {
						equalize_up_groups[index] = [equalize_up_elements[i]];
					}
				}
				for (i = 0; i < equalize_up_groups.length; i++) {
					var window_width = $(window).outerWidth();

					// console.log(equalize_up_responsive[i]);

					var equalize = false;
					if ((equalize_up_responsive[i].min == -1 || equalize_up_responsive[i].min <= window_width) &&
						(equalize_up_responsive[i].max == -1 || equalize_up_responsive[i].max >= window_width)) {
						var height = 0;
						if (equalize_up_groups[i] !== undefined) {
							var group = equalize_up_groups[i];
							for (var j = 0; j < group.length; j++) {
								if (height < $(group[j]).height()) {
									height = $(group[j]).height();
								}
							}
							for (var j = 0; j < equalize_up_groups[i].length; j++) {
								$(group[j]).height(height);
							}
						} // if group not undefined
					} // if responsive width criteria met
				} // end loops to set element heights
			} // end if equalize_up_elements has elements
		} // end equalize_up()

		function equalize_down() {
			if (equalize_down_elements.length > 0) {
				var index = -1;
				for (var i = 0; i < equalize_down_elements.length; i++) {
					index = equalize_down_elements[i].getAttribute("equalize-height-down");
					if (equalize_down_groups[index] !== undefined) {
						equalize_down_groups[index].push(equalize_down_elements[i]);
					} else {
						equalize_down_groups[index] = [equalize_down_elements[i]];
					}
				}
				for (var i = 0; i < equalize_down_groups.length; i++) {
					var height = 99999999;
					if (equalize_down_groups[i] !== undefined) {
						var group = equalize_down_groups[i];
						for (var j = 0; j < group.length; j++) {
							if (height > $(group[j]).height() && $(group[j]).height() > 0) {
								height = $(group[j]).height();
							}
						}
						for (var j = 0; j < equalize_down_groups[i].length; j++) {
							$(group[j]).height(height);
						}
					} // end if equalize down group defined
				} // end loops to set element heights
			} // end if equalize_down_elements has elements
		} // end equalize_down()

		equalize_up();
		equalize_down();

		var resizeTimer;
		$(window).on('resize', function (e) {
			clearTimeout(resizeTimer);
			resizeTimer = setTimeout(function () {
				reset_heights();
				equalize_up();
				equalize_down();
			}, 20);
		}); // end window re-size
	});

})(jQuery);