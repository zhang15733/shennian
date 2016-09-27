<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title>神辇用户登录</title>
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/uikit.almost-flat.min.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/components/notify.css');?>" />
    <link rel="stylesheet" href="<?php echo base_url('static/css/base.css');?>" />
    <style>
        html{
            background:#f9f9f9;
        }
    </style>
    <script type="text/javascript" src="<?php echo base_url('static/js/jquery-3.0.0.min.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/uikit-2.25.0/js/uikit.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/uikit-2.25.0/js/components/notify.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian.js');?>"></script>
    <script type="text/javascript" src="<?php echo base_url('static/js/shennian-login.js')?>"></script>
</head>
<body class="uk-container uk-container-center uk-text-center">

<div class="sn-form-box">
    <form action="" method="post" class="uk-form">
        <div class="sn-input-box">
            <input name = "username" id="username"  type="text" placeholder="请输入用户名" value="<?php echo set_value('username'); ?>" autofocus="autofocus"/>
            <p class="sn-err"></p>
        </div>
        <p>
            <input name = "password" id="password" type="password" placeholder="请输入密码" value="<?php echo set_value('password'); ?>"/>
        </p>
        <button id="login-submit" type="submit" class="sn-summit-btn" disabled="disabled">登录
            <i id="sn-icon-spinner" class="uk-icon-spinner uk-icon-spin sn-icon-spinner sn-hide"></i>
        </button>
        <p style="color:#757575">首次登录即为注册</p>
    </form>
</div>
</body>
</html>


