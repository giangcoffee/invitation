//전역변수 선언
var _SKIN_DIR = "/_data/mbcard/skin/";
var _SKIN_SAMPLE_IMG = "sample.png";
var _SKIN_DEMO_IMG = "demo.png";
var _PHOTO_OUT_DIR = "/bundles/viettutweb/templates/template1/img/";
var _PHOTO_TMP_DIR = "/_data/mbcard/photo/tmp/";
var _VIDEO_SAMPLE_DIR = "/_data/mbcard/video/sample/";
var _VIDEO_OUT_DIR = "/_data/mbcard/video/out/";
var _VIDEO_IMG_OUT_DIR = "/_data/mbcard/video/img/out/";
var _VIDEO_IMG_TMP_DIR = "/_data/mbcard/video/img/tmp/";
var _KAKAO_PHOTO_PREFIX = "k";
var _KAKAO_PHOTO_WIDTH = 183;
var _KAKAO_PHOTO_HEIGHT = 248;
var _MAIN_PHOTO_PREFIX = "m";
var _GAL_PHOTO_PREFIX = "g";
var _VIDEO_PREFIX = "v";
var _IMG_EXT = ".jpg";
var _VDO_EXT = ".mp4";
var _KAKAOSTORY_PHOTO_PREFIX = "_kakaostory";
var _KAKAOTALK_PHOTO_PREFIX = "_kakaotalk";
var _MAP_IMG_PREFIX = "map";
var _MAP_IMG_EXT = ".jpg";
var _map, _mapFS;



//네이버맵 API 관련
//naver Maps JavaScript API v3 적용
function geoCode(addr, label, id) {
	var map = "";
	if(!id) {
		id = "MAP_CANVAS";
    	if(!_map) _map = new naver.maps.Map(id, {
    		mapDataControl: false,
    	    logoControl:false
    	});
    	map = _map;
    }else if(id=="MAP_CANVAS_FS") {
    	if(!_mapFS) _mapFS = new naver.maps.Map(id, {
    		mapDataControl: false,
    	    logoControl:false
    	});
    	map = _mapFS;
    }
//    map = _map = new naver.maps.Map('map', {
//	    mapDataControl: false,
//	    logoControl:false
//    });
	
	$map = $("#"+id);
	
	//예외처리(2017.02.28)
	if(addr.trim()=="서울특별시 송파구 양재대로 932 가락몰 SAFF타워 (업무동) 2F") {
		var items = {};
		items.point = {};
 		items.point.y=37.495053;
    	items.point.x=127.1155166;
    	showMapPoint($map, map, items, label);
	}
	//예외처리(2017.04.07)
	else if(addr.trim()=="서울특별시 관악구 관악로 1 서울대학교 65동 교수회관") {
		var items = {};
		items.point = {};
 		items.point.y=37.457761;
    	items.point.x=126.953875;
    	showMapPoint($map, map, items, label);
	}
	//주소->경위도 찾기
	else {
	    $.getJSON("/mbcard/mb_exec.php?addrToLatlng", {addr:addr}, function(data) {
	    	if(data && data.result) {
	    		var items = data.result.items[0];
	        	showMapPoint($map, map, items, label);
	        } else if(data && data.error){
	        	$map.find("> *").hide();
	        	alert(data.error.msg+"\n정확한 주소로 다시 입력하세요\n(네이버맵에서 지원하지 않는 주소는 표시할 수 없습니다.)");
	        	//$map.text(data.error.msg);
	        } else if(!data){
	        	$map.find("> *").hide();
	        	alert("정확한 주소로 다시 입력하세요\n(네이버맵에서 지원하지 않는 주소는 표시할 수 없습니다.)");
	        	//$map.text(data.error.msg);
	        }
	    });
	}
}

function showMapPoint($map, map, items, label) {
	
	$map.find("> *").show();
	
	var point  = new naver.maps.LatLng(items.point.y, items.point.x);
	map.setCenter(point);
	
	var size  = new naver.maps.Size(20, 30);
	var offset = new naver.maps.Size(20, 30); 
	var marker = new naver.maps.Marker({
		map: map,
		position: point,
		title : label,
		zIndex: 100
	});

	var makerLabel = new naver.maps.InfoWindow({
        content: '<div style="width:auto;text-align:center;padding:3px 10px;">"'+ label +'"</div>'
    });
	makerLabel.open(map, marker);
	//makerLabel.setMap(map); // - 마커 라벨 지도에 추가. 기본은 라벨이 보이지 않는 상태로 추가됨. 
	//makerLabel.setVisible(true, marker); // 마커 라벨 보이기
}

