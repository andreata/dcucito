jQuery( function ( $ ) {

	// FitVids
	$('.site-inner').fitVids();
	
	if ($('.woocommerce-store-notice.demo_store').length){
        $('body').css('margin-top', '65px'); 
	}

	// POPUP Exit Intent
	function addEvent(obj, evt, fn) {
		if (obj.addEventListener) {
			obj.addEventListener(evt, fn, false);
		} else if (obj.attachEvent) {
			obj.attachEvent("on" + evt, fn);
		}
	}

	function setCookie(cname, cvalue, exdays) {
		var d = new Date();
		d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
		var expires = "expires=" + d.toUTCString();
		document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
	}

	function getCookie(cookieName) {
		var name = cookieName + "=";
		var decodedCookie = decodeURIComponent(document.cookie);
		var ca = decodedCookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) == ' ') {
				c = c.substring(1);
			}
			if (c.indexOf(name) == 0) {
				return c.substring(name.length, c.length);
			}
		}
		return "";
	}

	document.addEventListener("mouseleave", function (event) {
		var cookie_intent = getCookie("exit-stop");
		if (cookie_intent == 1) {

		} else {
			if (event.clientY <= 0 || event.clientX <= 0 || (event.clientX >= window.innerWidth || event.clientY >= window.innerHeight)) {
				$('.lightbox').show();
				setCookie('exit-stop', '1', '5');
			}
		}
	});

	
	
	$(document).mouseup(function (e) {
		var container = $(".box");
		if (!container.is(e.target) && container.has(e.target).length === 0) {
			$('.lightbox').hide();
		}
	});

	$('a.close').click(function () {
		$('.lightbox').slideUp();
	});
	// popup add to cart cross sell
	
	
	$(window).scroll(function () {
		
		if ($(window).scrollTop() + $(window).height() == $(document).height()) {
			$('.sicky-add-to-cart').hide(800);
		} else {
			$('.sicky-add-to-cart').show(800)
		}
		if ($(window).scrollTop() == 0) {
			$('.sicky-add-to-cart').hide(800);
		}
	});
	

});

document.addEventListener('wpcf7mailsent', function (event) {
	location = 'https://dottorcucito.it/grazie-per-avermi-contattato/';
}, false);