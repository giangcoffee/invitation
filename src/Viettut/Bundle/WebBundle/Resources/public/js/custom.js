// Add here all your JS customizations
var owl = $(".product-slider");
owl.owlCarousel({
    loop:true,
    smartSpeed:450,
    responsiveClass: true,
    autoplayHoverPause: true, // Stops autoplay
    responsiveRefreshRate : 10,
    items:1,
});