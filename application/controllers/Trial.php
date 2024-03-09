<?php

class Trial extends CI_Controller {

    function __construct() {
        parent::__construct();
        //$this->load->helper(array('form', 'url'));
    }

    public function index()
    {
        var_dump('ssss');
    }

    public function test($text, $is)
    {
        $this->load->library(array('generatepassword'));
        $vc_jwb = 'F@AE@DBH432.164';
        $vl_dcd = ($is == 'false'); // Set to true or false based on your requirements
        $result = $this->generatepassword->sidia($vc_jwb,$vl_dcd);
        echo $result;
    }

    public function exportfile()
    {
        $this->load->view("stimulsoft/export_file",array(
            'filename' => 'laporan sales',
            'mrt'=>'assets/mrt/sales_target.mrt',
            'jsonfile'=>'automation/SalesReport/jsontest'
        ));
    }

    public function jsontest()
    {
        header('Content-Type: application/json');
        echo json_encode(array(
            'sales' => array('nama'=>'tarjo'),

        ),  JSON_PRETTY_PRINT );
    }

    public function getGreeing()
    {
        $this->load->library('greeting');
        $greeting = $this->greeting->getgreeting();
        var_dump($greeting);die();
    }


}
?>
