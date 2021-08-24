<?php
$basename = basename($_SERVER['REQUEST_URI']);
$currentPage = pathinfo($_SERVER['PHP_SELF'], PATHINFO_BASENAME);
include_once("include/classes/Cart.class.php");
$cartObj = new Cart;
$amtArr = $functions->getCartAmountAndQuantity($cartObj, null);
?>
<style>
	.typeahead li {}

	.typeahead {
		display: block !important
	}
@media only screen and (min-width: 360px) and (max-width: 760px) {
  .slick-slider .slick-track {
    top: 120px !important;
    height: auto !important;
}
}
@media only screen and  (max-width: 760px) {
.header_right_two{
	margin-top: 41px;
}
}
	.cart-notification {
		width: auto;
		padding: 0 30px;
		left: 80%;
		top: 0;
		margin: 77px 0;
		text-align: center;
		transition: all .5s ease-in-out;
		-webkit-transition: all .5s ease-in-out;
		-moz-transition: all .5s ease-in-out;
		-o-transition: all .5s ease-in-out;
		position: fixed;
		z-index: 99999997;
		background: #fff;
		border-radius: 0;
		border: 0;
		color: #431a92;
		box-shadow: 0px 3px 7px #c9c9c9, -11px -11px 14px #7269880d;
	}

	.cart-notification-container.alert {
		margin: 0px;
		font-weight: bold;
		padding: 10px 30px;
	}

	.animated {
		-webkit-animation-duration: 1s;
		animation-duration: 1s;
		-webkit-animation-fill-mode: both;
		animation-fill-mode: both;
	}

	.fadeInDown {
		-webkit-animation-name: fadeInDown;
		animation-name: fadeInDown;
	}

	p,
	a,
	h1,
	h2,
	h3,
	h4,
	h5,
	h6,
	strong,
	body,
	html, label {
		font-family: "Gotham-Font" !important;
		font-style: normal;
	}

	flex-propers {
		width: 100% !important;
	}
	.slick-slide img{
	display:initial; 
	}
	
	#capacittext{
		margin-top: 10px;
	}
	.my_cart, #my_cart
	{
	    max-width:600px;
	}
</style>
<!-- Loader start -->
<div id="loader-wrapper">
	<div class="loader">
		<img src="<?php echo BASE_URL; ?>/images/logo.png">
		<h2>Please Wait</h2>
	</div>
</div>
<div class="off_canvars_overlay">

</div>
<div class="offcanvas_menu">
	<div class="container-fluid">
		<div class="row">
			<div class="col-12">
				<div class="canvas_open">
					<a href="javascript:void(0)"><img src="https://solvoix.xyz/selvel/images/icons8-menu-50.png" style="width:26px"></a>
				</div>
				<div class="offcanvas_menu_wrapper">
					<div class="canvas_close">
						<a href="javascript:void(0)"><i class="fa fa-times"></i></a>
					</div>

					<div id="menu" class="text-left ">
						<ul class="offcanvas_main_menu">

							<li class="menu-item-has-children">
								<a href="https://solvoix.xyz/selvel/">Home</a>
							</li>
							
                    </div>

</div>