(function(win){ 
	if(!win.shennian){
		var shennian = shennian || {};
		win.shennian = shennian;
	}
	
	var G = G ||{};
	G.szCarType = [];
	G.selectedType = {};
	
	function initJstree(){
		
		if(!G.szCarType || G.szCarType.length == 0){
			sendDataByAjax('/car/getAllCarType.html',null, function(data){
				G.szCarType = data;
				
				createJstree(G.szCarType);
			});
		}else{}
	}
	
	function createJstree(data){
		var jsoption = {
				'core':{
					'data':data
				},
				'checkbox':{
					'keep_selected_stype':true
				},
				"plugins" : [ "checkbox" ]
		};
		$('#jstree_cartype-box').jstree(jsoption);
	}
	
    function sendDataByAjax(url,data,callback){
    	!isFunction(callback) && (callback = function(){});
    	data = data || {};
    	$.ajax({
			  type: 'POST',
			  url: BASEURL+url, //'/car/getAllCarType.html',
			  dataType: 'json',
			  data:data,
			  success: function (data){
				callback(data);
				},
			  error:function(obj){
				 // console.log(obj);
				  ///alert("网络异常,请稍候再试");
				  UIkit.notify(getSNNotifyOption("网络异常,请刷新..."));
			  }
			});
    	return true;
    }        
    
    function getCarTypeId(data){
        if(data && data.length == 0) return;
        var reg = /^SNHZ*/;
        for(i in data){
          	var b = reg.test(data[i]);
          	if(!b) {data.splice(i,1)};
          	if(data[i] && (data[i].length <= 4 || data[i].substring(0,4) != 'SNHZ')){data.splice(i,1)};
        }
        return data.join(',');
      }
    function saveCarType(part_partid, callback){
    	!isFunction(callback) && (callback = function(){});
    	var cartypeids = getCarTypeId($('#jstree_cartype-box').jstree().get_selected());
    	if(!cartypeids){
    		var reValue = {
    				code :1,
    				msg:'请选择车型',
    		};
    		callback(reValue);
    		return false;
    	};
    	if(G.selectedType == cartypeids){
    		var reValue = {
    				code :0,
    				msg:'添加成功',
    				carPartTypeId:cartypeids
    		};
    		callback(reValue);
    		return true;
    	};
    	var bool = false;
    	sendDataByAjax('/car/saveCarTypeId.html',{'carTypeId':cartypeids,'carpart_partid':part_partid},callback) 
    	&& $('#jstree_cartype-box').jstree().deselect_all(true);
    	return bool;
    }
         
    function selectedJsTree(selectedObj){
    	$('#jstree_cartype-box').jstree().deselect_all(true);
    	G.selectedType = selectedObj.text();
    	$('#jstree_cartype-box').jstree().select_node(selectedObj.text().split(','));
    }
    
    win.shennian.initJstree = initJstree;
    win.shennian.saveCarType = saveCarType;
    win.shennian.selectedJsTree = selectedJsTree;
})(window)