/**
 * Created by giangle on 05/02/2018.
 */
const WEDDING_REQUIRE_FIELDS = ['groom_name', 'bride_name', 'wedding_date', 'party_date'];
const EXHIBITION_REQUIRE_FIELDS = ['event_title', 'event_date'];
const BIRTHDAY_REQUIRE_FIELDS = ['party_title', 'baby_name', 'birthday_date'];
const CARD_POST_RESOURCE = '/api/v1/cards';
const CARD_PATCH_RESOURCE = '/api/v1/cards/{0}';
const CARD_PATCH_UPDATE_RESOURCE = '/api/v1/cards/{0}/updates';
const DOWNLOAD_ALBUM_RESOURCE = '/{0}/photos?fields=images';
const ALBUM_LIST_RESOURCE = '/me/albums';
const VIDEO_LIST_RESOURCE = '/me/videos?fields=created_time,embed_html,description&type=uploaded';
const CARD_EDIT_LINK = '/thiep/{0}/sua';
const CREATE_CARD_BUTTON = 'Tạo Thiệp';
const COPY_CARD_BUTTON = 'Copy';
const UPDATE_CARD_BUTTON = 'Cập Nhật';
const UPDATE_ALBUM_BUTTON = 'Cập Nhật Album';


var gallery = $('.card-info').data('gallery');
var videos = {};
var columns = $('.card-columns').data('columns');
var cardId = $('.card-info').data('id');
var requireColumns = ['groom_name', 'bride_name', 'groom_phone', 'bride_phone', 'place', 'place_addr', 'greeting'];
var textColumns = ['greeting', 'content', 'schedule_content'];

if (!String.prototype.format) {
    String.prototype.format = function() {
        var args = arguments;
        return this.replace(/{(\d+)}/g, function(match, number) {
            return typeof args[number] != 'undefined'
                ? args[number]
                : match
                ;
        });
    };
}

if (!Array.prototype.remByVal()) {
    Array.prototype.remByVal = function(val) {
        for (var i = 0; i < this.length; i++) {
            if (this[i]['src'] === val) {
                this.splice(i, 1);
                i--;
            }
        }

        return this;
    };
}

function createWeddingCard() {
    for (var column in WEDDING_REQUIRE_FIELDS) {
        var value = $('#' + WEDDING_REQUIRE_FIELDS[column]).val();
        if (value.length < 1) {
            dangerNotify('Điền vào các ô còn thiếu');
            $('#' + WEDDING_REQUIRE_FIELDS[column]).parent().parent().addClass('has-error');
            $('#' + WEDDING_REQUIRE_FIELDS[column]).focus();
            return;
        } else {
            $('#' + WEDDING_REQUIRE_FIELDS[column]).parent().parent().removeClass('has-error');
        }
    }

    var data = {};
    data['template'] = id;
    data['weddingDate'] = $('#wedding_date').val();
    data['partyDate'] = $('#party_date').val();
    data['forGroom'] = false;
    data['libraryCard'] = {'gallery': [], 'video': ''};

    if ($('#for_groom').is(":checked")) {
        data['forGroom'] = true;
    }

    data['data'] = {};
    data['data']['groom_name'] = $('#groom_name').val();
    data['data']['bride_name'] = $('#bride_name').val();
    $('button#create-button').html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(CREATE_CARD_BUTTON));
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_POST_RESOURCE,
        type : 'POST',
        data : JSON.stringify(data),
        success : function(response, textStatus, jqXhr) {
            infoNotify(' Tạo thiệp thành công !');
            infoNotify(' Bạn sẽ được chuyển đến trang chỉnh sửa trong giây lát !');
            $('button#create-button').html(CREATE_CARD_BUTTON);
            window.location.href = CARD_EDIT_LINK.format(response.hash);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            dangerNotify('Có lỗi xảy ra, vui lòng thử lại sau !');
        },
        complete : function() {
        }
    });
}

function copyWeddingCard(id,libCard, template, date, groom, bride, forGroom) {
    var data = {};
    data['template'] = template;
    data['weddingDate'] = date;
    data['partyDate'] = date;
    data['forGroom'] = forGroom;
    data['libraryCard'] = libCard;

    data['data'] = {};
    data['data']['groom_name'] = groom;
    data['data']['bride_name'] = bride;
    $('button#copy_button_' + id).html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(COPY_CARD_BUTTON));
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_POST_RESOURCE,
        type : 'POST',
        data : JSON.stringify(data),
        success : function(response, textStatus, jqXhr) {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
            window.location.href = CARD_EDIT_LINK.format(response.hash);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
        },
        complete : function() {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
        }
    });
}

