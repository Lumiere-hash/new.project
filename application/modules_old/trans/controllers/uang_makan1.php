<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Uang_makan extends MX_Controller {
		
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_uang_makan','master/m_akses'));		
		$this->load->library(array('form_validation','template','upload','pdf','Excel_generator'));   				
		if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
	}

	
    function index(){
		$branch=$this->input->post('branch');
		$data['title']="Laporan Absensi Uang Makan";
		$data['kanwil']=$this->m_uang_makan->q_kanwil()->result();
		if($this->uri->segment(4)=="exist_data")
            $data['message']="<div class='alert alert-danger'>Data Sudah Ada</div>";
		else if($this->uri->segment(4)=="add_success")
			$data['message']="<div class='alert alert-success'>Input Data Sukses</div>";	
		else if($this->uri->segment(4)=="fp_success")
			$data['message']="<div class='alert alert-success'>Download Data Sukses</div>";
		$this->template->display('trans/uang_makan/view_filter',$data);
	}	
	    
	function list_um(){
        $data['title']="Laporan Absens Uang Makan";
		$tgl=explode(' - ',$this->input->post('tgl'));	
		$kdcabang=strtoupper(trim($this->input->post('kanwil')));
		if (empty($tgl) or empty($kdcabang)) { redirect('trans/uang_makan'); }
		$awal=date( "Y-m-d", strtotime($tgl[0]) );
		$akhir=date( "Y-m-d", strtotime($tgl[1]) );
		$data['kdcabang']=$kdcabang;
		$data['kanwil']=$this->m_uang_makan->q_kanwil()->result();		
		$data['tgl']=$this->input->post('tgl');
		$data['tgl1']=$awal;
		$data['tgl2']=$akhir;
		$this->db->query("select sc_tmp.pr_hitung_rekap_um('$kdcabang','$awal', '$akhir')");
		$data['list_um']=$this->m_uang_makan->q_uangmakan_absensi($kdcabang,$awal,$akhir)->result();
		$this->template->display('trans/uang_makan/view_absensi',$data);
    }
	
	function pdf(){
		$kdcabang=$this->input->post('kdcabang');		
		$tgl=explode(' - ',$this->input->post('tgl'));	
		if (empty($tgl) or empty($kdcabang)) { redirect('trans/uang_makan'); }		
		$awal=date( "Y-m-d", strtotime($tgl[0]) );
		$akhir=date( "Y-m-d", strtotime($tgl[1]) );	
		$data['tgl1']=$awal;
		$data['tgl2']=$akhir;
		$data['kdcabang']=$kdcabang;
		
		$judul=$this->m_uang_makan->q_kanwil_dtl($kdcabang)->row_array();
		$jdl=$judul['desc_cabang'];
		$data['cabang']=$judul['desc_cabang'];
		$data['list_um']=$this->m_uang_makan->q_uangmakan_absensi($kdcabang,$awal,$akhir)->result();
		
		$this->pdf->load_view('trans/uang_makan/view_pdf',$data);
		$this->pdf->set_paper('A4','potrait');
		$this->pdf->render();		
		$this->pdf->stream("Laporan Absensi $jdl $awal hingga $akhir.pdf");		
		
		//$this->load->view('trans/uang_makan/view_pdf',$data);
	}
	
	public function excel_absensi($kdcabang,$awal,$akhir){
		
		$judul=$this->m_uang_makan->q_kanwil_dtl($kdcabang)->row_array();
		$jdl=$judul['desc_cabang'];
		$datane=$this->m_uang_makan->q_uangmakan_absensi($kdcabang,$awal,$akhir);			
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK','NAMA LENGKAP','DEPARTEMENT','JABATAN','TANGGAL','CHECKTIME','KETERANGAN','UANG MAKAN'));
        $this->excel_generator->set_column(array('nik','nmlengkap','nmdept','nmjabatan','tglhari','checktime','keterangan','nominalrp'));
        $this->excel_generator->set_width(array(12,25,25,25,25,25,25,25));
        $this->excel_generator->exportTo2007("Laporan Absensi $jdl $awal hingga $akhir.pdf");
	}
	
	
	
	
	function tarik(){
		$data['title']="Tarik Data Absensi";
		$data['fingerprintwil']=$this->m_uang_makan->q_idfinger()->result();
		$this->template->display('hrd/absensi/view_tarikfp',$data);
	}

	
	function add_finger(){
		$idfinger=$this->input->post('fingerid');
		$wil=strtoupper($this->input->post('wilayah'));
		$ip=$this->input->post('ipaddress');
		$cek=$this->m_hrd->cek_finger($idfinger,$ip,$wil);		
		echo $cek->num_rows();
		/*
		if($cek->num_rows()>0){
			echo 'aa';
			//redirect('hrd/absensi/index/exist_data');
		} else {
		*/
		$info_finger=array( 'fingerid'=>$idfinger,
							'wilayah'=>$wil,
							'ipaddress'=>$ip
					);
		$this->m_hrd->simpan_finger($info_finger);
		redirect('hrd/absensi/index/add_success');
		/*
		}
		*/
	}
	function edit_finger(){
		$idfinger=$this->input->post('fingerid');
		$wil=strtoupper($this->input->post('wilayah'));
		$ip=$this->input->post('ipaddress');
		$info_finger=array( 'fingerid'=>$idfinger,
							'wilayah'=>$wil,
							'ipaddress'=>$ip
					);
		$this->m_hrd->edit_finger($info_finger,$ip);
		redirect('hrd/absensi/index/add_success');
	}
	

	
	function tarik_userfp($ipne){
		$branch=$this->input->post('branch');
		$data['title']="Tarik Data Absensi";		
		//$ipne='192.168.0.222';
		$aq=$this->absen->tarik($ipne);
		if (empty($aq)) {
			redirect('hrd/absensi/index/fp_success');
		} else {
			redirect('hrd/absensi/index/fp_gagal');
		}		
	}
	
	function tarik_logfp($ipne){
		$branch=$this->input->post('branch');
		$data['title']="Tarik Data Absensi";		
		//$ipne='192.168.0.222';
		$aq=$this->absen->logfp($ipne);
		exec("ping -n 4 $ipne 2>&1", $output, $retval);
		if ($retval != 0) { 
			echo "DISCONNECT!"; 
			redirect('hrd/absensi/index/fp_gagal');
		} 
		else 
		{ 
			echo "CONNECTED!";
			redirect('hrd/absensi/index/fp_success');
		}
		/*
		if (empty($aq)) {
			redirect('hrd/absensi/index/fp_success');
		} else {
			redirect('hrd/absensi/index/fp_gagal');
		}
		*/
	}
	

	
	function cek_koneksifp(){		
		$ip ="192.168.0.221"; 
		//$_SERVER["192.168.0.222"];
		//exec("ping -n 4 $ip 2>&1", $output, $retval);
		exec("ping $ip ", $output, $retval);
		if ($retval != 0) { 
		echo "DISCONNECT!"; 
		} 
		else 
		{ 
		echo "CONNECTED!"; }		
	}
	
	public function excel07(){
		$datane=$this->m_rkap->q_absensi($branch,$awal,$akhir);				
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('nama','checktime'));
        $this->excel_generator->set_column(array('nama','checktime'));
        $this->excel_generator->set_width(array(10,15));
        $this->excel_generator->exportTo2007('Laporan Absensi');
	}	
	
}
