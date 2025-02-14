$(document).ready(function() {
    $('.fa-shopping-cart').hover(function() {
        $('.cart-dropdown').stop(true, true).slideDown();
    }, function() {
        $('.cart-dropdown').stop(true, true).slideUp();
    });
});