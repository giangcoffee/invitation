/**
 * Created by giangle on 12/10/2017.
 */
var gallery = $('.card-info').data('gallery');
var columns = $('.card-columns').data('columns');
var cardId = $('.card-info').data('id');

Array.prototype.remByVal = function(val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i] === val) {
            this.splice(i, 1);
            i--;
        }
    }

    return this;
};

var requireColumns = ['groom_name', 'bride_name', 'groom_phone', 'bride_phone', 'place', 'place_addr', 'greeting'];
function submit() {

    $('div.has-error').removeClass('has-error');
    for (var column in columns) {
        var value = $('#' + column).val();
        if (requireColumns.indexOf(column) >=0 && value.length < 1) {
            var html = '<div class="alert alert-danger alert-dismissable">' +
                '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                'Điền vào các ô còn thiếu'
                + '</div>';
            $('div.form-horizontal').before(html);
            $('#' + column).parent().parent().addClass('has-error');
            $('#' + column).focus();
            return;
        }

        columns[column] = $('#' + column).val();
    }



    $.post('/app_dev.php/api/v1/cards/' + cardId + '/updates', columns, function (response) {
        var html = '<div class="alert alert-success alert-dismissable">' +
            '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
            'Thông tin cập nhật thành công !'
            + '</div>';
        $('div.form-horizontal').before(html);
    }, 'json');

    var forGroom = false;
    if ($('#check_id').is(":checked"))
    {
        forGroom = true;
    }

    $.ajax({
        headers : {
            'Content-Type' : 'application/json'
        },
        url : '/app_dev.php/api/v1/cards/' + cardId,
        type : 'PATCH',
        data : JSON.stringify({weddingDate: $('#wedding_date').val(), forGroom: forGroom}),
        success : function(response, textStatus, jqXhr) {
        },
        error : function(jqXHR, textStatus, errorThrown) {
        },
        complete : function() {
        }
    });
}


function updateAlbum() {
    $.ajax({
        headers : {
            'Content-Type' : 'application/json'
        },
        url : '/app_dev.php/api/v1/cards/' + cardId,
        type : 'PATCH',
        data : JSON.stringify({gallery: gallery}),
        success : function(response, textStatus, jqXhr) {
            var html = '<div class="alert alert-success alert-dismissable">' +
                '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                'Thông tin cập nhật thành công !'
                + '</div>';
            $('div.form-horizontal').before(html);
        },
        error : function(jqXHR, textStatus, errorThrown) {
        },
        complete : function() {
        }
    });
}

function updateVideo() {
    var video = $('input#video_link').val();
    $.ajax({
        headers : {
            'Content-Type' : 'application/json'
        },
        url : '/app_dev.php/api/v1/cards/' + cardId,
        type : 'PATCH',
        data : JSON.stringify({video: video}),
        success : function(response, textStatus, jqXhr) {
            var html = '<div class="alert alert-success alert-dismissable">' +
                '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                'Thông tin cập nhật thành công !'
                + '</div>';
            $('div#videoForm').before(html);
        },
        error : function(jqXHR, textStatus, errorThrown) {
        },
        complete : function() {
        }
    });
}

$(document).ready(function(){
    jQuery('#wedding_date').datetimepicker(
        {
            format: 'Y-m-d H:i',
            lang:   'vi'
        }
    );

    $("#fileuploader").uploadFile({
        url:"/app_dev.php/api/v1/cards/uploads",
        fileName:"myfile",
        onSuccess:function(files,data,xhr,pd) {
            var src = data['src'];
            $('<li data-url="'+src+'" style="background-image: url('+src+')" class="aimg"><span><i class="fa fa-trash-o fa-3x" aria-hidden="true"></i></span></li>').hide().appendTo('ul.gallery').fadeIn(300);
            gallery.push(data);
        },
        uploadStr:"Thêm Ảnh"
    });
});

$('ul.gallery').on('click', 'li span:first-child', function() {
    $(this).parent().fadeOut(300, function() {
        var url = $(this).data('url');
        $(this).remove();
        gallery = gallery.remByVal(url);
    });
});
