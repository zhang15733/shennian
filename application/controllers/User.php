<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wwtx
 * Date: 16-9-24
 * Time: 下午1:59
 */
class User extends CI_Controller
{

    public  function  __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');

    }

    /**
     * 登录页面
     */
    public function login(){
        if(isset($_SESSION['user'])){
            redirect('/');
            return;
        }
        $this->load->view('user/login');
    }

    /**
     * 登录
     * 提交方式：post
     * 返回 json
     */
    public  function  do_login(){
        $this->load->helper('form');
        $this->load->model('user_model');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required',
            array('required' => 'You must provide a %s.')
        );
        $user['username'] = $this->input->post('username');
        $user['password'] = $this->input->post('password');

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

    /**
     * 退出
     *
     */
    public function do_logout(){

        $this->load->helper('form');
        echo  $this->session->user;
        $this->session->unset_userdata('user');
        redirect('/user/login');

    }
}