
 $(document).ready(function() {
        var t = $("#owl-demo");
        t.owlCarousel({
            itemsCustom: [
                [0, 1],
                [450, 2],
                [600, 3],
                [700, 3],
                [1e3, 4],
                [1200, 4],
                [1400, 4],
                [1600, 4],
				[20000, 4]
            ],
            navigation: !0,
            items: 4,
            autoPlay:false,
            loop: !0
        })
    })
	
	// get header height (without border)
	var getHeaderHeight = $('.headerContainerWrapper').outerHeight();

	// border height value (make sure to be the same as in your css)
	var borderAmount = 2;

	// shadow radius number (make sure to be the same as in your css)
	var shadowAmount = 30;

	// init variable for last scroll position
	var lastScrollPosition = 0;

	// set negative top position to create the animated header effect
	$('.headerContainerWrapper').css('top', '-' + (getHeaderHeight + shadowAmount + borderAmount) + 'px');

	$(window).scroll(function() {
		var currentScrollPosition = $(window).scrollTop();

		if ($(window).scrollTop() > 2 * (getHeaderHeight + shadowAmount + borderAmount) ) {

			$('body').addClass('scrollActive').css('padding-top', getHeaderHeight);
			$('.headerContainerWrapper').css('top', 0);

			if (currentScrollPosition < lastScrollPosition) {
				$('.headerContainerWrapper').css('top', '-' + (getHeaderHeight + shadowAmount + borderAmount) + 'px');
			}
			lastScrollPosition = currentScrollPosition;

		} else {
			$('body').removeClass('scrollActive').css('padding-top', 0);
		}
	});