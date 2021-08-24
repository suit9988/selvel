<script>
	var BASE_URL = "<?php echo BASE_URL; ?>";
</script>
<script src="<?php echo BASE_URL; ?>/js/jquery-3.3.1.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/jquery.nice-select.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/slick/slick.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/jquery-ui.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/jquery.matchHeight.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/jquery.nice-select.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/jquery.elevatezoom.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/fancy.js" type="text/javascript"></script>
<script src="https://www.google.com/recaptcha/api.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/wow.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/additional-methods.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/jquery.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/index.js" type="text/javascript"></script>

<script src="<?php echo BASE_URL; ?>/js/jquery.mCustomScrollbar.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/dms/js/owl.carousel.js" type="text/javascript"></script>
<script type="text/javascript">
	$(".scrollbarhai").mCustomScrollbar({
		axis: "y"
	});
	<?php
	if (isset($_GET['resetsuccess'])) {
	?>
		$(".before-login").fancybox().trigger('click');

	<?php
	}
	if (isset($_GET['wrong-password'])) {
	?>
		$(".before-login").fancybox().trigger('click');

	<?php
	}
	?>
	new WOW().init();

	// $("[data-fancybox='login-pop']").fancybox({
	//     iframe : {
	//         css : {
	//             width : '650px',
	//             height :'650px'
	//         }
	//     }
	// });
	$('[data-fancybox]').fancybox({
		closeExisting: true,
		loop: true,
		touch: false,
		clickSlide: false,
		clickOutside: false
	});
	$(document).ready(function() {
		$('#open-register').click(function() {
			//$('#register-page').css("display","block");
			$("#login-page").slideToggle(),
				$("#register123-page").slideToggle()
			//alert("hii");
		});
	});
</script>
<script src="<?php echo BASE_URL ?>/js/bootstrap3-typeahead.min.js"></script>
<script src="<?php echo BASE_URL ?>/js/bootstrap-select.min.js"></script>
<script>
	$(document).ready(function() {
		incrementSpinner();

		$("#news_letterSub").validate({
			ignore: ".ignore",
			rules: {
				youremail: {
					required: true,
					email: true,
				},
				yourname: {
					required: true,
				}
			},
			messages: {
				email: {
					required: 'Please enter your email address',
					email: 'Pleas enter valid email Address'
				},
			}
		});
	});

	function incrementSpinner() {
		$('.btn-number').off("click");
		$('.input-number').off("click");
		$('.input-number').off("change");
		$('.input-number').off("keydown");

		$('.btn-number').click(function(e) {
			// alert('click');
			e.preventDefault();

			fieldName = $(this).attr('data-field');
			type = $(this).attr('data-type');
			var input = $("input[name='" + fieldName + "']");
			var currentVal = parseInt(input.val());
			//alert(currentVal);
			if (!isNaN(currentVal)) {
				if (type == 'minus') {
					if (currentVal > input.attr('min')) {
						input.val(currentVal - 1).change();
					}
					/* if(parseInt(input.val()) == input.attr('min')) {
						$(this).attr('disabled', true);
					} */

				} else if (type == 'plus') {

					if (currentVal < input.attr('max')) {
						input.val(currentVal + 1).change();
					}

				}
			} else {
				input.val(0);
			}
		});
		$('.input-number').focusin(function() {
			$(this).data('oldValue', $(this).val());
		});
		$('.input-number').change(function() {
			minValue = parseInt($(this).attr('min'));
			maxValue = parseInt($(this).attr('max'));
			valueCurrent = parseInt($(this).val());

			name = $(this).attr('name');
			if (valueCurrent >= minValue) {
				$(".btn-number[data-type='minus'][data-field='" + name + "']").removeAttr('disabled')
			} else {
				alert('Sorry, the minimum value was reached');
				$(this).val($(this).data('oldValue'));
			}
			if (valueCurrent <= maxValue) {
				$(".btn-number[data-type='plus'][data-field='" + name + "']").removeAttr('disabled')
			} else {
				alert('Sorry, the maximum value was reached');
				$(this).val($(this).data('oldValue'));
			}
		});
		$(".input-number").keydown(function(e) {
			// Allow: backspace, delete, tab, escape, enter and .
			if ($.inArray(e.keyCode, [46, 8, 9, 17, 13, 190]) !== -1 ||
				// Allow: Ctrl+A
				(e.keyCode == 65 && e.ctrlKey === true) ||
				// Allow: home, end, left, right
				(e.keyCode >= 35 && e.keyCode <= 39)) {
				// let it happen, don't do anything
				return;
			}
			// Ensure that it is a number and stop the keypress
			if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
				e.preventDefault();
			}
		});
	}
