(function(win){
	var shennian = shennian || {};
	win.shennian = shennian;

    shennian.initCarType = function(callback){
    		!isFunction(callback) && (callback = function(){});
    		var $head = '<thead><tr><th>序号</th><th width = >品牌</th><th width = >车系</th><th width="">车型</th><th>车型ID</th></tr></thead>';
            var $foot = '<tfoot><tr><td colspan = "5"><div class="uk-float-left"><a href="javascript:void(0);" id="clearCarTypeBtn">清空所有数据</a></div><div id="page-box" class = "uk-float-right "></div></td></tr></tfoot>';
            var $tbody = '<tbody></tbody>';
            $('#cartype-table').append($head).append($tbody).append($foot);
            updateTable(1,callback);
            FenYe.init();
        }
    function setTbody(szCartypes){
    	var $body = $('#cartype-table tbody');
    	$body.empty();
    	var $tbody = '';
    	
    	for(i in szCartypes){
    		var cartype = szCartypes[i];
    		$tbody += '<tr><td class="cartype-num">'+(parseInt(i)+1)+'</td>'
					+'<td class = "cartype-brand">'+cartype.brand+'</td>'
					+'<td class = "cartype-series">'+cartype.series+'</td>'
					+'<td class="cartype-name">'+cartype.name+'</td>'
					+'<td class = "cartype-cartypeId">'+cartype.cartypeId+'</td></tr>';
    	}
    	$body.append($tbody);
    }
    var updateTable = function(curIndex, callback){
    	!isFunction(callback) && (callback = function(){});
    	if(parseInt(curIndex) <= 0) {
    		callback();
    		return;
    	}
    	getCarTypeByAjax(curIndex,function(data){
    		setTbody(data);
        	FenYe.setPageIndex(curIndex);
        	callback();
    	});
    }
    function clearTable(){
    	var $body = $('#cartype-table tbody');
    	$body.empty();
    	$('#curPageIndex').data('curpageindex', 0).text('共'+0 + '条记录 第('+0+'/'+0+')页');
		$('#first-btn').data('index',0);
		$('#perv-btn').data('index',0);
		$('#next-btn').data('index', 0);
		$('#last-btn').data('index', 0);
    }
    function clearAllCarType(callback){
    	!isFunction(callback) && (callback = function(){});
    	$.ajax({
			  type: 'POST',
			  url: BASEURL+'/car/clearcartype.html',
			  dataType: 'json',
			  success: function (data){
				  if(data.code == '0') clearTable();
				  callback(data);
				},
			  error:function(obj){
				  console.log(obj);
				  UIkit.notify(getSNNotifyOption("网络异常,请稍后再试..."));
			  }
			});
    }
    
    function getCarTypeByAjax(curIndex, callback){
    	!isFunction(callback) && (callback = function(){});
    	if(parseInt(curIndex) <= 0) return;
    	$.ajax({
			  type: 'POST',
			  url: BASEURL+'/car/get_type',
			  dataType: 'json',
			  data:{
				  "curIndex":parseInt(curIndex)
			  },
			  success: function (data){
				  callback(data);
				},
			  error:function(obj){
				  console.log(obj);
				  UIkit.notify(getSNNotifyOption("网络异常,请稍后再试..."));
			  }
			});
    }
    var FenYe = (function(){
    	var pageSize = 20;
    	function getTypeCountByAjax(callback){
    		!isFunction(callback) && (callback = function(){});
        	$.ajax({
				  type: 'POST',
				  url: BASEURL+'/car/getcartypecount.html',
				  dataType: 'json',
				  success: function (data){
					  callback(data);
					},
				  error:function(obj){
					  UIkit.notify(getSNNotifyOption("网络异常,请稍后再试..."));
				  }
				});	
    	}
    	
    	function init(){
    		setFenYe();
    		setPageIndex(1);
    	}
    	function setFenYe(){
    		$page = '<span id = "curPageIndex" data-curpageindex = "0"></span>';
    		$page += '<a href="javascript:void(0)" id="first-btn" class="fenye-btn" data-index = "0">首页</a>';
        	$page += '<a href="javascript:void(0)" id="perv-btn" class="fenye-btn" data-index = "0">上一页</a>';
        	$page += '<a href="javascript:void(0)" id = "next-btn" class="fenye-btn" data-index = "0">下一页</a>';
        	$page += '<a href="javascript:void(0)" id = "last-btn" class="fenye-btn" data-index = "0">末页</a>';
        	$page += '<span class="sn-span-box">跳至<input onkeyup="this.value=this.value.replace(/\D/g,")" onafterpaste="this.value=this.value.replace(/\D/g,")" type="number" name="jump_number" id="jump_number" max = "1" min="1" class="sn-input-text"/>页<input type="button" id="jump-submit" value="GO" class="uk-button uk-button-mini uk-button-primary" style="border-radius:6px"/></span>';
        	$('#page-box').append($page);
    	}
    	
    	function setPageIndex(curIndex){
    		getTypeCountByAjax(function(totalCount){
        		var pageCount = parseInt(totalCount/pageSize);
        		if(totalCount%pageSize) pageCount += 1;
        		if(totalCount <= 0) curIndex = 0;
        		$('#curPageIndex').data('curpageindex', curIndex).text('共'+totalCount + '条记录 第('+curIndex+'/'+pageCount+')页');
        		var pindex = (curIndex == 1 ? curIndex : curIndex - 1);
        		$('#first-btn').data('index',1);
        		$('#perv-btn').data('index',pindex);
        		var nindex = curIndex >= pageCount ? pageCount : curIndex+1;
        		$('#next-btn').data('index', nindex);
        		$('#last-btn').data('index', pageCount);
        		$('#jump_number').attr('max',pageCount);
    		});
    	}
    	
    	return {
    		init:init,
    		setPageIndex:setPageIndex
    	};
    })() 
    
	shennian.updateCarType = updateTable;
    shennian.clearAllCarType = clearAllCarType;
})(window)

