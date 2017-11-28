var $body = $("body");
$(document).ready(function(){
    $('.contents_list').masonry({
        // options
        itemSelector: 'li',
        columnWidth: 200
    });

    $(".popup_close").on("click", function(){
        $('#popup_login').removeClass('on');

        if(!$("#popup_write, .mypage_wrap").hasClass("on")) {
            var top = -($body.offset().top);
            $body.removeClass("noscroll").css("top", "");
            $("html, body").scrollTop(top);
        }
    });

    $(".header_area").css("height",$(".header_area").width() * 0.9);
    $(".header_wrap .recentlist_box").css("top",$(".header_area").outerHeight() + 50);
    $(window).bind("orientationchange, resize", function(e) {
        $(".header_area").css("height",$(".header_area").width() * 0.9);
        $(".header_wrap .recentlist_box").css("top",$(".header_area").outerHeight() + 50);
    });

    var HeaderHeight = $('.header_wrap').outerHeight(true);

    $(window).scroll(function() {
        var scrollTop = $(window).scrollTop();

        if ( scrollTop > HeaderHeight ) {
            $('.gnb_wrap,.btn_write').addClass('fixed');
        } else {
            $('.gnb_wrap,.btn_write').removeClass('fixed');
        }
    });

    $("html, body").scroll(function() {
        var scrollTop = $(this).scrollTop();

        if ( scrollTop > HeaderHeight ) {
            $('.gnb_wrap,.btn_write').addClass('fixed');
        } else {
            $('.gnb_wrap,.btn_write').removeClass('fixed');
        }
    });
});


function addComment(content) {
    var name = $('div#userInfo').data('name');
    var avatar = $('div#userInfo').data('avatar');
    $('div#commentTemplate img').attr('src', avatar);
    $('div#commentTemplate div#name').html(name);
    $('div#commentTemplate p#content').html(content);
    $('div#commentTemplate span#date').html(getCurrentDateTime());
    $('div.content_size').after($('div#commentTemplate').html());
    $('.contents_list').masonry({
        // options
        itemSelector: 'li',
        columnWidth: 200
    });
}

function getCurrentDateTime() {
    var today = new Date();
    var day = today.getDate();
    var month = today.getMonth()+1;
    var year = today.getFullYear();

    if (day < 10) {
        day = '0' + day;
    }

    if (month < 10 ) {
        month= '0' + month;
    }

    return day + '-' + month + '-' + year;
}

function showLoginPopup() {
    var $body = $("body");
    var top = $body.scrollTop() ? -($body.scrollTop()) : -($("html, body").scrollTop());

    $("#popup_login").addClass("on");
    $body.addClass("noscroll").offset({"top": top});
}

function showEmoticon() {
    $('#popup_icon').addClass('on');
}

function postGreeting() {
    var content = $('textarea#contents').val();
    if (content.length < 3) {
        alert('Nội dung quá ngắn!');
        return;
    }
    var data = {'card': $('#cardId').data('id'), 'content': content};
    $.post('/api/v1/comments', data, function (response) {
//            addComment(content);
        $('#popup_login').removeClass('on');
        location.reload();
    }, 'json');
}