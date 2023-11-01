<?php defined('BASEPATH') or exit('No direct script access allowed');

class CashbonDinas extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model(array('master/m_akses'));
		$this->load->library(array('template', 'flashmessage', ));
		if (!$this->session->userdata('nik')) {
			redirect(base_url() . '/');
		}
	}
	public function cook() {
        sleep(60 * 2);
        echo 'Ok';
    }
	public function index() {
        $this->load->library(array('datatablessp'));
        $this->load->model(array('m_employee', 'M_Cashbon'));
        if ($this->m_akses->list_aksesperdep()->num_rows() > 0 OR strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
            $this->datatablessp->datatable('table-cashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, dutieid, dutieperiod, employeeid, employeename, departmentname, subdepartmentname')
                ->addcolumn('no', 'no')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('trans/cashbon/actionpopup/$1').'\' class=\'text-green popup\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;Action</i></a>', 'branch, dutieid', true)
                ->querystring($this->M_Cashbon->q_dutie_txt_where(' AND TRUE '))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o.Dinas', 'dutieid', true, true, true)
                ->header('<u>N</u>ik', 'employeeid', true, true, true)
                ->header('Nama Karyawan', 'employeename', true, true, true)
                ->header('Departemen', 'departmentname', true, true, true, array('departmentname', 'subdepartmentname'))
                ->header('Tanggal Dinas', 'dutieperiod', true, true, true)
                ->header('Status', 'statustext', true, true, true)
                ->header('', 'action', false, false, true, array('popup'));
            $this->datatablessp->generateajax();
            $data['title'] = 'Kasbon Dinas Karyawan';
            $this->template->display('trans/cashbon/v_read', $data);
        } else {
            $this->datatablessp->datatable('table-cashbon', 'table table-striped table-bordered table-hover', true)
                ->columns('branch, dutieid, dutieperiod, employeeid, employeename, departmentname, subdepartmentname')
                ->addcolumn('no', 'no')
                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('trans/cashbon/actionpopup/$1').'\' class=\'text-green popup\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;Action</i></a>', 'branch, dutieid', true)
                ->querystring($this->M_Cashbon->q_dutie_txt_where(' AND search ILIKE \'%'.$this->session->userdata('nik').'%\' '))
                ->header('No.', 'no', false, false, true)
                ->header('<u>N</u>o.Dinas', 'dutieid', true, true, true)
                ->header('<u>N</u>ik', 'employeeid', true, true, true)
                ->header('Nama Karyawan', 'employeename', true, true, true)
                ->header('Departemen', 'departmentname', true, true, true, array('departmentname', 'subdepartmentname'))
                ->header('Tanggal Dinas', 'dutieperiod', true, true, true)
                ->header('Status', 'statustext', true, true, true)
                ->header('', 'action', false, false, true, array('popup'));
            $this->datatablessp->generateajax();
            $data['title'] = 'Kasbon Dinas Karyawan';
            $this->template->display('trans/cashbon/v_read', $data);
        }
	}
    function actionpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('M_Cashbon'));
        $cashbon = $this->M_Cashbon->q_dutie_read_where(' AND dutieid = \''.$json->dutieid.'\' ')->row();
        header('Content-Type: application/json');
        if (!is_null($cashbon->approveby) && !empty($cashbon->approveby) && !is_null($cashbon->approvedate)) {
            echo json_encode(array(
                'data' => $cashbon,
                'canprint' => true,
                'next' => site_url('trans/cashbon/printoption/'.bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid, )))),
            ));
        } else if (!is_null($cashbon->cashbonid) && !is_null($cashbon->cashbonid) && !empty($cashbon->cashbonid)) {
            if ($this->m_akses->list_aksesperdep()->num_rows() > 0 or strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A' or $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$cashbon->cashbonid.'\' AND superiors ILIKE \'%'.$this->session->userdata('nik').'%\' ')->num_rows() > 0) {
                echo json_encode(array(
                    'data' => $cashbon,
                    'canapprove' => true,
                    'next' => array(
                        'update' => site_url('trans/cashbon/update/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid,)))),
                        'approve' => site_url('trans/cashbon/approve/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid,)))),
                    ),
                ));
            } else {
                echo json_encode(array(
                    'data' => $cashbon,
                    'canupdate' => true,
                    'next' => site_url('trans/cashbon/update/' . bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'cashbonid' => $cashbon->cashbonid, 'dutieid' => $cashbon->dutieid,)))),
                ));
            }
        } else {
            echo json_encode(array(
                'data' => array('dutieid' => $json->dutieid),
                'cancreate' => true,
                'next' => site_url('trans/cashbon/create/'.bin2hex(json_encode(array('branch' => empty($cashbon->branch) ? $this->session->userdata('branch') : $cashbon->branch, 'dutieid' => $cashbon->dutieid, )))),
            ));
        }
    }
    function create($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $docno = $this->input->get_post('docno');
        if (!empty($docno) && strtolower($docno) != 'null') {
            $docno = "'".implode("','",explode(",",$docno))."'";
            $filter = ' AND id IN ('.$docno.') ';
        }else{
            $filter = ' AND id = \'1\' ';
        }
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/M_TrxType', 'trans/m_employee', 'trans/m_dinas', 'kasbon_umum/M_Cashbon', 'kasbon_umum/M_CashbonComponentDinas', 'trans/M_DestinationType', 'trans/M_CityCashbon'));
        $this->M_Cashbon->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));
        $this->M_CashbonComponentDinas->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' ');
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$json->nik.'\' ')->row();
        $this->datatablessp->datatable('table-dutie', 'table table-striped table-bordered table-hover', true)
            ->columns('branch, id, dutieperiod, employeeid, employeename, departmentname, subdepartmentname,callplan_reformat')
            ->addcolumn('no', 'no')
            ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('trans/cashbon/actionpopup/$1').'\' class=\'text-green popup\'><i class=\'fa fa-edit\'>&nbsp;&nbsp;Action</i></a>', 'branch, dutieid', true)
            ->querystring($this->m_dinas->q_transaction_txt_where(' AND TRUE '.$filter))
            ->header('No.', 'no', false, false, true)
            ->header('<u>N</u>o.Dinas', 'id', true, true, true)
            ->header('Tanggal Dinas', 'dutieperiod', true, true, true)
            ->header('Callplan', 'callplan_reformat', true, true, true);
        $this->datatablessp->generateajax();
        $this->template->display('kasbon_umum/cashbon/dinas/v_create', array(
            'title' => 'Input Kasbon Dinas Karyawan',
            'employee' => $empleyee,
            'cashboncomponentsempty' => $this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid = null AND active AND calculated  ')->result(),
        ));
    }

    function createcomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $json->dutieid = $this->input->get_post('dutieid');
        $json->dutieid = "'".implode("','",explode(",",$json->dutieid))."'";
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', 'trans/M_DestinationType', 'trans/M_CityCashbon'));
        $this->M_Cashbon->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));
        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND dutieid IN ( '.$json->dutieid.') 
            AND TRIM(inputby) <> \''.$this->session->userdata('nik').'\' 
            ORDER BY inputdate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon dinas karyawan nomer <b>'.$edited->dutieid.'</b> sedang diinput oleh <b>'.$edited->inputby.'</b>', 'warning'))
                ->redirect('trans/cashbon/');
        }

        $this->M_Cashbon->q_temporary_create(array(
            'branch' => $this->session->userdata('branch'),
            'cashbonid' => $this->session->userdata('nik'),
            'dutieid' => $this->input->get_post('dutieid'),
            'superior' => '',
            'status' => 'I',
            'paymenttype' => '',
            'totalcashbon' => 0,
            'inputby' => $this->session->userdata('nik'),
            'inputdate' => date('Y-m-d H:i:s'),
        ));
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$json->dutieid.') ')->result();
        foreach ($dinas as $index => $row) {
            $nik = $row->nik;
        }
        $filter = ($dinas->tipe_transportasi == 'TDN' ? " AND componentid <> 'SWK' "  : "");
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$nik.'\' ')->row();
        $this->load->view('kasbon_umum/cashbon/dinas/v_create_component_modal', array(
            'title' => 'Detail Biaya Kasbon',
            'employee' => $empleyee,
            'dutieid' => $this->input->get_post('dutieid') ,
            'cashboncomponents' => $this->M_CashbonComponentDinas->q_temporary_read_where(' AND dutieid IN ('.$json->dutieid.') AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated '.$filter)->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid IN ('.$json->dutieid.') AND active AND calculated  '.$filter)->result(),
        ));
    }
	public function docreatecomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $dutiein = "'".implode("','",explode(",",$json->dutieid))."'";
        $this->load->model(array('M_Cashbon', 'M_CashbonComponentDinas','trans/m_dinas' ));
        $this->M_CashbonComponentDinas->q_temporary_delete(' TRUE AND cashbonid = \''.trim($this->session->userdata('nik')).'\' ');
