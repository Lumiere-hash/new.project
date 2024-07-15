<?php
class M_option extends CI_Model{
	function q_kantor(){
		return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang");
	}

	function q_option(){
		return $this->db->query("select status,
									case 
									when status='T' then 'AKTIF' 
									when status='F' then 'TIDAK AKTIF'
									end as status1,
                                    REPLACE(kdoption, ':', '_') as kdoption_reformat,
									* from sc_mst.option order by kdoption asc
									 ");
	}

    function q_cekoption($kdoption){
        return $this->db->query("select * from sc_mst.option where trim(kdoption)='$kdoption'");
    }

	function q_pj_hrd(){
		return $this->db->query("select a.*,b.nmlengkap,b.nohp1 from sc_mst.notif_sms a
		left outer join sc_mst.karyawan b on a.nik=b.nik");
	}

	function q_add_notif($info){
		$this->db->insert("sc_hrd.snotif_sms",$info);
	}
	function q_jam_absen(){
		return $this->db->query("select to_char(input_date,'DD-MM-YYYY')as tanggal_input,status as t1, 
		case
		when status='T' then 'AKTIF'
		when status='F' then 'TIDAK AKTIF'
		else 'UNKNOWN'
		end as t1,
		* from sc_mst.option
		where group_option='ABSEN' order by kdoption");

	}
	function q_option_master(){
		return $this->db->query("select status as t1, 
									case 
									when status='t' then 'AKTIF'
									when status='f' then 'TIDAK AKTIF'
									else 'UNKNOWN'
									end as t1,*
									from sc_hrd.option");
	}

	function q_option_cuti(){
		return $this->db->query(" select to_char(input_date,'YYYY-MM-DD')as tanggal_mulai,status as t1, 
									case
									when status='T' then 'AKTIF'
									when status='F' then 'TIDAK AKTIF'
									else 'UNKNOWN'
									end as t1,
									* from sc_mst.option
									where group_option='CUTI' order by kdoption");

	}

	function q_option_reminder(){
		return $this->db->query("select status as t1, 
									case
									when status='T' then 'AKTIF'
									when status='F' then 'TIDAK AKTIF'
									else 'UNKNOWN'
									end as t1,
									* from sc_mst.option
									where group_option='REMINDER'");

	}

	function q_tgl_libur($tgl){
		return $this->db->query("select to_char(tgl_libur,'DD-MM-YYYY')as tanggal_libur,* from sc_mst.libur_nasional 
								where to_char(tgl_libur,'YYYY')='$tgl'
								order by tgl_libur desc");

	}

	function q_hari_kerja(){
		return $this->db->query("select * from sc_mst.hari_kerja");
	}

	function q_group_option(){
		return $this->db->query("select group_option from sc_hrd.group_option");
	}

	function q_cek_exist($nip){
		return $this->db->query("select * from sc_hrd.notif_sms where nip='$nip'");
	}

    function q_option_mail_broadcast(){
	    return $this->db->query("select a.*,b.nmlengkap,b.nmdept,b.nmsubdept,b.nmjabatan,b.nmcabang,b.email,b.nohp1 from sc_mst.option_broadcast a
left outer join sc_mst.lv_m_karyawan b on a.nik=b.nik
where coalesce(statuskepegawaian,'')!='KO'");
    }

    function q_list_karyawan($param){
	    return $this->db->query("select * from sc_mst.lv_m_karyawan where coalesce(statuskepegawaian,'')!='KO' $param order by nmlengkap asc");
    }

    function read($clause = null){
        return $this->db->query($this->read_txt($clause));
    }
    function read_txt($clause = null){
        return sprintf(<<<'SQL'
SELECT * FROM (
    SELECT
        COALESCE(TRIM(a.kdoption),'') AS kdoption,
        COALESCE(TRIM(a.nmoption),'') AS nmoption,
        COALESCE(TRIM(a.value1),'') AS value1,
        a.value2,
        a.value3,
        COALESCE(TRIM(a.status),'') AS status,
        COALESCE(TRIM(a.keterangan),'') AS keterangan,
        COALESCE(TRIM(a.input_by),'') AS input_by,
        COALESCE(TRIM(a.update_by),'') AS update_by,
        a.input_date,
        a.update_date,
        COALESCE(TRIM(a.group_option),'') AS group_option
    FROM sc_mst.option a
) as aa
WHERE TRUE
SQL
            ).$clause;
    }

    function q_master_read($where){
        return $this->db
            ->select('*')
            ->where($where)
            ->get('sc_mst.option');
    }
}
