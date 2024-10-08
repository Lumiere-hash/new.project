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
        $vc_jwb = 'G?BEGD05432.164';
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

	function send_mail()
    {	
		
		$this->load->library(array('Fiky_encryption', 'Fiky_mailer', 'jagoan_mail'));
		$pass = 'vhvXD3c0FNakdLXqmzXDP5QhN42u29BEu+7va1T8lxKByzHgRc29pONMZ9iCX+ymZjiUsbEG6DigSylkM4Gqow==';
		$decode = $this->encrypt->decode($pass);
		var_dump($decode);die();
        $no_dok='NSANBI';
        $sender=$this->m_mailserver->q_smtp($no_dok)->row_array();
        //$penerima='ikangurame3@gmail.com';
        //$penerima = 'ikangurame3@gmail.com,gilrandyseptiansyah@gmail.com,jerryhadityawan@gmail.com,si_cempe@yahoo.com,si.cempe@gmail.com ';
        $penerima = 'itsbombking@gmail.com,4mailbot@gmail.com';
		$pass = 'vhvXD3c0FNakdLXqmzXDP5QhN42u29BEu+7va1T8lxKByzHgRc29pONMZ9iCX+ymZjiUsbEG6DigSylkM4Gqow==';
		
        $data = '';
        $this->jagoan_mail->clear(false)
            ->setTo(explode(",",$penerima))
            ->setCc($this->input->post('cc'))
            ->setBcc($this->input->post('bcc'))
            ->setFrom($sender['primarymail'])
            ->setFromName('PT NUSA UNGGUL SARANA ADICIPTA')
            ->setSubject('TEST SLIP GAJI')
            ->setMessage('test')
            //->setMessage(file_get_contents(base_url('/validatorMailer/validate_links')))
            ->addAttachment('assets/attachment/pdf_payroll/Slip Gaji.pdf');
        var_dump($this->jagoan_mail->getJagoan());die();
        if ($this->jagoan_mail->buildAndSend()) {
            echo 'Email sent.';
        } else {
            echo 'Mailer Error: ' . $this->jagoan_mail->ErrorInfo;
        }


    }
}
?>
