$(document).ready(function() {
    // == DETAILS PAGE ==(
    $('#cartBtn').on('click', function() {
        var productId = $(this).data('id');
        var size = $(this).data('size');
        var color = $(this).data('color');
        var quantity = $('input[name="productCount"]').val();
        var available_qty = $("#available_qty").val();

        if (parseInt(available_qty) < parseInt(quantity)) {
            alert("Product is out of stock");
            return false;
        }

        updateCart(productId, quantity, "updateCart", "0", "0", size, color);
    });

    $('#buyNowBtn').on('click', function() {
		

        var productId = $(this).data('id');
        var size = $(this).data('size');
        var color = $(this).data('color');
        var quantity = $('input[name="productCount"]').val();
        var available_qty = $(this).closest('.priceDiv').find('.available_qty').val();
        if (parseInt(available_qty) < parseInt(quantity)) {
           // alert("Product is out of stock");
            return false;
        }
		//alert(quantity);
        updateCart(productId, quantity, "updateCart", "0", "1", size, color);
    });
    // == DETAILS PAGE ==

    // == QUICKVIEW PAGE ==
    $('#cartQuickViewBtn').on('click', function() {

        var productId = $(this).data('id');
        var quantity = $('input[name="productCount"]').val();
        var available_qty = $(this).closest('.priceDiv').find('.available_qty').val();
        var price_id = $(this).closest('.priceDiv').find('.price_id').val();

        if (parseInt(available_qty) < parseInt(quantity)) {
            alert("Product is out of stock");
            return false;
        }
        $(this).html('<span class="fa fa-refresh fa-spin"></span> Adding to cart');
        $(this).prop('disabled', true);
        updateCart(productId, quantity, "quickViewUpdateCart", "0", "0", price_id);

        /* parent.$(".slidermenu").addClass("open");
        parent.$('body').addClass("shw"); */

        // parent.jQuery.fancybox.close();
    });
    $('#buyNowQuickViewBtn').on('click', function() {

        var productId = $(this).val();
        var quantity = $('input[name="productCount"]').val();
        var available_qty = $(this).closest('.priceDiv').find('.available_qty').val();
        var price_id = $(this).closest('.priceDiv').find('.price_id').val();
        if (parseInt(available_qty) < parseInt(quantity)) {
            alert("Product is out of stock");
            return false;
        }
        $(this).html('<span class="fa fa-refresh fa-spin"></span> Buy Now');
        $(this).prop('disabled', true);
        updateCart(productId, quantity, "updateCart", "0", "1", price_id);

    });
    // == QUICKVIEW PAGE ==


    // == LISTING PAGE ==
    $('.cartListingBtn').on('click', function() {
        var productId = $(this).data("id");

        var quantity = 1;
        var available_qty = $(this).find('input[name="available_qty"]').val();
        var size = $(this).find('input[name="size"]').val();
        var color = $(this).find('input[name="color"]').val();

        //var price_id = $(this).closest('.priceDiv').find('.price_id').val();
        if (available_qty < quantity) {
            alert("Product is out of stock");
            return false;
        }
        updateCart(productId, quantity, "updateCart", $(this), "0", size, color);
    });
    $('.listingBuyNow').on('click', function() {
        var productId = $(this).data('id');
        //alert(productId);
        var quantity = 1;
        var available_qty = $(this).closest('.priceDiv').find('.available_qty').val();
        //var price_id = $(this).closest('.priceDiv').find('.price_id').val();
        if (available_qty < quantity) {
            alert("Product is out of stock");
            return false;
        }
        updateCart(productId, quantity, "updateCart", "0", "1");
    });

    // == LISTING PAGE ==

    // == CART SIDE POPUP ==
    $('.removeFromCartBtn').on('click', onRemoveFromCart);
    /* $('.cartListingBtn').on('click', cartListingBtn); */
    $('.incrementCartBtn').on('click', onIncrementFromCart);
    $('.decrementCartBtn').on('click', onDecrementFromCart);
    // == CART SIDE POPUP ==

    // == CART PAGE ==
    $('.cartPageRemoveFromCartBtn').on('click', onRemoveFromCartOnCartPage);
    $('.cartPageIncrementFromCartBtn').on('click', onIncrementFromCartOnCartPage);
    $('.cartPageDecrementFromCartBtn').on('click', onDecrementFromCartOnCartPage);
    // == CART PAGE ==

    // == CHECKOUT PAGE ==
    $('.checkoutPageRemoveFromCartBtn').on('click', onRemoveFromCartOnCheckoutPage);
    $('.checkoutPageIncrementFromCartBtn').on('click', onIncrementFromCartOnCheckoutPage);
    $('.checkoutPageDecrementFromCartBtn').on('click', onDecrementFromCartOnCheckoutPage);
    // == CHECKOUT PAGE ==

    // == COUPON CODE ==
    $('.applyCouponCodeCartBtn').on('click', applyCouponCode);
    $('.removeCouponCodeCartBtn').on('click', removeCouponCode);

    $('.applyCouponCodeCheckoutBtn').on('click', applyCouponCodeOnCheckoutPage);
    $('.removeCouponCodeCheckoutBtn').on('click', removeCouponCodeOnCheckoutPage);
    // == COUPON CODE ==
});


