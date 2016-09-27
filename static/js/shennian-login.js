$(function(){
    $('#login-submit').removeAttr('disabled');
    function check(){
        var bool = true;
        if(!$.trim($('#username').val()) || !$.trim($('#password').val())){
            showError('用户名或密码不能为空');
            bool = false;
            $('#login-submit').removeAttr('disabled');
            $('#sn-icon-spinner').removeClass('sn-show').addClass('sn-hide');
        }else{
            ///bool = true;
            //showError('');
        }
        return bool;
    }

    function showError(errMsg){
        errMsg = errMsg || '信息错误';
        $('.sn-err').text(errMsg);
        $('.sn-err').css({
            'margin-left':-$('.sn-err').width()/2+'px',
        });
    }

    $('form').submit(function(e){
        $('#login-submit').attr('disabled','disabled');
        $('#sn-icon-spinner').removeClass('sn-hide').addClass('sn-show');

        check() && login(function(data){ console.log(data);
            UIkit.notify(getSNNotifyOption(data.msg));
            if(data.code == "0"){
                window.location.href = data.url;
            }
            showError(data.msg);
            $('#login-submit').removeAttr('disabled');
            $('#sn-icon-spinner').removeClass('sn-show').addClass('sn-hide');
        });

        e.preventDefault();
    });
    function login(callback){
        !isFunction(callback) && (callback=function(){});
        $.ajax({
            type: 'POST',
            url: BASEURL + '/user/do_login',
            dataType: 'json',
            data:{
                username:$.trim($('#username').val()),
                password:$.trim($('#password').val())
            },
            success: function (data){
                callback(data);
            },
            error:function(obj){
                console.log(obj.responseText);
                $('#login-submit').removeAttr('disabled');
                $('#sn-icon-spinner').removeClass('sn-show').addClass('sn-hide');
                UIkit.notify(getSNNotifyOption("登录失败，请重新登录"));
            }
        });

    }
})/**
 * Created by wwtx on 16-9-24.
 */
