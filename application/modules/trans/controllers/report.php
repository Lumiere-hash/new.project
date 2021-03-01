<?php
/*
	@author : excel
	18-03-2015
*/
error_reporting(0);

class Report extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		
        $this->load->model(array('m_geografis','m_report'));
        $this->load->library(array('form_validation','template','upload','Excel_generator','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Filter Laporan HRD";		
		$data['kantor']=$this->m_report->q_kantor()->result();
		$data['qlaporan']=$this->m_report->q_laporan()->result();
        $this->template->display('trans/report/view_filter_reporthrd',$data);
    }
	
	function filter(){
		 $tahun=$this->input->post('tahun'); 
		 $bulan=$this->input->post('bulan'); 
		 $kantor=$this->input->post('kantor'); 
		 $laporan=$this->input->post('laporan');
		$periode=$tahun.$bulan;
		switch ($bulan){
			case 01:$bln='Januari'; break;
			case 02:$bln='Februari'; break;
			case 03:$bln='Maret'; break;
			case 04:$bln='April'; break;
			case 05:$bln='Mei'; break;
			case 06:$bln='Juni'; break;
			case 07:$bln='Juli'; break;
			case 08:$bln='Agustus'; break;
			case 09:$bln='September'; break;
			case 10:$bln='Oktober'; break;
			case 11:$bln='November'; break;
			case 12:$bln='Desember'; break;
		}
		
		switch($laporan){
			case 'MP':
				$data['title']="Filter Man Power";
				$data['list_manpower']=$this->m_report->q_man_power($tahun,$bulan)->result();
				$this->template->display('trans/report/view_manpower',$data);
				break;
			case 'DM':
				$data['title']="Detail MAN POWER $bln $tahun";				
				$data['list_detmp']=$this->m_reporthrd->q_detail_mp($tahun,$bulan)->result();				
				$this->template->display('trans/report/view_detailmp',$data);
				break;
			case 'SK':
				$data['title']="Status Kepegawaian $bln $tahun";
				$data['list_stspeg']=$this->m_reporthrd->q_status_kepegawaian($tahun,$bulan)->result();		
				$data['ttl_stspeg']=$this->m_reporthrd->q_total_status_kepegawaian($tahun,$bulan)->row_array();		
				$data['chart']=$this->m_reporthrd->q_chart()->result();
				$this->template->display('trans/report/view_stskepegawaian',$data);
				break;
			case 'TO':
				$data['title']="Turn Over $bln $tahun";
				$data['periode']=$periode;
				$data['kantor']=$kantor;
				$data['list_turnover']=$this->m_reporthrd->q_turn_over($periode,$kantor)->result();
				$this->template->display('trans/report/view_turn_over',$data);
				break;
			case 'AR':redirect("trans/report/attendance_report/$periode/$kantor"); break;
			case 'DA':redirect('trans/report/detail_attendance'); break;
			case 'KS':
				$data['title']="Filter Karyawan Selesai Kontrak $bln $tahun";
				$data['list_karslskontrak']=$this->m_reporthrd->q_kar_slskontrak($tahun,$bulan)->result();
				$this->template->display('trans/report/view_kar_slskontrak',$data);
				break;
			case 'LP':redirect('trans/report/lap_pemakaianatk'); break;
			case 'SA':redirect('trans/report/stock_atk'); break;
			case 'MC':redirect('trans/report/mtc_cost'); break;
			case 'LR':redirect("trans/report/late_report/$periode/$kantor"); break;
			case 'LI':redirect("trans/report/ijin_report/$periode"); break;
			case 'LC':redirect("trans/report/cuti_report/$periode"); break;
			case 'LL':redirect("trans/report/lembur_report/$periode"); break;
			
			
		}

		if (empty($tahun)){
			redirect('trans/report',$data);
		}		
	}
	
	function attendance_report($periode,$kantor){ 
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		//echo $bulan.$bln;
		
		
		$data['title']="Attendance Report Periode Bulan $bln Tahun $tahun ";
		$this->db->query("select sc_trx.pr_reportabsen('$bulan','$thn')");
		$data['list_att']=$this->m_report->q_att_new($periode,$kantor)->result();
		$data['periode']=$periode;
		$this->template->display('trans/report/view_attendancereport',$data);
	}
	
	function detail_attendance(){
		$data['title']="Filter Detail Attendance";
		$data['list_turnover']=$this->m_reporthrd->q_turn_over()->result();
		$this->template->display('hrd/report/view_turn_over',$data);
	}
	function lap_pemakaianatk(){
		$data['title']="Filter Laporan Pemakaian ATK";
		$data['list_pemakaianatk']=$this->m_reporthrd->q_lap_pemakaianatk()->result();
		$this->template->display('hrd/report/view_pemakaianatk',$data);
	}
	function stock_atk(){
		$data['title']="Filter Stock ATK";
		$data['list_stockatk']=$this->m_reporthrd->q_stock_atk()->result();
		$this->template->display('hrd/report/view_stokatk',$data);
	}
	function mtc_cost(){
		$data['title']="Filter MTC Cost";
		$data['list_mstccost']=$this->m_reporthrd->q_mtc_cost()->result();
		$this->template->display('hrd/report/view_mtccost',$data);
	}
	
	function late_report($periode,$kantor){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		switch (trim($kantor)){
			case 'NAS':$ktr='NASIONAL'; break;
			case 'SBYMRG':$ktr='SURABAYA'; break;
			case 'SMGDMK':$ktr='DEMAK'; break;
			case 'SMGCND':$ktr='SEMARANG'; break;
			case 'JKTKPK':$ktr='JAKARTA'; break;
			
		}
		
		
		$data['title']="Laporan Keterlambatan Periode Bulan $bln Tahun $tahun Kantor NUSA $ktr";
		$data['periode']=$periode;
		$data['kantor']=$kantor;
		$data['list_att']=$this->m_report->q_late_report_new($periode,$kantor)->result();
		//$cl=$this->m_reporthrd->q_late_report($periode)->row_array();
		$this->template->display('trans/report/view_latereport',$data);
		//echo $cl;
	}
	
	function ijin_report($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		$data['title']="Laporan Ijin Karyawan Periode Bulan $bln Tahun $tahun";
		$data['periode']=$periode;
		$data['list_ijin']=$this->m_report->q_ijin_report($periode)->result();
		$this->template->display('trans/report/view_ijinreport',$data);
	
	}
	
	function lembur_report($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		$data['title']="Laporan Lembur Karyawan Periode Bulan $bln Tahun $tahun";
		$data['periode']=$periode;
		$data['list_ijin']=$this->m_report->q_lembur_report($periode)->result();
		$this->template->display('trans/report/view_lemburreport',$data);
	
	}
	
	
	function cuti_report($periode){
		
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		$data['title']="Laporan Cuti Karyawan Periode Bulan $bln Tahun $tahun";
		$data['periode']=$periode;
		$data['list_cuti']=$this->m_reporthrd->q_cuti_report($periode)->result();
		$this->template->display('hrd/report/view_cutireport',$data);
	
	}
	
	function excel_late($periode,$kantor){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		switch (trim($kantor)){
			case 'NAS':$ktr='NASIONAL'; break;
			case 'SBYMRG':$ktr='SURABAYA'; break;
			case 'SMGDMK':$ktr='DEMAK'; break;
			case 'SMGCND':$ktr='SEMARANG'; break;
			case 'JKTKPK':$ktr='JAKARTA'; break;
			
		}
		
		
		$datane=$this->m_report->q_late_report_new($periode,$kantor);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('NIK','Nama Karyawan','Tanggal Absen', 'Jam Absen','Durasi Keterlambatan','Ref Doc'));
        $this->excel_generator->set_column(array('nik', 'nmlengkap','tgl', 'jam_masuk_absen','total_terlambat','nodok_ref'));
        $this->excel_generator->set_width(array(20,30,20,20,30,10));
        $this->excel_generator->exportTo2007("Laporan Keterlambatan Periode Bulan $bln Tahun $tahun Tahun $tahun Kantor NUSA $ktr");
	}
	
	function excel_ijin($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		
		$datane=$this->m_report->q_ijin_report_excel($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Karyawan', 'Department', 'No. Dokumen',
		'Nama Ijin','Tanggal Ijin','Jam Mulai','Jam Akhir','Keterangan',));
        $this->excel_generator->set_column(array('nmlengkap', 'nmdept', 'nodok_new','nmijin_absensi','tgl_kerja','tgl_jam_mulai'
		,'tgl_jam_selesai','keterangan'));
        $this->excel_generator->set_width(array(40,20,20,30,20,20,20,40));
        $this->excel_generator->exportTo2007("Laporan Ijin Periode Bulan $bln Tahun $tahun");
	}
	
	function excel_cuti($periode){
		
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		$datane=$this->m_reporthrd->q_cuti_report_excel($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Karyawan', 'No. Dokumen',
		'Tanggal Mulai','Tanggal Selesai','Keterangan','Jumlah Cuti'));
        $this->excel_generator->set_column(array('nmlengkap', 'nodokumen', 'tglmulai','tglahir','keterangan','jmlcuti_new'));
        $this->excel_generator->set_width(array(40,30,30,30,40,30));
        $this->excel_generator->exportTo2007("Laporan Cuti Periode Bulan $bln Tahun $tahun");
	}
	
	function excel_lembur($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		
		$datane=$this->m_report->q_lembur_report_excel($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Karyawan', 'Department', 'No. Dokumen',
		'Tanggal Lembur','Jam Mulai','Jam Akhir','Durasi','Keterangan',));
        $this->excel_generator->set_column(array('nmlengkap', 'nmdept', 'nodok_new','tgl_kerja1','jammulai'
		,'jamselesai','durasi','keterangan'));
        $this->excel_generator->set_width(array(40,20,20,20,20,20,20,40));
        $this->excel_generator->exportTo2007("Laporan Lembur Periode Bulan $bln Tahun $tahun");
	}
	
	function excel_attendence($periode){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		
		$datane=$this->m_reporthrd->q_att_new($periode);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Nama Karyawan', 'Department',
		'Alpha','Ijin Keluar','Ijin Pulang','Ijin Sakit','Ijin Terlambat','Ijin Menikah','Terlambat','Cuti'));
        $this->excel_generator->set_column(array('nmlengkap','departement', 'alpha', 'ijinkeluar','ijinpulang','skd','ijinterlambat','ijinmenikah','terlambat','cuti'));
        $this->excel_generator->set_width(array(40,40,20,20,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Laporan Absensi Periode Bulan $bln Tahun $tahun");
	
	}
	
	function download_pdf_to($tahun,$bulan){
		
		
		//$data['periode']=$periode;
		$data['title']="Turn Over $bulan $tahun";
		$data['list_turnover']=$this->m_reporthrd->q_turn_over($tahun,$bulan)->result();
        
        $this->pdf->load_view('hrd/report/view_turn_over',$data);
        $this->pdf->set_paper('f4','potrait');
        $this->pdf->render();       
        $this->pdf->stream("Turn Over.pdf");
        //redirect('web/index/add_succes');       
    }
	
	function excel_turnover($periode,$kantor){
		$bulan=substr(trim($periode),4);
		
		$tahun=substr($periode,0,4);
		switch (trim($bulan)){
			case '01':$bln='Januari'; break;
			case '02':$bln='Februari'; break;
			case '03':$bln='Maret'; break;
			case '04':$bln='April'; break;
			case '05':$bln='Mei'; break;
			case '06':$bln='Juni'; break;
			case '07':$bln='Juli'; break;
			case '08':$bln='Agustus'; break;
			case '09':$bln='September'; break;
			case '10':$bln='Oktober'; break;
			case '11':$bln='November'; break;
			case '12':$bln='Desember'; break;
		}
		
		
		$datane=$this->m_reporthrd->q_turnover_excel($periode,$kantor);
        $this->excel_generator->set_query($datane);
        $this->excel_generator->set_header(array('Kantor', 'Keterangan','NIP','Nama Karyawan',
		'Department','Sub Department','Jabatan','Tanggal Masuk','Tanggal Keluar','Pendidikan Terakhir'));
        $this->excel_generator->set_column(array('desc_cabang','status', 'nip', 'nmlengkap','departement','subdepartement','deskripsi','masuk','keluar','desc_pendidikan'));
        $this->excel_generator->set_width(array(30,20,10,30,20,20,20,20,20,20));
        $this->excel_generator->exportTo2007("Laporan Turn Over Periode Bulan $bln Tahun $tahun");
	
	}
	
	
	
}