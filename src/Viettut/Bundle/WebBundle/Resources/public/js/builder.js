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

function submit() {
    for (var column in columns) {
        columns[column] = $('#' + column).val()
    }

    $.post('/api/v1/cards/' + cardId + '/updates', columns, function (response) {
        var html = '<div class="alert alert-success alert-dismissable">' +
            '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
            'Thông tin cập nhật thành công !'
            + '</div>';
        $('div.form-horizontal').before(html);
    }, 'json');

    $.ajax({
        headers : {
            'Content-Type' : 'application/json'
        },
        url : '/api/v1/cards/' + cardId,
        type : 'PATCH',
        data : JSON.stringify({weddingDate: $('#wedding_date').val()}),
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
        url : '/api/v1/cards/' + cardId,
        type : 'PATCH',
        data : JSON.stringify({gallery: gallery}),
        success : function(response, textStatus, jqXhr) {
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
        url:"/api/v1/cards/uploads",
        fileName:"myfile",
        onSuccess:function(files,data,xhr,pd) {
            $('<li data-url="'+data+'" style="background-image: url('+data+')" class="aimg"><span><i class="fa fa-trash-o fa-3x" aria-hidden="true"></i></span></li>').hide().appendTo('ul').fadeIn(300);
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
