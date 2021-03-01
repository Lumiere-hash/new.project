<?php
/*
	@author : Junis pusaba
	@recreate : Fiky Ashariza
	12-12-2016
*/
class Dashboard extends MX_Controller{
    function __construct(){
        parent::__construct();
        $this->load->model(array('m_modular','m_geografis','web/m_user'));
        $this->load->library(array('form_validation','template','Excel_Generator'));
        if(!$this->session->userdata('nik')){
            redirect('web');
        }
		$level=$this->session->userdata('lvl');
    }
    
    function index(){
        $data['title']="Home";
		$jumlah_karyawan=$this->db->query("select *,case when kuranghari<0 then 'TERLEWAT'
											else 'AKAN HABIS' 
											end as keteranganhari  from 
											(select a.nmlengkap,b.tgl_selesai-cast(now() as date) as kuranghari,a.nik,b.nodok,a.statuskepegawaian,b.keterangan,c.nmkepegawaian,
											to_char(b.tgl_mulai,'DD-MM-YYYY') as tgl_mulai1,
											to_char(b.tgl_selesai,'DD-MM-YYYY') as tgl_selesai1
											from sc_mst.karyawan a
											left outer join sc_trx.status_kepegawaian b on a.nik=b.nik and a.statuskepegawaian=b.kdkepegawaian
											left outer join sc_mst.status_kepegawaian c on b.kdkepegawaian=c.kdkepegawaian
											where a.statuskepegawaian<>'KO' and a.statuskepegawaian<>'KT' 
											and to_char(tgl_selesai,'YYYYMM') between to_char(now() - interval '1 Months','YYYYMM') and  to_char(now(),'YYYYMM')) as t1 
											")->num_rows();
		$data['jumlah_karyawan']=$jumlah_karyawan;
		$jumlah_pensiun=$this->db->query("select  a.nmlengkap,to_char(age(a.tgllahir),'YY'),cast(to_char(tgllahir,'DD-MM')||'-'||to_char(now(),'YYYY')as date) as tglultah,a.nik,b.nodok,b.kdkepegawaian,b.keterangan,c.nmkepegawaian,
											to_char(b.tgl_mulai,'DD-MM-YYYY') as tgl_mulai1,
											to_char(b.tgl_selesai,'DD-MM-YYYY') as tgl_selesai1
											from sc_mst.karyawan a
											left outer join sc_trx.status_kepegawaian b on a.statuskepegawaian=b.kdkepegawaian and a.nik=b.nik
											left outer join sc_mst.status_kepegawaian c on b.kdkepegawaian=c.kdkepegawaian
											where to_char(age(a.tgllahir),'YY')>='56' AND b.kdkepegawaian<>'KO' and b.kdkepegawaian<>'KP'  

										")->num_rows();
		$data['jumlah_pensiun']=$jumlah_pensiun;								
        $this->template->display('dashboard/dashboard/index',$data);
				
    }
    
    function userosin(){
        $data['title']="Data User Osin";		
		$data['nama']=strtoupper($this->session->userdata('username'));
        $data['userosin']=$this->m_user->semua()->result();
		$data['progmodul']=$this->m_user->list_modulprg()->result();
		$data['usermodul']=$this->m_user->list_modulusr()->result();
		$data['listmodul']=$this->m_user->list_modul()->result();
		$data['list_peg']=$this->m_hrd->q_listpeg()->result();
		$data['gudang']=$this->m_geografis->q_gudang()->result();
		$data['wilayah']=$this->m_geografis->q_wilayah()->result();		
		$data['divisi']=$this->m_user->divisi()->result();
        if($this->uri->segment(4)=="delete_success")
            $data['message']="<div class='alert alert-success'>Data berhasil dihapus</div>";
        else if($this->uri->segment(4)=="add_success")
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan</div>";
        else if($this->uri->segment(4)=="update_success")
            $data['message']="<div class='alert alert-success'>Data Berhasil diupdate</div>";
		else if($this->uri->segment(4)=="data_sama")
            $data['message']="<div class='alert alert-danger'>Data Sudah Ada</div>";
		else if($this->uri->segment(4)=="pwd_beda")
            $data['message']="<div class='alert alert-danger'>Password Harus Sama</div>";
		else if($this->uri->segment(4)=="danger")
            $data['message']="<div class='alert alert-danger'>Terjadi kesalahan saat input</div>";
		else
            $data['message']='';
        $this->template->display('dashboard/userosin/index',$data);
    }
	//input user baru
	function add_user(){
		$userid=strtoupper($this->input->post('userid'));
		$usersname=$this->input->post('namauser');
		$nip=$this->input->post('nip');
		$userlname=$this->input->post('userpjg');				
		$password1=$this->input->post('passwordweb');				
		$password2=$this->input->post('passwordweb2');				
		$gudang=$this->input->post('gudang');								
		$divisi=$this->input->post('divisi');													
		$kunci=$this->input->post('kunci');				
		$timelock=$this->input->post('end_date');				
		$leveluser=$this->input->post('leveluser');				
		$wilayah=$this->input->post('wilayah');	
				
		$cek=$this->m_user->cekUser($userid);
            if($cek->num_rows()>0){
                redirect('dashboard/userosin/index/data_sama');
            }else{
				if ($password1<>$password2){
					redirect('dashboard/userosin/index/pwd_beda');
				} else {
					$info=array(
						'branch'=>'SBYNSA',
						'userid'=>trim($userid),
						'usersname'=>strtoupper($usersname),
						'nip'=>$nip,
						'userlname'=>strtoupper($userlname),                   
						'passwordweb'=>md5($password1),
						'location_id'=>$gudang,
						'groupuser'=>$divisi,
						'divisi'=>$divisi,
						'hold_id'=>strtoupper($kunci),
						'level_id'=>$leveluser,
						'custarea'=>$wilayah,
						'inputby'=>$this->session->userdata('username'),
						'timelock'=>$timelock,
						'inputdate'=>date("Y-m-d H:i:s"),
						'image'=>'admin.jpg');
					if ($userid<>null){
						$this->m_user->simpan($info);
					} else {
						redirect('dashboard/userosin/index/danger');	
					}
						//simpan modul
						$listmdl=$this->m_user->list_modulprg()->result();
						foreach ($listmdl as $mdl){
							$namamdl=trim($mdl->mdlprg);
							$cekmdl=$this->input->post($namamdl);
							if ($cekmdl=='Y') {
								$infomdl=array(
									'branch'=>'SBYNSA',
									'userid'=>$userid,
									'mdlprg'=>$mdl->mdlprg,
									'modul'=>$mdl->modul,
									'link'=>$mdl->LINK									
									);
									$this->m_user->simpan_mdl($infomdl);
							}
						}
						//end simpan modul
				}
									
					redirect('dashboard/userosin/index/add_success');	
			}
	}	
    
    function edit_user(){
		$userid=$this->input->post('userid');
		$usersname=$this->input->post('namauser');
		$nip=$this->input->post('nip');
		$userlname=$this->input->post('userpjg');				
		$passwordbaru=$this->input->post('passwordweb');				
		$passwordasli=$this->input->post('passwordwebasli');				
		if ($passwordasli==$passwordbaru) {
			$password=$passwordasli;
		} else {
			$password=md5($passwordbaru);
		}
		$gudang=$this->input->post('gudang');								
		$divisi=$this->input->post('divisi');													
		$kunci=$this->input->post('kunci');	
		$timelock=$this->input->post('end_date');			
		$leveluser=$this->input->post('leveluser');				
		$wilayah=$this->input->post('wilayah');	
		if ($password1<>$password2){
					redirect('dashboard/userosin/index/pwd_beda');
				} else {
					$info=array(
						'branch'=>'SBYNSA',
						'userid'=>strtoupper($userid),
						'usersname'=>strtoupper($usersname),
						'userlname'=>strtoupper($userlname),                    
						'passwordweb'=>$password,
						'location_id'=>$gudang,
						'groupuser'=>$divisi,
						'divisi'=>$divisi,
						'hold_id'=>strtoupper($kunci),
						'timelock'=>$timelock,
						'level_id'=>$leveluser,
						'custarea'=>$wilayah,					
						);				
					$this->m_user->update($userid,$info);
					$this->m_user->hapus_mdl(trim($userid));
					$listmdl=$this->m_user->list_modulprg()->result();
					foreach ($listmdl as $mdl){
						$namamdl=trim($mdl->mdlprg);
						$cekmdl=$this->input->post($namamdl);
						if ($cekmdl=='Y') {
							$cekmodul=$this->m_user->cek_modul($userid,$cekmdl);
							
							$infomdl=array(
								'branch'=>'SBYNSA',
								'userid'=>$userid,
								'mdlprg'=>$mdl->mdlprg,
								'modul'=>$mdl->modul,
								'link'=>$mdl->LINK
								);
							if($cekmodul->num_rows()>0) {
								$this->m_user->update_mdl($userid,$infomdl);
							} else {
								$this->m_user->simpan_mdl($infomdl);
							}
						}
					}
					redirect('dashboard/userosin/index/add_success'); 
				}
    }
    
    function hapus_user($kode){
		$level=$this->session->userdata('level');
		if ($level<>'A'){
		$data['message']='Level Anda di tolak';
		redirect('dashboard/userosin',$data);
		} else {
		$data['message']='Data Berhasil Di Hapus';
        $this->m_user->hapus($kode);
		redirect('dashboard/userosin',$data);
		}
    }
    
    function _set_rules(){
        $this->form_validation->set_rules('user','username','required|trim');
        $this->form_validation->set_rules('password','password','required|trim');
        $this->form_validation->set_error_delimiters("<div class='alert alert-danger'>","</div>");
    }
    
    function logout(){
        $this->session->unset_userdata('username');
		$this->session->sess_destroy();
        redirect('web');
    }
	
 
}