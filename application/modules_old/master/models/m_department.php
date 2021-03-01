<?php
class M_department extends CI_Model{
	function q_department(){
		return $this->db->query("select * from sc_mst.departmen order by kddept asc");
	}
	
	function q_subdepartment(){
		return $this->db->query("select a.*,b.nmdept from sc_mst.subdepartmen a 
								left outer join sc_mst.departmen b 
								on a.kddept=b.kddept
								order by kdsubdept asc");
	}
	
	function q_cekdepartment($kddept){
		return $this->db->query("select * from sc_mst.departmen where trim(kddept)='$kddept'");
	}
	
	function q_ceksubdepartment($kdsubdept){
		return $this->db->query("select * from sc_mst.subdepartmen where trim(kdsubdept)='$kdsubdept'");
	}
}



	