function onIncrementFromCart(){
	console.log("hii");
	var cartQty=$(this).closest('.input-group1').find('.cartQty').val();
	var productId=$(this).closest('.input-group1').find('input[name="productNo"]').val();
	var size=$(this).closest(".input-group1").find('input[name="size"]').val();
	var color=$(this).closest(".input-group1").find('input[name="color"]').val();
	// console.log(pricee);
	// updateCart(productId,cartQty,"updateCart","3","0",size,pricee);
	
	updateCart(productId, cartQty, "updateCart", "3", "0", size, color);
}
function onDecrementFromCart(){
	var cartQty=$(this).closest('.input-group1').find('.cartQty').val();
	var productId=$(this).closest('.input-group1').find('input[name="productNo"]').val();
	var size=$(this).closest(".cart_details").find('input[name="size"]').val();
	var color=$(this).closest(".input-group1").find('input[name="color"]').val();
	updateCart(productId,cartQty,"updateCartDesc","3","0",size, color);
}

// == CART SIDE POPUP ==
function cartListingBtn() {
    var productId = $(this).data("id");
    //alert(productId);
    var quantity = 1;
    var available_qty = $(this).closest('.ajaxPrice').find('input[name="available_qty"]').val();
    var size = $(this).closest('.ajaxSize').find('select[name="size"]').val();
    //var price_id = $(this).closest('.priceDiv').find('.price_id').val();
    if (available_qty < quantity) {
        alert("Product is out of stock");
        return false;
    }
    updateCart(productId, quantity, "updateCart", $(this), "0", size,);
}

function onRemoveFromCart() {   
   // if (confirm("Are you sure you want to remove this Product from cart?") == true) {
        var productId = $(this).data('id');
        //alert(productId);
        var size = $(this).closest(".cart_details").find('input[name="size"]').val();
        var color = $(this).closest(".cart_details").find('input[name="color"]').val();
        updateCart(productId, 1, "removeFromCart", "0", "0", size, color);
    //}
}
/*
function onIncrementFromCart() {

    //debugger;

    var cartQty = $(this).closest('.input-group1').find('.cartQty').val();
    var productId = $(this).closest('.input-group1').find('input[name="productNo"]').val();
    //var price_id = $(this).closest('.input-group1').find('input[name="price_id"]').val();
    var size = $(this).closest(".cart_details").find('input[name="size"]').val();
    var color = $(this).closest(".cart_details").find('input[name="color"]').val();

    updateCart(productId, cartQty, "updateCart", "0", "0", size, color);
}

function onDecrementFromCart() {
    var cartQty = $(this).closest('.input-group1').find('.cartQty').val();
    var productId = $(this).closest('.input-group1').find('input[name="productNo"]').val();
    //var price_id = $(this).closest('.input-group1').find('input[name="price_id"]').val();
    var size = $(this).closest(".cart_details").find('input[name="size"]').val();
    var color = $(this).closest(".cart_details").find('input[name="color"]').val();
    updateCart(productId, cartQty, "updateCartDesc", "0", "0", size, color);
}*/
// == CART SIDE POPUP ==

