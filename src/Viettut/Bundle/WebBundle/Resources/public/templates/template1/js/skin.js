//동적 js 파일 추가
var s1 = document.createElement("script"); s1.type = "text/javascript"; s1.src = "/bundles/viettutweb/templates/template1/js/piaaano-utils.js";
var s2 = document.createElement("script"); s2.type = "text/javascript"; s2.src = "/bundles/viettutweb/templates/template1/js/jquery-1.12.4.min.js";
var s3 = document.createElement("script"); s3.type = "text/javascript"; s3.src = "/bundles/viettutweb/templates/template1/js/jssor.slider.min.js";
var s4 = document.createElement("script"); s4.type = "text/javascript"; s4.src = "/bundles/viettutweb/templates/template1/js/common.js";
var s5 = document.createElement("script"); s5.type = "text/javascript"; s5.src = "/bundles/viettutweb/templates/template1/js/kakao.min.js";
var s6 = document.createElement("script"); s6.type = "text/javascript"; s6.src = "/bundles/viettutweb/templates/template1/js/kakaostoryLink.js";
var s7 = document.createElement("script"); s7.type = "text/javascript"; s7.src = "/bundles/viettutweb/templates/template1/js/jquery-ui.min.js";
var s8 = document.createElement("script"); s8.type = "text/javascript"; s8.src = "/bundles/viettutweb/templates/template1/js/jquery.bxslider.min.js";


var body = document.getElementsByTagName("body")[0];
body.appendChild(s1);
body.appendChild(s2);
body.appendChild(s3);
body.appendChild(s4);
body.appendChild(s5);
body.appendChild(s6);

//전역변수 선언
var _mIdx;
var _postProcBySkin;
var _scrollTop;
var _scrollTop2;
var $slider;

