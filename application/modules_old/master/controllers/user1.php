<?php
/*
	@author : Junis
	02-12-2015
*/
//error_reporting(0);

class User extends MX_Controller{
    
    function __construct(){
        parent::__construct();
		        
        $this->load->model(array('m_user','m_menu','m_akses'));
        $this->load->library(array('form_validation','template','upload','pdf'));        

        if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
    }
    
    function index(){
        $data['title']="Master User";	
        $data['message']="";			
		$data['list_user']=$this->m_user->list_user()->result();
		$data['list_kary']=$this->m_user->list_karyawan()->result();
		if($this->uri->segment(4)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(4)=="success"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(4)=="notacces"){			
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
		}
		else if($this->uri->segment(4)=="del"){			
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
        else {
            $data['message']='';
		}
		$this->template->display('master/user/v_user',$data);
    }
	
	function edit($nik){
		if (empty($nik)){
			redirect('master/user/');
		} else {
			$data['title']='EDIT DATA USER';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik);
			$this->template->display('master/user/v_edituser',$data);			
		}		
	}
	
	function editprofile($nik){
	
		if (empty($nik)){
			redirect('dashboard');
		} else {
			$data['title']='UBAH PASSWORD USER';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Password Berhasil Diubah </div>";
				///redirect('dashboard/logout');
			}
			else if($this->uri->segment(5)=="pwnotmatch"){
				
				$data['message']="<div class='alert alert-danger'>PASSWORD Tidak Sama </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik);
			$this->template->display('master/user/v_editprofile',$data);			
		}
				
	}
	
	
	function edit_akses($nik,$kodemenu){
		if (empty($nik)){
			redirect('master/user/akses/');
		} else {
			$data['title']='EDIT DATA AKSES USER';			
			if($this->uri->segment(5)=="upsuccess"){			
				$data['message']="<div class='alert alert-success'>Data Berhasil di update </div>";
			}
			else {
				$data['message']='';
			}
			$data['dtl_user']=$this->m_user->dtl_user($nik);
			$data['akses']=$this->m_akses->detail_user_akses($nik,$kodemenu)->row_array();
			$this->template->display('master/user/v_edit_aksesuser',$data);			
		}		
	}
	
	function hps($nik){		
		$this->db->where('nik',$nik);
		$this->db->delete('sc_mst.user');
		redirect('master/user/index/del');
	}
	
	function hps_akses($nik,$kodemenu){		
		$this->db->where('nik',$nik);
		$this->db->where('kodemenu',$kodemenu);
		$this->db->delete('sc_mst.akses');
		redirect("master/user/akses/$nik/del");
	}
	
	function akses($nik){
		$data['title']="HAK AKSES USER $nik";
		$data['dtl_user']=$this->m_user->dtl_user($nik);
		$data['list_akses']=$this->m_akses->list_akses($nik)->result();
		$data['list_menu']=$this->m_akses->list_menu($nik)->result();
		$data['nik']=$nik;
		if($this->uri->segment(5)=="exist") {
            $data['message']="<div class='alert alert-warning'>Data Sudah Ada!</div>";
		}
		else if($this->uri->segment(5)=="success"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(5)=="upsuccess"){			
            $data['message']="<div class='alert alert-success'>Data Berhasil disimpan </div>";
		}
		else if($this->uri->segment(5)=="notacces"){			
            $data['message']="<div class='alert alert-success'>Anda tidak Berhak untuk mengakses modul ini</div>";
		}
		else if($this->uri->segment(5)=="del"){			
            $data['message']="<div class='alert alert-success'>Hapus Data Sukses</div>";
		}
        else {
            $data['message']='';
		}
		$this->template->display('master/user/v_akses_user',$data);			
	}
	
