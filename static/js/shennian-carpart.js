(function(win){
	if(!win.shennian){
		var shennian = shennian || {};
		win.shennian = shennian;
	}
	
    shennian.initPart = function(callback){
    		!isFunction(callback) && (callback = function(){});
    		var $head = '<thead><tr><th width = "5%">序号</th><th width = "15%">零件编码</th><th width="25%" max-width="25%">零件名称</th><th width="55%" max-width="55%">适用车型</th></tr></thead>';
            var $foot = '<tfoot><tr><td colspan = "4"><div class="uk-float-left"><a href="javascript:void(0);" id="clearAllCarPart">清空所有零件</a></div><div id="page-box" class = "uk-float-right"></div></td></tr></tfoot>';
            var $tbody = '<tbody></tbody>';
            $('#part-table').append($head).append($tbody).append($foot);
            updateTable(1, callback);
            FenYe.init();
        }
    function setTbody(szCarparts){
    	var $body = $('#part-table tbody');
    	$body.empty();
    	var $tbody = '';
		console.log(szCarparts[0]);
    	for(i in szCarparts){
    		var carpart = szCarparts[i];
    		$tbody += '<tr class="part"><td class="part-num">'+(parseInt(i)+1)+'</td>'
			+'<td class = "part-id">'+carpart.carpartnum+'</td>'
			+'<td class="part-name">'+carpart.carpartname+'</td>'
			+'<td><div><span class="part-cars sn-text-word">'+carpart.carparttype+'</span>'
			+'<a href="#carstype_model" data-id="'+carpart.carpartid+'" data-part-id="'+carpart.carpartnum+'" data-part-name="'+carpart.carpartname+'" class="part-add-btn sn-btn sn-add-btn" title="添加适用车型" data-uk-modal>添加</a><a class="sn-btn sn-del-btn part-del-btn" title="删除适配车型">删除</a></div></td></tr>';
    	}
    	$body.append($tbody);
    }
    var updateTable = function(curIndex, callback){
    	!isFunction(callback) && (callback = function(){}); 
    	if(parseInt(curIndex) <= 0) {callback();return;}
    	getCarPartByAjax(curIndex,function(obj){
    		
    		if(obj.code != 0) {
    			UIkit.notify(getSNNotifyOption(obj.msg));
    		}
    		setTbody(obj.data);
        	FenYe.setPageIndex(curIndex);
        	callback();
    	});
    }
    
    function clearTable(){
    	var $body = $('#part-table tbody');
    	$body.empty();
    	$('#curPageIndex').data('curpageindex', 0).text('共'+0 + '条记录 第('+0+'/'+0+')页');
		$('#first-btn').data('index',0);
		$('#perv-btn').data('index',0);
		$('#next-btn').data('index', 0);
		$('#last-btn').data('index', 0);
    }
    
    function clearCarPart(code){
    	if(parseInt(code) == 0){
    		clearCarPartByAjax(null, function(data){
    			if(data.code == 0) {clearTable();}
    			UIkit.notify(getSNNotifyOption(data.msg));
    		});
    	}else{ console.log(code);
    		clearCarPartByAjax(code, function(data){
    			if(data.code == 0) {updateTable(1);}
    			UIkit.notify(getSNNotifyOption(data.msg));
    		});
    	}
    }
    
    function clearCarPartTypeIdByAjax(carPartTypeId, callback){
    	!isFunction(callback) && (callback = function(){});
    	$.ajax({
			  type: 'POST',
			  url: BASEURL+'/car/saveCarTypeId.html',
			  dataType: 'json',
			  data:{
				  'carTypeId':'',
				  'carpart_partid':carPartTypeId
			  },
			  success: function (data){
				  callback(data);
				},
			  error:function(obj){
				  console.log(obj);
				  //alert("网络异常,请刷新...");
				  UIkit.notify(getSNNotifyOption("网络异常,请刷新..."));
			  }
			});
    }
    
    function clearCarPartByAjax(carPartTypeId, callback){
    	!isFunction(callback) && (callback = function(){});
    	var code = carPartTypeId ? '1' : '0';
    	$.ajax({
			  type: 'POST',
			  url: BASEURL+'/car/clearCarPart.html',
			  dataType: 'json',
			  data:{
				  "code":code,
				  "carPartTypeId":carPartTypeId
			  },
			  success: function (data){
				  callback(data);
				},
			  error:function(obj){
				  console.log(obj);
				  //alert("网络异常,请刷新...");
				  UIkit.notify(getSNNotifyOption("网络异常,请刷新..."));
			  }
			});
    }
    
    function getCarPartByAjax(curIndex, callback){
    	!isFunction(callback) && (callback = function(){});
    	$.ajax({
			  type: 'POST',
			  url: BASEURL+'/car/get_part',
			  dataType: 'json',
			  data:{
				  "curIndex":parseInt(curIndex)
			  },
			  success: function (data){
				  callback(data);
				},
			  error:function(obj){
				  console.log(obj);
				  //alert("网络异常,请刷新...");
				  UIkit.notify(getSNNotifyOption("网络异常,请刷新..."));
			  }
			});
    }
    var FenYe = (function(){
    	var pageSize = 20;
    	function getPageCountByAjax(callback){
    		!isFunction(callback) && (callback = function(){});
        	$.ajax({
				  type: 'POST',
				  url: BASEURL+'/car/getcarpartcount.html',
				  dataType: 'json',
				  success: function (data){
					  callback(data);
					},
				  error:function(obj){
					  //alert("网络异常,请刷新...");
					  UIkit.notify(getSNNotifyOption("网络异常,请刷新..."));
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
        	$page += '<span class="sn-span-box">至<input type="number" name="jump_number" id="jump_number" min="1" max="1" class="sn-input-text"/>页<input type="button" id="jump-submit" value="GO" class="uk-button uk-button-mini uk-button-primary" style="border-radius:6px"/></span>';
        	$('#page-box').append($page);
    	}
    	
    	function setPageIndex(curIndex){
    		getPageCountByAjax(function(totalCount){
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
    
    shennian.updatePart = updateTable;
    shennian.clearCarPart = clearCarPart;
    shennian.clearCarPartType = clearCarPartTypeIdByAjax;
})(window)