window.onload = function() {
	
	//동적으로 jquery.js 가 다 로딩된 후 호출해야함
	body.appendChild(s7);
	body.appendChild(s8);	 	
	
	var mIdx = parseInt( getParameterByName("mIdx") );

	var info = {"m_idx":"40635","sk_idx":"9","gal_disp_ord":"1-2-4","vdo_idx":"0","groom_nm":"\uae40\uc77c","groom_nm_eng":"KIM IL","groom_hp":"010-2049-7893","groom_fa_nm":"\uc9c0\uc0b0 \uae40\uad11\ub144","groom_fa_hp":"010-9021-7793","groom_mo_nm":"","groom_mo_hp":"010--","groom_relation":"\ucc28\ub0a8","bride_nm":"\uc591\uc740\uc815","bride_nm_eng":"YANG EUNJEONG","bride_hp":"010-9659-5153","bride_fa_nm":"\uc591\ud6c8\uc11d","bride_fa_hp":"010-4135-3026","bride_mo_nm":"\uc624\uc740\ud658","bride_mo_hp":"010-3609-3026","bride_relation":"\uc7a5\ub140","wedding_dt":"2017-11-04 14:30:00","place_nm":"\uc2e0\ub3c4\ub9bc \ud14c\ud06c\ub178\ub9c8\ud2b8 \uc6e8\ub529\uc2dc\ud2f0","place_zip":"","place_addr":"\uc11c\uc6b8\uc2dc \uad6c\ub85c5\ub3d9 3-25\ubc88\uc9c0","place_tel":"02-2111-8888","floor_hall":"8\uce35 \uc544\ubaa8\ub974\ud640","state":"R","req_dt":"2017-09-14 15:05:45","sms_send":"1","greeting":"\uc608\uc05c \uc608\uac10\uc774 \ub4e4\uc5c8\ub2e4\n\uc6b0\ub9ac\ub294 \uc5b8\uc81c\ub098 \uc190\uc744 \uc7a1\uace0 \uc788\uac8c \ub420 \uac83\uc774\ub2e4.\n- \uc774\uc774\uccb4 '\uc5f0\uc778'-\n\n\uc544\uc8fc \uc791\uc740 \uc778\uc5f0\uc774 \uc800\ud76c\ub97c \uc5f0\uc778\uc73c\ub85c \ub9cc\ub4e4\uc5c8\uace0\n\uc624\ub298, \uadf8 \uc778\uc5f0\uc73c\ub85c \uc800\ud76c\uac00 \ud558\ub098 \ub429\ub2c8\ub2e4.\n\uadc0\ud55c \uac78\uc74c\uc73c\ub85c \ucd95\ubcf5\ud574 \uc8fc\uc2dc\uba74\n\ub354\uc5c6\ub294 \uae30\uc068\uc73c\ub85c \uac04\uc9c1\ud558\uaca0\uc2b5\ub2c8\ub2e4.","parent_view_yn":"0","subway_info":"*1\ud638\uc120,2\ud638\uc120 \uc2e0\ub3c4\ub9bc\uc5ed \ud558\ucc28 3\ubc88 \ucd9c\uad6c\n-\ud14c\ud06c\ub178\ub9c8\ud2b8 \ud310\ub9e4\ub3d9 \uc9c0\ud5581\uce35\uacfc \uc9c1\uc811\uc5f0\uacb0\ub418\uc5b4\uc788\uc2b5\ub2c8\ub2e4.","bus_info":"*\uc2e0\ub3c4\ub9bc\uc5ed 3\ubc88 \ucd9c\uad6c \ud558\ucc28\n\uc9c0\uc120\ubc84\uc2a4(\ub179\uc0c9):5619, 6411, 6511, 6611, 6650, 6651,\uc601\ub4f1\ud3ec09\n*\uc2e0\ub3c4\ub9bc\uc5ed 1\ubc88 \ucd9c\uad6c \ud558\ucc28\n\uac04\uc120\ubc84\uc2a4(\ud30c\ub791):160, 503, 600, 662, 670\n\uc9c0\uc120\ubc84\uc2a4(\ub179\uc0c9):5615, 5714, 6512, 6513, 6515, 6637, 6640\n\uc88c\uc11d\ubc84\uc2a4:201, 320, 510\n\uacbd\uae30\ubc84\uc2a4:10, 11-1, 11-2, 83, 88","parking_info":"*\ud14c\ud06c\ub178\ub9c8\ud2b8 \uc9c0\ud558\uc8fc\ucc28\uc7a5 \uc774\uc6a9 (B3~B7)\n*\uc8fc\ucc28\uc694\uc6d0\uc758 \uc548\ub0b4\ub97c \ubc1b\uc73c\uc138\uc694","chartered_bus_info":"","banquet_info":"","etc_info":"","subway_chk":"0","bus_chk":"0","parking_chk":"0","chartered_bus_chk":"1","banquet_chk":"1","etc_chk":"1","map_upload_chk":"0","sk_nm":"\ud574\ud53c\ub9ac\uc2a4","main_width":"0","main_height":"0","gallery_width":"520","gallery_height":"520","m_uid":"ej3026"};
	//모바일 청첩장 마스터 정보 추출
	//$.post("/mbcard/mb_exec.php?getMbCardInfoByMIdx", {mIdx:mIdx}, function(info) {
		_mIdx = parseInt(info.m_idx);		
		var skIdx = parseInt( info.sk_idx);
		var vdoIdx = parseInt( info.vdo_idx);
		var galDispOrd = info.gal_disp_ord;
		var groomNm = info.groom_nm;
		var groomNm = info.groom_nm;
		var groomNmEng = info.groom_nm_eng;
		var groomFaNm = info.groom_fa_nm;
		var groomMoNm = info.groom_mo_nm;
		var groomRelation = info.groom_relation;
		var groomPhone = info.groom_hp;
		var groomFaPhone = info.groom_fa_hp;
		var groomMoPhone = info.groom_mo_hp;
		var brideNm = info.bride_nm;
		var brideNmEng = info.bride_nm_eng;
		var brideFaNm = info.bride_fa_nm;
		var brideMoNm = info.bride_mo_nm;
		var brideRelation = info.bride_relation;
		var bridePhone = info.bride_hp;
		var brideFaPhone = info.bride_fa_hp;
		var brideMoPhone = info.bride_mo_hp;
		var placeNm = info.place_nm;
		var placeZip = info.place_zip;
		var placeAddr = info.place_addr;
		var placeTel = info.place_tel;
		var floorHall = info.floor_hall;
		var state = info.state;
		var greeting = info.greeting;
		var parentViewYn = Number(info.parent_view_yn);
		var subwayInfo = info.subway_info;
		var busInfo = info.bus_info;
		var parkingInfo = info.parking_info;
		var charteredBusInfo = info.chartered_bus_info;
		var banquetInfo = info.banquet_info;
		var etcInfo = info.etc_info;
		var subwayChk = Number(info.subway_chk);
		var busChk = Number(info.bus_chk);
		var parkingChk = Number(info.parking_chk);
		var charteredBusChk = Number(info.chartered_bus_chk);
		var banquetChk = Number(info.banquet_chk);
		var etcChk = Number(info.etc_chk);
		var weddingDt = new Date(Date.parseHHmmss(info.wedding_dt));
		var mapUploadChk = Number(info.map_upload_chk);
		
		//var siteDomain = getBaseDomain();
		var siteDomain = "http://card-market.co.kr";
		var urlPath = "/mbcard/mb_card.php?mIdx=";
		var serviceNm = '카드마켓 모바일청첩장';
		var imgSrc = _PHOTO_OUT_DIR+mIdx+"/"+_MAIN_PHOTO_PREFIX+_IMG_EXT;
		//var myMbURL = siteDomain+urlPath+_mIdx; 
		var myMbURL = siteDomain+"/"+info.m_uid;
		var myMbURLforFB = siteDomain+"/mbcard/mb_card.php?mIdx="+_mIdx;
		
		//if(state!="C") setTimeout(function(){alert("웨딩영상이 아직 등록되지 않았습니다\n영상 제작은 신청 후 2~3일 정도 소요됩니다");},2000);

		//웨딩 정보 표시
		var today = new Date(); today.setHours(0,0,0,0);
		var wdday = new Date(weddingDt.getTime()); wdday.setHours(0,0,0,0);
		var dDay = today.inDays(wdday);
		$(".DDAY").text(dDay);

		$(".GR_NM").text(groomNm);
		$(".GR_NM_ENG").text(groomNmEng);
		$(".GR_FA").text(groomFaNm);
		$(".GR_MO").text(groomMoNm);
		$(".GR_REL").text(groomRelation);
		$(".BR_NM").text(brideNm);
		$(".BR_NM_ENG").text(brideNmEng);
		$(".BR_FA").text(brideFaNm);
		$(".BR_MO").text(brideMoNm);
		$(".BR_REL").text(brideRelation);
		
		if(!groomFaNm) $(".GR_FA").parents(".info:first").hide();
		if(!groomMoNm) $(".GR_MO").parents(".info:first").hide();
		if(!brideFaNm) $(".BR_FA").parents(".info:first").hide();
		if(!brideMoNm) $(".BR_MO").parents(".info:first").hide();
		
		if(!parentViewYn && groomFaNm!=null) $(".PARENT_INFO").show();
		
		var months = ["January", "February", "March", "Aprill", "May", "June", "July", "August", "September", "October", "November", "December"];
		var weekdays = ["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"];
		var weekdaysKr = ["일요일", "월요일", "화요일", "수요일", "목요일", "금요일", "토요일"];
		//var weekdays = ["SUN","MON", "TUE", "WED", "THU", "FRI", "SAT"];
		/*
		var wdDayDisp = weddingDt.getFullYear()+". "+
						(weddingDt.getMonth() + 1)+". "+
						weddingDt.getDate()+" "+
						weekdays[weddingDt.getDay()]+" "+
						(weddingDt.getHours()>=12 ? "PM" : "AM")+" "+
						(weddingDt.getHours()>=13 ? weddingDt.getHours()-12 : weddingDt.getHours())+":"+
						(weddingDt.getMinutes().toString()[1] ? weddingDt.getMinutes() : "0"+weddingDt.getMinutes());
		$(".W_DAY").text(wdDayDisp);
		*/
		
		// 혼주 예외처리 문혜민/vadavi - 20170904
		if(info.m_uid=='vadavi') {
			$(".PARENT_INFO").hide();
			$(".PARENT_INFO_EXCEPTION").show();
		}
		
		
		var year = weddingDt.getFullYear();
		var month = (weddingDt.getMonth() + 1);
		var day = weddingDt.getDate();
		var week = weddingDt.getDay();
		var wdDay = year+". "+month+". "+day;
		var wdDayKr = year+"년 "+month+"월 "+day+"일";
		var wdWeek = (weekdays[week]).substr(0,3);
		var wdWeekFull = weekdays[week];
		var wdWeekUpper = wdWeek.toUpperCase();
		var wdWeekKr = weekdaysKr[week];
		var wdMMTxt = months[month-1];
		var wdTime =(weddingDt.getHours()>=12 ? "PM" : "AM")+" "+
						(weddingDt.getHours()>=13 ? weddingDt.getHours()-12 : weddingDt.getHours())+":"+
						(weddingDt.getMinutes().toString()[1] ? weddingDt.getMinutes() : "0"+weddingDt.getMinutes());
		
		var wdTimeKr =(weddingDt.getHours()>=12 ? "오후" : "오전")+" "+
						(weddingDt.getHours()>=13 ? weddingDt.getHours()-12 : weddingDt.getHours())+"시 "+
						(weddingDt.getMinutes().toString()[1] ? weddingDt.getMinutes() : "0"+weddingDt.getMinutes()) + "분";

		
		var wdMM = month > 9 ? month : '0'+ month;
		var wdDD = day > 9 ? day: '0'+ day;
		
		$(".W_YYYY").text(year);
		$(".W_MM").text(wdMM);
		$(".W_MM_TXT").text(wdMMTxt);
		$(".W_DD").text(wdDD);
		
		$(".W_DAY").text(wdDay);
		$(".W_DAY_KR").text(wdDayKr);
		$(".W_Week").text(wdWeek);
		$(".W_WeekFull").text(wdWeekFull);
		$(".W_WeekUpper").text(wdWeekUpper);
		$(".W_WeekKr").text(wdWeekKr);

		$(".W_Time").text(wdTime);
		$(".W_TimeKr").text(wdTimeKr);

		$(".PL_NM").text(placeNm);
		
		if(floorHall) $(".PL_NM2").text(floorHall);
		else $(".PL_NM2").hide();
		
		$(".PL_ADDR").text(placeAddr);
		
		if(placeTel) $(".PL_TEL_NO").text(placeTel);
		else		 $(".PL_TEL").hide();
		
		$("#PL_TEL_NO").attr("href","tel:"+placeTel);
		
		if(greeting==null) $(".GREETING").hide();
		$(".GREETING").text(greeting);
		
		if(!subwayChk && subwayInfo) $(".SUBWAY_CHK").show();
		if(!busChk && busInfo) $(".BUS_CHK").show();
		if(!parkingChk && parkingInfo) $(".PARKING_CHK").show();
		if(!banquetChk && banquetInfo) $(".BANQUET_CHK").show();
		if(!charteredBusChk && charteredBusInfo) $(".CHARTERED_BUS_CHK").show();
		if(!etcChk && etcInfo) $(".ETC_CHK").show();
		
		$(".SUBWAY_INFO").text(subwayInfo);
		$(".BUS_INFO").text(busInfo);
		$(".PARKING_INFO").text(parkingInfo);
		$(".BANQUET_INFO").text(banquetInfo);
		$(".CHARTERED_BUS_INFO").text(charteredBusInfo);
		$(".ETC_INFO").text(etcInfo);
		
		//메타태그 적용 (동적으로 생성한 메타는 카카오톡에서 인식이 안됨. index.php에서 html 직접코딩)
		var title = groomNm + ' ♡ ' + brideNm + "의 모바일청첩장";
		var description = groomNm+" ♥ "+brideNm+"\n"+"결혼식에 초대합니다.\n꼭 오셔서 축하해 주세요\n[일시] "+wdDayKr+" "+wdWeekKr+" "+wdTimeKr+"\n"+"[장소] "+placeNm+" "+floorHall;
		$("head title").text(title);
//		$("head title").before("<meta property='og:type' content='website'>");
//		$("head title").before("<meta property='og:title' content='"+ title1 +"'>");
//		$("head title").before("<meta property='og:description' content='"+ title1 + '\n' +title2 +"'>");
//		$("head title").before("<meta property='og:url' content='"+ myMbURLforFB +"'>");
//		$("head title").before("<meta property='og:image' content='"+ siteDomain+imgSrc +"'>");
		
		//메인 사진 적용
		$("#MAIN_PHOTO").attr("src", imgSrc+"?"+nowTimestamp());
		

		//갤러리 적용
		var arrGalDispOrd = galDispOrd.split("-"); 
		for(var i in arrGalDispOrd) {
			var photoNo = arrGalDispOrd[i];
			var src = _PHOTO_OUT_DIR+"/"+_GAL_PHOTO_PREFIX+photoNo+_IMG_EXT+"?"+nowTimestamp();
			var $item = $(".GAL_TEMPLATES li").clone();
			$item.find("img").attr("src", src).attr("data-num",i);
			
			if(i<6) {
				$("#GAL_LIST").append($item.clone());
			}
			
			if(arrGalDispOrd.length<=6) {
				$("#BTN_MORE_GAL_LIST").hide();
			}
			
			$("#GAL_LIST_ALL").append($item);
			
			var $view = $(".VIEW_TEMPLATES li").clone();
			$view.find("img").attr("src", src);
			$("#VIEWER_LIST").append($view.clone());
		}
		
		//이미지 뷰어 보기
		var once = true;
		var gal_visiabled = false;
		var eventhandler = function(e) {
		   e.preventDefault();      
		}
		
		$("#GAL_LIST, #GAL_LIST_ALL").find("img").on("click", function() {
			_scrollTop = $(document).scrollTop();
			$("#IMG_LAYER").css("z-index",120).show();
			$("#IMG_LAYER .top_bar").show();
			$("#wrap").hide();
			$("#GAL_LAYER").hide();
			
			$(body).bind('touchmove', eventhandler);
			
			if(once) {
				once = false;
				$slider = $('#VIEWER_LIST').bxSlider({
					speed: 300,
					minSlides: 1,
					maxSlides: 1,
					auto:false,
					pager:true,
					controls:false
				});
				
				$(window).resize(function(){
					var currentSlide = $slider.getCurrentSlide();
					var width, margin;
					if($(window).height()>$(window).width()) {
						width = $(window).width();
						margin = 0;
					} else {
						width = $(window).height()-100;
						margin = ($(window).width()-width)/2;
					}
					
					$slider.reloadSlider({
						controls:false,
						slideWidth: width,
						startSlide: currentSlide,
						onSliderLoad: function() {
							$(".viewer").css("margin-left",margin).css("margin-right",margin);
						}
					});
				})
			}
			
			var num = $(this).attr("data-num");
			$slider.reloadSlider({
				controls:false,
				startSlide: num
			});
		});			
		//이미지 뷰어 닫기
		$("#IMG_LAYER .btn_close").on("click", function(){
			if(!gal_visiabled) $("#wrap").show();
			else $("#GAL_LAYER").show();
			
			$(body).unbind('touchmove', eventhandler);
			
			$(document).scrollTop(_scrollTop);
			$("#IMG_LAYER").hide();
		});
		
		
		
		//갤러리 more
		$("#BTN_MORE_GAL_LIST").on("click", function(){
			_scrollTop2 = $(document).scrollTop();
			$("#GAL_LAYER").css("z-index",111).show();
			$("#GAL_LAYER .top_bar").show();
			
			$("#wrap").hide();
			gal_visiabled = true;
		});
		$("#GAL_LAYER .btn_close").on("click", function(){
			$("#wrap").show();
			$(document).scrollTop(_scrollTop2);
			$("#GAL_LAYER").hide();
			gal_visiabled = false;
		});
        
		
		//축하 메시지 리스트
        appendMoreMessageList();
        
		//축하 메시지 작성
		$("#submit").on("click", function(){
			var msg = $("#MSG").val();
			var wrtNm = $("#WRT_NM").val();
			var pwd = $("#PWD").val();
			
			if(!msg) { alert("메세지를 입력하세요."); $("#MSG").focus(); return false; }
			if(!wrtNm) { alert("이름을 입력하세요."); $("#WRT_NM").focus(); return false; }
			if(!pwd) { alert("비밀번호를 입력하세요."); $("#PWD").focus(); return false; }
			
			var param = {mIdx:_mIdx, wrtNm:wrtNm, msg:msg, pwd:pwd};
			$.post("/mbcard/mb_exec.php?writeMessage", param, function(msgIdx) {
				var tmp = {msg_idx:msgIdx, wrt_nm:wrtNm, msg:msg, reg_dt:(new Date()).formatHHmmss()};
				addMsgDOM(tmp, "prepend");
				
				$("#WRT_NM").val("");
				$("#MSG").val("");
				$("#PWD").val("");
			});
			
			return false;
		});

		//축하 메시지 more
		$("#BTN_MORE_MSG_LIST").on("click", appendMoreMessageList);
		
		//축하 메시지 개별 삭제
		$(document).on("click", ".BTN_DEL_MSG", function(){
			var $popup = $(this).parents(".MSG_ITEM").find(".POPUP_DEL_MSG");
			$popup.show();
			$popup.find(".PWD").val("");
			$popup.find(".PWD").focus();
		});
		$(document).on("click", ".CCL_DEL_MSG", function(){
			$(this).parents(".POPUP_DEL_MSG").hide();
		});
		$(document).on("click", ".CNF_DEL_MSG", function(){
			var $item = $(this).parents(".MSG_ITEM");
			var msgIdx = $item.attr("data-msg_idx");
			var pwd = $item.find(".PWD").val();
			$.post("/mbcard/mb_exec.php?removeMessage", {msgIdx:msgIdx, pwd:pwd, mIdx:_mIdx}, function(result) {
				if(result==1) {
					$item.remove();
				}else {
					alert("비밀번호가 올바르지 않습니다.");
					$item.find(".POPUP_DEL_MSG").hide();
				}
			});
		});
		
		
		
//		//비디오 적용
//		var $player = $("#VIDEO_PLAYER");
//		var player = $player.get(0);
//		var src = _VIDEO_OUT_DIR+mIdx+"/"+_VIDEO_PREFIX+_VDO_EXT;
//		var $source = $("<source src='"+ src +"' type='video/mp4' />");
//		
//		$player.attr("poster",_VIDEO_SAMPLE_DIR+vdoIdx+"/"+_VIDEO_PREFIX+"0"+_IMG_EXT);
//		$player.attr("width", "100%");
//		$player.attr("height", "auto");
//		if(state=="C") {
//			$player.append($source);
//			player.load();
//		}
		
		//전화번호/문자 적용
		$("#GROOMPHONE").attr("href","tel:"+groomPhone);
		$("#GROOMSMS").attr("href","sms:"+groomPhone);
		$("#BRIDEPHONE").attr("href","tel:"+bridePhone);
		$("#BRIDESMS").attr("href","sms:"+bridePhone);
		$("#PLACETEL").attr("href","tel:"+placeTel);
		
		if(groomFaPhone) {
			$("#GROOMFAPHONE").attr("href","tel:"+groomFaPhone);
			$("#GROOMFASMS").attr("href","sms:"+groomFaPhone);
			$(".GR_FA_HP").show();
		}if(groomMoPhone) {
			$("#GROOMMOPHONE").attr("href","tel:"+groomMoPhone);
			$("#GROOMMOSMS").attr("href","sms:"+groomMoPhone);
			$(".GR_MO_HP").show();
		}if(brideFaPhone) {
			$("#BRIDEFAPHONE").attr("href","tel:"+brideFaPhone);
			$("#BRIDEFASMS").attr("href","sms:"+brideFaPhone);
			$(".BR_FA_HP").show();
		}if(brideMoPhone) {
			$("#BRIDEMOPHONE").attr("href","tel:"+brideMoPhone);
			$("#BRIDEMOSMS").attr("href","sms:"+brideMoPhone);
			$(".BR_MO_HP").show();
		}
		
		
//		$("#BYCAR").on("click",function(){
//			$(this).attr("href","http://m.map.naver.com/route.nhn?ename="+encodeURI(placeAddr));
//		});
//		$("#BYBUS").on("click",function(){
//			if(!busSta) busSta="";
//			$(this).attr("href","http://m.map.naver.com/bus/search.nhn?query="+encodeURI(busSta));
//		});
//		$("#BYSUBWAY").on("click",function(){
//			$(this).attr("href","http://m.map.naver.com/subway/subwayLine.nhn?region=1000");
//		});
		
		//카카오톡용 이미지가 없는 경우 카카오스토리 이미지로 대체
		var KTimgSrc = _PHOTO_OUT_DIR+mIdx+"/"+_KAKAO_PHOTO_PREFIX+_IMG_EXT+"?"+nowTimestamp();
		var img = new Image();
		img.src = siteDomain+KTimgSrc;
		img.onload = function(){
			kakaotalk();
		}
		img.onerror = function(){
			KTimgSrc = _PHOTO_OUT_DIR+mIdx+"/"+_MAIN_PHOTO_PREFIX+_KAKAOTALK_PHOTO_PREFIX+_IMG_EXT+"?"+nowTimestamp();
			kakaotalk();
		}
		
		//카카오톡 API3.0 적용		
		Kakao.init('67af927d10acc74849e5e473881f428c'); //김혁의 개발자키 (차후 카드마켓측의 개발자키로 변경해야함) //TODO
		function kakaotalk() {
			Kakao.Link.createTalkLinkButton({
				container: '#KAKAOTALK',
				label: description,
				image: {
					src: siteDomain + KTimgSrc,
					width: _KAKAO_PHOTO_WIDTH,
					height: _KAKAO_PHOTO_HEIGHT
				},
				webButton: {
					text: "청첩장 바로가기",
					url: myMbURLforFB + '&' + nowTimestamp()
				}
			});
		}
		
		//카카오스토리용 이미지 (카카오톡과 같은 이미지 사용)
		var KSimgSrc = _PHOTO_OUT_DIR+mIdx+"/"+_KAKAO_PHOTO_PREFIX+_IMG_EXT+"?"+nowTimestamp();
		var img = new Image();
		img.src = siteDomain+KSimgSrc;
		img.onload = function(){
		}
		img.onerror = function(){
			KSimgSrc = _PHOTO_OUT_DIR+mIdx+"/"+_MAIN_PHOTO_PREFIX+_KAKAOSTORY_PHOTO_PREFIX+_IMG_EXT+"?"+nowTimestamp();
		}
		
		//카카오스토리
		$("#KAKAOSTORY").on("click",function(){
			
		    kakao.link("story").send({   
		        post : groomNm + ' ♡ ' + brideNm + "의 모바일청첩장입니다.\n\n" + myMbURL,
		        appid : "card-market.co.kr",
		        appver : "3.0",
		        apiver : "1.0",
		        appname : description,
		        urlinfo : JSON.stringify({
		        	title : groomNm + ' ♡ ' + brideNm,
		        	desc : myMbURL,
		        	imageurl : [siteDomain+KSimgSrc],
		        	type : "article"
		        })
		    });
		});
		
		//페이스북
		$("#FACEBOOK").on("click",function(){
			var strUrl = "http://www.facebook.com/sharer.php?u="+encodeURIComponent(myMbURLforFB)+"&t="+encodeURIComponent('['+serviceNm+'] '+groomNm + ' ♡ ' + brideNm + '의 청첩장입니다'); // 페이스북 링크등록 로봇때문에 http://www.card-market.co.kr/USERID 사용불가
			window.open(strUrl);
		});
		
		
		
		//밴드
		$("#BAND").on("click", function() {
			var text = groomNm + ' ♡ ' + brideNm + "의 모바일청첩장입니다.\n" + myMbURL;
			var strUrl = "http://band.us/plugin/share?body="+encodeURIComponent(text);
			window.open(strUrl);
			
			//window.location.href = "bandapp://create/post?text="+encodeURIComponent(text);
		});
		
		
		
		//트위터
//		$("#TWITTER").on("click",function(){
//			var strUrl = "http://twitter.com/intent/tweet?text="+encodeURIComponent('['+serviceNm+'] '+groomNm+' ♡ '+brideNm+'] 의 청첩장입니다 \n '+myMbURL);
//			window.open(strUrl);
//		});
		
		
		//네이버 지도
		if(mapUploadChk) {
			$("#MAP_CANVAS").append("<img class='map' id='MAP_TEMP' src='"+_PHOTO_OUT_DIR+_mIdx+"/"+_MAP_IMG_PREFIX+_MAP_IMG_EXT+"?"+(new Date()).getTime()+"' width='100%' height='auto' />");
			$("#MAP_CANVAS_FS").attr('style','overflow:scroll').append("<img src='"+_PHOTO_OUT_DIR+_mIdx+"/"+_MAP_IMG_PREFIX+_MAP_IMG_EXT+"?"+(new Date()).getTime()+"' width='auto' height='100%' />");
			$("#MAP_TEMP").show();
		} else {
			geoCode(placeAddr, placeNm);
			geoCode(placeAddr, placeNm, "MAP_CANVAS_FS");
			$("#MAP_CANVAS").css("height","200px");
		}
		$("#ZOOM_LAYER").hide();
		
		$(".zoom").on("click", function(){
			_scrollTop = $(document).scrollTop();
			$("#ZOOM_LAYER").css("z-index",100).show();
			$("#ZOOM_LAYER .top_bar").show();
			$("#wrap").hide();
		});
		$("#ZOOM_LAYER .btn_close").on("click", function(){
			$("#wrap").show();
			$(document).scrollTop(_scrollTop);
			$("#ZOOM_LAYER").hide();
		});
		
		//달력
		setTimeout(function(){
			if($("#wrap .data_txt").has(".cal")) {
				$(".cal").datepicker();
				$(".cal").datepicker("setDate",weddingDt);
				$(".cal_cover").css("height", $(".cal").height()+40);
			}
		},500);
		
		//네이버 길찾기
		$.getJSON("/mbcard/mb_exec.php?addrToLatlng", {addr:placeAddr}, function(data) {
			if(data && data.result) {
	    		var point = data.result.items[0].point;
	    		var url = "http://m.map.naver.com/directions/?menu=route&sy=&esy=&esx=&sname=&sdid=&ey="+point.y+"&ex="+point.x+"&ename="+placeNm+"&edid=&pathType=&dtPathType=&idx=";
				$(".location .naver a:last").show().attr("href",url);
			}
		});
	
		
		//스킨별 후처리 함수 호출
		if(_postProcBySkin) _postProcBySkin();
	//},"json");
	
	//TOP버튼
	$("#TOP").attr("href", location.href.replace("#","") + "#");
	
	
};