// == QUICKVIEW CART SIDE POPUP ==
function addQuickViewEvents() {
    // == CART SIDE POPUP ==
    $('.removeFromCartBtn').on('click', onRemoveFromCart);
    $('.incrementCartBtn').on('click', onIncrementFromCart);
    $('.decrementCartBtn').on('click', onDecrementFromCart);
    // == CART SIDE POPUP ==

    // == COUPON CODE ==
    $('.applyCouponCodeCartBtn').on('click', applyCouponCode);
    $('.removeCouponCodeCartBtn').on('click', removeCouponCode);
    // == COUPON CODE ==
}
/*
function onRemoveFromCartQuickView(){
	var productId = parent.$(this).val();
	updateCart(productId, 1, "removeFromCart", "0", "0");
}
function onIncrementFromCartQuickView(){
	var cartQty = parent.$(this).closest('.input-group').find('.cartQty').val();
	var productId = parent.$(this).closest('.input-group').find('input[name="productNo"]').val();
	updateCart(productId, cartQty, "updateCart", "0", "0");
}
function onDecrementFromCartQuickView(){
	var cartQty = parent.$(this).closest('.input-group').find('.cartQty').val();
	var productId = parent.$(this).closest('.input-group').find('input[name="productNo"]').val();
	updateCart(productId, cartQty, "updateCart", "0", "0");
} */
// == QUICKVIEW CART SIDE POPUP ==

// == CART PAGE ==
function onRemoveFromCartOnCartPage() {
    var productId = $(this).val();
    var price_id = $(this).closest('div').find('input[name="price_id"]').val();
    if (productId) {
        updateCart(productId, 1, "removeFromCart", "1", "0", price_id);
    }
}

function onIncrementFromCartOnCartPage() {
    var cartQty = $(this).closest('.input-group1').find('.cartQty').val();
    var productId = $(this).closest('.input-group1').find('input[name="productNo"]').val();
    var size = $(this).closest(".cart_details").find('input[name="size"]').val();
    var color = $(this).closest(".cart_details").find('input[name="color"]').val();

    if (productId && cartQty) {
        updateCart(productId, cartQty, "updateCart", "1", "0", size, color);
    }
}

function onDecrementFromCartOnCartPage() {
    var cartQty = $(this).closest('.input-group').find('.cartQty').val();
    var productId = $(this).closest('.input-group').find('input[name="productNo"]').val();
    var size = $(this).closest(".cart_details").find('input[name="size"]').val();
    var color = $(this).closest(".cart_details").find('input[name="color"]').val();

    if (productId && cartQty) {
        updateCart(productId, cartQty, "updateCartDesc", "1", "0", size, color);
    }
}
// == CART PAGE ==

// == CHECKOUT PAGE ==
function onRemoveFromCartOnCheckoutPage() {
    //debugger;
    if (confirm("Are you sure you want to remove this Product from cart ?") == true) {

        var productId = $(this).data('id');
        //var price_id = $(this).closest('tr').find('input[name="price_id"]').val();
        // var size = $(this).closest(".cart_details").find('select[name="size"]').val();
        var size = $(this).closest('.cart_details').find('input[name="size"]').val();
        var color = $(this).closest(".cart_details").find('input[name="color"]').val();

        // console.log(price_id);
        if (productId) {
            updateCart(productId, 1, "removeFromCart", "2", "0", size, color);
        }

    }
}

function onIncrementFromCartOnCheckoutPage() {

    //debugger;
    var cartQty = $(this).closest('.input-group1').find('.cartQty').val();
    var productId = $(this).closest('.input-group1').find('input[name="productNo"]').val();
    //var price_id = $(this).closest('.input-group1').find('input[name="price_id"]').val();
    var size = $(this).closest(".cart_details").find('input[name="size"]').val();
    var color = $(this).closest(".cart_details").find('input[name="size"]').val();
    if (productId && cartQty) {
        updateCart(productId, cartQty, "updateCart", "2", "0", size, color);
    }
}

