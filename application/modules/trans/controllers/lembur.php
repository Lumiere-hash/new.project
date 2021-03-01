<?php
/*
	@author : randy
	13-04-2015
*/
//error_reporting(0)
class Lembur extends MX_Controller{

    function __construct(){
        parent::__construct();

		$this->load->model(array('m_lembur','master/m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf','fiky_encryption','Fiky_notification_push'));
		 if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
	function index(){
        //echo "test";


		$nama=$this->session->userdata('nik');
		$data['title']="List Lembur Karyawan";

        /* CODE UNTUK VERSI*/
        $nama=trim($this->session->userdata('nik'));
        $kodemenu='I.T.B.3'; $versirelease='I.T.B.3/ALPHA.001'; $releasedate=date('2019-04-12 00:00:00');
        $versidb=$this->fiky_version->version($kodemenu,$versirelease,$releasedate,$nama);
        $x=$this->fiky_menu->menus($kodemenu,$versirelease,$releasedate);
        $data['x'] = $x['rows']; $data['y'] = $x['res']; $data['t'] = $x['xn'];
        $data['kodemenu']=$kodemenu; $data['version']=$versidb;
        /* END CODE UNTUK VERSI */

        $paramerror=" and userid='$nama' and modul='LEMBUR'";
        $dtlerror=$this->m_lembur->q_trxerror($paramerror)->row_array();
        $count_err=$this->m_lembur->q_trxerror($paramerror)->num_rows();
        if(isset($dtlerror['description'])) { $errordesc=trim($dtlerror['description']); } else { $errordesc='';  }
        if(isset($dtlerror['nomorakhir1'])) { $nomorakhir1=trim($dtlerror['nomorakhir1']); } else { $nomorakhir1='';  }
        if(isset($dtlerror['errorcode'])) { $errorcode=trim($dtlerror['errorcode']); } else { $errorcode='';  }

        if($count_err>0 and $errordesc<>''){
            if ($dtlerror['errorcode']==0){
                $data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message']="<div class='alert alert-info'>$errordesc</div>";
            }

        }else {
            if ($errorcode=='0'){
                $data['message']="<div class='alert alert-info'>DATA SUKSES DISIMPAN/DIUBAH $nomorakhir1 </div>";
            } else {
                $data['message']="";
            }
        }

		$thn=$this->input->post('tahun');
		$bln=$this->input->post('bulan');
		$status1=$this->input->post('status');
		$nik1=$this->input->post('nik');

		if (empty($thn)){
			$tahun=date('Y'); $bulan=date('m'); $tgl=$bulan.$tahun;
			$status='is not NULL';
			$nik2='is not NULL';
		} else {
			$tahun=$thn; $bulan=$bln; $tgl=$bulan.$tahun;
			//$status="='$status1'";
			if ($status1==""){
				$status='is not NULL';
			} else {
				$status="='$status1'";
			}

			if ($nik1==""){
				$nik2='is not NULL';
			} else {
				$nik2="='$nik1'";

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
		//echo $nik2;
		$cek2=$this->m_lembur->cek_position($nama)->num_rows();

		if ($cek2<=0){
			$position='IT';

		} else {
			$cek=$this->m_lembur->cek_position($nama)->row_array();
			$position=trim($cek['bag_dept']);
		}

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

		$kmenu='I.T.B.3';
		$data['akses']=$this->m_akses->list_aksespermenu($nama,$kmenu)->row_array();
		$data['position']=$position;
		$data['list_lembur_edit']=$this->m_lembur->list_lembur()->result();
		$data['list_karyawan']=$this->m_lembur->list_karyawan()->result();
		$data['list_lembur']=$this->m_lembur->q_lembur($tgl,$status,$nik2,$nikatasan)->result();
		$data['list_lembur_dtl']=$this->m_lembur->q_lembur_dtl()->result();
		$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();

        $this->template->display('trans/lembur/v_list',$data);

        $paramerror=" and userid='$nama'";
        $dtlerror=$this->m_lembur->q_deltrxerror($paramerror);
    }
	function karyawan(){
		//$data['title']="List Master Riwayat Keluarga";

		$data['title']="List Karyawan";
		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdep()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));

		if($userhr>0 or $level_akses=='A'){
			$data['list_karyawan']=$this->m_akses->list_karyawan()->result();
		} else{
			$data['list_karyawan']=$this->m_akses->list_akses_alone()->result();
		}
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
		$lintashari=$this->input->post('lintashari');
		$tgllintas=$this->input->post('tgllin');

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
		//$tgl_dok=$this->input->post('tgl_dok');
		$tgl_dok=$tgl_kerja;
		$kdtrx=$this->input->post('kdtrx');
		$keterangan=$this->input->post('keterangan');
		$status=$this->input->post('status');
		$tgl_input=$this->input->post('tgl');
		$inputby=$this->input->post('inputby');
		$jenis_lembur=$this->input->post('jenis_lembur');

		if($lintashari=='t'){
			$jenis_lembur='D2';
			$jam_awal1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_awal);
			$jam_selesai1=trim(date("Y-m-d",strtotime($tgllintas)).' '.$jam_selesai);

		} else{
			$jam_awal1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_awal);
			$jam_selesai1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_selesai);
		}

		//echo $jam_awal1.'<br>';
		//echo $jam_selesai1.'<br>';

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
			'tgl_dok'=>date('Y-m-d H:i:s'),
			'kdlembur'=>$kdlembur,
			'tgl_kerja'=>$tgl_kerja,
			'tgl_jam_mulai'=>$jam_awal1,
			'tgl_jam_selesai'=>$jam_selesai1,
			'kdtrx'=>strtoupper($kdtrx),
			'jenis_lembur'=>strtoupper($jenis_lembur),
			'keterangan'=>strtoupper($keterangan),
			'status'=>strtoupper($status),
			'input_date'=>$tgl_input,
			'input_by'=>strtoupper($inputby),
		);

		//echo $durasi;
		$cek=$this->m_lembur->q_cekdouble($nik,$tgl_kerja,$jam_awal1)->num_rows();
		if ($cek>0) {
			redirect("trans/lembur/index/lembur_failed");
		} else {
            $nama = $this->session->userdata('nik');
            $this->db->insert('sc_tmp.lembur',$info);
            $dtl_push = $this->m_akses->q_lv_mkaryawan(" and nik='$nik'")->row_array();
            $paramerror=" and userid='$nama' and modul='LEMBUR'";
            $dtlerror=$this->m_lembur->q_trxerror($paramerror)->row_array();
            if ($this->fiky_notification_push->onePushVapeApprovalHrms($nik,trim($dtl_push['nik_atasan']),trim($dtlerror['nomorakhir1']))){
                redirect("trans/lembur/index/rep_succes/$nik");
            }

		}

	}

	function edit($nodok){
		//echo "test";


		$data['title']='EDIT DATA LEMBUR';
		if($this->uri->segment(5)=="upsuccess"){
			$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
		}
		else {
			$data['message']='';
		}
			$nik=$this->uri->segment(4);
		//$data['nik']=$nik;
		$data['list_lembur_edit']=$this->m_lembur->list_lembur()->result();
		//$data['list_lembur']=$this->m_lembur->q_lembur($tgl,$status)->result();
		$data['list_lembur_dtl']=$this->m_lembur->q_lembur_edit($nodok)->result();
		$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		$this->template->display('trans/lembur/v_edit',$data);

	}

	function detail($nodok){
		//echo "test";
		$nama=trim($this->session->userdata('nik'));
		$data['title']='DETAIL DATA LEMBUR';
		if($this->uri->segment(5)=="upsuccess"){
			$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
		}
		else {
			$data['message']='';
		}
		//$nik=$this->uri->segment(4);
		//$data['nik']=$nik;
		$dtl=$this->m_lembur->q_lembur_edit($nodok)->row_array();
		/* akses approve atasan */
		$ceknikatasan1=$this->m_akses->list_aksesatasan1($nama)->num_rows();
		$ceknikatasan2=$this->m_akses->list_aksesatasan2($nama)->num_rows();
		$nikatasan1=$this->m_akses->list_aksesatasan1($nama)->result();
		$nikatasan2=$this->m_akses->list_aksesatasan2($nama)->result();

		$userinfo=$this->m_akses->q_user_check()->row_array();
		$userhr=$this->m_akses->list_aksesperdepcuti()->num_rows();
		$level_akses=strtoupper(trim($userinfo['level_akses']));

		if(($userhr>0)){
			//$nikatasan='';
			$cekatasan=1;
		}
		else if (trim($dtl['nik_atasan'])==$nama and $userhr==0 ){
			//$nikatasan="where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan='$nama') or x1.nik='$nama'";
			$cekatasan=1;
		}
		else if (trim($dtl['nik_atasan2'])==$nama and $userhr==0 ){
			//$nikatasan="where x1.nik in (select trim(nik) from sc_mst.karyawan where nik_atasan2='$nama') or x1.nik='$nama'";
			$cekatasan=1;
		}
		else {
			//$nikatasan="where x1.nik='$nama'";
			$cekatasan=0;
		}
		$data['nama']=$nama;
		$data['userhr']=$userhr;
		$data['level_akses']=$level_akses;
		$data['cekatasan']=$cekatasan;
		/* END APPROVE ATASAN */

		$data['list_lembur_edit']=$this->m_lembur->list_lembur()->result();
		//$data['list_lembur']=$this->m_lembur->q_lembur($tgl,$status)->result();
		$data['list_lembur_dtl']=$this->m_lembur->q_lembur_edit($nodok)->result();
		$data['list_trxtype']=$this->m_lembur->list_trxtype()->result();
		$this->template->display('trans/lembur/v_detail',$data);
	}

	function edit_lembur(){
		//$nik1=explode('|',);
		$lintashari=$this->input->post('lintashari');
		$tgllintas=$this->input->post('tgllin');


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

		if($lintashari=='t'){
			$jenis_lembur='D2';
			$jam_awal1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_awal);
			$jam_selesai1=trim(date("Y-m-d",strtotime($tgllintas)).' '.$jam_selesai);

		} else{
			//$jenis_lembur='D1';
			$jam_awal1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_awal);
			$jam_selesai1=trim(date("Y-m-d",strtotime($tgl_kerja)).' '.$jam_selesai);
		}


		$info=array(
			//'nodok'=>strtoupper($nodok),

			'durasi_istirahat'=>$durasi_istirahat,
			'kdlembur'=>$kdlembur,
			'tgl_kerja'=>$tgl_kerja,
			'tgl_jam_mulai'=>$jam_awal1,
			'tgl_jam_selesai'=>$jam_selesai1,
			'kdtrx'=>strtoupper($kdtrx),
			'keterangan'=>strtoupper($keterangan),
			'jenis_lembur'=>strtoupper($jenis_lembur),
			'update_date'=>$tgl_input,
			'update_by'=>strtoupper($inputby),
		);
		//$this->db->where('custcode',$kode);

			$cek=$this->m_lembur->cek_dokumen($nodok)->num_rows();
			$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
			//if ($cek>0 or $cek2>0) {
			if ($cek2>0) {
				redirect("trans/lembur/index/kode_failed");
			} else {
				$this->db->where('nodok',$nodok);
				$this->db->update('sc_trx.lembur',$info);
				$this->db->query("update sc_trx.lembur set status='U' where nodok='$nodok'");
				redirect("trans/lembur/index/$nodok/upsuccess");
			}


		//echo $inputby;
	}

	function hps_lembur($nodok){
		//$this->db->where('nodok',$nodok);
		$cek=$this->m_lembur->cek_dokumen3($nodok)->row_array();
		$cek2=$this->m_lembur->cek_dokumen2($nodok)->num_rows();
		$tgl_closing1=$this->m_lembur->tgl_closing()->row_array();
		$tgl_closing=$tgl_closing1['value1'];
		$tgl_dok=$cek['tgl_dok'];
		$info=array(
			'delete_date'=>date('Y-m-d H:i:s'),
			'delete_by'=>$this->session->userdata('nik'),
			'status'=>'D',
		);

		/*if ($cek>0 or $cek2>0) {
			redirect("trans/lembur/index/kode_failed");
		} else {
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.lembur',$info);
			redirect("trans/lembur/index/del_succes");
		}*/


		if ($tgl_closing>=$tgl_dok){
			redirect("trans/lembur/index/del_failed");
		} else {
			$this->db->where('nodok',$nodok);
			$this->db->update('sc_trx.lembur',$info);
			redirect("trans/lembur/index/del_succes");
		}
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
