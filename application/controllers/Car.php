<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Created by PhpStorm.
 * User: wwtx
 * Date: 16-9-24
 * Time: 下午8:56
 */
class Car extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        if(!isset($_SESSION['user'])){
            redirect('user/login');
        }
    }

    public function typelist(){
        $this->load->view('car/type');
    }

    public function get_type(){
        $this->load->library (array('PHPExcel','PHPExcel/IOFactory'));

        $cur_index = $this->input->post('curIndex');

        $file_name = './uploads/chexing.xlsx';

        $objPhpExcel = IOFactory::load($file_name);

        $objWorkSheet = $objPhpExcel->getActiveSheet();

//        $arr_head = [];
//
//        foreach ($objWorkSheet->getRowIterator(1)->current()->getCellIterator() as $head_cell) {
//
//            array_push($arr_head, $head_cell->getValue());
//        }

        $arr_head = array('A' => 'brand', 'B' => 'series', 'C' => 'name', 'D' => 'cartypeId');
        $jsonObj = [];
        foreach ($objWorkSheet->getRowIterator(2) as $row) {
            $arr_tmp = array();
            foreach ($row->getCellIterator() as $cell){
                $arr_tmp[$arr_head[$cell->getColumn()]] = $cell->getValue();
            }
            array_push($jsonObj, $arr_tmp);
        }
        echo json_encode($jsonObj);

    }

    public function partlist(){
        $this->load->view('car/part');
    }

    public function get_part(){
        $this->load->library (array('PHPExcel','PHPExcel/IOFactory'));

        $cur_index = $this->input->post('curIndex');

        $file_name = './uploads/peijian.xlsx';

        $objPhpExcel = IOFactory::load($file_name);

        $objWorkSheet = $objPhpExcel->getActiveSheet();

//        $arr_head = [];
//
//        foreach ($objWorkSheet->getRowIterator(1)->current()->getCellIterator() as $head_cell) {
//
//            array_push($arr_head, $head_cell->getValue());
//        }

        $arr_head = array('A' => 'carpartnum', 'B' => 'carpartname', 'C' => 'carparttype');
        $data = [];
        foreach ($objWorkSheet->getRowIterator(2) as $row) {
            $arr_tmp = array();
            foreach ($row->getCellIterator() as $cell){
                $arr_tmp[$arr_head[$cell->getColumn()]] = $cell->getValue();
            }
            array_push($data, $arr_tmp);
        }
        $jsonObj['data'] = $data;
        $jsonObj['code'] = 0;
        $jsonObj['msg'] = '获取信息成功';
        echo json_encode($jsonObj);

    }
}