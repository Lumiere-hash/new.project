<?php
/**
 * Created by PhpStorm.
 *  * User: FIKY-PC
 *  * Date: 5/3/19 8:44 AM
 *  * Last Modified: 4/12/19 11:11 AM.
 *  Developed By: Fiky Ashariza Powered By PhpStorm
 *  Copyright© 2019 .All rights reserved.
 *
 */

class Fiky_grade
{

    protected $_CI;

       function __construct(){
           $this->_CI=&get_instance();
           $this->_CI->load->model(array('master/m_akses','master/m_menu'));
           $this->_CI->load->library(array('session','Fiky_version','Fiky_string','Fiky_menu','Fiky_encryption','Fiky_wilayah'));
       }

    function coba(){
        return 'TEST';
        /**
         * P1 : KODEMENU
         * P2 : NAMA VERSI
         * P3 : SESSION
         */
    }

    function list_lvljabatan($param = null){
        return $this->_CI->db->query("select * from sc_mst.lvljabatan where kdlvl is not null $param order by kdlvl asc");
    }

    function list_grade($param = null){
        return $this->_CI->db->query("select * from 
                                        (select a.*,b.nmlvljabatan from sc_mst.jobgrade a 
                                        left outer join sc_mst.lvljabatan b on a.kdlvl=b.kdlvl) as x
                                        where kdgrade is not null $param                                        
                                        order by kdgrade asc");
    }

    function list_lvlgaji($param = null){
        return $this->_CI->db->query("select * from sc_mst.m_lvlgp
                                        where c_hold ='NO' $param
                                        order by kdlvlgp");
    }


   function getLvljabatan($p){
       $gmed=json_decode($p);
       $gmed->search;
       $search = $gmed->search;
       $perpage = $gmed->perpage;
       $page = $gmed->page;
       $paramlvljab = $gmed->paramlvljab;
       $param_c="";
       $count = $this->list_lvljabatan($param_c)->num_rows();
       $search = strtoupper(urldecode($search));

       $perpage = intval($perpage);
       $perpage = $perpage < 1 ? $count : $perpage;


       $page = intval($page);
       $limit = $perpage * $page;

       $param=" and (kdlvl like '%$search%' $paramlvljab ) or (nmlvljabatan like '%$search%' $paramlvljab )";
       $result = $this->list_lvljabatan($param)->result();
       header('Content-Type: application/json');
       $datanya = json_encode(
           array(
               'totalcount' => $count,
               'search' => $search,
               'perpage' => $perpage,
               'page' => $page,
               'limit' => $limit,
               'group' => $result,
               'paramlvljab' => $paramlvljab
           ),
           JSON_PRETTY_PRINT
       );
       return $datanya;
   }

   function getJobgrade($p){
       $gmed=json_decode($p);
       $gmed->search;
       $search = $gmed->search;
       $perpage = $gmed->perpage;
       $page = $gmed->page;
       $lvl_jabatan = $gmed->lvl_jabatan;

       $param_c="";
       $count = $this->list_grade($param_c)->num_rows();

       $search = strtoupper(urldecode($search));

       $perpage = intval($perpage);
       $perpage = $perpage < 1 ? $count : $perpage;

       $page = intval($page);
       $limit = $perpage * $page;
       $param=" and (kdlvl='$lvl_jabatan' and nmgrade like '%$search%') or (kdlvl='$lvl_jabatan' and nmgrade like '%$search%')";
       $result = $this->list_grade($param)->result();
       header('Content-Type: application/json');
       echo json_encode(
           array(
               'totalcount' => $count,
               'search' => $search,
               'perpage' => $perpage,
               'page' => $page,
               'limit' => $limit,
               'group' => $result,
               'lvl_jabatan' => $lvl_jabatan
           ),
           JSON_PRETTY_PRINT
       );
   }

    function getKdlvlgp($p){
        $gmed=json_decode($p);
        $gmed->search;
        $search = $gmed->search;
        $perpage = $gmed->perpage;
        $page = $gmed->page;
        $grade_golongan = $gmed->grade_golongan;


        $dtlgrade= $this->list_grade(" and kdgrade='$grade_golongan'")->row_array();
        $kdlvlgpmin = $dtlgrade['kdlvlgpmin'];
        $kdlvlgpmax = $dtlgrade['kdlvlgpmax'];

        $param_c="";
        $count = $this->list_lvlgaji($param_c)->num_rows();

        $search = strtoupper(urldecode($search));

        $perpage = intval($perpage);
        $perpage = $perpage < 1 ? $count : $perpage;

        $page = intval($page);
        $limit = $perpage * $page;
        $param=" and (kdlvlgp between '$kdlvlgpmin' and '$kdlvlgpmax' and kdlvlgp like '%$search%')";
        $result = $this->list_lvlgaji($param)->result();
        header('Content-Type: application/json');
        echo json_encode(
            array(
                'totalcount' => $count,
                'search' => $search,
                'perpage' => $perpage,
                'page' => $page,
                'limit' => $limit,
                'group' => $result,
                'grade_golongan' => $grade_golongan
            ),
            JSON_PRETTY_PRINT
        );
    }

    
}
