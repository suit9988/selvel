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
<!-- <script src="<?php echo BASE_URL; ?>/js/jquery.elevatezoom.js" type="text/javascript"></script> -->
<script src="<?php echo BASE_URL; ?>/js/fancy.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/api.js" type="text/javascript"></script>  
<script src="<?php echo BASE_URL; ?>/js/jquery.validate.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/wow.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/additional-methods.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/jquery.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo BASE_URL; ?>/js/index.js" type="text/javascript"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.min.js" type="text/javascript"></script>

<script type="text/javascript">
	$(".scrollbarhai").mCustomScrollbar({
		axis:"y"
	});
	<?php
	    if(isset($_GET['resetsuccess'])){
	    ?>
	    $(".before-login").fancybox().trigger('click');

	     <?php
	    }
	    if(isset($_GET['wrong-password'])){
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
					email:true,
				},
				yourname: {
					required: true,
				}
			},
			messages: {
				email: {
					required: 'Please enter your email address',
					email : 'Pleas enter valid email Address'
				},
			}
		});
	});

	function incrementSpinner(){
		$('.btn-number').off("click");
		$('.input-number').off("click");
		$('.input-number').off("change");
		$('.input-number').off("keydown");

		$('.btn-number').click(function(e){
			// alert('click');
			e.preventDefault();

			fieldName = $(this).attr('data-field');
			type = $(this).attr('data-type');
			var input = $("input[name='"+fieldName+"']");
			var currentVal = parseInt(input.val());
			//alert(currentVal);
			if (!isNaN(currentVal)) {
				if(type == 'minus') {
					if(currentVal > input.attr('min')) {
						input.val(currentVal - 1).change();
					} 
					/* if(parseInt(input.val()) == input.attr('min')) {
						$(this).attr('disabled', true);
					} */

				} else if(type == 'plus') {

					if(currentVal < input.attr('max')) {
						input.val(currentVal + 1).change();
					}

				}
			} else {
				input.val(0);
			}
		});
		$('.input-number').focusin(function(){
			$(this).data('oldValue', $(this).val());
		});
		$('.input-number').change(function() {
			minValue =  parseInt($(this).attr('min'));
			maxValue =  parseInt($(this).attr('max'));
			valueCurrent = parseInt($(this).val());
			
			name = $(this).attr('name');
			if(valueCurrent >= minValue) {
				$(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
				alert('Sorry, the minimum value was reached');
				$(this).val($(this).data('oldValue'));
			}
			if(valueCurrent <= maxValue) {
				$(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
			} else {
				alert('Sorry, the maximum value was reached');
				$(this).val($(this).data('oldValue'));
			}
		});
		$(".input-number").keydown(function (e) {
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
		source: function(query, getData){
			setTimeout(function(){ // for fast typing, delay
				var categoty = $('select[name="categories"]').val();
				search_texts = $('input#search_text').val();
				var aTest = $.ajax({
					url:"<?php echo BASE_URL ?>/search_product.php?cat="+categoty,
					type:"get",
					data:{q:query},
					success: function(response){
						console.log(response);
						// alert(response); // TEST
						var response = response.split("D#K");
						getData(response);
					},
					error: function(response){
						getData(["Unable to get results please try again"]);
					},
					complete: function(){
					}
				});
			}, 1000);
		},
		showHintOnFocus:false,
		// delay:100,
		autoSelect:false,
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