function onDecrementFromCartOnCheckoutPage() {
    //debugger;
    var cartQty = $(this).closest('.input-group1').find('.cartQty').val();
    var productId = $(this).closest('.input-group1').find('input[name="productNo"]').val();
    //var price_id = $(this).closest('.input-group1').find('input[name="price_id"]').val();
    var size = $(this).closest(".cart_details").find('input[name="size"]').val();
    var color = $(this).closest(".cart_details").find('input[name="color"]').val();
    if (productId && cartQty) {
        updateCart(productId, cartQty, "updateCartDesc", "2", "0", size, color);
    }
}
// == CHECKOUT PAGE ==

// == COUPON CODE ==
function applyCouponCode() {

    var inputGroupEle = $(this).closest('.input-group1');
    var couponCodeEle = inputGroupEle.find('input[name="couponCode"]');
    if (couponCodeEle.val()) {
        // inputGroupEle.removeClass('has-error');
        // $(this).removeClass('btn-danger').addClass('btn-primary');
        updateCart("-", "-", "applyCouponCode", "0", "0", "0");
    } else {
        inputGroupEle.addClass('has-error');
        couponCodeEle.focus();
        // $(this).removeClass('btn-primary').addClass('btn-danger');
    }
}

function removeCouponCode() {

    if (confirm("Are you sure you want to remove this Discount Coupon ?") == true) {
        updateCart("-", "-", "removeCouponCode", "0", "-", "-");
    }
}

function applyCouponCodeOnCheckoutPage() {
    var inputGroupEle = $(this).closest('.input-group1');
    var couponCodeEle = inputGroupEle.find('input[name="couponCode"]');
    if (couponCodeEle.val()) {
        // inputGroupEle.removeClass('has-error');
        // $(this).removeClass('btn-danger').addClass('btn-primary');
        updateCart("-", "-", "applyCouponCode", "2", "-", "-", "-");
    } else {
        inputGroupEle.addClass('has-error');
        couponCodeEle.focus();
        $(this).removeClass('btn-primary').addClass('btn-danger');
    }
}

function removeCouponCodeOnCheckoutPage() {
    if (confirm("Are you sure you want to remove this Discount Coupon ?") == true) {
        updateCart("-", "-", "removeCouponCode", "2", "-", "-", "-");
    }
}
// == COUPON CODE ==

function disableFields(status, isCheckoutNow) {
    var productCountEle = $('input[name="productCount"]');
    productCountEle.prop("disabled", status);
    productCountEle.prev(".input-group-btn").find("button").prop("disabled", status);
    productCountEle.next(".input-group-btn").find("button").prop("disabled", status);
    var cartBtn = $('#cartBtn');
    if (isCheckoutNow == "0" && status) {
        cartBtn.prop('disabled', status);
        cartBtn.html('<span class="fa fa-refresh fa-spin"></span> Adding...');
    } else if (isCheckoutNow == "0" && !status) {
        cartBtn.prop('disabled', status);
        cartBtn.html('Add to cart');
    }
}

