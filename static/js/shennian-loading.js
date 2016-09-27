(function(win){
	
	if(!win.shennian){
		var shennian = shennian || {};
		win.shennian = shennian;
	}else{
		shennian = win.shennian;
	}
	
	initLoading();
	
	function initLoading(msg){
		var $div = '<div id="snloadig" class="sn-loading-box">';
    		$div += '<div class="spinner">'
    		$div += '<div class="rect1"></div>'
    		$div += '<div class="rect2"></div>'
    		$div += '<div class="rect3"></div>'
    		$div += '<div class="rect4"></div>'
    		$div += '<div class="rect5"></div>'
			$div += '</div>'
			$div += '<div class="loading-text">'+msg+'</div>'
			$div += '</div>';
    		$('body').append($div);
	}
	
	var show = function(msg){
		msg = msg || '数据加载中...';
		if($('.sn-loading-box').length == 0){
			initLoading(msg);
		}
		$('.loading-text').text(msg);
		$('.sn-loading-box').css({
			'z-index':'1000',
			'display':'block',
		});
	}
	var hide = function(){
		$('.sn-loading-box').css({
			'z-index':'-1',
			'display':'none',
		});
	}
	shennian.showloading = show;
	shennian.hideloading = hide;
})(window)