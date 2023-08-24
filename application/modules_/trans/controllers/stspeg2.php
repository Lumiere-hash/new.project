<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Stspeg extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_stspeg');
		$this->load->library(array('form_validation','template','upload','pdf'));   
		
		if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
	}

	public function index()
	{
		$data['title']='STATUS KEPEGAWAIAN';
		$data['message']='';
		$this->template->display('trans/stskepegawaian/v_stskepegawaian',$data);
	}

	public function ajax_list()
	{
		$list = $this->m_stspeg->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->kdkepegawaian;
			$row[] = $person->nmkepegawaian;				

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".trim($person->kdkepegawaian)."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".trim($person->kdkepegawaian)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->m_stspeg->count_all(),
						"recordsFiltered" => $this->m_stspeg->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->m_stspeg->get_by_id($id);
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
		$insert = $this->m_stspeg->save($data);
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
		$this->m_stspeg->update(array('kdkepegawaian' => $this->input->post('kdkepegawaian')), $data);
		echo json_encode(array("status" => TRUE));
		
		$data['message']='Update succes';
	}

	public function ajax_delete($id)
	{
		$this->m_stspeg->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
