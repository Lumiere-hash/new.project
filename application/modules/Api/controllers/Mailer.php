<?php defined('BASEPATH') or exit('No direct script access allowed');

class Mailer extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array('payroll/m_final', 'mail/m_mailserver','Api/m_setup','Api/m_cabang'));
        $this->load->library(array('Fiky_encryption', 'Fiky_mailer', 'pdfs'));
    }

    function index()
    {
        header($_SERVER['SERVER_PROTOCOL'] . ' 500 Internal Server Error', true, 500);
    }

    function capitalize($str)
    {
        $words = explode(' ', $str);
        $capitalized = array_map('ucfirst', array_map('strtolower', $words));
        return implode(' ', $capitalized);
    }

    function formatIDR($number)
    {
        return number_format($number, 0, ',', '.');
    }


    function send_mail_jagoan($title = 'Judul', $mailto = '4mailbot@gmail.com,bagoswahyus486@gmail.com,fornubi2020@gmail.com',$message='<h1>Important message use this as tester</h1>', $attachment = null)
    {
        $this->load->library(array('jagoan_mail'));
        $sender = $this->m_mailserver->q_smtp("NSANBI")->row_array();
        $dari = $sender['primarymail'];
        $subject = $title;
        $this->jagoan_mail->clear(false)
            ->setTo(explode(",", $mailto))
            ->setFrom($sender['primarymail'])
            ->setFromName('PT SINAR NUSANTARA INDUSTRIES')
            ->setSubject($subject)
            ->setMessage($message);
//            ->addAttachment('assets/attachment/pdf_payroll/Slip Gaji.pdf');
        if ($this->jagoan_mail->buildAndSend()) {
            return true;
        } else {
            echo 'Mailer Error: ' . $this->jagoan_mail->ErrorInfo;
        }
    }

     function send_mail_agenda($title = 'test', $mailto = 'iqbalkresna.12@gmail.com',$message='<h1>Important message use this as tester</h1>', $attachment = null)
    {
        $this->load->library(array('jagoan_mail'));
        $sender = $this->m_mailserver->q_smtp("NSANBI")->row_array();
        $dari = $sender['primarymail'];
        $subject = $title;
        $this->jagoan_mail->clear(false)
            ->setTo(explode(",", $mailto))
            ->setFrom($sender['primarymail'])
            ->setFromName('PT NUSA UNGGUL SARANA ADICIPTA')
            ->setSubject($subject)
            ->setMessage($message);
//            ->addAttachment('assets/attachment/pdf_payroll/Slip Gaji.pdf');
        if ($this->jagoan_mail->buildAndSend()) {
            return true;
        } else {
            echo 'Mailer Error: ' . $this->jagoan_mail->ErrorInfo;
        }
    }


    



}