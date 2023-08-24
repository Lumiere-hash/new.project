<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Lembur extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		       
		$this->load->model('m_lembur');
        $this->load->library(array('form_validation','template','upload','pdf')); 
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";
		
		
		$nik=$this->session->userdata('nik');
		$data['title']="List Lembur Karyawan";
		
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>No Dokumen Sudah Di Approve Atau Sudah Di Batalkan</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Dokumen Sukses Disimpan </div>";
		else if($this->uri->segment(4)=="del_succes")
            $data['message']="<div class='alert alert-success'>Delete Succes</div>";
		else if($this->uri->segment(4)=="app_succes")
            $data['message']="<div class='alert alert-success'>Approve Succes</div>";
		else if($this->uri->segment(4)=="edit_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Diubah</div>";
		else if($this->uri->segment(4)=="cancel_succes")
            $data['message']="<div class='alert alert-danger'>Data Berhasil Dibatalkan</div>";
        else
            $data['message']='';
		//$nik=$this->uri->segment(4);
		//$data['nik']=$nik;
		
		//$data['list_lk']=$this->m_lembur->list_karyawan_index($nik)->row_array();
		
		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');		
		$status1=$this->input->post('status');		
		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
			$status='is not NULL';
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
			//$status="='$status1'";
			if ($status1==""){
				$status='is not NULL';
			} else {
				$status="='$status1'";
			}
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
		
		$cek2=$this->m_lembur->cek_position($nik)->num_rows();
		
		if ($cek2<=0){
			$position='IT';
		
		} else {
			$cek=$this->m_lembur->cek_position($nik)->row_array();
			$position=trim($cek['bag_dept']);
		}
		
		$data['position']=$position;
		$data['list_lembur_edit']=$this->m_lembur->list_lembur()->result();
		$data['list_lembur']=$this->m_lembur->q_lembur($tgl,$status)->result();
		$data['list_lembur_dtl']=$this->m_lembur->q_lembur_dtl()->result();
		$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		//$data['list_lembur']=$this->m_lembur->list_lembur()->result();
		//$data['list_rk']=$this->m_lembur->q_lembur($nik)->row_array();
		
        $this->template->display('trans/lembur/v_list',$data);
		
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";
		
		$data['title']="List Karyawan";
		$data['list_karyawan']=$this->m_lembur->list_karyawan()->result();
		$data['list_lembur']=$this->m_lembur->list_lembur()->result();
		$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		//$data['list_lk2']=$this->m_lembur->list_karyawan_index($nik)->row_array();
		//$data['list_lk']=$this->m_lembur->list_karyawan_index()->result();
		$this->template->display('trans/lembur/v_list_karyawan',$data);
	}
	
	
	function proses_input($nik){
		$data['title']="List Karyawan";
		$data['list_lk']=$this->m_lembur->list_karyawan_index($nik)->result();
		$data['list_lembur']=$this->m_lembur->list_lembur()->result();
		$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		$this->template->display('trans/lembur/v_input',$data);
	}
	
	
	function add_lembur(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$nodok=$this->session->userdata('nik');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdlembur=$this->input->post('kdlembur');
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
		$jam_awal=str_replace("_","",$this->input->post('jam_awal'));
		$jam_selesai=str_replace("_","",$this->input->post('jam_selesai'));
		$durasi_istirahat=str_replace("_","",$this->input->post('durasi_istirahat'));
		//$durasi=$jam_selesai-$jam_awal;
		$tgl_dok=$this->input->post('tgl_dok');
		$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$jenis_lembur=$this->input->post('jenis_lembur');
		
		
		//echo $gaji_bpjs;
		$info=array(
			'nik'=>$nik,
			'nodok'=>strtoupper($nodok),
			'kddept'=>strtoupper($kddept),
			'kdsubdept'=>strtoupper($kdsubdept),
			//'durasi'=>$durasi,
			'durasi_istirahat'=>$durasi_istirahat,
			'kdjabatan'=>$kdjabatan,
			'kdlvljabatan'=>strtoupper($kdlvljabatan),
			'kdjabatan'=>strtoupper($kdjabatan),
			'nmatasan'=>$atasan,
			'tgl_dok'=>$tgl_dok,
			'kdlembur'=>$kdlembur,
			'tgl_kerja'=>$tgl_kerja,
			'tgl_jam_mulai'=>$jam_awal,
			'tgl_jam_selesai'=>$jam_selesai,
			'kdtrx'=>strtoupper($kdtrx),
			'jenis_lembur'=>strtoupper($jenis_lembur),
			'keterangan'=>strtoupper($keterangan),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);
		
		//echo $durasi;
		$this->db->insert('sc_tmp.lembur',$info);
		redirect("trans/lembur/index/rep_succes");
		
	}
	
	function edit($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/lembur/index/$nik");
		} else {
			$data['title']='EDIT DATA RIWAYAT KELUARGA';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$nik=$this->uri->segment(4);
			$data['nik']=$nik;
			$data['list_bpjs']=$this->m_bpjs->list_jnsbpjs()->result();	
			$data['list_bpjskomponen']=$this->m_bpjs->list_bpjskomponen()->result();
			$data['list_bpjskaryawan']=$this->m_bpjs->q_bpjs_karyawan()->result();
			$data['list_faskes']=$this->m_bpjs->list_faskes()->result();
			$data['list_kelas']=$this->m_bpjs->q_trxtype()->result();
			$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
			$data['list_keluarga']=$this->m_lembur->list_keluarga()->result();
			$data['list_negara']=$this->m_lembur->list_negara()->result();
			$data['list_prov']=$this->m_lembur->list_prov()->result();
			$data['list_kotakab']=$this->m_lembur->list_kotakab()->result();
			$data['list_jenjang_keahlian']=$this->m_lembur->list_jenjang_keahlian()->result();
			$data['list_rk']=$this->m_lembur->q_lembur_edit($nik,$nodok)->row_array();
			$this->template->display('trans/lembur/v_edit',$data);
		}	
	}
	
	function detail($nik,$no_urut){
		//echo "test";
		
		if (empty($no_urut)){
			redirect("trans/lembur/index/$nik");
		} else {
			$data['title']='DETAIL DATA RIWAYAT PENGALAMAN KERJA';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$nik=$this->uri->segment(4);
			$data['nik']=$nik;
			
			$data['list_karyawan']=$this->m_bpjs->list_karyawan()->result();
			$data['list_rk']=$this->m_lembur->q_lembur_edit($nik,$nodok)->row_array();
			$this->template->display('trans/lembur/v_detail',$data);
		}	
	}
	function edit_lembur(){
		//$nik1=explode('|',);
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$kddept=$this->input->post('department');
		$kdsubdept=$this->input->post('subdepartment');
		$kdjabatan=$this->input->post('jabatan');
		$kdlvljabatan=$this->input->post('kdlvl');
		$atasan=$this->input->post('atasan');
		$kdlembur=$this->input->post('kdlembur');
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
		$jam_awal=str_replace("_","",$this->input->post('jam_awal'));
		$jam_selesai=str_replace("_","",$this->input->post('jam_selesai'));
		$durasi_istirahat=str_replace("_","",$this->input->post('durasi_istirahat'));
		$kdtrx=$this->input->post('kdtrx');
		$tgl_dok=$this->input->post('tgl_dok');
		$keterangan=$this->input->post('keterangan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$jenis_lembur=$this->input->post('jenis_lembur');
		//$no_urut=$this->input->post('no_urut');
		
		$info=array(
			//'nodok'=>strtoupper($nodok),
			
			'durasi_istirahat'=>$durasi_istirahat,
			'kdlembur'=>$kdlembur,
			'tgl_kerja'=>$tgl_kerja,
			'tgl_jam_mulai'=>$jam_awal,
			'tgl_jam_selesai'=>$jam_selesai,
			'kdtrx'=>strtoupper($kdtrx),
			'keterangan'=>strtoupper($keterangan),
			'jenis_lembur'=>strtoupper($jenis_lembur),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);
		
			$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
			$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
			if ($cek>0 or $cek2>0) {
				redirect("trans/lembur/index/kode_failed");
			} else {
				$this->db->where('nodok',$nodok);			
				$this->db->update('sc_trx.lembur',$info);
				$this->db->query("update sc_trx.lembur set status='U' where nodok='$nodok'");
				redirect("trans/lembur/index/edit_succes");
			}
		
		
		//echo $inputby;
	}
	
	function hps_lembur($nodok){
		//$this->db->where('nodok',$nodok);
		$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
		$info=array(
			'status'=>'D',
		);
		
		/*if ($cek>0 or $cek2>0) {
			redirect("trans/lembur/index/kode_failed");
		} else {
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.lembur',$info);
			redirect("trans/lembur/index/del_succes");
		}*/
		
		$this->db->where('nodok',$nodok);
		$this->db->update('sc_trx.lembur',$info);
		redirect("trans/lembur/index/del_succes");
		
	}
	
	function approval($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
			if ($cek>0) {
				redirect("trans/lembur/index/kode_failed");
			} else if ($cek2>0){
				redirect("trans/lembur/index/kode_failed");
			} else {
				$this->m_lembur->tr_app($nodok,$inputby,$tgl_input);	
				redirect("trans/lembur/index/app_succes");
			}
		//echo $cek2;
	}
	
	function cancel($nik,$nodok){
		$nik=$this->input->post('nik');
		$nodok=$this->input->post('nodok');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
		$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
		if ($cek>0) {
				redirect("trans/lembur/index/kode_failed");
			} else if ($cek2>0){
				redirect("trans/lembur/index/kode_failed");
			} else {
				$this->m_lembur->tr_cancel($nodok,$inputby,$tgl_input);	
				redirect("trans/lembur/index/cancel_succes");
			}
		
	}
}	