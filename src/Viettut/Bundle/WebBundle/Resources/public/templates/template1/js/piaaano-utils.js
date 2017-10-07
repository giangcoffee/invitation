//Rev.12

//문자열 (prototype 확장금지)
var _stringUtil = {
	replaceAll : function(str, from, to) {
		return str.split(from).join(to);
	},
};


//배열 확장 (prototype 확장금지)
var _arrayUtil = {
	removeByElem : function(arr, elem) {
		var rtn = [];
		for(var i in arr) {
			var tmp = arr[i];
			if(tmp!=elem) {
				rtn[i] = tmp;
			}
		}

		return rtn;
	},

	removeByIdx : function(arr, idx) {
		var rtn = [];
		var cnt = 0;
		for(var i in arr) {
			var tmp = arr[i];
			if(i!=idx) {
				rtn[cnt++] = tmp;
			}
		}

		return rtn;
	},

	toStringEx : function(arr, delimiter) {
		if(arr!=null && arr.length > 0)
			return arr.toString().split(",").join(delimiter);
		else
			return null;
	}
};

//Date 확장
Date.prototype.inDays = function(targetDate) {
    var targetTS = targetDate.getTime();
    var thisTS = this.getTime();
    return Math.floor((targetTS-thisTS)/(24*3600*1000));
};
Date.prototype.inHours = function(targetDate) {
    var targetTS = targetDate.getTime();
    var thisTS = this.getTime();
    return Math.floor((targetTS-thisTS)/(3600*1000));
};
Date.prototype.inMins = function(targetDate) {
    var targetTS = targetDate.getTime();
    var thisTS = this.getTime();
    return Math.floor((targetTS-thisTS)/(60*1000));
};
Date.prototype.inWeeks = function(targetDate) {
    var targetTS = targetDate.getTime();
    var thisTS = this.getTime();
    return Math.floor((targetTS-thisTS)/(24*3600*1000*7));
};
Date.prototype.inMonths = function(targetDate) {
        var thisY = this.getFullYear();
        var thisM = this.getMonth();
        var targetY = targetDate.getFullYear();
        var targetM = targetDate.getMonth();

        return (targetM+12*targetY)-(thisM+12*thisY);
};
Date.prototype.inYears = function(targetDate) {
	return targetDate.getFullYear() - this.getFullYear();
};
//날짜 출력(yyyy-mm-dd)
Date.prototype.format = function() {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); mm = (mm[1] ? mm : '0'+mm[0]);
    var dd = this.getDate().toString();  dd = (dd[1] ? dd : '0'+dd[0]);

    return yyyy + "-" + mm + "-" + dd;
};
//날짜 출력(yyyy-mm-dd HH:ii)
Date.prototype.formatHHmm = function() {
    var HH = this.getHours().toString(); HH = (HH[1] ? HH : '0'+HH[0]);
    var ii = this.getMinutes().toString();  ii = (ii[1] ? ii : '0'+ii[0]);

    return this.format() + " " + HH + ":" + ii;
};
//날짜 출력(yyyy-mm-dd HH:ii:ss)
Date.prototype.formatHHmmss = function() {
    var HH = this.getHours().toString(); HH = (HH[1] ? HH : '0'+HH[0]);
    var ii = this.getMinutes().toString();  ii = (ii[1] ? ii : '0'+ii[0]);
    var ss = this.getSeconds().toString();  ii = (ii[1] ? ii : '0'+ii[0]);

    return this.format() + " " + HH + ":" + ii + ":" + ss;
};
//날짜 출력(yyyy-mm-dd'T'HH:ii)
Date.prototype.formatTHHmm = function() {
    var HH = this.getHours().toString(); HH = (HH[1] ? HH : '0'+HH[0]);
    var ii = this.getMinutes().toString();  ii = (ii[1] ? ii : '0'+ii[0]);

    return this.format() + "T" + HH + ":" + ii;
};
//날짜 출력(yyyymmdd)
Date.prototype.formatYYYYMMDD = function() {
    var yyyy = this.getFullYear().toString();
    var mm = (this.getMonth() + 1).toString(); mm = (mm[1] ? mm : '0'+mm[0]);
    var dd = this.getDate().toString();  dd = (dd[1] ? dd : '0'+dd[0]);
    return yyyy + mm + dd;
};
//날짜 파싱(yyyy-mm-dd HH:ii:ss)
Date.parseHHmmss = function(str) {
    var dt = new Date();
	
    if(str) {
		var tmp1 = str.split(" ");
		if(tmp1 && tmp1.length==2) {
			var tmp2 = tmp1[0].split("-");
			if(tmp2 && tmp2.length==3) {
				dt.setFullYear(parseInt(tmp2[0],10), parseInt(tmp2[1],10)-1, parseInt(tmp2[2],10));
			}
			
			var tmp3 = tmp1[1].split(":");
			if(tmp3 && tmp3.length==3) {
				dt.setHours(parseInt(tmp3[0],10), parseInt(tmp3[1],10), parseInt(tmp3[2],10), 0);
			}
		}
    }

    return dt;
};



