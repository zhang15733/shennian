<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8; initial-scale=1.0, user-scalable=no"/>
        <title><?php echo $title;?></title>
        <link rel="stylesheet" href="<?php echo base_url('static/uikit-2.25.0/css/uikit.almost-flat.min.css');?>" />
        <link rel="stylesheet" href="<?php echo base_url('static/css/base.css');?>"/>
        <style type="text/css">
            html{
                background:#f9f9f9;
            }
        </style>
    </head>
    <body>
    <div class="head uk-width-1-1">
        <div class="uk-width-1-2 uk-float-left">
            <h3 class="head-name"><?php echo $head_name;?></h3>
        </div>
        <div class="uk-width-1-2 uk-float-right sn-box-small">
            <a href="./user/do_logout" class="sn-button uk-float-right">退出</a>
            <a href="javascript:void(0);" class="sn-button sn-button-blue uk-float-right"><?php echo $username?></a>
        </div>
    </div>
    <div class="uk-container uk-container-center">
        <div class="uk-grid">
            <div class="uk-width-1-2">
                <div class="sn-box uk-float-right sn-box-left">
                    <a class="sn-box-large-text" href="./car/partlist"><?php echo $car_part;?></a>
                </div>
            </div>
            <div class="uk-width-1-2">
                <div class="sn-box uk-float-left sn-box-right">
                    <a class="sn-box-large-text" href="./car/typelist"><?php echo $car_type;?></a>
                </div>
            </div>
        </div>
    </div>
    <div class="sn-footer uk-width-1-1">
        <p class="sn-version uk-float-left" style="margin: 17px 0 0 0px;"><?php echo $version;?></p>
        <p class="uk-float-right" style="margin: 17px 0px 0 0;"><?php echo $foot_text?></p>

    </div>

    </body>
</html>