//        var_dump($_POST);die();
        $id = $this->input->post('id');
//        var_dump($id);die();
        $dutieid = $this->input->post('dutieid');
        $nominal = $this->input->post('nominal');
        $description = $this->input->post('description');
        foreach ($id as $index => $row) {
            $data[$id[$index].':'.$dutieid[$index]] = json_decode(json_encode(
                array(
                    'componentid' => $id[$index],
                    'dutieid' => $dutieid[$index],
                    'nominal' => $nominal[$index],
                    'description' => $description[$index],
                )
            ));
        }
        $dutie = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ')->row();
        $filter = ($dutie->tipe_transportasi == 'TDN' ? " AND componentid <> 'SWK' "  : "");
        $this->db->trans_start();
        foreach (array_unique(explode(",",$json->dutieid)) as $index => $item) {
            foreach ($this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid IN (\''.$item.'\')  AND active '.$filter)->result() as $index => $row) {
                $this->M_CashbonComponentDinas->q_temporary_create(array(
                    'branch' => $this->session->userdata('branch'),
                    'cashbonid' => $this->session->userdata('nik'),
                    'dutieid' => $item,
                    'componentid' => $row->componentid,
                    'nominal' => $row->readonly == 't' ? (int)$row->nominal  : (int)$data[$row->componentid.':'.$item]->nominal,
                    'quantityday' => $row->quantityday,
                    'totalcashbon' => $row->readonly == 't' ? $row->totalcashbon : (($row->multiplication == 't') ? (int)$data[$row->componentid.':'.$item]->nominal * $row->quantityday:(int)$data[$row->componentid.':'.$item]->nominal),
                    'description' => $row->readonly == 't' ? $row->description : $data[$row->componentid.':'.$item]->description,
                    'inputby' => $this->session->userdata('nik'),
                    'inputdate' => date('Y-m-d H:i:s'),
                ));
            }
        }
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail biaya kasbon berhasil dibuat'
        ));
    }
	public function createcomponent($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $dutieid = $this->input->get_post('dutieid');
        $dutiein = "'".implode("','",explode(",",$dutieid))."'";
        $this->load->model(array('trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', ));
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$json->dutieid.'\' ')->row();
        $filter = ($dinas->tipe_transportasi == 'TDN' ? " AND componentid <> 'SWK' "  : "");
        $this->load->view('kasbon_umum/cashbon/dinas/v_component_read', array(
            'cashbon' => $this->M_Cashbon->q_temporary_read_where(' AND dutieid = \''.$dutieid.'\' AND cashbonid = \''.$this->session->userdata('nik').'\' ')->row(),
            'cashboncomponents' => $this->M_CashbonComponentDinas->q_temporary_read_where(' AND dutieid = \''.$dutieid.'\' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated '.$filter)->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid = \''.$dutieid.'\' AND active AND calculated '.$filter)->result(),
        ));
    }
	public function docreate($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', ));
        if ($this->M_Cashbon->q_temporary_exists(' TRUE AND cashbonid = \''.trim($this->session->userdata('nik')).'\' ') && $this->M_CashbonComponentDinas->q_temporary_exists(' TRUE AND cashbonid = \''.trim($this->session->userdata('nik')).'\' ')) {
            $component = $this->M_CashbonComponentDinas->q_temporary_read_where(' AND cashbonid = \''.trim($this->session->userdata('nik')).'\' ORDER BY docref DESC')->row();
            $item = explode(',',$component->dutieid);
            $input = $this->input->post('dutieid');
            if ($item==$input){
                $temporaryCashbon = $this->M_Cashbon->q_temporary_read_where(' AND cashbonid = \''.trim($this->session->userdata('nik')).'\' ')->row();
                if ($temporaryCashbon->totalcashbon > 0){
                    $this->M_Cashbon->q_temporary_update(array(
                        'paymenttype' => $this->input->post('paymenttype'),
                        'status' => 'F',
                        'inputby' => $this->session->userdata('nik'),
                        'inputdate' => date('Y-m-d H:i:s'),
                    ), array(
                        'cashbonid' => trim($this->session->userdata('nik')),
                    ));
                    $transaction = $this->M_Cashbon->q_transaction_read_where(' 
                    AND inputby = \''.trim($this->session->userdata('nik')).'\' 
                    ORDER BY inputdate DESC 
                    ')->row();
                    if (!is_null($transaction) && !is_nan($transaction)) {
                        header('Content-Type: application/json');
                        echo json_encode(array(
                            'data' => $transaction,
                            'message' => 'Data kasbon dinas karyawan berhasil dibuat dengan nomer <b>'.$transaction->cashbonid.'</b>'
                        ));
                    } else {
                        header('Content-Type: application/json');
                        http_response_code(404);
                        echo json_encode(array(
                            'data' => array(),
                            'message' => 'Data kasbon dinas karyawan gagal dibuat'
                        ));
                    }
                }else{
                    header('Content-Type: application/json');
                    http_response_code(403);
                    echo json_encode(array(
                        'data' => array(),
                        'message' => 'Total cashbon tidak boleh 0'
                    ));
                }

            }else{
                header('Content-Type: application/json');
                http_response_code(403);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Nomor referensi dinas berbeda dengan inputan rincian kasbon'
                ));
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>detail biaya kasbon</b> kosong, silahkan input terlebih dahulu'
            ));
        }
    }
    function update($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $dutieid = $json->dutieid;
        $dutiein = "'".implode("','",explode(",",$dutieid))."'";
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/M_TrxType', 'trans/m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', 'trans/M_TrxType', 'trans/M_DestinationType', 'trans/M_CityCashbon','master/m_option'));
        $this->db->trans_start();
        $this->M_Cashbon->q_temporary_delete(array('updateby' => trim($this->session->userdata('nik'))));
        $this->M_CashbonComponentDinas->q_temporary_delete(' TRUE AND updateby = \''.$this->session->userdata('nik').'\' ');
        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon dinas karyawan nomer <b>'.$edited->cashbonid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('trans/cashbon/');
        }
        $this->M_Cashbon->q_transaction_update(
            array('status' => 'U', 'updateby' => $this->session->userdata('nik'), 'updatedate' => date('Y-m-d H:i:s'),),
            array('cashbonid' => $json->cashbonid,)
        );
        $temporary = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND updateby = \''.$this->session->userdata('nik').'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($temporary) && !is_nan($temporary)) {
            $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok IN ('.$dutiein.') ')->row();
            $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$dinas->nik.'\' ')->row();
            $setup = $this->m_option->read(' AND kdoption =\'DUTIE:LIMIT:DATE\' AND group_option = \'DINAS\' ');
            $setup = (($setup->num_rows() > 0) ? $setup->row()->value1 : '' );
            $this->db->trans_complete();
            $this->template->display('kasbon_umum/cashbon/dinas/v_update', array(
                'title' => 'Update Kasbon Dinas Karyawan',
                'employee' => $empleyee,
                'dinas' => $dinas,
                'dutiein' => $dutiein,
                'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$temporary->paymenttype.'\' ')->result(),
                'cashbon' => $temporary,
                'cashboncomponents' => $this->M_CashbonComponentDinas->q_temporary_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated ')->result(),
                'cashboncomponentsempty' => $this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND active AND calculated ')->result(),
            ));
        }
    }
    function updatecomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', 'M_DestinationType', 'M_CityCashbon'));
        $this->M_Cashbon->q_temporary_update(array(
            'updateby' => $this->session->userdata('nik'),
            'updatedate' => date('Y-m-d H:i:s'),
        ), array(
            'cashbonid' => $json->cashbonid,
        ));
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$json->dutieid.'\' ')->row();
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$dinas->nik.'\' ')->row();
        $this->load->view('trans/cashbon/v_update_component_modal', array(
            'title' => 'Detail Biaya Kasbon',
            'employee' => $empleyee,
            'dinas' => $dinas,
            'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \''.$dinas->jenis_tujuan.'\' ')->row(),
            'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \''.$dinas->tujuan_kota.'\' ')->row(),
            'cashbon' => $this->M_Cashbon->q_temporary_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ')->row(),
            'cashboncomponents' => $this->M_CashbonComponentDinas->q_temporary_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated ')->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND active AND calculated ')->result(),
        ));
    }
    public function doupdatecomponentpopup($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_Cashbon', 'M_CashbonComponentDinas','trans/m_dinas' ));
        $id = $this->input->post('id');
        $nominal = $this->input->post('nominal');
        $description = $this->input->post('description');
        foreach ($id as $index => $row) {
            $data[$id[$index]] = json_decode(json_encode(array(
                'componentid' => $id[$index],
                'nominal' => $nominal[$index],
                'description' => $description[$index],
            )));
        }
        $dutie = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$json->nodok.'\' ')->row();
        $filter = ($dutie->tipe_transportasi == 'TDN' ? " AND componentid <> 'SWK' "  : "");
        $this->db->trans_start();
        foreach ($this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid = \''.$json->dutieid.'\' AND active '.$filter)->result() as $index => $row) {
            $totalcashbon = $data[$row->componentid]->nominal;
            if ($row->multiplication == 't') {
                $totalcashbon = $data[$row->componentid]->nominal * $row->quantityday;
            }
            $this->M_CashbonComponentDinas->q_temporary_update(array(
                'branch' => $this->session->userdata('branch'),
                'cashbonid' => $json->cashbonid,
                'componentid' => $row->componentid,
                'nominal' => $row->readonly == 't' ? $row->nominal : (int)$data[$row->componentid]->nominal,
                'quantityday' => $row->quantityday,
                'totalcashbon' => $row->readonly == 't' ? $row->totalcashbon : $totalcashbon,
                'description' => $row->readonly == 't' ? $row->description : $data[$row->componentid]->description,
                'updateby' => $this->session->userdata('nik'),
                'updatedate' => date('Y-m-d H:i:s'),
            ), array(
                'cashbonid' => $json->cashbonid,
                'componentid' => $row->componentid,
            ));
        }
        $this->db->trans_complete();
        header('Content-Type: application/json');
        echo json_encode(array(
            'message' => 'Data detail biaya kasbon berhasil diupdate'
        ));
    }
    public function updatecomponent($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', ));
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$json->dutieid.'\' ')->row();
        $this->load->view('trans/cashbon/v_component_read', array(
            'cashbon' => $this->M_Cashbon->q_temporary_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$json->cashbonid.'\' ')->row(),
            'cashboncomponents' => $this->M_CashbonComponentDinas->q_temporary_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated ')->result(),
            'cashboncomponentsempty' => $this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND active AND calculated ')->result(),
        ));
    }
    public function doupdate($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', ));
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$json->dutieid.'\' ')->row();
        if ($this->M_Cashbon->q_temporary_exists(' TRUE AND cashbonid = \''.$json->cashbonid.'\' ') && $this->M_CashbonComponentDinas->q_temporary_exists(' TRUE AND cashbonid = \''.$json->cashbonid.'\' ')) {
            $this->M_Cashbon->q_temporary_update(array(
                'paymenttype' => $this->input->post('paymenttype'),
                'status' => 'U',
                'updateby' => $this->session->userdata('nik'),
                'updatedate' => date('Y-m-d H:i:s'),
            ), array(
                'cashbonid' => $json->cashbonid,
            ));
            $transaction = $this->M_Cashbon->q_transaction_read_where(' 
                AND updateby = \''.trim($this->session->userdata('nik')).'\' 
                ORDER BY updatedate DESC 
                ')->row();
            if (!is_null($transaction) && !is_nan($transaction)) {
                header('Content-Type: application/json');
                echo json_encode(array(
                    'data' => $transaction,
                    'message' => 'Data kasbon dinas karyawan dengan nomer <b>'.$transaction->cashbonid.'</b> berhasil dirubah'
                ));
            } else {
                header('Content-Type: application/json');
                http_response_code(404);
                echo json_encode(array(
                    'data' => array(),
                    'message' => 'Data kasbon dinas karyawan gagal dirubah'
                ));
            }
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>detail biaya kasbon</b> kosong, silahkan input terlebih dahulu'
            ));
        }
    }
    public function docancel($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', ));
        $this->db->trans_start();
        if ($this->M_Cashbon->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' OR updateby = \''.$this->session->userdata('nik').'\' ') && $this->M_CashbonComponentDinas->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' OR updateby = \''.$this->session->userdata('nik').'\' ')) {
            $this->db->trans_complete();
            header('Content-Type: application/json');
            echo json_encode(array(
                'message' => 'Data kasbon dinas karyawan berhasil direset'
            ));
        } else {
            header('Content-Type: application/json');
            http_response_code(404);
            echo json_encode(array(
                'data' => array(),
                'message' => 'Data <b>kasbon dinas karyawan</b> tidak berhasil direset'
            ));
        }
    }
    function approve($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library(array('datatablessp'));
        $this->load->model(array('trans/M_TrxType', 'trans/m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', 'trans/M_TrxType', 'trans/M_DestinationType', 'trans/M_CityCashbon'));
        $this->db->trans_start();
        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon dinas karyawan nomer <b>'.$edited->cashbonid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('trans/cashbon/');
        }
        $transaksi = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' AND approvedate IS NULL ')->row();
        if (!is_null($transaksi) && !is_nan($transaksi)) {
            $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$json->dutieid.'\' ')->row();
            $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$dinas->nik.'\' ')->row();
            $this->db->trans_complete();
            $this->template->display('trans/cashbon/v_approve', array(
                'title' => 'Persetujuan Kasbon Dinas Karyawan',
                'employee' => $empleyee,
                'dinas' => $dinas,
                'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \''.$dinas->jenis_tujuan.'\' ')->row(),
                'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \''.$dinas->tujuan_kota.'\' ')->row(),
                'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \''.$dinas->transportasi.'\' ')->row(),
                'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$transaksi->paymenttype.'\' ')->row(),
                'cashbon' => $transaksi,
                'cashboncomponents' => $this->M_CashbonComponentDinas->q_transaction_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$json->cashbonid.'\' AND active AND calculated ')->result(),
                'cashboncomponentsempty' => $this->M_CashbonComponentDinas->q_empty_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND active AND calculated ')->result(),
            ));
        }
    }
    public function doapprove($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('m_employee', 'trans/m_dinas', 'M_Cashbon', 'M_CashbonComponentDinas', ));
        $this->db->trans_start();
        $edited = $this->M_Cashbon->q_temporary_read_where(' 
            AND cashbonid = \''.$json->cashbonid.'\' 
            AND TRIM(updateby) <> \''.trim($this->session->userdata('nik')).'\' 
            ORDER BY updatedate DESC 
            ')->row();
        if (!is_null($edited) && !is_nan($edited)) {
            $this->flashmessage
                ->set(array('Data kasbon dinas karyawan nomer <b>'.$edited->cashbonid.'</b> sedang diupdate oleh <b>'.$edited->updateby.'</b>', 'warning'))
                ->redirect('trans/cashbon/');
        }
        $this->M_Cashbon->q_transaction_update(
            array('status' => 'P', 'approveby' => $this->session->userdata('nik'), 'approvedate' => date('Y-m-d H:i:s'),),
            array('cashbonid' => $json->cashbonid,)
        );
        $this->db->trans_complete();
        echo json_encode(array(
            'message' => 'Data kasbon dinas karyawan berhasil disetujui'
        ));
    }
    public function printoption($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('trans/M_TrxType', 'trans/m_dinas', 'trans/m_employee', 'M_Cashbon', 'M_CashbonComponentDinas', 'trans/M_DestinationType', 'trans/M_CityCashbon', 'master/m_option', 'master/M_RegionalOffice' ));
        $setup = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row();
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ORDER BY updatedate DESC ')->row();
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$cashbon->dutieid.'\' ')->row();
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$dinas->nik.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$empleyee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->load->view('trans/cashbon/v_print_option', array(
            'title' => 'Cetak Kasbon Dinas Karyawan '.$cashbon->cashbonid,
            'city' => ucfirst(strtolower($city)).', ',
            'employee' => $empleyee,
            'dinas' => $dinas,
            'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \''.$dinas->jenis_tujuan.'\' ')->row(),
            'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \''.$dinas->tujuan_kota.'\' ')->row(),
            'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \''.$dinas->transportasi.'\' ')->row(),
            'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
            'cashbon' => $cashbon,
            'cashboncomponents' => $this->M_CashbonComponentDinas->q_transaction_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
        ));
    }
    public function preview($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->model(array('M_TrxType', 'trans/m_dinas', 'm_employee', 'M_Cashbon', 'M_CashbonComponentDinas', 'M_DestinationType', 'M_CityCashbon', 'master/m_option', 'master/M_RegionalOffice'));
        $setup = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row();
        $fontsize = (int)($this->input->get_post('fontsize') ?: 0);
        $marginsize = (int)($this->input->get_post('marginsize') ?: 0);
        $paddingsize = (int)($this->input->get_post('paddingsize') ?: 0);
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ORDER BY updatedate DESC ')->row();
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$cashbon->dutieid.'\' ')->row();
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$dinas->nik.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$empleyee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->load->view('trans/cashbon/v_read_pdf', array(
            'title' => 'Cetak Kasbon Dinas Karyawan '.$cashbon->cashbonid,
            'city' => ucfirst(strtolower($city)).', ',
            'fontsize' => $fontsize,
            'marginsize' => $marginsize,
            'paddingsize' => $paddingsize,
            'employee' => $empleyee,
            'dinas' => $dinas,
            'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \''.$dinas->jenis_tujuan.'\' ')->row(),
            'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \''.$dinas->tujuan_kota.'\' ')->row(),
            'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \''.$dinas->transportasi.'\' ')->row(),
            'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
            'cashbon' => $cashbon,
            'cashboncomponents' => $this->M_CashbonComponentDinas->q_transaction_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
        ));
    }
    public function exportpdf($param=null) {
        $json = json_decode(
            hex2bin($param)
        );
        $this->load->library('pdfs');
        $this->load->model(array('M_TrxType', 'trans/m_dinas', 'm_employee', 'M_Cashbon', 'M_CashbonComponentDinas', 'M_DestinationType', 'M_CityCashbon', 'master/m_option', 'master/M_RegionalOffice'));
        $setup = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row();
        $fontsize = (int)($this->input->get_post('fontsize') ?: 0);
        $marginsize = (int)($this->input->get_post('marginsize') ?: 0);
        $paddingsize = (int)($this->input->get_post('paddingsize') ?: 0);
        $cashbon = $this->M_Cashbon->q_transaction_read_where(' AND cashbonid = \''.$json->cashbonid.'\' ORDER BY updatedate DESC ')->row();
        $dinas = $this->m_dinas->q_transaction_read_where(' AND nodok = \''.$cashbon->dutieid.'\' ')->row();
        $empleyee = $this->m_employee->q_mst_read_where(' AND nik = \''.$dinas->nik.'\' ')->row();
        if($this->m_option->read(' AND kdoption = \'REGIONAL:OFFICE\' AND status = \'T\' ')->num_rows() > 0){
            $city = $this->m_option->read(' AND kdoption = \'BRANCH:CITY\' ')->row()->value1;
        }else{
            $city = $this->M_RegionalOffice->read(' AND kdcabang = \''.$empleyee->kdcabang.'\' ')->row()->regional_name;
        }
        $this->pdfs->loadHtml(
            $this->load->view('trans/cashbon/v_read_pdf', array(
                'title' => 'Cetak Kasbon Dinas Karyawan '.$cashbon->cashbonid,
                'city' => ucfirst(strtolower($city)).', ',
                'fontsize' => $fontsize,
                'marginsize' => $marginsize,
                'paddingsize' => $paddingsize,
                'employee' => $empleyee,
                'dinas' => $dinas,
                'destinationtype' => $this->M_DestinationType->q_master_search_where(' AND id = \''.$dinas->jenis_tujuan.'\' ')->row(),
                'citycashbon' => $this->M_CityCashbon->q_master_search_where(' AND id = \''.$dinas->tujuan_kota.'\' ')->row(),
                'transportasi' => $this->M_TrxType->q_master_search_where(' AND a.group = \'TRANSP\' AND id = \''.$dinas->transportasi.'\' ')->row(),
                'paymenttype' => $this->M_TrxType->q_master_search_where(' AND a.group = \'PAYTYPE\' AND id = \''.$cashbon->paymenttype.'\' ')->row(),
                'cashbon' => $cashbon,
                'cashboncomponents' => $this->M_CashbonComponentDinas->q_transaction_read_where(' AND dutieid = \''.$dinas->nodok.'\' AND cashbonid = \''.$cashbon->cashbonid.'\' AND active AND calculated ')->result(),
            ), true)
        );
        $this->pdfs->setPaper('A4', 'landscape');
        $this->pdfs->render();
        $this->pdfs->stream('CASHBON'.$json->complaintid.'.PDF', array('Attachment' => 0));
    }
    
	public function search() {
		header('Content-Type: application/json');
		$brand = $this->input->get_post('brand');
		$count = $this->M_DestinationType->q_master_search_where('
			AND a.active
			')->num_rows();
		$search = $this->input->get_post('search');
		$search = strtolower(urldecode($search));
		$perpage = $this->input->get_post('perpage');
		$perpage = intval($perpage);
		$perpage = $perpage < 1 ? $count : $perpage;
		$page = $this->input->get_post('page');
		$page = intval($page > 0 ? $page : 1);
		$limit = $perpage * ($page -1);
		$result = $this->M_DestinationType->q_master_search_where('
            AND a.active
            AND ( LOWER(id) LIKE \'%'.$search.'%\'
            OR LOWER(text) LIKE \'%'.$search.'%\'
            )
            ORDER BY text ASC
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

    /*begin::kasbon dinas*/
    function create_cashbon($param)
    {
        $this->load->model(array('M_CashbonComponentDinas','M_Cashbon','M_FindDocument'));
        $this->M_Cashbon->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));
        $this->M_CashbonComponentDinas->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));
        $this->M_FindDocument->q_temporary_delete(array('cashbonid' => trim($this->session->userdata('nik'))));

        if ($param){
            $json = json_decode(
                hex2bin($param)
            );
            $this->load->model(array('trans/M_TrxType'));
            $type = $this->M_TrxType->q_master_search_where('
			    AND a.group IN (\'CASHBONTYPE\') AND id IN (\''.$json->type.'\')
			')->row();

            if ($type) {

                switch ($type->id){
                    case "PO":
                        $this->M_FindDocument->q_temporary_delete(' TRUE AND cashbonid = \''.$this->session->userdata('nik').'\' ');
                        $data = array(
                            'saveurl' => site_url('kasbon_umum/cashbon/docreate_cashbon'),
                            'title' => ' Kasbon ' . $type->text,
                            'title_detail' => ' Dokumen ' . $type->text,
                            'code_type' => $json->type,
                            'type'  => $param,
                            'formattype'    => $type->text,
                            'cashboncomponents'         => $this->M_CashbonComponentDinas->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                            'cashboncomponentsempty'    => $this->M_CashbonComponentDinas->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                        );
                        $this->template->display('kasbon_umum/cashbon/v_create_po', $data);
                        break;
                    case "BL":
                        $data = array(
                            'saveurl'                   => site_url('kasbon_umum/cashbon/docreate_cashbon'),
                            'title'                     => ' Kasbon ' . $type->text,
                            'title_detail'              => ' Dokumen ' . $type->text,
                            'code_type'                 => $json->type,
                            'type'                      => $param,
                            'formattype'    => $type->text,
                            'cashboncomponents'         => $this->M_CashbonComponentDinas->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                            'cashboncomponentsempty'    => $this->M_CashbonComponentDinas->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                        );
                        $this->template->display('kasbon_umum/cashbon/v_create_bl', $data);
                        break;
                    case "AI":
                        $data = array(
                            'saveurl'                   => site_url('kasbon_umum/cashbon/docreate_cashbon'),
                            'title'                     => ' Kasbon ' . $type->text,
                            'title_detail'              => ' Dokumen ' . $type->text,
                            'code_type'                 => $json->type,
                            'type'                      => $param,
                            'formattype'                => $type->text,
                            'cashboncomponents'         => $this->M_CashbonComponentDinas->q_temporary_read_where(' AND cashbonid = \''.$this->session->userdata('nik').'\' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                            'cashboncomponentsempty'    => $this->M_CashbonComponentDinas->q_empty_read_where(' AND active AND calculated AND type = \''.$json->type.'\'')->result(),
                        );
                        $this->template->display('kasbon_umum/cashbon/v_create_bl', $data);
                        break;
                    case "DN":
                        $this->load->library(array('datatablessp'));
                        $this->load->model(array('trans/M_Employee'));
                        if ($this->m_akses->list_aksesperdep()->num_rows() < 0 OR strtoupper(trim($this->m_akses->q_user_check()->row()->level_akses)) === 'A') {
                            $this->datatablessp->datatable('table-employee', 'table table-striped table-bordered table-hover', true)
                                ->columns('branch, nik, nmlengkap, nmdept, nmsubdept, nmjabatan')
                                ->addcolumn('no', 'no')
                                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/cashbondinas/createpopup/$1').'\' class=\'btn btn-sm btn-success popup pull-right\'>Buat Kasbon</a>', 'branch, nik', true)
                                ->querystring($this->M_Employee->q_mst_txt_where(' AND TRUE '))
                                ->header('No.', 'no', false, false, true)
                                ->header('Nik', 'nik', true, true, true, array('nik','popup') )
                                ->header('Nama Karyawan', 'nmlengkap', true, true, true )
                                ->header('Departemen', 'nmdept', true, true, true)
                                ->header('Subdepartemen', 'nmsubdept', true, true, true)
                                ->header('Jabatan', 'nmjabatan', true, true, true);
                            $this->datatablessp->generateajax();
                            $data['title'] = 'Kasbon Dinas Karyawan';
                            $this->template->display('kasbon_umum/cashbon/dinas/v_employee', $data);
                        } else {
                            $this->datatablessp->datatable('table-employee', 'table table-striped table-bordered table-hover', true)
                                ->columns('branch, nik, nmlengkap, nmdept, nmsubdept, nmjabatan')
                                ->addcolumn('no', 'no')
                                ->addcolumn('popup', '<a href=\'javascript:void(0)\' data-href=\''.site_url('kasbon_umum/cashbondinas/createpopup/$1').'\' class=\'btn btn-sm btn-success popup pull-right\'>Buat Kasbon</a>', 'branch, nik', true)
                                ->querystring($this->M_Employee->q_mst_txt_where(' AND search ilike \'%'.trim($this->session->userdata('nik')).'%\' '))
                                ->header('No.', 'no', false, false, true)
                                ->header('Nik', 'nik', true, true, true, array('nik','popup') )
                                ->header('Nama Karyawan', 'nmlengkap', true, true, true )
                                ->header('Departemen', 'nmdept', true, true, true)
                                ->header('Subdepartemen', 'nmsubdept', true, true, true)
                                ->header('Jabatan', 'nmjabatan', true, true, true);
                            $this->datatablessp->generateajax();
                            $data['title'] = 'Kasbon Dinas Karyawan';
                            $this->template->display('kasbon_umum/cashbon/dinas/v_employee', $data);
                        }
                        break;
                }

            }else{
                redirect('kasbon_umum/cashbon/index');
            }
        }else{
            redirect('kasbon_umum/cashbon/index');
        }


    }

    public function createpopup($param)
    {
        $json = json_decode(
            hex2bin($param)
        );
        switch (strtoupper($this->input->get_post('type'))){
            case "DN":
                header('Content-Type: application/json');
                http_response_code(200);
                echo json_encode(array(
                    'cancreate' => TRUE,
                    'next' => site_url('kasbon_umum/cashbondinas/create/'.bin2hex(json_encode(array('nik'=>$json->nik,'type'=>'DN')))),
                ));
                break;
        }
    }


    /*end::kasbon dinas*/
}