//맵 자료구조 정의
var Map = function() {
	this.map = new Object();
};
Map.prototype = {
    put : function(key, value){
        this.map[key] = value;
    },
    get : function(key){
        return this.map[key];
    },
    containsKey : function(key){
     return key in this.map;
    },
    containsValue : function(value){
     for(var prop in this.map){
      if(this.map[prop] == value) return true;
     }
     return false;
    },
    isEmpty : function(key){
     return (this.size() == 0);
    },
    clear : function(){
     for(var prop in this.map){
      delete this.map[prop];
     }
    },
    remove : function(key){
     delete this.map[key];
    },
    keys : function(){
        var keys = new Array();
        for(var prop in this.map){
            keys.push(prop);
        }
        return keys;
    },
    values : function(){
     var values = new Array();
        for(var prop in this.map){
         values.push(this.map[prop]);
        }
        return values;
    },
    size : function(){
      var count = 0;
      for (var prop in this.map) {
        count++;
      }
      return count;
    }
};


//GET 파라미터 구하기
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}


//기타 Util
var _utils = {
	nullToZero : function(num) {
		return num==null ? 0 : num;
	},
	nullToBlank : function(str) {
		return str==null ? "" : str;
	}
};

//URL상 파일 존재여부
function existsFileOnUrl(urlToFile)
{
	var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();

    if (xhr.status=="404" || xhr.status=="405") {
        return false;
    } else {
        return true;
    }
}

//현재시각 timestamp값 반환
function nowTimestamp() {
	return (new Date).getTime();
}


//캔버스 관련
var _canvasUtils = {
	//이미지 투명 마스킹
	maskByImage :	function(image, mask, asBase64) {
		// check we have Canvas, and return the unmasked image if not
		if (!document.createElement('canvas').getContext && !asBase64) {
			return image;
		}
		else if (!document.createElement('canvas').getContext && asBase64) {
			return image.src;
		}

		var bufferCanvas = document.createElement('canvas'),
			buffer = bufferCanvas.getContext('2d'),
			outputCanvas = document.createElement('canvas'),
			output = outputCanvas.getContext('2d'),

			contents = null,
			imageData = null,
			alphaData = null;

		// set sizes to ensure all pixels are drawn to Canvas
		var width = mask.width;
		var height = mask.width;

		bufferCanvas.width = width;
		bufferCanvas.height = height * 2;
		outputCanvas.width = width;
		outputCanvas.height = height;

		// draw the base image
		buffer.drawImage(image, 0, 0, image.width, image.height, 0, 0, width, height);

		// draw the mask directly below
		buffer.drawImage(mask, 0, height);

		// grab the pixel data for base image
		contents = buffer.getImageData(0, 0, width, height);

		// store pixel data array seperately so we can manipulate
		imageData = contents.data;

		// store mask data
		alphaData = buffer.getImageData(0, height, width, height).data;

		// loop through alpha mask and apply alpha values to base image
		for (var i = 3, len = imageData.length; i < len; i = i + 4) {

			if (imageData[i] > alphaData[i]) {
				imageData[i] = alphaData[i];
			}

		}

		// return the pixel data with alpha values applied
		if (asBase64) {
			output.clearRect(0, 0, width, height);
			output.putImageData(contents, 0, 0);

			return outputCanvas.toDataURL();
		}
		else {
			return contents;
		}
	}
};



//url에서 get query string function
function getUrlVars(){
	var vars = [], hash;
	var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
	for(var i = 0; i < hashes.length; i++){
		hash = hashes[i].split('=');
		vars.push(hash[0]);
		vars[hash[0]] = hash[1];
	}
	return vars;
}

//null, empty 예외 처리된 substring 함수
function getSubString(str, len){
	if(str == null || str.length == 0){
		return "";
	}

	return str.substring(0, len);
}

// 숫자만 입력받기 위한 함수
function disabledExceptNum(){
	if ((event.keyCode> 47) && (event.keyCode < 58)){
		event.returnValue=true;
	} else {
		event.returnValue=false;
	}
}

//비동기 alert (아이폰/아이패드에서 ajax 이벤트헨들러에서 일반 alert시 멈춰버리는 버그 대응)
function alertAsync(msg) {
	setTimeout(function(){
		alert(msg);
	}, 0);
}



//쿠기 관련
var _cookieUtils = {
	//생성
	setCookie : function(key, val, inDays) {
      var cookies = key + '=' + escape(val) + '; path=/ '; // 한글 깨짐을 막기위해 escape(cValue)를 합니다.
      if(inDays) {
          var expire = new Date();
          expire.setDate(expire.getDate() + inDays);
      	cookies += ';expires=' + expire.toGMTString() + ';';
      }
      document.cookie = cookies;
	},

	//추출
	getCookie : function(key) {
      key = key + '=';
      var cookieData = document.cookie;
      var start = cookieData.indexOf(key);
      var val = '';
      if(start != -1){
           start += key.length;
           var end = cookieData.indexOf(';', start);
           if(end == -1) end = cookieData.length;
           val = cookieData.substring(start, end);
      }

      return unescape(val);
	}
};