</script>

<script src="<?php echo BASE_URL; ?>/js/ajaxWishlist.js" type="text/javascript"></script>
<script>
	var search_texts = '';
	var qField = $('#search_text, #mini_search_text, #mobile-search');
	var qFieldTypeBox = qField.typeahead({
		source: function(query, getData) {
			setTimeout(function() { // for fast typing, delay
				var categoty = $('select[name="categories"]').val();
				search_texts = $('input#search_text').val();
				var aTest = $.ajax({
					url: "<?php echo BASE_URL ?>/search_product.php?cat=" + categoty,
					type: "get",
					data: {
						q: query
					},
					success: function(response) {
						console.log(response);
						// alert(response); // TEST
						var response = response.split("D#K");
						getData(response);
					},
					error: function(response) {
						getData(["Unable to get results please try again"]);
					},
					complete: function() {}
				});
			}, 1000);
		},
		showHintOnFocus: false,
		// delay:100,
		autoSelect: false,
		afterSelect: function(e, f, g) {
			qField.val(e);
			setTimeout(function() {
				$("#searchFrm").submit();
				//alert(search_texts);
				//window.location.href = "<?php echo BASE_URL; ?>/listing-search?product_id="+search_text;
			}, 10);
		}
	});
</script>
<script src="<?php echo BASE_URL; ?>/js/ajax-update-cart.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/ajaxWishlist.js" type="text/javascript"></script>
<script>
	$('.mini_cart_wrapper > a').on('click', function() {
		$('.mini_cart,.off_canvars_overlay').addClass('active')
	});

	$('.mini_cart_close,.off_canvars_overlay').on('click', function() {
		$('.mini_cart,.off_canvars_overlay').removeClass('active')
	});
	$('.canvas_open').on('click', function() {
		$('.offcanvas_menu_wrapper,.off_canvars_overlay').addClass('active')
	});

	$('.canvas_close,.off_canvars_overlay').on('click', function() {
		$('.offcanvas_menu_wrapper,.off_canvars_overlay').removeClass('active')
	});


	$('#nav-tab a,#nav-tab2 a').on('click', function(e) {
		e.preventDefault()
		$(this).tab('show')
	})

	/*---Off Canvas Menu---*/
	var $offcanvasNav = $('.offcanvas_main_menu'),
		$offcanvasNavSubMenu = $offcanvasNav.find('.sub-menu');
	$offcanvasNavSubMenu.parent().prepend('<span class="menu-expand"><i class="fa fa-angle-down"></i></span>');

	$offcanvasNavSubMenu.slideUp();

	$offcanvasNav.on('click', 'li a, li .menu-expand', function(e) {
		var $this = $(this);
		if (($this.parent().attr('class').match(/\b(menu-item-has-children|has-children|has-sub-menu)\b/)) && ($this.attr('href') === '#' || $this.hasClass('menu-expand'))) {
			e.preventDefault();
			if ($this.siblings('ul:visible').length) {
				$this.siblings('ul').slideUp('slow');
			} else {
				$this.closest('li').siblings('li').find('ul:visible').slideUp('slow');
				$this.siblings('ul').slideDown('slow');
			}
		}
		if ($this.is('a') || $this.is('span') || $this.attr('clas').match(/\b(menu-expand)\b/)) {
			$this.parent().toggleClass('menu-open');
		} else if ($this.is('li') && $this.attr('class').match(/\b('menu-item-has-children')\b/)) {
			$this.toggleClass('menu-open');
		}
	});
	$(window).scroll(function() {
		$(window).scrollTop() >= 150 ? $(".canvas_open").addClass("sticky") : $(".canvas_open").removeClass("sticky")
	});
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script>
	function miniCartUpdate($cart_item, action) {
		const productId = $cart_item.find('input[name="productNo"]').val();
		const cartQty = $cart_item.find('input[name="productCount"]').val();
		const size = $cart_item.find('input[name="size"]').val();
		const color = $cart_item.find('input[name="color"]').val();
		let quantity = 1;
		const isCartPage = "0";
		const isCheckoutNow = "12121";
		if (action == 'updateCartDesc') {
			quantity = cartQty;
		}
		updateCart(productId, quantity, action, isCartPage, isCheckoutNow, size, color);
		setTimeout(function() {
			window.location.reload();
		}, 2000);
	}

	$(document).ready(function() {

		$('#minicart-related-items_slider').owlCarousel({
			margin: 10,
			center: true,
			loop: true,
			nav: false,
			items: 1,
			autoplay: true,
			autoplayHoverPause: true,
			autoplayTimeout: 5000
		})

		$(document).on('click', '.mini_cart .plus', function() {
			const input = $(this).parents('ul').find('input[name="productCount"]');
			const total = parseInt(input.val());
			input.val(total + 1);
			$(this).attr('disabled', 'disabled')
			miniCartUpdate($(this).parents('.cart_item'), 'updateCart');
		});

		$(document).on('click', '.mini_cart .minus', function() {
			$(this).attr('disabled', 'disabled')
			const input = $(this).parents('ul').find('input[name="productCount"]');
			const total = parseInt(input.val());
			if (total == 1) {
				// remove item from cart
				$(this).parents('.cart_item').find('.removeFromCartBtn').trigger('click');
			} else {
				input.val(total - 1);
				miniCartUpdate($(this).parents('.cart_item'), 'updateCartDesc');
			}
		});

		$( "#slider-range" ).slider({
			range: true,
			min: 0,
			max: 3000,
			values: [ 135, 500 ],
			slide: function( event, ui ) {
				// $( "#amount" ).val( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );
				$('#lower').val(ui.values[ 0 ]);
				$('#one').val(ui.values[ 0 ]);
				$('#upper').val(ui.values[ 1 ]);
				$('#two').val(ui.values[ 1 ]);
			}
		});
		$('#one').change(function() {
			$("#slider-range").slider("values", 0, $(this).val());
		});

		$('#two').change(function() {
			$("#slider-range").slider("values", 1, $(this).val());
		});


		$('.mega_menu .mega_menu_inner').fadeOut();

		$('.menu_two ul li').hover( function(e) {
			const megaMenu = $(this).find('.mega_menu');
			if (megaMenu.length) {
				setTimeout(function() {
					megaMenu.css({
						'visibility': 'visible',
						'max-height': '391px',
						'height': '391px',
						'padding': '25px 30px 30px 30px',
					});
					megaMenu.find('.mega_menu_inner').fadeIn('slow');
				}, 100)
			}
		}, function(e) {
			const megaMenu = $(this).find('.mega_menu');

			// if ($(e.target) == megaMenu || $(e.target).parents('.mega_menu').length) {
			// 	return false;
			// }
			if (megaMenu.length) {
				megaMenu.find('.mega_menu_inner').fadeOut('fast', function() {
					megaMenu.css({
						'visibility': 'hidden',
						// 'height': '0',
						// 'max-height': '0'
					});
				});
			}
		})

		// $(document).on('change', '.mini_cart input[name="productCount"]', function(e) {
		// 	// add product via ajax
		// 	console.log($(this).val());
		// });
	});
</script>