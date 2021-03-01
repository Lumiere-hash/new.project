<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Trxtype extends MX_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->model('m_trxtype','person');
		$this->load->library(array('form_validation','template','upload','pdf'));   
		
		if(!$this->session->userdata('nik')){
            redirect('dashboard');
        }
	}

	public function index()
	{
		$data['title']='KODE TRX TYPE';
		$data['message']='';
		$this->template->display('master/trxtype/v_trxtype',$data);
	}

	public function ajax_list()
	{
		$list = $this->person->get_datatables();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $person) {
			$no++;
			$row = array();	
			$row[] = $no;
			$row[] = $person->kdtrx;
			$row[] = $person->jenistrx;
			$row[] = $person->uraian;			

			//add html for action
			$row[] = '<a class="btn btn-sm btn-primary" href="javascript:void()" title="Edit" onclick="edit_person('."'".trim($person->kdtrx)."'".')"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
				  <a class="btn btn-sm btn-danger" href="javascript:void()" title="Hapus" onclick="delete_person('."'".trim($person->kdtrx)."'".')"><i class="glyphicon glyphicon-trash"></i> Delete</a>';
		
			$data[] = $row;
		}

		$output = array(
						"draw" => $_POST['draw'],
						"recordsTotal" => $this->person->count_all(),
						"recordsFiltered" => $this->person->count_filtered(),
						"data" => $data,
				);
		//output to json format
		echo json_encode($output);
	}

	public function ajax_edit($id)
	{
		$data = $this->person->get_by_id($id);
		echo json_encode($data);
	}

	public function ajax_add()
	{
		$data = array(
				'kdtrx' => strtoupper($this->input->post('kdtrx')),
				'jenistrx' => strtoupper($this->input->post('jenistrx')),
				'uraian' => strtoupper($this->input->post('uraian')),
			);
		$insert = $this->person->save($data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_update()
	{
		$data = array(
				'kdtrx' => $this->input->post('kdtrx'),
				'jenistrx' => $this->input->post('jenistrx'),
				'uraian' => $this->input->post('uraian'),
			);
		$this->person->update(array('kdtrx' => $this->input->post('kdtrx')), $data);
		echo json_encode(array("status" => TRUE));
	}

	public function ajax_delete($id)
	{
		$this->person->delete_by_id($id);
		echo json_encode(array("status" => TRUE));
	}

}
