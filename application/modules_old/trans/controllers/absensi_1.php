<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi extends MX_Controller {
		
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model(array('m_absensi','master/m_akses'));		
		$this->load->library(array('form_validation','template','upload','pdf','Excel_generator')); 				
		if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
	}
	
	function filter(){
		$data['title']='Tarikan Data Mesin Absensi'; //aksesconvert absensi
		$kmenu='I.T.B.6';
		$nama=$this->session->userdata('nik');
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$tglakhir1=$this->m_absensi->tglakhir_ci()->row_array();
		$tglakhir=$tglakhir1['tglakhir'];
		$data['tglakhir']=$tglakhir;
		$this->template->display('trans/absensi/v_filterabsensi',$data);
	}
	
	function filter_lembur(){
		$data['title']='Filter Data Lembur';
		$this->template->display('trans/absensi/v_filterlembur',$data);
	}
	
	function filter_koreksi(){
		if($this->uri->segment(4)=="rep_succes"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
		} elseif ($this->uri->segment(4)=="exist"){
			$data['message']="<div class='alert alert-warning'>Data Sudah Ada </div>";
		}
		else {
			$data['message']='';
		}
		
		$kmenu='I.T.B.7'; //aksesupdate koreksi absensi
		$nama=$this->session->userdata('nik');
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$data['title']='Filter Koreksi Data Absensi';
		$data['list_karyawan']=$this->m_absensi->q_karyawan()->result();
		$data['list_regu']=$this->m_absensi->q_regu()->result();
		$data['list_dept']=$this->m_absensi->q_department()->result();
	
		$this->template->display('trans/absensi/v_filterkoreksi',$data);
	}
	
	function filter_detail(){
		$kmenu='I.T.B.9'; //aksesview dan akses download absensi
		$nama=$this->session->userdata('nik');
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$data['title']='Filter Detail Data Absensi';
		$data['list_karyawan']=$this->m_absensi->q_karyawan()->result();
		$data['list_regu']=$this->m_absensi->q_regu()->result();
		$data['list_dept']=$this->m_absensi->q_department()->result();
		$this->template->display('trans/absensi/v_filterdtlabsensi',$data);
	}
	
	function filter_input(){
		if($this->uri->segment(4)=="kode_failed")
            $data['message']="<div class='alert alert-warning'>Absensi Gagal Disimpan</div>";
        else if($this->uri->segment(4)=="rep_succes")
			$data['message']="<div class='alert alert-success'>Absensi Sukses Disimpan </div>";
        else
            $data['message']='';
		$data['title']='DETAIL SIMPAN TRANSREADY';
		$kmenu='I.T.B.10'; //akses view transready
		$nama=$this->session->userdata('nik');
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$data['list_karyawan']=$this->m_absensi->q_karyawan()->result();
		$tglakhir1=$this->m_absensi->tglakhir_tr()->row_array();
		$tglakhir=$tglakhir1['tglakhir'];
		$data['tglakhir']=$tglakhir;
		$this->template->display('trans/absensi/v_filtertarik',$data);
	}
	
	public function index()
	{
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tgla=$tgl[0].' 00:00:00';
		$tglb=$tgl[1].' 23:59:59';
		//echo date('m-d-Y H:i:s',strtotime($tgl1)).'<br>';
		//echo date('m-d-Y H:i:s',strtotime($tgl2));
		$tgl1=date('m-d-Y H:i:s',strtotime($tgla));		
		$tgl2=date('m-d-Y H:i:s',strtotime($tglb));		
		if (empty($tanggal)){
			redirect('trans/absensi/filter');
		}
						
		$data['ttldata']=$this->m_absensi->ttldata($tgl1,$tgl2)->row_array();
		$data['title']="DATA MESIN ABSEN $tgla hingga $tglb";		
		$data['tgl1']=$tgla;		
		$data['tgl2']=$tglb;		
		$data['message']='';		
		$data['list_absen']=$this->m_absensi->show_user($tgl1,$tgl2)->result();		
		$this->template->display('trans/absensi/v_absensi',$data);
	}
	
	public function lembur()
	{
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tgla=$tgl[0].' 00:00:00';
		$tglb=$tgl[1].' 23:59:59';
		//echo date('m-d-Y H:i:s',strtotime($tgl1)).'<br>';
		//echo date('m-d-Y H:i:s',strtotime($tgl2));
		$tgl1=date('m-d-Y H:i:s',strtotime($tgla));		
		$tgl2=date('m-d-Y H:i:s',strtotime($tglb));		
		if (empty($tanggal)){
			redirect('trans/absensi/filter_lembur');
		}
						
		$data['ttldata']=$this->m_absensi->ttldata_lembur($tgl1,$tgl2)->row_array();
		$data['title']="DATA MESIN ABSEN $tgla hingga $tglb";		
		$data['tgl1']=$tgla;		
		$data['tgl2']=$tglb;		
		$data['message']='';		
		$data['list_lembur']=$this->m_absensi->show_user_lembur($tgl1,$tgl2)->result();		
		$this->template->display('trans/absensi/v_lembur',$data);
	}
	
	public function absen_mesin()
	{
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tgl1=$tgl[0].' 00:00:00';
		$tgl2=$tgl[1].' 23:59:59';
				
		if (empty($tanggal)){
			redirect('trans/absensi/filter');
		}					
		$data['ttldata']=$this->m_absensi->ttldata($tgl1,$tgl2)->row_array();
		$data['title']="DATA MESIN ABSEN $tgl1 hingga $tgl2";		
		$data['tgl1']=$tgl1;		
		$data['tgl2']=$tgl2;		
		$data['message']='';		
		$data['list_absen']=$this->m_absensi->show_user($tgl1,$tgl2)->result();		
		$this->template->display('trans/absensi/v_absensi',$data);
	}
	
	
	
	function tarik_data(){
		$tgla=$this->input->post('tgl1');
		$tglb=$this->input->post('tgl2');
		$tgl1=date('m-d-Y H:i:s',strtotime($tgla));		
		$tgl2=date('m-d-Y H:i:s',strtotime($tglb));	
		$tglawal=date('Y-m-d',strtotime($tgla));	
		$tglakhir=date('Y-m-d',strtotime($tglb));	
		//$tgl1='17-01-2016';
		//$tgl2='18-01-2016';		
		$datane=$this->m_absensi->show_user($tgl1,$tgl2)->result();
		
		foreach ($datane as $dta){					
			$info=array(
				'userid'=>$dta->USERID,
				'badgenumber'=>$dta->Badgenumber,
				'nama'=>$dta->Name,
				'checktime'=>$dta->CHECKTIME,
				'inputan'=>'M',
				'inputby'=>$this->session->userdata('nik')
			);
			$this->m_absensi->simpan($info);			
		}
		
		$txt='select sc_tmp.update_badgenumber('.chr(39).$tglawal.chr(39).','.chr(39).$tglakhir.chr(39).')';
		$this->db->query($txt);
		echo json_encode(array("status" => TRUE));
	}
	
	function tarik_data_lembur(){
		$tgla=$this->input->post('tgl1');
		$tglb=$this->input->post('tgl2');
		$tgl1=date('m-d-Y H:i:s',strtotime($tgla));		
		$tgl2=date('m-d-Y H:i:s',strtotime($tglb));	
		//$tgl1='17-01-2016';
		//$tgl2='18-01-2016';		
		$datane=$this->m_absensi->show_user_lembur($tgl1,$tgl2)->result();
		
		foreach ($datane as $dta){					
			$info=array(
				'userid'=>$dta->USERID,
				'badgenumber'=>$dta->Badgenumber,
				'nama'=>$dta->Name,
				'checktime'=>$dta->CHECKTIME,
				'inputan'=>'M',
				'inputby'=>$this->session->userdata('nik')
			);
			$this->m_absensi->simpan_lembur($info);			
		}
		echo json_encode(array("status" => TRUE));
	}
	
	function input_data(){
		$tanggal=$this->input->post('tgl');
		
		$tgl=explode(' - ',$tanggal);
		$tglawal1=$tgl[0];
		$tglakhir1=$tgl[1];
		$tglawal=date('Y-m-d',strtotime($tglawal1));
		$tglakhir=date('Y-m-d',strtotime($tglakhir1));
		
		/*$datane=$this->m_absensi->q_loopingjadwal($tglawal,$tglakhir)->result();

		
		foreach ($datane as $dta){					
			
			$nik=$dta->nik;
			$tgl1=$dta->tgl_min_masuk;
			$tgl2=$dta->tgl_max_pulang;
			$cari_absen=$this->m_absensi->q_caricheckinout($nik,$tgl1,$tgl2)->row_array();
			if (empty($cari_absen['tgl_min']) and empty($cari_absen['tgl_max'])) {
				$jam_min=NULL;
				$jam_max=NULL;
			} else {
				$jam_min=$cari_absen['tgl_min'];
				$jam_max=$cari_absen['tgl_max'];
			}
			$info_absen=array(
				
				'nik'=>$dta->nik,
				'kdjamkerja'=>$dta->kdjamkerja,
				'tgl'=>$dta->tgl,
			
				'shiftke'=>$dta->shiftke,
				
				'jam_masuk'=>$dta->jam_masuk,
				'jam_masuk_min'=>$dta->jam_masuk_min,
				
				'jam_pulang'=>$dta->jam_pulang,
				//'jam_pulang_min'=>$dta->jam_pulang_min,
				'jam_pulang_min'=>$dta->jam_pulang_min,
				'jam_pulang_max'=>$dta->jam_pulang_max,
				'kdhari_masuk'=>$dta->kdharimasuk,
				'kdhari_pulang'=>$dta->kdharipulang,
				'jam_masuk_absen'=>$jam_min,
				'jam_pulang_absen'=>$jam_max,
			);
			
			
			$this->db->insert('sc_trx.transready',$info_absen);	
			
			
			
		}*/
		$txt='select sc_tmp.pr_generate_transready('.chr(39).$tglawal.chr(39).','.chr(39).$tglakhir.chr(39).')';
		$this->db->query($txt);
		redirect('trans/absensi/filter_input/rep_succes');
	}
	
	function input_data_new(){
		$tanggal=$this->input->post('tgl');
		
		$tgl=explode(' - ',$tanggal);
		$tglawal1=$tgl[0];
		$tglakhir1=$tgl[1];
		$tglawal=date('Y-m-d',strtotime($tglawal1));
		$tglakhir=date('Y-m-d',strtotime($tglakhir1));
		//echo $tglawal.'|'.$tglakhir;
		
		//$tglb=$this->input->post('tgl2');
		//$tgl1=date('m-d-Y H:i:s',strtotime($tgla));		
		//$tgl2=date('m-d-Y H:i:s',strtotime($tglb));	
		//$tgl1='17-01-2016';
		//$tgl2='18-01-2016';		
		$datane=$this->m_absensi->q_loopingjadwal_new($tglawal,$tglakhir)->result();
		//$datane2=$this->m_absensi->q_showjadwal($tgl)->result();
		
		foreach ($datane as $dta){					
			
			$nik=$dta->nik;
			$tgl1=$dta->tgl_min_masuk;
			$tgl2=$dta->tgl_max_pulang;
			$cari_absen=$this->m_absensi->q_caricheckinout($nik,$tgl1,$tgl2)->row_array();
			if (empty($cari_absen['tgl_min']) and empty($cari_absen['tgl_max'])) {
				$jam_min=NULL;
				$jam_max=NULL;
			} else {
				$jam_min=$cari_absen['tgl_min'];
				$jam_max=$cari_absen['tgl_max'];
			}
			$info_absen=array(
				//'userid'=>$dta->userid,
				//'badgenumber'=>$dta->badgenumber,
				//'checktime'=>$dta->checktime,
				'nik'=>$dta->nik,
				'kdjamkerja'=>$dta->kdjamkerja,
				'tgl'=>$dta->tgl,
				//'kdregu'=>$dta->kdregu,
				'shiftke'=>$dta->shiftke,
				//'shift'=>$dta->shift,
				'jam_masuk'=>$dta->jam_masuk,
				'jam_masuk_min'=>$dta->jam_masuk_min,
				//'jam_masuk_max'=>$dta->jam_masuk_max,
				'jam_pulang'=>$dta->jam_pulang,
				//'jam_pulang_min'=>$dta->jam_pulang_min,
				'jam_pulang_min'=>$dta->jam_pulang_min,
				'jam_pulang_max'=>$dta->jam_pulang_max,
				'kdhari_masuk'=>$dta->kdharimasuk,
				'kdhari_pulang'=>$dta->kdharipulang,
				'jam_masuk_absen'=>$jam_min,
				'jam_pulang_absen'=>$jam_max,
			);
			
			/*
			echo $nik.'|';
			echo $jam_min.'|';
			echo $jam_max.'|';
			echo $tgl1.'|';
			echo $tgl2.'<br>';
			*/
			$this->db->insert('sc_trx.transready',$info_absen);	
			
			
			//echo $status;
			//$this->db->insert('sc_trx.transready',$info_absen);
			//$this->db->insert('sc_trx.transready',$status);
			
		}
		//echo 'sukses';
		redirect('trans/absensi/filter_input/rep_succes');
	}
	
	function update_status(){
			$data=$this->m_absensi->q_transready()->result();
			
				foreach ($data as $dta){
					$id=$dta->id;
					$jam=$dta->jam;
					$shiftke=$dta->shiftke;
					$jam_masuk=$dta->jam_masuk;
					$jam_masuk_min=$dta->jam_masuk_min;
					$jam_masuk_max=$dta->jam_masuk_min;
					$jam_pulang=$dta->jam_pulang;
					$jam_pulang_min=$dta->jam_pulang_min;
					$jam_pulang_max=$dta->jam_pulang_max;
					$kdhari_masuk=$dta->kdhari_masuk;
					$kdhari_pulang=$dta->kdhari_pulang;
					$tglcheck=$dta->tglcheck;
					$tgljadwal=$dta->tgljadwal;
					$checktime=$dta->checktime;
					
					//if ($jam>$jam_masuk_min and $jam<$jam_masuk_max) {
						//$status='STATUS MASUK';
					//} 
					if ($shiftke=='3' and $checktime>$tgljadwal and $jam<$jam_pulang) {
						$status='MASUK SHIFT 3';
					} else if ($jam>$jam_masuk_min and $jam<$jam_masuk and $jam<$jam_pulang and $shiftke=='1'){
						$status='STATUS MASUK';
					} else if ($jam>$jam_masuk and $jam>$jam_pulang_min and $jam<$jam_pulang_max and $shiftke=='1'){
						$status='STATUS PULANG';
					} else if ($jam>$jam_masuk and $jam>$jam_pulang_min and $jam<$jam_pulang_max and $shiftke=='3'){
						$status='STATUS PULANG';
					} else if ($jam>$jam_masuk_min and $jam<$jam_masuk and $jam<$jam_pulang and $shiftke=='2'){
						$status='STATUS MASUK';
					} else {
						$status='ISTIRAHAT';
					}
					
					echo $id.'|'.$tglcheck.'|'.$jam.'Tanggal JAM CHEKIN|'.$shiftke.'<br>';
					echo $id.'|'.$jam_masuk.' JAM MASUK|'.$jam_pulang.' JAM PULANG|'.$status.'<br>';
					
					$info_status=array(
					
						'keterangan'=>$status,
					);
					$this->db->where('id',$id);
					$this->db->update('sc_trx.transready',$info_status);
				}
			
			
			
			
			
	
	
	}
	
	
	
	function koreksiabsensi(){
		
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		//$nama=trim($this->input->post('karyawan'));		
		$nik=trim($this->input->post('karyawan'));		
		if (empty($tanggal)){
			redirect('trans/absensi/filter_koreksi');
		} else {	
			/*$data['title']="KOREKSI DATA ABSEN KARYAWAN";	
			//echo $nama;
			//$data['list_absen']=$this->m_absensi->q_absensi_kor($tgl1,$tgl2,$nik)->result();	
			
			$data['list_absen']=$this->m_absensi->q_transready_koreksi($nik,$tgl1,$tgl2)->result();	
			$data['list_jam']=$this->m_absensi->q_jamkerja()->result();	
			$data['nik']=$nik;	
			$this->template->display('trans/absensi/v_koreksiabsensi',$data);*/
			$this->lihat_koreksi_kar($nik,$tgl1,$tgl2);
		}
		
	}
	
	function koreksiabsensi_dept(){
		
		$tanggal=$this->input->post('tgl');				
		$tgl=explode(' - ',$tanggal);
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		//$nama=trim($this->input->post('karyawan'));		
		$kddept=trim($this->input->post('kddept'));		
		if (empty($tanggal)){
			redirect('trans/absensi/filter_koreksi');
		} else {	
			/*$data['title']="KOREKSI DATA ABSEN KARYAWAN";	
			//echo $nama;
			//$data['list_absen']=$this->m_absensi->q_absensi_kor($tgl1,$tgl2,$nik)->result();	
			
			$data['list_absen']=$this->m_absensi->q_transready_koreksidept($kddept,$tgl1,$tgl2)->result();	
			$data['list_jam']=$this->m_absensi->q_jamkerja()->result();	
			$data['kddept']=$kddept;	
			$this->template->display('trans/absensi/v_koreksiabsensi_dept',$data);*/
			$this->lihat_koreksi($kddept,$tgl1,$tgl2);
		}
		
	}
	
	function lihat_koreksi($kddept,$tgl1,$tgl2){
			$data['title']="KOREKSI DATA ABSEN KARYAWAN";	
			$data['list_absen']=$this->m_absensi->q_transready_koreksidept($kddept,$tgl1,$tgl2)->result();	
			$data['list_jam']=$this->m_absensi->q_jamkerja()->result();	
			$data['kddept']=$kddept;	
			$data['tgl1']=$tgl1;	
			$data['tgl2']=$tgl2;	
			$this->template->display('trans/absensi/v_koreksiabsensi_dept',$data);
	
	}
	
	function lihat_koreksi_kar($nik,$tgl1,$tgl2){
	
			$data['title']="KOREKSI DATA ABSEN KARYAWAN";	
			//echo $nama;
			//$data['list_absen']=$this->m_absensi->q_absensi_kor($tgl1,$tgl2,$nik)->result();	
			
			$data['list_absen']=$this->m_absensi->q_transready_koreksi($nik,$tgl1,$tgl2)->result();	
			$data['list_jam']=$this->m_absensi->q_jamkerja()->result();	
			$data['nik']=$nik;
			$data['tgl1']=$tgl1;	
			$data['tgl2']=$tgl2;				
			$this->template->display('trans/absensi/v_koreksiabsensi',$data);
	
	}
	
	function show_edit($id,$kddept,$tgl1,$tgl2){
	
			$data['title']="KOREKSI DATA ABSEN KARYAWAN";	
			//echo $nama;
			//$data['list_absen']=$this->m_absensi->q_absensi_kor($tgl1,$tgl2,$nik)->result();	
			$data['kddept']=$kddept;
			$data['tgl1']=$tgl1;	
			$data['tgl2']=$tgl2;
			$data['ld']=$this->m_absensi->q_show_edit($id)->row_array();	
			$data['list_jam']=$this->m_absensi->q_jamkerja()->result();	
			$this->template->display('trans/absensi/v_editkoresiabsensi_dept',$data);
	
	}
	
	
	function input_absensi(){
		$nik=$this->input->post('nik');
		$tgl=$this->input->post('tanggal1');
		$kdjamkerja=$this->input->post('kdjamkerja');
		//$editby=$this->input->post('editby');
		$jam_masuk=str_replace("_",0,$this->input->post('jam_masuk'));
		$jam_pulang=str_replace("_",0,$this->input->post('jam_pulang'));
		//$checktime=$tgl.' '.$jam;
			$info_absen=array(
				'nik'=>$nik,	
				'tgl'=>$tgl,
				'kdjamkerja'=>$kdjamkerja,
				'jam_masuk_absen'=>$jam_masuk,
				'jam_pulang_absen'=>$jam_pulang,
				//'input_by'=>$this->session->userdata('nik'),
				//'input_date'=>date('Y-m-d H:i:s'),
			    'editan'=>'T',
			);
		$cek=$this->m_absensi->cek_absenexist($nik,$tgl,$kdjamkerja)->num_rows();
		if ($cek>0){
			redirect('trans/absensi/filter_koreksi/exist');
		} else {
		
			$this->db->insert('sc_trx.transready',$info_absen);
			redirect('trans/absensi/filter_koreksi/rep_succes');
		}	
		
		
	
	}
	
	
	function detailabsensi(){
		$tanggal=$this->input->post('tgl');
		
		$tgl=explode(' - ',$tanggal);
		$ketsts1=$this->input->post('ketsts');
		if (!empty($ketsts1)) {
			$ketsts="='$ketsts1'";
			
		
		} else {
			$ketsts=" is not null";
			
		}
		//$tgl1=$tgl[0].' 00:00:00';
		//$tgl2=$tgl[1].' 23:59:59';
		
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		//$nama=trim($this->input->post('karyawan'));		
		$nik=trim($this->input->post('karyawan'));		
		if (empty($tanggal)){
			redirect('trans/absensi/filter_detail');
		} else {	
			$data['title']="DETAIL DATA ABSEN KARYAWAN";	
			//echo $nama;
			$data['list_absen']=$this->m_absensi->q_transready($nik,$tgl1,$tgl2,$ketsts)->result();	
				
			$this->template->display('trans/absensi/v_dtlabsensi',$data);
		}
		//echo $ketsts1;		
		
	}
	
	function detailabsensi_regu(){
		$tanggal=$this->input->post('tgl');
		
		$tgl=explode(' - ',$tanggal);
		$ketsts1=$this->input->post('ketsts');
		if (!empty($ketsts1)) {
			$ketsts="='$ketsts1'";
			
		
		} else {
			$ketsts=" is not null";
			
		}
		//$tgl1=$tgl[0].' 00:00:00';
		//$tgl2=$tgl[1].' 23:59:59';
		
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		//$nama=trim($this->input->post('karyawan'));		
		$kdregu=trim($this->input->post('kdregu'));		
		if (empty($tanggal)){
			redirect('trans/absensi/filter_detail');
		} else {	
			$data['title']="DETAIL DATA ABSEN KARYAWAN";	
			//echo $nama;
			$data['list_absen']=$this->m_absensi->q_transready_regu($kdregu,$tgl1,$tgl2,$ketsts)->result();	
				
			$this->template->display('trans/absensi/v_dtlabsensi',$data);
		}
		//echo $ketsts1;		
		
	}

	function detailabsensi_dept(){
		$tanggal=$this->input->post('tgl');
		
		$tgl=explode(' - ',$tanggal);
		$ketsts1=$this->input->post('ketsts');
		if (!empty($ketsts1)) {
			$ketsts="='$ketsts1'";
			
		
		} else {
			$ketsts=" is not null";
			
		}
		//$tgl1=$tgl[0].' 00:00:00';
		//$tgl2=$tgl[1].' 23:59:59';
		
		$tgl1=$tgl[0];
		$tgl2=$tgl[1];
		
		//$nama=trim($this->input->post('karyawan'));		
		$kddept=trim($this->input->post('kddept'));		
		if (empty($tanggal)){
			redirect('trans/absensi/filter_detail');
		} else {	
			$data['title']="DETAIL DATA ABSEN KARYAWAN";	
			//echo $nama;
			$data['list_absen']=$this->m_absensi->q_transready_dept($kddept,$tgl1,$tgl2,$ketsts)->result();	
				
			$this->template->display('trans/absensi/v_dtlabsensi',$data);
		}
		//echo $ketsts1;		
		
	}
	
	function edit_absensi_old(){
		$id=$this->input->post('id');
		$tgl=$this->input->post('tanggal');
		//$editby=$this->input->post('editby');
		$jam_masuk=str_replace("_",0,$this->input->post('jam_masuk'));
		$jam_pulang=str_replace("_",0,$this->input->post('jam_pulang'));
		$checktime=$tgl.' '.$jam;
		$this->db->query("update sc_tmp.checkinout set checktime='$checktime',editan='T' where id='$id'");
		redirect('trans/absensi/filter_koreksi/add_succes');

	
	}
	
	function edit_absensi(){
		$id=$this->input->post('id');
		$tgl=$this->input->post('tanggal');
		$nik=$this->input->post('nik');
		$tgl1=$this->input->post('tgl1');
		$tgl2=$this->input->post('tgl2');
		//$editby=$this->input->post('editby');
		$jam_masuk=str_replace("_",0,$this->input->post('jam_masuk'));
		$jam_pulang=str_replace("_",0,$this->input->post('jam_pulang'));
		$checktime=$tgl.' '.$jam;
		$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_masuk',jam_pulang_absen='$jam_pulang',editan='T' where id='$id'");
		//redirect('trans/absensi/filter_koreksi/rep_succes');
		redirect("trans/absensi/lihat_koreksi_kar/$nik/$tgl1/$tgl2");
		
	
	}
	
	function edit_absensi_dept(){
		$id=$this->input->post('id');
		$tgl=$this->input->post('tanggal');
		$kddept=$this->input->post('kddept');
		$tgl1=$this->input->post('tgl1');
		$tgl2=$this->input->post('tgl2');
		//$editby=$this->input->post('editby');
		$jam_masuk=str_replace("_",0,$this->input->post('jam_masuk'));
		$jam_pulang=str_replace("_",0,$this->input->post('jam_pulang'));
		$checktime=$tgl.' '.$jam;
		$this->db->query("update sc_trx.transready set jam_masuk_absen='$jam_masuk',jam_pulang_absen='$jam_pulang',editan='T' where id='$id'");
		redirect("trans/absensi/lihat_koreksi/$kddept/$tgl1/$tgl2");
	
	
	}
	
	function hapus_absensi($id){
		$this->db->where('id',$id);
		$this->db->delete('sc_tmp.checkinout');
		redirect('trans/absensi/filter_koreksi/rep_succes');
	
	}
	
	public function ajax_edit($id)
	{
		$data = $this->m_absensi->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'kdkepegawaian' => strtoupper($this->input->post('kdkepegawaian')),
				'nmkepegawaian' => strtoupper($this->input->post('nmkepegawaian')),
				'input_date' => date('d-m-Y H:i:s'),				
				'input_by' => $this->session->userdata('nik'),		
			);
		$insert = $this->m_absensi->save($data);
		echo json_encode(array("status" => TRUE));		
	}

	public function ajax_update()
	{
		$data = array(
				'kdkepegawaian' => strtoupper($this->input->post('kdkepegawaian')),
				'nmkepegawaian' => strtoupper($this->input->post('nmkepegawaian')),				
				'update_date' => date('d-m-Y H:i:s'),				
				'update_by' => $this->session->userdata('nik'),				
			);
		$this->m_absensi->update(array('kdkepegawaian' => $this->input->post('kdkepegawaian')), $data);
		echo json_encode(array("status" => TRUE));
		
		$data['message']='Update succes';
	}

	public function ajax_delete($id)
	{
		$this->m_absensi->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}
	
	function show_mdb(){
		$tgl1='2015-04-01';
		$tgl2='2015-04-30';
		$cek=$this->m_absensi->show_user_lembur($tgl1,$tgl2)->result();
		foreach ($cek as $ck){
		
			echo $ck->USERID.$ck->CHECKTIME; 
		
		} 
	
	}

	
	
	function delete_mdb(){
		$tgl1='2015-04-01';
		$tgl2='2015-04-30';
		$cek=$this->m_absensi->del_user_lembur($tgl1,$tgl2)->result();
		foreach ($cek as $ck){
		
			echo $ck->USERID.$ck->CHECKTIME; 
		
		} 
	
	}

		/* excel report absensi*/
	function report_absensi(){
		$bln=$this->input->post('bln');
		$thn=$this->input->post('thn');
		$this->m_absensi->q_prreportabsensi($bln,$thn);
		$info=$this->m_absensi->excel_reportabsensi($bln,$thn);
        $this->excel_generator->set_query($info);
		$this->excel_generator->set_header(array('NIK','NAMALENGKAP','DEPARTMENT','JABATAN','REGU',
												'tgl1','tgl2','tgl3','tgl4','tgl5','tgl6','tgl7','tgl8','tgl9','tgl10','tgl11','tgl12','tgl13','tgl14','tgl15',
												'tgl16','tgl17','tgl18','tgl19','tgl20','tgl21','tgl22','tgl23','tgl24','tgl25','tgl26','tgl27','tgl28','tgl29','tgl30','tgl31',
												'SHIFT2','SHIFT3','ALPHA','CUTI','IJIN KHUSUS'	
												));
 	    $this->excel_generator->set_column(array('nik','nmlengkap','nmdept','nmjabatan','kdregu',
												'tgl1','tgl2','tgl3','tgl4','tgl5','tgl6','tgl7','tgl8','tgl9','tgl10','tgl11','tgl12','tgl13','tgl14','tgl15',
												'tgl16','tgl17','tgl18','tgl19','tgl20','tgl21','tgl22','tgl23','tgl24','tgl25','tgl26','tgl27','tgl28','tgl29','tgl30','tgl31',
												'shift2','shift3','alpha','cuti','ijin'
												));
        $this->excel_generator->set_width(array(12,20,20,20,10,
												6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,
												6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,6,	
												6,6,6,6,6
												));
        $this->excel_generator->exportTo2007("REPORT ABSENSI BULAN $bln TAHUN $thn");
		
	}
	
	
	
	
}
