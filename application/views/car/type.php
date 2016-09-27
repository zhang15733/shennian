<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Created by PhpStorm.
 * User: wwtx
 * Date: 16-9-24
 * Time: 下午9:00
 */
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
    <title>杭州神辇网络科技有限公司</title>
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/uikit.min.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/uikit.almost-flat.min.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/components/form-file.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/components/notify.css')?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/css/base.css')?>" />
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery-3.0.0.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/uikit-2.25.0/js/uikit.min.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/uikit-2.25.0/js/components/notify.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery.form.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian-cartype.js')?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian-loading.js')?>"></script>
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
            shennian.updateCarType(parseInt(jump_index), shennian.hideloading);
        }

        function init(){
            shennian.showloading();
            shennian.initCarType(shennian.hideloading);
        }
        $(function(){
            init();
            $('#uploadbtn').on('click', function(){
                $(this).attr('disabled','disabled');
                shennian.showloading('正在导入数据...');
                uploadFile(document.getElementById('fileTypeUploadForm'), "/upload/do_upload", function(data){
                    $('#uploadbtn').attr('disabled','disabled');
                    shennian.updateCarType(1);
                    shennian.hideloading();
                    UIkit.notify(getSNNotifyOption(data.msg, 1000));
                });
            });
            $('#cartype-table').on('click', '.fenye-btn', function(){
                shennian.showloading('正在加载数据...');
                shennian.updateCarType($(this).data('index'),shennian.hideloading);
            });
            $('#jump_number').keydown(function(e){
                if(e.keyCode == 13){
                    fnJumpIndex();
                }
            });
            $('#jump-submit').on('click', function(){
                fnJumpIndex();
            });
            $('#clearCarTypeBtn').on('click', function(){
                $('#cartype-table tbody tr').length > 0 && UIkit.modal.confirm('<h2>确定删除所有车型吗？</h2>', function(){
                    shennian.clearAllCarType(function(data){
                        UIkit.notify(getSNNotifyOption(data.msg, 2000));
                    });
                })
            });
            $('#downcartype').on('click', function(){
                downLoadExcel('excelCarType', "/file/downloadexcel.html");
            });
            $('#fileinput').on('change',function(){
                if(!$(this).val()) {
                    $('#uploadbtn').addAttr('disabled');
                    return;
                }
                $('#filename').html($(this).val().substr(12));
                $('#uploadbtn').removeAttr('disabled');
            });
        })

    </script>
</head>

<body class="uk-container-center uk-text-center">
<div class="uk-margin">
    <h1 class="uk-width-1-2  uk-text-center uk-float-left"><a href="/" class="sn-title">杭州神辇车型列表</a></h1>
    <div class="uk-width-1-2 uk-float-right">
        <form class="uk-form sn-inline-block" id="fileTypeUploadForm" enctype="multipart/form-data" method="post">
            <div class="file-button-group">
                <div class="uk-form-file">
                    <input id="fileinput" type="file" name = "excelCarTypeFile"/>
                    <button class="uk-button uk-button-primary">选择文件</button>
                    <input type="text" hidden="true"  name = "excelType" value=excelCarType />
                </div>
                <input class="uk-button" disabled="disabled" type="button" id="uploadbtn" value="导入数据"/>
                <span id = "filename" class="sn-text-oneline">文件名</span>
            </div>
        </form>
        <button  id = "downcartype" class = "uk-button uk-button-primary">导出文件</button>
    </div>
</div>
<div class="uk-margin">
    <table id="cartype-table" class="sn-table uk-table uk-table-striped uk-table-hover uk-table-condensed"></table>
</div>

</body>

</html>

