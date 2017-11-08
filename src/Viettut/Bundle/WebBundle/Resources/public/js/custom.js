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

function subscribe() {
    var email = $('form#subscribeForm input[type=email]').val();
    var pattern = new RegExp(/^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/g);

    $('#subscribeMessage').remove();
    if (!pattern.test(email)) {
        $('form#subscribeForm input[type=email]').addClass('has-error');
        $('form#subscribeForm input[type=email]').focus();
        error('form#subscribeForm', 'Email không hợp lệ!');
        return;
    }
    var data = {'email': email};
    $('form#subscribeForm button').html("<i class='fa fa-spinner fa-spin'></i>");
    $.post('/app_dev.php/subscribe', data, function (response) {
        info('form#subscribeForm', 'Thông tin cập nhật thành công !');
        $('form#subscribeForm input[type=email]').val('');
        $('form#subscribeForm button').html("Go!");
    }, 'json');
}

function error(anchor, message) {
    var html = '<div class="alert alert-danger alert-dismissable" id="subscribeMessage">' +
        '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
        message +
        '</div>';
    $(anchor).before(html);
}

function info(anchor, message) {
    var html = '<div class="alert alert-success alert-dismissable" id="subscribeMessage">' +
        '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
        message +
        '</div>';
    $(anchor).before(html);
}