	function save_akses(){
		$nik=strtoupper(trim($this->input->post('nik')));
		$menu=trim($this->input->post('menu'));
		$hold=$this->input->post('hold');
		$view=$this->input->post('view');
		$input=$this->input->post('input');
		$update=$this->input->post('update');
		$delete=$this->input->post('delete');
		$approve=$this->input->post('approve');
		$approve2=$this->input->post('approve2');
		$approve3=$this->input->post('approve3');
		$convert=$this->input->post('convert');
		$print=$this->input->post('print');
		$download=$this->input->post('download');				
		$tipe=$this->input->post('tipe');				
		
		if ($tipe=='input'){
			$info_input=array(
				'nik'=>$nik,
				'kodemenu'=>$menu,
				'hold_id'=>$hold,
				'aksesview'=>$view,
				'aksesinput'=>$input,
				'aksesupdate'=>$update,
				'aksesdelete'=>$delete,
				'aksesapprove'=>$approve,
				'aksesapprove2'=>$approve2,
				'aksesapprove3'=>$approve3,
				'aksesconvert'=>$convert,
				'aksesprint'=>$print,
				'aksesdownload'=>$download
			);
			$cek=$this->m_akses->cek_input_akses($nik,$menu);
			if ($cek>0){
				redirect("master/user/akses/$nik/exist");
			} else {
				$this->db->insert('sc_mst.akses',$info_input);
				redirect("master/user/akses/$nik/success");
			}
		} else if ($tipe=='edit'){
			$info_update=array(
				'hold_id'=>$hold,
				'aksesview'=>$view,
				'aksesinput'=>$input,
				'aksesupdate'=>$update,
				'aksesdelete'=>$delete,
				'aksesapprove'=>$approve,
				'aksesapprove2'=>$approve2,
				'aksesapprove3'=>$approve3,
				'aksesconvert'=>$convert,
				'aksesprint'=>$print,
				'aksesdownload'=>$download
			);
			$this->m_akses->update_akses($nik,$menu,$info_update);			
			redirect("master/user/akses/$nik/upsuccess");
		}
	}
	
	function save(){		
		$tipe=$this->input->post('tipe');
		$splituser=explode('|',$this->input->post('user'));
		$nik=strtoupper(trim($splituser[0]));
		$nama=strtoupper(trim($splituser[1]));		
		$password=md5(strtoupper($this->input->post('passwordweb')));		
		$expdate=$this->input->post('expdate');
		$hold=$this->input->post('hold');
		$cek_user=$this->m_user->cek_user($nik);
		if ($tipe=='input') {
			if ($cek_user>0){
				redirect('master/user/index/exist');
			} else {
				$info_input=array(
					'nik'=>$nik,
					'username'=>$nama,
					'passwordweb'=>$password,
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'inputdate'=>date('d-m-Y'),
					'inputby'=>$this->session->userdata('nik')
				);
				$this->db->insert('sc_mst.user',$info_input);
				echo 'CEK';
				redirect('master/user/index/success');
			}			
		} else if ($tipe=='edit'){
			if (empty($password) or $password==''){
				$info_edit1=array(												
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);	
				$this->db->where('nik',$nik);
				$this->db->update('sc_mst.user',$info_edit1);
				redirect("master/user/edit/$nik/upsuccess");
			} else {
				$info_edit2=array(							
					'passwordweb'=>$password,
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);
				$this->db->where('nik',$nik);
				$this->db->update('sc_mst.user',$info_edit2);
				redirect("master/user/edit/$nik/upsuccess");
			}		
		} else {
			redirect('master/user/index/notacces');
		}		
	}
	
	
	function saveprofile(){		
		$tipe=$this->input->post('tipe');
		$splituser=explode('|',$this->input->post('user'));
		$nik=strtoupper(trim($splituser[0]));
		$nama=strtoupper(trim($splituser[1]));		
		$password=md5(strtoupper($this->input->post('passwordweb')));		
		$password2=md5(strtoupper($this->input->post('passwordweb2')));		
		$expdate=$this->input->post('expdate');
		$hold=$this->input->post('hold');
		$cek_user=$this->m_user->cek_user($nik);
		if ($tipe=='input') {
			/*if ($cek_user>0){
				redirect('master/user/index/exist');
			} else {
				$info_input=array(
					'nik'=>$nik,
					'username'=>$nama,
					'passwordweb'=>$password,
					'expdate'=>$expdate,
					'hold_id'=>$hold,
					'inputdate'=>date('d-m-Y'),
					'inputby'=>$this->session->userdata('nik')
				);
				$this->db->insert('sc_mst.user',$info_input);
				echo 'CEK';
				redirect('master/user/saveprofile/success');
			} */			
		} else if ($tipe=='edit'){
			if ($password<>$password2){
				
				redirect("master/user/editprofile/$nik/pwnotmatch");
				
			}
			if (empty($password) or $password==''){
				$info_edit1=array(												
					//'expdate'=>$expdate,
					//'hold_id'=>$hold,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);	
				$this->db->where('nik',$nik);
				$this->db->update('sc_mst.user',$info_edit1);
				redirect("master/user/editprofile/$nik/upsuccess");
			} else {
				$info_edit2=array(							
					'passwordweb'=>$password,
					//'expdate'=>$expdate,
					//'hold_id'=>$hold,
					'editdate'=>date('d-m-Y'),
					'editby'=>$this->session->userdata('nik')
				);
				$this->db->where('nik',$nik);
				$this->db->update('sc_mst.user',$info_edit2);
				redirect("master/user/editprofile/$nik/upsuccess");
			}		
		} else {
			redirect('master/user/index/notacces');
		}		
	}
}