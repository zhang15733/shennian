<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wwtx
 * Date: 16-9-26
 * Time: 下午2:37
 */
class Test extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index(){
        $this->load->view('test');
    }

    public function getusers(){
        $this->load->model('user_model');
        $user['username'] = 'wwtx';
        $user['password'] = 'wwtx';

        $dbuser = $this->user_model->get_user($user['username']);

        if(isset($dbuser) && strcmp($dbuser->password, $user['password']) == 0){
            $data['url']    = '/';
            $data['code']   = 0;
            $data['msg']    = '登录成功';
            $this->session->user = $user;
        }else{
            $data['code']   = 1;
            $data['msg']    = '登录失败';
        }
        echo  json_encode($data);
    }




}