<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
//	public function index()
//	{
//		$this->load->view('welcome_message');
//	}



    public function index(){
        $this->load->helper('url');
        $data['title']='杭州神辇网络科技有限公司';
        $data['head_name']='杭州神辇车系平台';
        $data['car_part']='零件列表';
        $data['car_type']='车型列表';
        $data['version']='VERSION 1.0';
        $data['username']='心灵的孤僻';
        $data['foot_text']='杭州神辇网络科技有限公司';

        $this->load->view('index', $data);
    }
}
