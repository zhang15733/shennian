<?php
/**
 * Created by PhpStorm.
 * User: wwtx
 * Date: 16-9-26
 * Time: 上午11:19
 */?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>杭州神辇网络科技有限公司</title>
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/uikit.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/uikit.almost-flat.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/components/form-file.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/components/notify.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/css/base.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/jstree/themes/default/style.min.css');?>" />

    <script type="text/javascript" src="<?php echo base_url('static/js/jquery-3.0.0.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/uikit-2.25.0/js/uikit.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/uikit-2.25.0/js/components/notify.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery.form.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/jstree/jstree.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian-carpart.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian-detailtype.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian-loading.js');?>"></script>
    <script type = "text/javascript">

        function fnJumpIndex(){
            var posDigit = /^[0-9]+$/;
            var jump_index = $.trim($('#jump_number').val());

            if(jump_index == 0 || !posDigit.test(jump_index)){
                UIkit.notify(getSNNotifyOption('请输入正整数', 1000));
                return;
            }
            if(jump_index  >  parseInt($('#jump_number').attr('max'))){
                UIkit.notify(getSNNotifyOption('超出最大值，请输入有效数字', 1000));
                return;
            }
            shennian.showloading('正在加载数据...');
            shennian.updatePart(parseInt(jump_index), shennian.hideloading);
        }



        var SNG = SNG || {};
        SNG.carPartType = {};
        function init(){
            shennian.showloading('正在加载数据...');
            shennian.initPart(shennian.hideloading);
            shennian.initJstree();
        }
        $(function(){
            init();

            $('#uploadbtn').on('click', function(){
                $(this).attr('disabled','disabled');
                shennian.showloading('正在导入数据...');
                uploadFile(document.getElementById('filePartUploadForm'), "/file/uploadExcel.html", function(data){
                    $('#uploadbtn').attr('disabled','disabled');
                    shennian.updatePart(1);
                    shennian.hideloading();
                    UIkit.notify(getSNNotifyOption(data.msg, 1000));
                });
            });
            //点击分页事件
            $('#part-table').on('click', '.fenye-btn', function(){
                shennian.showloading('正在加载数据...');
                shennian.updatePart($(this).data('index'), shennian.hideloading)
            });
            $('#downpart').on('click', function(){
                downLoadExcel('excelCarPart', "/file/downloadexcel.html");
            });
            $('#part-table').on('click', '#clearAllCarPart', function(e){

                $('#part-table tbody tr').length > 0 && UIkit.modal.confirm('<h2>确定删除收有配件吗？</h2>', function(){
                    shennian.clearCarPart(0);
                })
            });

            $('#jump_number').keydown(function(e){
                if(e.keyCode == 13){
                    fnJumpIndex();
                }
            });

            $('#jump-submit').on('click', function(){
                fnJumpIndex();
            });
            $('#part-table').on('click', '.part-del-btn', function(){
                var $cartype = $(this).siblings('.part-cars');
                if(!$cartype.text()){
                    UIkit.notify(getSNNotifyOption('适用车型为空'));
                    return;
                }
                shennian.clearCarPartType($(this).siblings('.part-add-btn').data('partId'), function(data){
                    if(data.code == 0){
                        $cartype.text('');
                        UIkit.notify(getSNNotifyOption('删除成功', 1000));
                    }else{
                        UIkit.notify(getSNNotifyOption('删除失败', 1000));
                    }
                });
            });
            $('#selected-btn').on('click',function(e){
                e.preventDefault();
                $(this).attr('disabled','disabled');
                shennian.saveCarType($('#input-part-id').text(),function(data){
                    if(data.code == 0){
                        SNG.carPartType.text(data.carPartTypeId);
                        $('#carstype_model').hide();
                        $('html').removeClass('uk-modal-page');
                    }
                    UIkit.notify(getSNNotifyOption(data.msg));
                    $('#selected-btn').removeAttr('disabled');
                });
            });
            $('#fileinput').on('change',function(){
                var reg = /xlsx$/;
                if(!$(this).val() || !reg.test($(this).val())) {
                    $('#uploadbtn').attr('disabled','disabled');
                    UIkit.notify(getSNNotifyOption('请选择后缀名为 xlsx 的excel文件'));
                    return;
                }
                $('#filename').html($(this).val().substr(12));
                $('#uploadbtn').removeAttr('disabled');
            });

            $('.uk-table').on('click','.part-add-btn', function(){
                $('#input-part-id').text($(this).data('partId'));
                $('#input-part-id').data('id', $(this).data('id'));
                console.log($(this).data('id'));
                $('#input-part-name').text($(this).data('partName'));
                SNG.carPartType = $(this).siblings('.part-cars');
                shennian.selectedJsTree(SNG.carPartType);
                $('#carstype_model').show();
            });

        })
    </script>
</head>

<body class="uk-container-center uk-text-center">
<div class="uk-margin">
    <h1 class="uk-width-1-2 uk-float-left"><a href="/" class="sn-title">杭州神辇零件列表</a></h1>
    <div class="uk-width-1-2 uk-float-right">
        <form class="uk-form sn-inline-block" id="filePartUploadForm" enctype="multipart/form-data" method="post">
            <div class="file-button-group">
                <div class="uk-form-file">
                    <input id="fileinput" type="file" name = "excelFile"/>
                    <button class="uk-button uk-button-primary">选择文件</button>
                    <input type="text" hidden="true"  name = "excelType" value="excelCarPart" />
                </div>
                <input class="uk-button" disabled="disabled" type="button" id="uploadbtn" value="导入数据"/>
                <span id = "filename" class="sn-text-oneline">文件名</span>
            </div>
        </form>
        <button  id = "downpart" class = "uk-button uk-button-primary">导出文件</button>
        <span>查看<a href="${pageContext.request.contextPath}/car/type.html" target="_blank">车型列表</a></span>
    </div>
</div>
<div class="uk-margin">
    <table id="part-table" class="sn-table uk-table uk-table-striped uk-table-hover uk-table-condensed"></table>
</div>
<!-- 模态对话框 -->
<div id="carstype_model" class="uk-modal">
    <div class="uk-modal-dialog uk-modal-dialog-blank uk-height-viewport">
        <a class="uk-modal-close uk-close"></a>
        <h1 class="uk-text-center">杭州神辇车型选择列表</h1>
        <div class="uk-text-left">
            <span>零件编码：</span><span data-id="" id="input-part-id"></span>
            <span style="margin-left:15px">零件名称：</span><span id="input-part-name"></span></div>
        <div class="sn-text uk-overflow-container sn-modal-tail" id="jstree_cartype-box"></div>

        <div class="uk-margin">
            <input type="button" class="uk-button uk-button-primary" id ="selected-btn" value="添加车型"/>
        </div>
    </div>
</div>

</body>
<script type="text/javascript">

</script>
</html>

