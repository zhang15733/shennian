<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wwtx
 * Date: 16-9-26
 * Time: 下午2:39
 */
class User_model extends CI_Model
{
    public function __construct()
    {
        $this->load->database();
    }

    public function get_users(){
        $query = $this->db->get('user_tb');
        return $query->result();
    }

    public function get_user($username){

        $row = $this->db->get_where('user_tb', array('name'=>$username))->row();
        return $row;
    }

}