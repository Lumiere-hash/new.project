<?php
/*
	@author : fiky
	13-10-2016
*/
//error_reporting(0)
class Mailserver extends MX_Controller{

    function __construct(){
        parent::__construct();



		$this->load->model(array('m_mailserver'));
        $this->load->library(array('form_validation','template','upload','encrypt','jagoan_mail'));

		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
		$nama=$this->session->userdata('nik');
		$data['title']="Email Karyawan";

		if($this->uri->segment(4)=="exist")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="send_success")
            $data['message']="<div class='alert alert-success'>Pesan Sudah Dikirim </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';

        $this->template->display('mail/mail/v_mailserver',$data);
    }

	function compose_mail(){
		$data['title']="Email NBI";
		$no_dok='NSANBI';
		$data['dtl_smtp']=$this->m_mailserver->q_smtp($no_dok)->row_array();
		$this->template->display('mail/mail/v_compose_mail',$data);
	}

	function setup_receipients(){
		if($this->uri->segment(4)=="exist")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Kode Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';

		$data['title']="List Email Penerima";
		$data['list_nik']=$this->m_mailserver->karyawan()->result();
		$data['list_receipt']=$this->m_mailserver->q_mailreceipt_list()->result();
		$this->template->display('mail/mail/v_mailreceipients',$data);
	}
	function save_receipt(){
		$nik=$this->input->post('nik');
		$mail_sender=$this->input->post('mail_sender');
		$mail_owner=$this->input->post('mail_owner');
		$type_receipt=$this->input->post('type_receipt');
		$mail_status=$this->input->post('mail_status');
		$mail_hold=$this->input->post('mail_hold');
		$mail_date=date('Y-m-d');
		$inputdate=date('Y-m-d');
		$inputby=$this->session->userdata('nik');
		$info = array(
			'nik' => trim($nik),
			'mail_sender' => trim($mail_sender),
			'mail_owner' => trim($mail_owner),
			'type_receipt' => trim($type_receipt),
			'mail_status' => trim($mail_status),
			'mail_hold' => trim($mail_hold),
			'mail_date' => $mail_date,
			'type_owner' => 'receipients',
			'inputdate' => $inputdate,
			'inputby' => $inputby,
		);

		//$cek=$this->m_mailserver->q_nik_receipt($nik)->num_rows();;
		//if($cek==0){
			$this->db->insert('sc_mst.setup_mail_sender',$info);
			redirect('mail/mailserver/setup_receipients/rep_succes');
		//} else {
		//	redirect('mail/mailserver/setup_receipients/exist');
		//}

	}
	public function json_nik($nik)
	{
		$data = $this->m_mailserver->cekkaryawan($nik)->row();
		echo json_encode($data);
	}
	function receipt_edit($no_dok){
		$data['message']='';
		$data['title']="Edit Penerima Email";
		$data['list_nik']=$this->m_mailserver->karyawan()->result();
		$data['dtl_receipt']=$this->m_mailserver->q_mailreceipt_dtl($no_dok)->row_array();
		$this->template->display('mail/mail/v_editreceipients',$data);
	}
	function save_edit_receipt(){
		$no_dok=$this->input->post('no_dok');
		$nik=$this->input->post('nik');
		$mail_sender=$this->input->post('mail_sender');
		$mail_owner=$this->input->post('mail_owner');
		$type_receipt=$this->input->post('type_receipt');
		$mail_status=$this->input->post('mail_status');
		$mail_hold=$this->input->post('mail_hold');
		$mail_date=date('Y-m-d');
		$updatedate=date('Y-m-d');
		$updateby=$this->session->userdata('nik');
		$info = array(
			'nik' => trim($nik),
			'mail_sender' => trim($mail_sender),
			'mail_owner' => trim($mail_owner),
			'type_receipt' => trim($type_receipt),
			'mail_status' => trim($mail_status),
			'mail_hold' => trim($mail_hold),
			'mail_date' => $mail_date,
			'type_owner' => 'receipients',
			'updatedate' => $updatedate,
			'updateby' => $updateby,
		);
			$this->db->where('no_dok',$no_dok);
			$this->db->update('sc_mst.setup_mail_sender',$info);
			$this->db->query("update sc_mst.karyawan set email='$mail_sender' where nik='$nik'");
			redirect('mail/mailserver/setup_receipients/rep_succes');

	}

	function hapus_receipt($no_dok){
		$this->db->where('no_dok',$no_dok);
		$this->db->delete('sc_mst.setup_mail_sender');
		redirect('mail/mailserver/setup_receipients/del_succes');
	}

	function setup_smtp(){
		$data['title']="SETUP SMTP MAIL SERVER";
		if($this->uri->segment(4)=="exist")
            $data['message']="<div class='alert alert-warning'>Kode Sudah Ada</div>";
        else if($this->uri->segment(4)=="rep_succes")
            $data['message']="<div class='alert alert-success'>Email terkirim </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="wrong_format")
            $data['message']="<div class='alert alert-danger'>Format Excel Salah</div>";
        else
            $data['message']='';
		$no_dok='NSANBI';

		$data['dtl_smtp']=$this->m_mailserver->q_smtp($no_dok)->row_array();
		$this->template->display('mail/mail/v_setup_smtp',$data);
	}

	function save_smtp(){
		$protocol=$this->input->post('protocol');
		$smtp_host=$this->input->post('smtp_host');
		$smtp_port=$this->input->post('smtp_port');
		$smtp_user=$this->input->post('smtp_user');
		$smtp_pass=$this->input->post('smtp_pass');
		$mail_type=$this->input->post('mail_type');
		$charset=$this->input->post('charset');
		$no_dok='NSANBI';
		$info = Array(
			'protocol' => trim($protocol),
			'smtp_host' => trim($smtp_host),
			'smtp_port' => trim($smtp_port),
			'smtp_user' => trim($smtp_user),
			'smtp_pass' => $this->encrypt->encode($smtp_pass),
			'mail_type' => trim($mail_type),
			'charset'   => trim($charset)
		);
		$this->db->where('no_dok',$no_dok);
		$this->db->update('sc_mst.setup_mail_smtp',$info);
		redirect('mail/mailserver/setup_smtp/rep_succes');

	}



	function send_mail(){
		$to             = $this->input->post('recipients');
        $subject        = $this->input->post('subject');
        $message        = $this->input->post('textmail');
        $from_name      = 'PT NUSANTARA BUILDING INDUSTRIES';
        $from           = $this->input->post('sender');
		$cc             = $this->input->post('cc');
		$bcc            = $this->input->post('bcc');
        $this->jagoan_mail->send($to, $subject, $message, $from_name, $from, $cc, $bcc, 0);
        redirect("mail/mailserver/index/rep_succes");
		//$data='';

        //$to, $subject, $message, $from_name, $from, $cc, $bcc, $debug = 0

//        $this->email->from($dari, 'PT NUSANTARA BUILDING INDUSTRIES');
//        $this->email->to($penerima);
//        $this->email->cc($cc);
//        $this->email->bcc($bcc);
//        $this->email->subject($subject);
            //$this->email->set_mailtype("html");
            //$this->email->message($this->load->view("leavesession/v_validator_mailer",$data, true));
            ///$this->email->message(file_get_contents(base_url('/gridview/grid_karkon')));
            //$this->email->message(file_get_contents(base_url('/validatorMailer/validate_links')));
			//$this->email->message($textmail);
//		if ($this->email->send()) {
//            echo 'Email sent.';
//        } else {
//            show_error($this->email->print_debugger());
//        }



	}

	function auto_send(){
		/*http://share.pho.to/ noreply_nbi : blocka7a8b9c*/
		$type_auto=$this->input->post('type_receipt');
		$no_dok='NSANBI';
		$penerima=null;
		if($type_auto=='REMDKT'){
			$loopreceiver=$this->m_mailserver->q_mailreceipt_send_kontr()->result();
				foreach($loopreceiver as $lr){
				$penerima.=trim($lr->mail_sender).',';
				}
				$sender=$this->m_mailserver->q_smtp($no_dok)->row_array();
				//$dari=$sender['primarymail'];
				//$subject='TEST MAIL SENDER';
                    $to             = $penerima;
                    $from_name      = 'PT NUSANTARA BUILDING INDUSTRIES';
                    $from           = $sender['primarymail'];
                    $subject        = 'TEST MAIL SENDER';
                    $message        = file_get_contents(base_url('/gridview/grid_karkon'));
                    $this->jagoan_mail->send($to, $subject, $message, $from_name, $from, 0, 0, 0);
					//$this->email->from($dari, 'PT NUSANTARA BUILDING INDUSTRIES');
					//$this->email->to($penerima);
					//$this->email->cc($cc);
					//$this->email->bcc($bcc);
					//$this->email->subject($subject);
					//$this->email->message(file_get_contents(base_url('/gridview/grid_karkon')));

				if ($this->jagoan_mail->send()) {
						echo 'Email sent.';
					} else {
                        echo 'Email not send';
						//show_error($this->email->print_debugger());
				}
			redirect("mail/mailserver/index/send_success");

		} else if ($type_auto='REMDPEN'){
			$loopreceiver=$this->m_mailserver->q_mailreceipt_send_pens()->result();
				foreach($loopreceiver as $lr){
				$penerima.=trim($lr->mail_sender).',';
				}
				$sender=$this->m_mailserver->q_smtp($no_dok)->row_array();

                    $to             = $penerima;
                    $from_name      = 'PT NUSANTARA BUILDING INDUSTRIES';
                    $from           = $sender['primarymail'];
                    $subject        = 'TEST MAIL SENDER';
                    $message        = file_get_contents(base_url('/gridview/grid_karpen'));
                    $this->jagoan_mail->send($to, $subject, $message, $from_name, $from, 0, 0, 0);

					//$this->email->from($dari, 'PT NUSANTARA BUILDING INDUSTRIES');
					//$this->email->to($penerima);
					//$this->email->cc($cc);
					//$this->email->bcc($bcc);
					//$this->email->subject($subject);
					//$this->email->message(file_get_contents(base_url('/gridview/grid_karpen')));

				if ($this->jagoan_mail->send()) {
						echo 'Email sent.';
					} else {
                        echo 'Email not send';
						//show_error($this->email->print_debugger());
				}
			redirect("mail/mailserver/index/send_success");
		}
		else{

		}


/*
		foreach($loopreceiver as $lr){
		$penerima.=trim($lr->mail_sender).',';
		}
		$sender=$this->m_mailserver->q_smtp($no_dok)->row_array();
		$dari=$sender['primarymail'];
		$subject='TEST MAIL SENDER';

			$this->email->from($dari, 'PT NUSANTARA BUILDING INDUSTRIES');
			$this->email->to($penerima);
			//$this->email->cc($cc);
			//$this->email->bcc($bcc);
			$this->email->subject($subject);
			//$this->email->message(file_get_contents(base_url('/gridview/grid_karkon')));

		if ($this->email->send()) {
				echo 'Email sent.';
			} else {
				show_error($this->email->print_debugger());
		}
	redirect("mail/mailserver/index/rep_succes");
	*/
	}

	function tester(){
		echo base_url('/gridview/grid_karkon');
	}


    function send_mail_x(){
        $dari='noreply_nusa@nusaboard.co.id';
        $penerima='itsbombking@gmail.com';
        //$penerima='ikangurame3@gmail.com,gilrandyseptiansyah@gmail.com,jerryhadityawan@gmail.com';
        //$cc=$this->input->post('');
        //$bcc=$this->input->post('');
        //$subject='TEST SLIP GAJI';

        $to             = $penerima;
        $from_name      = 'PT NUSANTARA BUILDING INDUSTRIES';
        $from           = $dari;
        $subject        = 'TEST SLIP GAJI';
        $message        = file_get_contents(base_url('/validatorMailer/validate_links'));
        $this->jagoan_mail->send($to, $subject, $message, $from_name, $from, 0, 0, 0);

//        $this->email->from($dari, 'PT NUSA UNGGUL SARANA ADICIPTA');
//        $this->email->to($penerima);
//        $this->email->cc();
//        $this->email->bcc();
//        $this->email->subject($subject);
//        $this->email->message(file_get_contents(base_url('/validatorMailer/validate_links')));
        if ($this->jagoan_mail->send()) {
            echo 'Email sent.';
        } else {
            echo 'Email not sent.';
            //show_error($this->email->print_debugger());
        }


    }



}