function createExhibitionCard() {
    for (var column in EXHIBITION_REQUIRE_FIELDS) {
        var value = $('#' + EXHIBITION_REQUIRE_FIELDS[column]).val();
        if (value.length < 1) {
            dangerNotify('Điền vào các ô còn thiếu');
            $('#' + EXHIBITION_REQUIRE_FIELDS[column]).parent().parent().addClass('has-error');
            $('#' + EXHIBITION_REQUIRE_FIELDS[column]).focus();
            return;
        } else {
            $('#' + EXHIBITION_REQUIRE_FIELDS[column]).parent().parent().removeClass('has-error');
        }
    }

    var data = {};
    data['template'] = id;
    data['weddingDate'] = $('#event_date').val();
    data['libraryCard'] = {'gallery': [], 'video': ''};

    data['data'] = {};
    data['data']['event'] = $('#event_title').val();
    $('button#create-button').html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(CREATE_CARD_BUTTON));
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_POST_RESOURCE,
        type : 'POST',
        data : JSON.stringify(data),
        success : function(response, textStatus, jqXhr) {
            infoNotify(' Tạo thiệp thành công !');
            infoNotify(' Bạn sẽ được chuyển đến trang chỉnh sửa trong giây lát !');
            $('button#create-button').html(CREATE_CARD_BUTTON);
            window.location.href = CARD_EDIT_LINK.format(response.hash);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            dangerNotify('Có lỗi xảy ra, vui lòng thử lại sau !');
        },
        complete : function() {
        }
    });
}

function copyExhibitionCard(id, libCard, template, date, title) {
    var data = {};
    data['template'] = template;
    data['weddingDate'] = date;
    data['libraryCard'] = libCard;

    data['data'] = {};
    data['data']['event'] = title;
    $('button#copy_button_' + id).html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(COPY_CARD_BUTTON));
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_POST_RESOURCE,
        type : 'POST',
        data : JSON.stringify(data),
        success : function(response, textStatus, jqXhr) {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
            window.location.href = CARD_EDIT_LINK.format(response.hash);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
        },
        complete : function() {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
        }
    });
}

function createBirthdayCard() {
    for (var column in BIRTHDAY_REQUIRE_FIELDS) {
        var value = $('#' + BIRTHDAY_REQUIRE_FIELDS[column]).val();
        if (value.length < 1) {
            dangerNotify('Điền vào các ô còn thiếu');
            $('#' + BIRTHDAY_REQUIRE_FIELDS[column]).parent().parent().addClass('has-error');
            $('#' + BIRTHDAY_REQUIRE_FIELDS[column]).focus();
            return;
        } else {
            $('#' + BIRTHDAY_REQUIRE_FIELDS[column]).parent().parent().removeClass('has-error');
        }
    }

    var data = {};
    data['template'] = id;
    data['weddingDate'] = $('#birthday_date').val();
    data['libraryCard'] = {'gallery': [], 'video': ''};

    data['data'] = {};
    data['data']['title'] = $('#party_title').val();
    data['data']['name'] = $('#baby_name').val();
    $('button#create-button').html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(CREATE_CARD_BUTTON));
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_POST_RESOURCE,
        type : 'POST',
        data : JSON.stringify(data),
        success : function(response, textStatus, jqXhr) {
            infoNotify(' Tạo thiệp thành công !');
            infoNotify(' Bạn sẽ được chuyển đến trang chỉnh sửa trong giây lát !');
            $('button#create-button').html(CREATE_CARD_BUTTON);
            window.location.href = CARD_EDIT_LINK.format(response.hash);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            dangerNotify('Có lỗi xảy ra, vui lòng thử lại sau !');
        },
        complete : function() {
        }
    });
}

function copyBirthdayCard(libCard, template, date, title, name) {
    var data = {};
    data['template'] = template;
    data['weddingDate'] = date;
    data['libraryCard'] = libCard;

    data['data'] = {};
    data['data']['title'] = title;
    data['data']['name'] = name;
    $('button#copy_button_' + id).html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(COPY_CARD_BUTTON));
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_POST_RESOURCE,
        type : 'POST',
        data : JSON.stringify(data),
        success : function(response, textStatus, jqXhr) {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
            window.location.href = CARD_EDIT_LINK.format(response.hash);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
        },
        complete : function() {
            $('button#copy_button_' + id).html(COPY_CARD_BUTTON);
        }
    });
}

