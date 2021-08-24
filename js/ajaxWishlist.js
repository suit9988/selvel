$(document).ready(function() {
    $('.clsWishlist').on('click', addToWishList);
});

function addToWishList() {
    var productVal = $(this).data('id');
    var productsize = $(this).data('size');
    var productcolor = $(this).data('color');

    var add = $('#addedWishlist');
    var currentButton = $(this);
    var element = $(this);
    $.ajax({
        url: BASE_URL + "/ajaxWishlistAdd.php",
        data: { product_id: productVal, size: productsize, color: productcolor },
        type: "GET",
        success: function(response) {
            var response = JSON.parse(response);
            if (response != "") {
                $('.wishlistCount').html(response.wishlistCount);
                currentButton.closest('.iwishlist').addClass('active');
                showNotification("Product added to wishlist");
                element.closest('.wishlistAdded').html('<button class="btn grey-btn wishlist" tabindex="0"><i class="fa fa-heart addedwish" aria-hidden="true"></i></button>');
                element.closest('.detailwish').html('<button class="btn grey-btn wishlist" tabindex="0"><i class="fa fa-heart addedwish" aria-hidden="true"></i> Wishlist</button>');
                element.closest('.homewish').html('<a class="wishlist" tabindex="0"><i class="fa fa-heart addedwish" aria-hidden="true"></i></a>');
                element.closest('.listingWish').html('<a class="wishlist" tabindex="0"><i class="fa fa-heart addedwish" aria-hidden="true"></i></a>');
            } else {
                showNotification("Product added to wishlist");
            }
        },
        error: function() {
            alert("Unable to get list, Please try again")
        }
    });
}