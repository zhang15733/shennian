<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wwtx
 * Date: 16-9-24
 * Time: 下午9:07
 */
class Upload extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['user'])){
            redirect('user/login');
        }
        $this->load->helper('form');

    }

    public function index(){
        $data['error'] = '';
        $this->load->view('test', $data);
    }

    public function do_upload(){
        $config['upload_path']      = './uploads/';
        $config['allowed_types']    = 'xlsx';

        $this->load->library('upload', $config);

        $data['url']    = '/';
        $data['code']   = 0;
        $data['msg']    = '上传成功';

        if ($this->upload->do_upload('excelCarTypeFile')){
            echo  json_encode($data);
        }else if(!$this->upload->do_upload('excelCarPartFile')){
            echo  json_encode($data);
        }
        else{
            $error = array('error' => $this->upload->display_errors());

            echo json_encode($error);

        }
    }

    public function read(){
        $this->load->library (array('PHPExcel','PHPExcel/IOFactory'));

        $file_name = './uploads/chexing.xlsx';

        $objPhpExcel = IOFactory::load($file_name);

        $objWorkSheet = $objPhpExcel->getActiveSheet();

        $arr_head = [];

        foreach ($objWorkSheet->getRowIterator(1)->current()->getCellIterator() as $head_cell) {

            array_push($arr_head, $head_cell->getValue());
        }

         //print_r($arr_head);
        /**
         * [{'brand':'brandname'}]
         */
        $arr_head = array('A' => 'brand', 'B' => 'series', 'C' => 'name', 'D' => 'cartypeId');
        $jsonObj = [];
        foreach ($objWorkSheet->getRowIterator(2) as $row) {
            $arr_tmp = array();
            foreach ($row->getCellIterator() as $cell){

                //$arr_tmp($arr_head[$cell->getColumn()] => $cell->getValue());
                $arr_tmp[$arr_head[$cell->getColumn()]] = $cell->getValue();

            }
            //print_r($arr_tmp);
            array_push($jsonObj, $arr_tmp);
        }
        print_r(json_encode($jsonObj));
    }
}