function updateCart(productId, quantity, action, isCartPage, isCheckoutNow, size, color) {
    if (productId && quantity && action && isCartPage && isCheckoutNow) {
        // console.log('isCartPage',isCartPage);
        // == COUPON CODE ==
        var couponCodeVal = '';
        var couponCode = '';
        $.each($('input[name="couponCode"]'), function(index, element) {
            couponCodeVal = $(element).val();
            if (couponCodeVal) {
                couponCode = couponCodeVal;
            }
        });
        // == COUPON CODE ==

        // == LOADING ==
        disableFields(true, isCheckoutNow);
        $('#cart-tray').html('<div class="text-center"><i class="fa fa-refresh fa-spin fa-3x"></i></div>');
        if (isCartPage == "1") {
            $("#cart-wrapper").html('<div class="text-center"><i class="fa fa-refresh fa-spin fa-3x"></i></div>');
        }
        if (isCartPage == "2") {
            $("#checkout-cart-wrapper").html('<div class="text-center"><i class="fa fa-refresh fa-spin fa-3x"></i></div><br/><br/>');
            $('button[name="makePayment"]').prop('disabled', true);
        }
        var cartToolTip = 0;
        if (typeof isCartPage == "object") {
            cartToolTip = isCartPage;
            cartToolTip.next('.tooltiptext').html('<i class="fa fa-refresh fa-spin"></i> Adding to cart...');
            isCartPage = 0
        }
        // == LOADING ==

        // == QUICK VIEW ==
        if (action == "quickViewUpdateCart") {
            var isQuickView = true;
            action = "updateCart";
        } else {
            var isQuickView = false;
        }
        // == QUICK VIEW ==

        if (isCartPage == "2") { // don't slide cart
        } else {
            if (isQuickView) {
                parent.slideCartTray(true);
            } else {
                slideCartTray(true);
            }
        }

        $.ajax({
            url: BASE_URL+"/ajax-update-cart.php",
            data: { productId: productId, quantity: quantity, size: size, action: action, isCartPage: isCartPage, couponCode: couponCode, color: color },
            type: "post",
            success: function(response) {
                // console.log(response); // TEST
                if (response) {
                    var responseOBJ = JSON.parse(response);
                    if (responseOBJ.response) {
                        // console.log(responseOBJ.response); // TEST
                        if (isQuickView) {
                            parent.jQuery.fancybox.close();
                            parent.$('#cart-tray').html(responseOBJ.cartHTML);
                            parent.$('#cart-notification').html(responseOBJ.cartNotificationHTML);
                            parent.$('.cart-quantity-count').html(responseOBJ.cartCount);
                            if (isCartPage == "1") {
                                parent.$("#cart-wrapper").html(responseOBJ.cartPageHTML);

                            }
                            // == EVENT HANDLERS ==
                            parent.incrementSpinner();
                            //parent.addQuickViewEvents();
                            // == EVENT HANDLERS ==

                            if (action == "updateCart") {
                                parent.showNotification('<i class="fa fa-check"></i> Cart updated');
                            }
                        } else {
                            $('.cartCount').text(responseOBJ.cartCount)
                            $('#cart-wrapper').html(responseOBJ.cartHTML);
                            //$('#cart-tray').html(responseOBJ.cartHTML);
                            $('#cart-notification').html(responseOBJ.cartNotificationHTML);
                            $('.cart-quantity-count').html(responseOBJ.cartCount);
                            if (isCartPage == "0" || isCartPage == "1") {
                                /*$('.cart-sidebar').css("right","0");
                                $('.cart-sidebar').css("transition","all 0.5s ease-in-out 0s;");
                                $('.body-overlay').css("display","block");
                                $('.close-cart-div').addClass('open');

                                $('.close_cart').click(function(){
                                	$('.cart_section').toggleClass('show-cart');
                                	$('.menu-overly-cart').toggle();
                                });*/
                                $('.cart-sidebar').css("right", "0");
                                $('.cart-sidebar').css("transition", "all 0.5s ease-in-out 0s;");
                                $('.body-overlay').css("display", "block");
                                $('.close-cart-div').addClass('open');
                                $('.close-cart-div').click(function() {
                                    $('.cart-sidebar').css("right", "-100%");
                                    $('.cart-sidebar').css("transition", "0.5s all ease-in-out");
                                    $('.body-overlay').css("display", "none");
                                    $(this).removeClass('open');
                                });
                            }
                            //alert(isCartPage);
                            if (isCartPage == "2") {
                                $("#checkout-cart-wrapper").html(responseOBJ.checkoutCartPageHTML);
                                $('button[name="makePayment"]').prop('disabled', false);
                                if (responseOBJ.cartCount == 0) {
                                    $(".submit-btn").attr('disabled', true);
                                } else {
                                    $(".submit-btn").attr('disabled', false);
                                }
                            }
                            if (typeof cartToolTip == "object") {
                                cartToolTip.next('.tooltiptext').html('Add To Cart');
                            }
                            // == EVENT HANDLERS ==
                            incrementSpinner();
                            // == CART SIDE POPUP ==
                            /* $('.cartListingBtn').on('click', cartListingBtn); */
                            $('.removeFromCartBtn').on('click', onRemoveFromCart);
                            $('.incrementCartBtn').on('click', onIncrementFromCart);
                            $('.decrementCartBtn').on('click', onDecrementFromCart);
                            // == CART SIDE POPUP ==

                            // == CHECKOUT PAGE ==
                            $('.checkoutPageRemoveFromCartBtn').on('click', onRemoveFromCartOnCheckoutPage);
                            $('.checkoutPageIncrementFromCartBtn').on('click', onIncrementFromCartOnCheckoutPage);
                            $('.checkoutPageDecrementFromCartBtn').on('click', onDecrementFromCartOnCheckoutPage);
                            if (typeof disableEnter == 'function') {
                                $('input[name="couponCode"], .checkoutQty').on('keypress', disableEnter);
                            }
                            // == CHECKOUT PAGE ==

                            // == COUPON CODE ==
                            $('.applyCouponCodeCartBtn').on('click', applyCouponCode);
                            $('.removeCouponCodeCartBtn').on('click', removeCouponCode);

                            $('.applyCouponCodeCheckoutBtn').on('click', applyCouponCodeOnCheckoutPage);
                            $('.removeCouponCodeCheckoutBtn').on('click', removeCouponCodeOnCheckoutPage);
                            // == COUPON CODE ==

                            $('.close_cart').click(function() {
                                $('.cart_section').toggleClass('show-cart');
                                $('.menu-overly-cart').toggle();
                            });

                            // == EVENT HANDLERS ==

                            if (responseOBJ.cartCount <= 0) {
                                $(".cart-dependency").hide();
                            } else {
                                $(".cart-dependency").show();
                            }

                            if (action == "updateCart") {
                                showNotification('<i class="fa fa-check"></i> Cart updated');
                            } else if (action == "updateCartDesc") {
                                showNotification('<i class="fa fa-check"></i> Cart updated');
                            } else if (action == "removeFromCart") {
                                showNotification('<i class="fa fa-check"></i> Product removed from cart');

								if(responseOBJ.cartCount==0) {
									location.reload();
								}
                            }

                            // console.log(responseOBJ.couponCodeMsg); // TEST
                            if (responseOBJ.couponCodeMsg) {
								console.log('responseOBJ', responseOBJ);
                                var couponCodeMsgEle = $('input[name="couponCode"]').closest('.input-group1').next();
                                couponCodeMsgEle.html(responseOBJ.couponCodeMsg);
                                if (responseOBJ.couponCodeMsg != "" && responseOBJ.couponCodeMsg == "Coupon code applied") {
                                    $(".couponErrorMsg").css("color", "green");
                                    $('.couponErrorMsg').text(responseOBJ.couponCodeMsg);
                                } else {
                                    $(".couponErrorMsg").css("color", "red");
                                    $('.couponErrorMsg').text(responseOBJ.couponCodeMsg);
                                }

                            }

                            if (isCheckoutNow == "1") {
                                parent.jQuery.fancybox.close();
                                parent.location.href = BASE_URL + "/chekout-order-summary.php";
                            }
                        }
                    }
                }
            },
            error: function() {
                alert("Something went wrong while updating your cart, please try again");
            },
            complete: function(response) {
                disableFields(false, isCheckoutNow);
            }
        });
    } else {
        return false;
    }
}

function slideCartTray(status) {
    if (status) { // open
        $(".slidermenu").addClass("open");
        $('body').addClass("shw");
    } else { // close
        $(".slidermenu").removeClass("open");
        $('body').removeClass("shw");
    }
}

function showNotification(message, time) {
    if (!time) time = 2000;
    $('.cart-notification .cart-notification-container').html(message);
    $('.cart-notification').fadeIn();
    setTimeout(function() {
        $('.cart-notification').fadeOut();
    }, time);
}

function showNotification(message, time) {
    if (!time) time = 2000;
    $('.cart-notification .cart-notification-container').html(message);
    $('.cart-notification').fadeIn();
    setTimeout(function() {
        $('.cart-notification').fadeOut();
    }, time);
}