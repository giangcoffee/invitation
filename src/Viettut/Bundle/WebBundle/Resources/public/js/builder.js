/**
 * Created by giangle on 12/10/2017.
 */
var gallery = $('.card-info').data('gallery');
var videos = {};
var columns = $('.card-columns').data('columns');
var cardId = $('.card-info').data('id');

Array.prototype.remByVal = function(val) {
    for (var i = 0; i < this.length; i++) {
        if (this[i]['src'] === val) {
            this.splice(i, 1);
            i--;
        }
    }

    return this;
};

var requireColumns = ['groom_name', 'bride_name', 'groom_phone', 'bride_phone', 'place', 'place_addr', 'greeting'];
var textColumns = ['greeting', 'content', 'schedule_content'];
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

        if (textColumns.indexOf(column) >= 0) {
            columns[column] = CKEDITOR.instances[column].getData();
        } else {
            columns[column] = $('#' + column).val();
        }
    }

    $('button#updateButton').html('<i class="fa fa-spinner fa-spin"></i> Cập Nhật');

    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : '/api/v1/cards/' + cardId + '/updates',
        type : 'POST',
        data : JSON.stringify(columns),
        success : function(response, textStatus, jqXhr) {
            $.notify({
                message: 'Thông tin cập nhật thành công !',
                icon: 'glyphicon glyphicon-star'
            },{
                type: 'info',
                allow_dismiss: true,
                newest_on_top: false,
                placement: {
                    from: "top",
                    align: "right"
                }
            });
        },
        error : function(jqXHR, textStatus, errorThrown) {
        },
        complete : function() {
        }
    });

    var forGroom = false;
    if ($('#for_groom').is(":checked"))
    {
        forGroom = true;
    }

    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : '/api/v1/cards/' + cardId,
        type : 'PATCH',
        data : JSON.stringify({partyDate: $('#party_date').val(), weddingDate: $('#wedding_date').val(), forGroom: forGroom}),
        success : function(response, textStatus, jqXhr) {
            $('button#updateButton').html('Cập Nhật');
        },
        error : function(jqXHR, textStatus, errorThrown) {
            $('button#updateButton').html('Cập Nhật');
        },
        complete : function() {
        }
    });
}


function updateAlbum() {
    $('button#updateAlbumButton').html('<i class="fa fa-spinner fa-spin"></i> Cập Nhật Album');
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : '/api/v1/cards/' + cardId,
        type : 'PATCH',
        data : JSON.stringify({libraryCard: {gallery: gallery}}),
        success : function(response, textStatus, jqXhr) {
            var html = '<div class="alert alert-success alert-dismissable">' +
                '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                'Thông tin cập nhật thành công !'
                + '</div>';
            $('div#edit_album').before(html);
            $('button#updateAlbumButton').html('Cập Nhật Album');
            $('body').scrollTop(0);
        },
        error : function(jqXHR, textStatus, errorThrown) {
        },
        complete : function() {
        }
    });
}

function updateVideo() {
    $('button#updateVideoButton').html('<i class="fa fa-spinner fa-spin"></i> Cập Nhật');
    var video = $('input#video_link').val();
    var embedded = $('textarea#embedded').val();
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : '/api/v1/cards/' + cardId,
        type : 'PATCH',
        data : JSON.stringify({libraryCard: {video: video, embedded: embedded}}),
        success : function(response, textStatus, jqXhr) {
            var html = '<div class="alert alert-success alert-dismissable">' +
                '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                'Thông tin cập nhật thành công !'
                + '</div>';
            $('div#edit_video').before(html);
            $('button#updateVideoButton').html('Cập Nhật');
        },
        error : function(jqXHR, textStatus, errorThrown) {
        },
        complete : function() {
        }
    });
}

function facebookAlbum(){
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            getAlbums();
        }
        else {
            FB.login(function(){
                getAlbums();
            }, {scope: 'user_photos,user_videos'});
        }
    });
}

function facebookVideos() {
    FB.getLoginStatus(function(response) {
        if (response.status === 'connected') {
            getVideos();
        }
        else {
            FB.login(function(){
                getVideos();
            }, {scope: 'user_photos,user_videos'});
        }
    });
}

