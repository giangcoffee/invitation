$(function(){

    $(".header_bg, .header_title").css("height",$(window).height());
    $(window).bind("orientationchange, resize", function(e) { $(".header_bg, .header_title").css("height",$(window).height()); });

    var headerTitle = $('.header_title').offset().top;
    var headerAnimate = function(){
        var scrollTop = $(window).scrollTop();
        if (scrollTop > headerTitle+100) $('.header_title').addClass('slideUp');
        else $('.header_title').removeClass('slideUp');
    };

    $(window).scroll(function() { return; headerAnimate(); });

    $(window).on("orientationchange",function(){
        callMapInitializeAfterResize();
    });

    function callMapInitializeAfterResize(){
        if($('#tabs_wedding').hasClass('on') !== false) initialize('wedding');
        else initialize('party');
    }


    // -- map -- //
    function initialize(md) {

    }

    $('#div_snsbbs').masonry({
        //columnWidth: .snsbbs_sections,
        //isFitWidth : true,
        itemSelector: '.snsbbs_sections'
    }).on( 'layoutComplete', function() {
        return true;
    });

    var closest = function closest(el, fn) {
        return el && (fn(el) ? el : closest(el.parentNode, fn));
    };

    var photoswipeParseHash = function() {
        var hash = window.location.hash.substring(1),
            params = {};

        if (hash.length < 5) {
            return params;
        }

        var vars = hash.split('&');
        for (var i = 0; i < vars.length; i++) {
            if (!vars[i]) {
                continue;
            }
            var pair = vars[i].split('=');
            if (pair.length < 2) {
                continue;
            }
            params[pair[0]] = pair[1];
        }

        if (params.gid) {
            params.gid = parseInt(params.gid, 10);
        }

        return params;
    };

    function getGallery($el) {
        var el = [];
        var aTag = Array.prototype.slice.call($el.find("a"));

        $.merge(el, aTag);

        return el;
    }

    function onThumbnailsClick(e) {
        e = e || window.event;
        e.preventDefault ? e.preventDefault() : e.returnValue = false;

        var eTarget = e.target || e.srcElement;
        var clickedListItem = closest(eTarget, function(el) {
            var tagName = el.tagName.toUpperCase();
            return (tagName && tagName === 'A');
        });

        if (!clickedListItem) {
            return;
        }

        if (clickedListItem.className.indexOf("swipebox") == -1) {
            return false;
        }

        var childNodes = el,
            numChildNodes = el.length,
            nodeIndex = 0,
            index = 0;

        var no_image_count = 0;
        for (var i = 0; i < numChildNodes; i++) {
            if (el[i].className.indexOf("swipebox") == -1) {
                no_image_count++;
            }

            if (el[i] == clickedListItem) {
                index = i - no_image_count;

                break;
            }
        }

        if (index >= 0) {
            openPhotoSwipe(index, el);
        }

        return false;
    }

    var gallery;

    function getPrefix(prop) {
        var style = document.body.style;
        var prefix = ['Webkit', 'ms', 'moz', 'o'];
        var prefix_len = prefix.length;

        if(style[prop] == '') {
            return prop;
        }

        prop = prop[0].toUpperCase() + prop.slice(1);

        for(var i = 0; i < prefix_len; i++) {
            if(style[prefix[i] + prop] == '') {
                return prefix[i] + prop;
            }
        }
    }

    function getTranslate(transform) {
        var regex;

        if(transform.indexOf('translate3d') == -1) {
            regex = /translate\(([-0-9.]+)px, ([-0-9.]+)px\)/;
        } else {
            regex = /translate3d\(([-0-9.]+)px, ([-0-9.]+)px, ([-0-9.]+)px\)/;
        }

        var matched = transform.match(regex);
        var coordinate = {};

        coordinate.x = matched[1];
        coordinate.y = matched[2];

        if(matched[3]) {
            coordinate.z = matched[3];
        }

        return coordinate;
    }

    function getScale(transform) {
        var regex = /scale\(([0-9.]+)\)/;
        var matched = transform.match(regex);

        return matched[1];
    }

    function psBeforeInitAddEvent() {
        gallery.listen('gettingData', function(index, item) {
            var size = item.el.getAttribute("data-size").split("X");

            item.w = size[0];
            item.h = size[1];
        });

        gallery.listen('arrowUpdate', function() {
            var $nextBtn = $('.pswp__button--arrow--right');
            var $prevBtn = $('.pswp__button--arrow--left');
            var loop = this.options.loop;
            var index = this.getCurrentIndex();

            $nextBtn.toggle(loop || index < this.items.length - 1);
            $prevBtn.toggle(loop || index > 0);
        });

        gallery.listen('initialZoomIn', function() {
            $(".snow").removeClass("snow").addClass("snow-off");

        });
    }

    function psAfterInitAddEvent() {
        gallery.listen('initialZoomOut', function() {
            var item = this.currItem;
            var container_style = item.container.style;
            var transform = getPrefix('transform');
            var transition = getPrefix('transition');

            if(!transform || !transition) {
                return;
            }

            var container_transform = container_style[getPrefix('transform')];
            var scale = getScale(container_transform);
            var coordinate = getTranslate(container_transform);
            var initTransY = item.initialPosition.y;
            var currTransY = coordinate.y;
            var size = item.el.getAttribute("data-size").split("X");
            var transX = item.initialPosition.x;
            var transY;

            if(initTransY > currTransY) {
                transY = -(size[1]);
            } else {
                transY = window.screen.availHeight;
            }

            container_style[transition] = "transform " + gallery.options.hideAnimationDuration + "ms";

            if(!this.isGestureClose() && this.isVerticalDrag()){
                container_style[getPrefix('transform')] = "translate3d(" + transX + "px, " + transY + "px, 0px) scale(" + scale + ")";
            }
        });

        gallery.listen('close', function() {
            setTimeout(function() {
                $(".snow-off").removeClass("snow-off").addClass("snow");
            }, this.options.hideAnimationDuration + 45);

        });
    }

    var openPhotoSwipe = function(index, galleryElement, disableAnimation, fromURL) {
        var pswpElement = document.querySelector('.pswp'),
            options, items, kakaoInApp;

        items = parseThumbnailElements(galleryElement);

        options = {
            useZoom: true,
            arrowKeys: false,
            hideAnimationDuration: 200,
            showAnimationDuration: 100,
            loop: false,
            imageEl: true,
            galleryUID: $my_gallery[0].getAttribute('data-pswp-uid'),
            showHideOpacity: true,
            getThumbBoundsFn: false,
            closeOnScroll: false,
            kakaoInApp: kakaoInApp,
        };

        if (fromURL) {
            if (options.galleryPIDs) {

                for (var j = 0; j < items.length; j++) {
                    if (items[j].pid == index) {
                        options.index = j;
                        break;
                    }
                }
            } else {
                options.index = parseInt(index, 10);
            }
        } else {
            options.index = parseInt(index, 10);
        }

        if (isNaN(options.index)) {
            return;
        }

        if (disableAnimation) {
            options.showAnimationDuration = 0;
        }

        gallery = new PhotoSwipe(pswpElement, PhotoSwipeUI_Default, items, options);

        gallery.useAniNum = false;

        psBeforeInitAddEvent();
        gallery.init();
        psAfterInitAddEvent();
    };

    var parseThumbnailElements = function(el) {
        var imageElements = el,
            numNodes = imageElements.length,
            items = [],
            size,
            item;
        var wrapper = document.createElement('div');
        var imageEl,
            thumbEl;

        for (var i = 0; i < numNodes; i++) {
            imageEl = imageElements[i];

            if (imageEl.nodeType !== 1) {
                continue;
            }

            var img_el = imageEl.getElementsByTagName("img");
            var exist_img = img_el.length > 0 ? true : false;
            var src = imageEl.href;
            var is_swipe_image = imageEl.className.indexOf("swipebox") > -1 ? true : false;
            var msrc;
            var $imageEl = $(imageEl);

            if(!is_swipe_image) {
                continue;
            }

            if(!exist_img) {
                thumbEl = imageEl.getElementsByTagName("div")[0];

                if(thumbEl) {
                    msrc = thumbEl.style.backgroundImage.slice(4, -1).replace(/"/g, "");
                } else {
                    var piece = src.split("/");
                    var pieceCount = piece.length;
                    var file = piece[pieceCount - 1]

                    piece[pieceCount - 1] = "S_" + file;

                    msrc = piece.join("/");
                }
            } else {
                if($imageEl.parent(".gal_more").length > 0 || $imageEl.children(".gal_more").length > 0) {
                    msrc = img_el[0].parentNode.href;
                } else {
                    thumbEl = img_el[0];
                    msrc = thumbEl.src;
                }
            }

            item = {
                src: src,
                msrc: msrc,
                el: imageEl,
            };

            item.id = imageEl.getAttribute("imgId");
            items.push(item);
        }

        return items;
    };

    var $my_gallery = $("#sk_gallery");
    var my_gallery_count = $my_gallery.length;
    var el = getGallery($my_gallery);
    var $el = $(el);
    var hashData = photoswipeParseHash();

    $el.on("click", onThumbnailsClick);

    for (var i = 0; i < my_gallery_count; i++) {
        $my_gallery[i].setAttribute("data-pswp-uid", i + 1);
    }

    if (hashData.pid && hashData.gid) {
        openPhotoSwipe(hashData.pid - 1, el, true, true);
    }

    $(document).on("keydown keyup", function(e) {
        var hidden = $(".pswp").attr("aria-hidden") == "true";

        if(hidden) {
            return;
        }

        var keydownAction = '';
        var index = gallery.getCurrentIndex();
        var gallery_len = gallery.items.length;

        if(e.type == "keydown") {
            if(e.keyCode === 37 && index != 0) {
                keydownAction = 'prev';
            } else if(e.keyCode === 39 && index != (gallery_len - 1)) {
                keydownAction = 'next';
            }
        } else if(e.type == "keyup") {
            if(e.keyCode === 37 && index == 0) {
                keydownAction = 'prev';
            } else if(e.keyCode === 39 && index == (gallery_len - 1)) {
                keydownAction = 'next';
            }
        }

        if(keydownAction) {
            if( !e.ctrlKey && !e.altKey && !e.shiftKey && !e.metaKey ) {
                if(e.preventDefault) {
                    e.preventDefault();
                } else {
                    e.returnValue = false;
                }

                gallery[keydownAction]();
            }
        }
    });

    $('#div_snsbbs').masonry('bindResize');

    function setPosition(id){
        var $obj = $('#sk_'+id);
        // console.log(id);

        $('body').scrollTo($obj, 500);
    }

    $('.menu_scrolls').click(function(){
        try{
            if($(this).attr('id')){
                var id = $(this).attr('id').replace('p_','').replace('m_','');
                setPosition(id);
            } else {
                window.location.href = '/';
            }
        }catch(e){
        }
    }).css('cursor','pointer');

    $('#tabs_wedding').click(function() {
        $('#tabs_wedding').addClass('on');
        $('#tabs_party').removeClass('on');
        $('#div_wedding').css('display', 'block');
        $('#div_party').css('display', 'none');
    }).css('cursor', 'pointer');

    $('#tabs_party').click(function() {
        $('#tabs_party').addClass('on');
        $('#tabs_wedding').removeClass('on');
        $('#div_wedding').css('display', 'none');
        $('#div_party').css('display', 'block');
    }).css('cursor', 'pointer');
});

$( window ).load(function() {
    $('.gal_list2').masonry({
        itemSelector: '.gal_frame',
        columnWidth: '.gal_size',
        transitionDuration: '0.2s',
        percentPosition: true
    });

    $('.movie_wrap').onScrollTo(function() {
        $('#signup').addClass('show');
    }, function() {
        $('#signup').removeClass('show');
    });

    $('#signup').on('click', '.close', function(e) {
        e.preventDefault();
        $('#signup').removeClass('show');
    });
});

function initMap() {
    var lat = $('#coordinates').data('lat');
    var lon = $('#coordinates').data('lon');
    var title = $('#coordinates').data('title');

    var homeLat = $('#coordinates').data('home-lat');
    var homeLon = $('#coordinates').data('home-lon');
    var homeTitle = $('#coordinates').data('home-title');

    var location = {lat: lat, lng: lon};
    var homeLocation = {lat: homeLat, lng: homeLon};

    var map = new google.maps.Map(document.getElementById('party_pmap_canvas'), {
        zoom: 16,
        center: location
    });
    var marker = new google.maps.Marker({
        position: location,
        map: map
    });

    var info = new google.maps.InfoWindow({
        content: '<h4>' + title + '</h4>'
    });
    info.open(map, marker);

    var homeMap = new google.maps.Map(document.getElementById('wedding_pmap_canvas'), {
        zoom: 16,
        center: homeLocation
    });
    var homeMarker = new google.maps.Marker({
        position: homeLocation,
        map: homeMap
    });

    var homeInfo = new google.maps.InfoWindow({
        content: '<h4>' + homeTitle + '</h4>'
    });
    homeInfo.open(homeMap, homeMarker);
}

function getPath() {
    var addr = $('#getPath input[name=saddr]').val();

    if (addr.length < 3) {
        $('#getPath input[name=saddr]').focus();
        alert('Nhập địa chỉ của bạn một cách chính xác!');
        return;
    }

    document.getElementById("getPath").submit();
}


function getHomePath() {
    var addr = $('#getHomePath input[name=saddr]').val();

    if (addr.length < 3) {
        $('#getHomePath input[name=saddr]').focus();
        alert('Nhập địa chỉ của bạn một cách chính xác!');
        return;
    }

    document.getElementById("getHomePath").submit();
}