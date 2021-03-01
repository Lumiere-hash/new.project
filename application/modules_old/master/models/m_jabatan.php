<?php
class M_jabatan extends CI_Model{
	function q_jabatan(){
		return $this->db->query("select a.*,shift,
									case 
									when shift='T' then 'YES'
									else 'NO'
									end as shift1,
									lembur,
									case
									when lembur='T' then 'YES'
									else 'NO'
									end as lembur1,
							b.nmdept,c.nmsubdept,d.nmgrade from sc_mst.jabatan a 
							left outer join sc_mst.departmen b on a.kddept=b.kddept
							left outer join sc_mst.subdepartmen c on a.kdsubdept=c.kdsubdept
							left outer join sc_mst.jobgrade d on a.kdgrade=d.kdgrade
							order by kdjabatan asc");
	}
	
	function q_cekjabatan($kdjbt){
		return $this->db->query("select a.*,b.nmdept,c.nmsubdept,d.nmgrade from sc_mst.jabatan a 
								left outer join sc_mst.departmen b on a.kddept=b.kddept
								left outer join sc_mst.subdepartmen c on a.kdsubdept=c.kdsubdept
								left outer join sc_mst.jobgrade d on a.kdgrade=d.kdgrade
								where trim(kdjabatan)='$kdjbt'");
	}
	
	function q_jobgrade(){
		return $this->db->query("select a.*,b.nmlvljabatan from sc_mst.jobgrade a
								left outer join sc_mst.lvljabatan b on a.kdlvl=b.kdlvl 
								order by kdgrade asc");	
	
	}
	function q_cekjobgrade($kdgrade){
		return $this->db->query("select a.*,b.nmlvljabatan from sc_mst.jobgrade a
								left outer join sc_mst.lvljabatan b on a.kdlvl=b.kdlvl
								where trim(kdgrade)='$kdgrade'");	
	
	}
	
	function chain_jobgrade(){
		return $this->db->query("select a.kdjabatan,a.nmjabatan,b.kdgrade ,b.nmgrade from sc_mst.jabatan a
		join sc_mst.jobgrade b on a.kdgrade=b.kdgrade");
	}

				
	
	
	function q_lvljabatan(){
		return $this->db->query("select * from sc_mst.lvljabatan order by kdlvl asc");
	}
	
	function q_ceklvljabatan($kdlvl){
		return $this->db->query("select * from sc_mst.lvljabatan where trim(kdlvl)='$kdlvl'");
	}

	function q_lvlgp($param=null){
	    return $this->db->query("select * from sc_mst.m_lvlgp where kdlvlgp is not null $param order by kdlvlgp asc");
    }
	
	
}



	