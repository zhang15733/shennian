<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wwtx
 * Date: 16-9-24
 * Time: 上午10:03
 */
class Main extends CI_Controller
{
    private  $user = '';

    public function  __construct()
    {
        parent::__construct();
        if(isset($_SESSION['user'])){
            $this->user = $_SESSION['user'];
        }else{
            redirect('user/login');
        }

    }

    /**
     *
     */
    public function index(){

        $data['title']='杭州神辇网络科技有限公司';
        $data['head_name']='杭州神辇车系平台';
        $data['car_part']='零件列表';
        $data['car_type']='车型列表';
        $data['version']='VERSION 1.0';

        $data['username']=$this->user['username'];
        $data['foot_text']='杭州神辇网络科技有限公司';

        $this->load->view('index', $data);
    }

    public function welcome(){
        $this->load->view('welcome');
    }

}