function infoNotify(message) {
    $.notify({
        message: message,
        icon: 'glyphicon glyphicon-ok'
    },{
        type: 'info',
        allow_dismiss: true,
        newest_on_top: false,
        placement: {
            from: "top",
            align: "right"
        }
    });
}

function dangerNotify(message) {
    $.notify({
        message: message,
        icon: 'glyphicon glyphicon-remove'
    },{
        type: 'danger',
        allow_dismiss: true,
        newest_on_top: false,
        placement: {
            from: "top",
            align: "right"
        }
    });
}


function updateCard() {
    $('div.has-error').removeClass('has-error');
    for (var column in columns) {
        var value = $('#' + column).val();
        if (requireColumns.indexOf(column) >=0 && value.length < 1) {
            dangerNotify('Điền vào các ô còn thiếu');
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

    $('button#updateButton').html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(UPDATE_CARD_BUTTON));

    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_PATCH_UPDATE_RESOURCE.format(cardId),
        type : 'POST',
        data : JSON.stringify(columns),
        success : function(response, textStatus, jqXhr) {
            infoNotify('Thông tin cập nhật thành công !');
        },
        error : function(jqXHR, textStatus, errorThrown) {
            dangerNotify('Có lỗi xảy ra, vui lòng thử lại sau !');
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
        url : CARD_PATCH_RESOURCE.format(cardId),
        type : 'PATCH',
        data : JSON.stringify({partyDate: $('#party_date').val(), weddingDate: $('#wedding_date').val(), forGroom: forGroom}),
        success : function(response, textStatus, jqXhr) {
            $('button#updateButton').html('Cập Nhật');
        },
        error : function(jqXHR, textStatus, errorThrown) {
            $('button#updateButton').html('Cập Nhật');
            dangerNotify('Có lỗi xảy ra, vui lòng thử lại sau !');
        },
        complete : function() {
        }
    });
}

function updateAlbum() {
    $('button#updateAlbumButton').html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(UPDATE_ALBUM_BUTTON));
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_PATCH_RESOURCE.format(cardId),
        type : 'PATCH',
        data : JSON.stringify({libraryCard: {gallery: gallery}}),
        success : function(response, textStatus, jqXhr) {
            infoNotify('Thông tin cập nhật thành công !');
            $('button#updateAlbumButton').html(UPDATE_ALBUM_BUTTON);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            dangerNotify('Có lỗi xảy ra, vui lòng thử lại sau !');
        },
        complete : function() {
        }
    });
}

function updateVideo() {
    $('button#updateVideoButton').html('<i class="fa fa-spinner fa-spin"></i> {0}'.format(UPDATE_CARD_BUTTON));
    var video = $('input#video_link').val();
    var embedded = $('textarea#embedded').val();
    $.ajax({
        headers : {
            'Content-Type' : 'application/json; charset=utf-8'
        },
        url : CARD_PATCH_RESOURCE.format(cardId),

        type : 'PATCH',
        data : JSON.stringify({libraryCard: {video: video, embedded: embedded}}),
        success : function(response, textStatus, jqXhr) {
            infoNotify('Thông tin cập nhật thành công !');
            $('button#updateVideoButton').html(UPDATE_CARD_BUTTON);
        },
        error : function(jqXHR, textStatus, errorThrown) {
            dangerNotify('Có lỗi xảy ra, vui lòng thử lại sau !');
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
    infoNotify('Tải danh sách Video ...');
    FB.api(VIDEO_LIST_RESOURCE, function(response) {
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
        $('#videos').click();
        infoNotify('Danh sách Video tải xong !');
    });
}

function getAlbums() {
    infoNotify('Tải danh sách Album ...');
    FB.api(ALBUM_LIST_RESOURCE, function(response) {
        var data = response.data;
        data.forEach(function(album){
            var option = '<option value="' + album['id'] + '">' + album['name'] + '</option>';
            $('select#albums').append(option);
        });
        $('div#selectAlbums').css('display', 'block');
        $('#albums').click();
        infoNotify('Danh sách Album tải xong !');
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
    infoNotify('Tải Album !');
    FB.api(DOWNLOAD_ALBUM_RESOURCE.format(selected), function(response) {
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
        infoNotify('Album tải xong !');
    });
}