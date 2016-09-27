
 var BASEURL = (function() {
     var pathName = window.location.pathname.substring(1);
     var webName = pathName == '' ? '' : pathName.substring(0, pathName.indexOf('/'));
     return window.location.protocol + '//' + window.location.host;
     })();
 function isFunction(fn) {
	   return Object.prototype.toString.call(fn)=== '[object Function]';
	}
 function downLoadExcel(excelType, url) { 
     var form = $("<form>");   //定义一个form表单
     form.attr('style', 'display:none');   //在form表单中添加查询参数
     form.attr('target', '');
     form.attr('method', 'post');
     form.attr('action', BASEURL + url);

     var input1 = $('<input>');
     input1.attr('type', 'hidden');
     input1.attr('name', 'excelType');
     input1.attr('value', excelType);
     $('body').append(form);  //将表单放置在web中 
     form.append(input1);   //将查询参数控件提交到表单上
     form.submit();
  };

  function uploadFile(formelem, url, callback){
	  !isFunction(callback) && (callback = function(){});
	   var formData = new FormData(formelem);
	   $.ajax({
		   url:BASEURL+url, 
		   type:'post',
		   dataType:'json',
		   data:formData,
		   processData: false,  // 告诉jQuery不要去处理发送的数据
		   contentType: false,   // 告诉jQuery不要去设置Content-Type请求头
		   success:function(data){
			   callback(data);
		   },
		   error:function(data){
			   UIkit.notify(getSNNotifyOption("网络错误，请稍候再试..."));
		   }
	   });
  }
  
  function getSNNotifyOption(msg, lefttime){
	  lefttime = lefttime || 3000;
	  return {
		  message:		msg,
		  status:		'warning',
		  timeout:		lefttime,
		  pos:			'top-center'
	  };
  }
  
  