function addMsgDOM(msg, mode) {
	$list = $("#MSG_LIST");

	var $item = $(".TEMPLATES > .MSG_ITEM").clone();
	$item.attr("data-msg_idx", msg.msg_idx);
	$item.find(".name").text(msg.wrt_nm);
	$item.find(".con").text(msg.msg);
	$item.find(".date span").text(msg.reg_dt);
	if(mode=="append")
		$list.append($item);
	else
		$list.prepend($item);
	
}

function appendMoreMessageList() {
    var limit = 10;
    //var msgIdx = $("#MSG_LIST > .MSG_ITEM").last().attr("data-msg_idx");
	var list = [{"msg_idx":"83757","m_idx":"40635","wrt_nm":"\ub3d9\ud658","msg":"\uccad\ucca9\uc7a5 \uc608\uc058\uac8c \ub098\uc654\uad6c\ub098 \ucd95\ud558\ud55c\ub2e4 \n\ud589\ubcf5\ud574\ub77c","pwd":"aa8dccd5bb65bccdcc334157505e3b1a","reg_dt":"2017-09-14 20:17:17"},{"msg_idx":"83706","m_idx":"40635","wrt_nm":"\uc6a9\uc900","msg":"\uc77c\uc544 \ucd94\uce74\ud55c\ub2e4\n\uc774\uc05c \uc544\ub4e4 \ub538 \ub0b3\uace0\n\ud589\ubcf5\ud558\uac8c \uc798\uc0b4\uc544~~","pwd":"76622ccf93cf130f9fc14f56a6d1aa0d","reg_dt":"2017-09-14 17:48:21"},{"msg_idx":"83673","m_idx":"40635","wrt_nm":"\uc5fc\ud604\ud638","msg":"\ud56d\uc0c1 \ud589\ubcf5\ud558\uace0 \uac00\uc871\uc774 \ucd5c\uc6b0\uc120\uc778 \uac00\uc7a5\uc774 \ub418\uae38 \ubc14\ub780\ub2e4.  \ud615\uc774 \uae30\ub3c4\ud560\uaed8 ","pwd":"9f25f40b95b2111e1dff0364c057ca4b","reg_dt":"2017-09-14 16:37:46"},{"msg_idx":"83669","m_idx":"40635","wrt_nm":"\ucabc\uae30","msg":"\uacf0~ \uc9c4\uc9dc\uc9c4\uc9dc \uac00\ub294\uad6c\ub098~\n\uce5c\uad6c\uc57c \ucd95\ud558\ud55c\ub2e4\n\uacf0\ub3c4 \uacb0\ud63c\ud574\uc11c \ub354 \ud589\ubcf5\ud558\uac8c \uc798 \uc0b4\uaebc\ub77c \ubbff\ub294\ub2e4!\n\n\uaf43\ubbf8\ub0a8 \uc77c\uc774\ub2d8~  \uc740\uc815\uc774 \uc798\ubd80\ud0c1\ud574\uc694~~\n\uc55e\uc73c\ub85c\ub3c4 \uc5f4\uc2ec\ud788!!  \ucb49~~ \uc0ac\ub791\ud574\uc8fc\uc138\uc694\n\uc5bc\ub9c8\ub098 \ud589\ubcf5\ud558\uac8c \uc798\ud574\uc8fc\ub294\uc9c0 \uc9c0\ucf1c\ubcfc\uaebc\uc784 @.@\u314b\n\ucd95\ud558\ud569\ub2c8\ub2e4!! ","pwd":"491e6b4e8aee547fdac35c219e40924e","reg_dt":"2017-09-14 16:28:01"}];
	//$.getJSON("/mbcard/mb_exec.php?getMessageList", {mIdx:_mIdx, msgIdx:msgIdx, limit:limit+1}, function(list) {
		var count;
		for(var i=0; i<limit; i++) {
			if(list && i < list.length) {
				var msg = list[i];
				addMsgDOM(msg, "append");
			}
		}
		
		if(list && list.length > limit) {
			$("#MORE_MSG_LIST").show();
		}else {
			$("#MORE_MSG_LIST").hide();
		}
	//});
}

function getBaseDomain () {
    return location.protocol + "//" + location.hostname;
}
