function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

function updateStatus(status) {
    switch (status) {
        case 1:
            $('button#btn_going').html('<i class="fa fa-spinner fa-spin"></i> Sẽ đến');
            break;
        case 2:
            $('button#btn_notsure').html('<i class="fa fa-spinner fa-spin"></i> Cân nhắc');
            break;
        case 3:
            $('button#btn_notgoing').html('<i class="fa fa-spinner fa-spin"></i> Không đến');
            break;
    }
    var cardId = $('div#card_id').data('id');
    var uniqueUser = getCookie('user_unique_id');
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        xhrFields: { withCredentials:true },
        url : '/api/v1/statuses',
        type : 'POST',
        data : JSON.stringify({card: cardId, status: status, uniqueUser: uniqueUser}),
        success : function(response, textStatus, jqXhr) {
            $('div.signup').remove();
        },
        error : function(jqXHR, textStatus, errorThrown) {
        },
        complete : function() {
        }
    });
}

function guestBookAlert() {
    alert('Không thể chúc mừng trên thiệp mẫu !');
}

function gotoGuestBook(hash) {
    window.location.href = '/cards/' + hash + '/guest-book';
}