function getVideos() {
    FB.api('/me/videos?fields=created_time,embed_html,description&type=uploaded', function(response) {
        var data = response.data;
        data.forEach(function(video){
            var id = video['id'];
            var name = 'video';
            if( video["description"] !== undefined ) {
                name = video['description'];
            }
            var option = '<option value="' + video['id'] + '">' + name + '</option>';
            $('select#videos').append(option);
            videos[id] = video['embed_html'];
        });
        $('div#selectVideos').css('display', 'block');
    });
}

function getAlbums() {
    FB.api('/me/albums', function(response) {
        var data = response.data;
        data.forEach(function(album){
            var option = '<option value="' + album['id'] + '">' + album['name'] + '</option>';
            $('select#albums').append(option);
        });
        $('div#selectAlbums').css('display', 'block');
    });
}

function downloadVideo() {
    var selected = $('select#videos :selected').val();
    if (selected == '0') {
        alert('Chọn một video khác !');
        return;
    }

    if( videos[selected] !== undefined ) {
        $('textarea#embedded').html(videos[selected]);
    }
}

function downloadAlbum() {
    var selected = $('select#albums :selected').val();
    if (selected == '0') {
        alert('Chọn một album khác !');
        return;
    }

    $('ul.gallery').html('');
    gallery = [];
    $('button#downloadAlbum').html('<i class="fa fa-spinner fa-spin"></i> Download');
    FB.api('/' + selected + '/photos?fields=images', function(response) {
        var data = response.data;
        data.forEach(function(chunk){
            var images = chunk['images'];
            var image = images[0];
            var src = image['source'];
            var li = '<li data-url="' + src + '" style="background-image: url('+ src + ');" class="aimg"><span><i class="fa fa-trash-o fa-2x" aria-hidden="true"></i></span></li>';
            $('ul.gallery').append(li);
            gallery.push({"src": src, "size": image['width'] + 'X' + image['height']})
        });
        $('button#downloadAlbum').html('Download');
    });
}

$(document).ready(function(){
    jQuery('#wedding_date').datetimepicker({format: 'Y-m-d H:i',lang:   'vi'});
    var cardId = $('.card-info').data('id');
    $("#fileuploader").uploadFile({
        url:"/api/v1/cards/"+cardId+"/uploads",
        fileName:"myfile",
        maxFileSize: 5242880,
        allowedTypes: 'jpg,png,gif',
        acceptFiles: 'image/',
        dragDrop: true,
        multiple: true,
        maxFileCount: 10,
        showProgress: true,
        onSuccess:function(files,data,xhr,pd) {
            data.forEach(function(element) {
                var src = element['src'];
                $('<li data-url="'+src+'" style="background-image: url('+src+');background-size: contain;" class="aimg"><span><i class="fa fa-trash-o fa-3x" aria-hidden="true"></i></span></li>').hide().prependTo('ul.gallery').fadeIn(300);
                gallery.unshift(element);
            });
        },
        onError: function(files,status,errMsg,pd) {
            var html = '<div class="alert alert-danger alert-dismissable">' +
                '    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>' +
                errMsg
                + '</div>';
            $('div#fileuploader').before(html);
        },
        uploadStr:"Thêm Ảnh"
    });

    var clipboard = new Clipboard('#copy_link');

    clipboard.on('success', function(e) {
        $.notify({
            message: 'Đã copy link thiệp',
            icon: 'glyphicon glyphicon-star'
        },{
            type: 'info',
            allow_dismiss: true,
            newest_on_top: false,
            placement: {
                from: "top",
                align: "right"
            }
        });
    });

    clipboard.on('error', function(e) {
        $.notify({
            message: 'Không thể copy link thiệp',
            icon: 'glyphicon glyphicon-star'
        },{
            type: 'danger',
            allow_dismiss: true,
            newest_on_top: false,
            placement: {
                from: "top",
                align: "right"
            }
        });
    });
});

$('ul.gallery').on('click', 'li span:first-child', function() {
    $(this).parent().fadeOut(300, function() {
        var url = $(this).data('url');
        $(this).remove();
        gallery = gallery.remByVal(url);
    });
});
