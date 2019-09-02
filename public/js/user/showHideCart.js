$(document).ready(function() {
    $(".btn-info").on('click', function () {
        $(this).siblings().toggleClass( "dropdown-cart-menu-noactive" );
        $(this).siblings().toggleClass( "dropdown-cart-menu-active" );
    });
});
