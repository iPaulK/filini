$(function() {


	//мобильное меню close-menu

	$('.mobile-icon').click(function(){
		$('.mobile-nav').addClass('mobile-nav-open');
		$('.shadow-menu').show();
	});
	$('.close-menu').click(function(){
		$('.mobile-nav').removeClass('mobile-nav-open');
		$('.shadow-menu').hide();
	});
	$('.shadow-menu').click(function(){
		$('.mobile-nav').removeClass('mobile-nav-open');
		$('.shadow-menu').hide();
	});

	$('.popup-with-zoom-anim').magnificPopup({
		type: 'inline',

		fixedContentPos: false,
		fixedBgPos: true,

		overflowY: 'auto',

		closeBtnInside: true,
		preloader: false,
		
		midClick: true,
		removalDelay: 300,
		mainClass: 'my-mfp-zoom-in'
	});

	$('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
		disableOn: 700,
		type: 'iframe',
		mainClass: 'mfp-fade',
		removalDelay: 160,
		preloader: false,

		fixedContentPos: false
	});

	//обратная связь

	$('.contact-form .phone').click(function(){
		$(this).css('background', '#a29f9e');
		$('.contact-form .phone .off').css('background', '#e3e2e2');
		$('.contact-form .email').css('background', '#e3e2e2');
		$('#input-phone').show();
		$('#input-email').hide();
	});
	$('.contact-form .email').click(function(){
		$(this).css('background', '#a29f9e');
		$('.contact-form .phone .off').css('background', '#a29f9e');
		$('.contact-form .phone').css('background', '#e3e2e2');
		$('#input-phone').hide();
		$('#input-email').show();
	});

// text size complect

	$('.product-text .li-text').click(function(){
		$('.product-text .li-text').addClass('li-active');
		$('.product-text .li-size').removeClass('li-active');
		$('.product-text .li-complect').removeClass('li-active');
		$('.product-text .text').show();
		$('.product-text .size').hide();
		$('.product-text .complect').hide();
	});

		$('.product-text .li-size').click(function(){
			$(this).addClass('li-active');
			$('.product-text .li-text').removeClass('li-active');
			$('.product-text .li-complect').removeClass('li-active');
			$('.product-text .size').show();
			$('.product-text .text').hide();
			$('.product-text .complect').hide();
	});
// text size complect
		$('.product-text .li-complect').click(function(){
		$(this).addClass('li-active');
		$('.product-text .li-text').removeClass('li-active');
		$('.product-text .li-size').removeClass('li-active');
		$('.product-text .complect').show();
		$('.product-text .text').hide();
		$('.product-text .size').hide();
	});

	/*
loop: true,
			items: 1,
			itemClass: "slide-wrap",
			nav: true,
			navText: ""
	*/

});
