<?php
class M_modular extends CI_Model{
	
	function list_modul(){		
		return $this->db->query('select * from "SC_MST".mdlprg');			
	}			
}
