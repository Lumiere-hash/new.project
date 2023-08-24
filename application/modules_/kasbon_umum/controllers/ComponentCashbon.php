<?php defined('BASEPATH') or exit('No direct script access allowed');

class ComponentCashbon extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model(array('master/m_akses'));
        $this->load->library(array('template', 'flashmessage'));
        if (!$this->session->userdata('nik')) {
            redirect(base_url() . '/');
        }
    }
    public function index(){
        $this->load->library(array('datatablessp'));
        $this->load->model('M_ComponentCashbon');
        $this->datatablessp->datatable('table-component-cashbon', 'table table-striped table-bordered table-hover', true)
            ->columns('branch, componentid, description, unit, sort, cashbon_type, calculated, active, readonly, formatcalculated, formatreactive, formatreadonly, edited, deleted')
            ->addcolumn('no', 'no')
            ->addcolumn('edit', '<a href="javascript:void(0)" data-href="'.site_url('kasbon_umum/componentcashbon/action/$1').'" class="btn btn-sm btn-warning popup mr-2">Edit</button>','branch,componentid,edited',true)
            ->addcolumn('delete', '<a href="javascript:void(0)" data-href="'.site_url('kasbon_umum/componentcashbon/action/$1').'" class="btn btn-sm btn-danger popup mr-2">Hapus</button>','branch,componentid,deleted',true)
            ->querystring($this->M_ComponentCashbon->q_component_txt_where())
            ->header('No.', 'no', true, false, true)
            ->header('ID', 'componentid', true, true, true)
            ->header('Deskripsi', 'description', true, true, true)
            ->header('Tipe', 'cashbon_type', true, true, true)
            ->header('Unit', 'unit', true, true, true)
            ->header('Kalkulasi', 'formatcalculated', true, false, true)
            ->header('Aktif', 'formatreactive', true, false, true)
            ->header('Readonly', 'formatreadonly', true, false, true)
            ->header('Aksi', '', true, false, true,array('edit'));
        $this->datatablessp->generateajax();
        $data = array(
            'configkey' => hex2bin(json_encode(array('config'=>'create'))),
            'title'     => 'Data Master Komponen Kasbon',
        );
        $this->template->display('kasbon_umum/component_cashbon/v_index', $data);
    }

    public function search() {
        header('Content-Type: application/json');
        $count = $this->M_ComponentCashbon->q_component_read_where()->num_rows();
        $search = $this->input->get_post('search');
        $search = strtolower(urldecode($search));
        $perpage = $this->input->get_post('perpage');
        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;
        $page = $this->input->get_post('page');
        $page = intval($page > 0 ? $page : 1);
        $limit = $perpage * ($page -1);
        $result = $this->M_ComponentCashbon->q_component_read_where('
            AND ( LOWER(componentid) LIKE \'%'.$search.'%\'
            OR LOWER(description) LIKE \'%'.$search.'%\'
            )
            ORDER BY componentid ASC
            LIMIT '.$perpage.' OFFSET '.$limit.'
            ')->result();
        echo json_encode(array(
            'totalcount' => $count,
            'search' => $search,
            'perpage' => $perpage,
            'page' => $page,
            'limit' => $limit,
            'location' => $result
        ), JSON_NUMERIC_CHECK);
    }

    public function action($param=null)
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_ComponentCashbon'));

        $json = json_decode(hex2bin($param));
        $component = $this->M_ComponentCashbon->q_component_read_where(' AND componentid = \''.$json->componentid.'\' ')->row();
        header('Content-Type: application/json');
        if (!is_null($component->componentid) && !is_null($component->componentid) && !empty($component->componentid) && !is_null($json->edited)){
            if($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A'){
                echo json_encode(array(
                    'data' => $component,
                    'canupdate' => true,
                    'next' => site_url('kasbon_umum/componentcashbon/update/'.bin2hex(json_encode(array('branch' => empty($component->branch) ? $this->session->userdata('branch') : $component->branch, 'componentid' => $component->componentid, 'action' => $component->edited, )))),
                ));
            }
        }
        if (!is_null($component->componentid) && !is_null($component->componentid) && !empty($component->componentid) && !is_null($json->deleted)){
            if($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A'){
                echo json_encode(array(
                    'data' => $component,
                    'candelete' => true,
                    'next' => site_url('trans/cashbon/printoption/'.bin2hex(json_encode(array('branch' => empty($component->branch) ? $this->session->userdata('branch') : $component->branch, 'cashbonid' => $component->cashbonid, 'dutieid' => $cashbon->dutieid, )))),
                ));
            }
        }
    }

    public function update($param)
    {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_ComponentCashbon'));

        $json = json_decode(hex2bin($param));
        $component = $this->M_ComponentCashbon->q_component_read_where(' AND componentid = \''.$json->componentid.'\' ')->row();
        if (!is_null($component->componentid) && !is_null($component->componentid) && !empty($component->componentid) && ($json->action == 'edit')){
            if($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A'){
                $data = array(
                    'backurl'   => site_url('kasbon_umum/componentcashbon/index'),
                    'saveurl'   => site_url('kasbon_umum/componentcashbon/update_submit'),
                    'data'      => $component,
                    'title'     => 'Ubah Master Komponen Kasbon',
                );
                $this->template->display('kasbon_umum/component_cashbon/v_update', $data);
            }
        }else{
            $data = array(
                'title'     => 'data tidak ditemukan',
            );
            $this->template->display('kasbon_umum/component_cashbon/v_update', $data);
        }
    }

    public function update_submit()
    {
        $componentid = $this->input->post('componentid');
        $this->db->trans_start();
        $data = array(
            'description'   => strtoupper($this->input->post('description')),
            'unit'          => strtoupper($this->input->post('unit')),
            'sort'          => sprintf('%02d',$this->input->post('sort')),
            'calculated'    => $this->input->post('calculated'),
            'active'        => $this->input->post('active'),
            'readonly'      => $this->input->post('readonly'),
        );
        $this->db->where('componentid',$componentid);
        $this->db->update('sc_mst.component_cashbon',$data);
        if ($this->db->trans_complete()){
            $response = array(
                'status' => true,
                'title' => 'Perubahan '.$componentid,
                'message' => ucwords($componentid.' berhasil dirubah'),
            );
        }else{
            $response = array(
                'status' => false,
                'title' => 'Perubahan '.$componentid,
                'message' => ucwords($componentid.' gagal disimpan'),
            );
        }
        echo json_encode($response);

    }
}