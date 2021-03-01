<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Ijin_karyawan extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model(array('m_ijin_karyawan','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		//redirect(trans/ijin_karyawan/index);
		$nama=$this->session->userdata('nik');
		$data['title']="List Ijin Karyawan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve Atau Sudah Dibatalkan</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		 else if($this->uri->segment(4)=="app_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Di Approve </div>";
		 else if($this->uri->segment(4)=="cancel_succes")
			$data['message']="<div class='alert alert-danger'>Dokumen Dibatalkan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
        else
            $data['message']='';
		//$nik=$this->uri->segment(4);

		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$status1=$this->input->post('status');

		if (empty($thn) and empty($status1)){
			$tahun=date('Y'); $bulan=date('m'); 
			$tgl=$bulan.$tahun;
			$status='is not NULL';
			
		} 
		else if (empty($status1)){
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
			$status='is not NULL';
			
		}
		else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
			$status="='$status1'";
		}
		switch ($bulan){
			case '01': $bul='Januari'; break;
			case '02': $bul='Februari'; break;
			case '03': $bul='Maret'; break;
			case '04': $bul='April'; break;
			case '05': $bul='Mei'; break;
			case '06': $bul='Juni'; break;
			case '07': $bul='Juli'; break;
			case '08': $bul='Agustus'; break;
			case '09': $bul='September'; break;
			case '10': $bul='Oktober'; break;
			case '11': $bul='November'; break;
			case '12': $bul='Desember'; break;
		}
		
		//echo $status;
		
		$kmenu='I.T.B.4';
		$nama=$this->session->userdata('nik');
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();	
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();	
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();	
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();	

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
	
		if(($userhr>0 or $level_akses=='A')){
			$nikatasan='';	
		} 
		else if (($ceknikatasan1)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$nikatasan="where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or x1.nik='$nama'";	
			
		}
		else if (($ceknikatasan2)>0 and $userhr==0 and ($level_akses=='B' OR $level_akses=='C' OR $level_akses=='D')){
			$nikatasan="where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or x1.nik='$nama'";	
		}
		else {
			$nikatasan="where x1.nik='$nama'";
		} 
		$data['nama']=$nama;
		$data['userhr']=$userhr; 
		$data['level_akses']=$level_akses;
		/* END APPROVE ATASAN */
		
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$data['list_ijin_karyawan']=$this->m_ijin_karyawan->q_ijin_karyawan($tgl,$nikatasan,$status)->result();
		$data['list_ijin']=$this->m_ijin_karyawan->list_ijin()->result();
		
        $this->template->display('trans/ijin_karyawan/v_list',$data);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		
		$data['title']="List Karyawan";
		//$data['list_karyawan']=$this->m_ijin_karyawan->list_karyawan()->result();
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		
		if($userhr>0 or $level_akses=='A'){
			$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		} else{
			$data['list_karyawan']=$this->m_akses->list_akses_alone()->result();
		}
		 	
		
		$data['list_ijin']=$this->m_ijin_karyawan->list_ijin()->result();
		//$data['list_lk2']=$this->m_ijin_karyawan->list_karyawan_index($nik)->row_array();
		//$data['list_lk']=$this->m_ijin_karyawan->list_karyawan_index()->result();
		$this->template->display('trans/ijin_karyawan/v_list_karyawan',$data);
	}
	
	function proses_input($nik){
		$data['title']="Input Ijin Karyawan";
		if($this->uri->segment(5)=="input_failed"){			
			$data['message']="<div class='alert alert-danger'>Data Sudah Ada/Pernah Di Input</div>";
		}
		else {
			$data['message']='';
		}
		
		$nama=$this->session->userdata('nik');
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		
		$data['list_lk']=$this->m_ijin_karyawan->list_karyawan_index($nik)->result();
		if($userhr>0){
			$data['list_ijin']=$this->m_ijin_karyawan->list_ijin()->result();
		} else{
			$data['list_ijin']=$this->m_ijin_karyawan->list_ijin_khusus()->result();
		}
		
		//$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		$this->template->display('trans/ijin_karyawan/v_input',$data);
	}
	
	function add_ijin_karyawan(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		//$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdijin_absensi=$this->input->post('kdijin_absensi');
		$tgl_kerja1=$this->input->post('tgl_kerja');
		
		if ($tgl_kerja1==''){
			$tgl_kerja=NULL;
		} else {
			$tgl_kerja=$tgl_kerja1;
		}
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		
		$jam_awal1=$this->input->post('jam_awal');
		if ($jam_awal1==''){
			$jam_awal=NULL;
		} else {
			$jam_awal=$jam_awal1;
		}
		$jam_selesai1=$this->input->post('jam_selesai');
		if ($jam_selesai1==''){
			$jam_selesai=NULL;
		} else {
			$jam_selesai=$jam_selesai1;
		}
		$durasi=$jam_selesai-$jam_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		$keterangan=$this->input->post('keterangan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$ktgijin=$this->input->post('ktgijin');
		
		//echo $gaji_bpjs;
		$info=array(
			'nik'=>$nik,
			'nodok'=>$this->session->userdata('nik'),
			'kddept'=>strtoupper($kddept),
			'kdsubdept'=>strtoupper($kdsubdept),
			'durasi'=>$durasi,
			'kdjabatan'=>$kdjabatan,
			'kdlvljabatan'=>strtoupper($kdlvljabatan),
			'kdjabatan'=>strtoupper($kdjabatan),
			'nmatasan'=>$atasan,
			'tgl_dok'=>$tgl_dok,
			'kdijin_absensi'=>strtoupper($kdijin_absensi),
			'tgl_kerja'=>$tgl_kerja,
			'tgl_jam_mulai'=>$jam_awal,
			'tgl_jam_selesai'=>$jam_selesai,
			'keterangan'=>strtoupper($keterangan),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
			'type_ijin'=>strtoupper($ktgijin),
		);
		//echo $durasi;
		//$this->db->where('custcode',$kode);
		/*$cek=$this->m_ijin_karyawan->q_ijin_karyawan($nik,$kdpengalaman)->num_rows();
		if ($cek>0){
			redirect('master/bpjskaryawan/index/kode_failed');
		} else {
			$this->db->insert('sc_mst.bpjs_karyawan',$info);
			redirect('master/bpjskaryawan/index/rep_succes');
		}*/
		$cek=$this->m_ijin_karyawan->cek_double($nik,$tgl_kerja)->num_rows();
		if ($cek>0){
			redirect("trans/ijin_karyawan/proses_input/$nik/input_failed");
		} else {
			$this->db->insert('sc_tmp.ijin_karyawan',$info);
			redirect("trans/ijin_karyawan/index/rep_succes");
		}
		
		
	}
	
	
	function edit($nodok){
		//echo "test";
	
		$data['title']='EDIT DATA IJIN KARYAWAN';			
		if($this->uri->segment(5)=="upsuccess"){			
			$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
		}
		else {
			$data['message']='';
		}
		
	
		$data['list_ijin']=$this->m_ijin_karyawan->list_ijin()->result();
		$data['list_ijin_karyawan_dtl']=$this->m_ijin_karyawan->q_ijin_karyawan_dtl($nodok)->result();
		
		$this->template->display('trans/ijin_karyawan/v_edit',$data);
	
	}
	
	function detail($nodok){
		//echo "test";
	
		$data['title']='DETAIL DATA IJIN KARYAWAN';			
		$data['list_ijin']=$this->m_ijin_karyawan->list_ijin()->result();
		$data['list_ijin_karyawan_dtl']=$this->m_ijin_karyawan->q_ijin_karyawan_dtl($nodok)->result();
		$this->template->display('trans/ijin_karyawan/v_detail',$data);
			
	}
	function edit_ijin_karyawan(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdijin_absensi=$this->input->post('kdijin_absensi');
		$tgl_kerja1=$this->input->post('tgl_kerja');
		if ($tgl_kerja1==''){
			$tgl_kerja=NULL;
		} else {
			$tgl_kerja=$tgl_kerja1;
		}
		/*$durasi1=$this->input->post('durasi');
		if ($durasi1==''){
			$durasi=NULL;
		} else {
			$durasi=$durasi1;
		}*/
		$jam_awal=$this->input->post('jam_awal');
		$jam_selesai=$this->input->post('jam_selesai');
		$durasi=$jam_selesai-$jam_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		$keterangan=$this->input->post('keterangan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//$no_urut=$this->input->post('no_urut');
		
		$info=array(
			//'nodok'=>strtoupper($nodok),
			
			'durasi'=>$durasi,
			'kdijin_absensi'=>strtoupper($kdijin_absensi),
			'tgl_kerja'=>$tgl_kerja,
			'tgl_jam_mulai'=>$jam_awal,
			'tgl_jam_selesai'=>$jam_selesai,
			'keterangan'=>strtoupper($keterangan),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
		$cek=$this->m_ijin_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_ijin_karyawan->cek_dokumen2($nodok)->num_rows();
			//if ($cek>0 or $cek2>0) {
			if ($cek2>0) {
				redirect("trans/ijin_karyawan/index/kode_failed");
			} else {
			$this->db->where('nodok',$nodok);
			//$this->db->where('nik',$nik);
			//$this->db->where('kdpengalaman',$kdpengalaman);
			$this->db->update('sc_trx.ijin_karyawan',$info);
			redirect("trans/ijin_karyawan/edit/$nodok/upsuccess");
			}
			
		
		//echo $inputby;
	}
	
	function hps_ijin_karyawan($nodok){
		$cek=$this->m_ijin_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_ijin_karyawan->cek_dokumen2($nodok)->num_rows();
			//if ($cek>0 or $cek2>0) {
			if ($cek2>0) {
				redirect("trans/ijin_karyawan/index/kode_failed");
			} else {
				$this->db->where('nodok',$nodok);
				$this->db->delete('sc_trx.ijin_karyawan');
				redirect("trans/ijin_karyawan/index/del_succes");
			}
		
		
	}
	
	function approval($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//echo $nik;
		//echo $nodok;
		$cek=$this->m_ijin_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_ijin_karyawan->cek_dokumen2($nodok)->num_rows();
			if ($cek>0 or $cek2>0) {
				redirect("trans/ijin_karyawan/index/kode_failed");
			} else {
			$this->m_ijin_karyawan->tr_app($nodok,$inputby,$tgl_input);	
			redirect("trans/ijin_karyawan/index/app_succes");
			}
	}
	
	
	function cancel($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		//echo $nik;
		//echo $nodok;
		$cek=$this->m_ijin_karyawan->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_ijin_karyawan->cek_dokumen2($nodok)->num_rows();
			if ($cek>0 or $cek2>0) {
				redirect("trans/ijin_karyawan/index/kode_failed");
			} else {
				$this->m_ijin_karyawan->tr_cancel($nodok,$inputby,$tgl_input);	
				redirect("trans/ijin_karyawan/index/cancel_succes");
			}
	}
}	