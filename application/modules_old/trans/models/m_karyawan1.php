<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_karyawan extends CI_Model {

	var $table = 'sc_tmp.karyawan';
	var $tablemst = 'sc_mst.karyawan';
	var $column = array('nik','nmlengkap','nmdept','nmjabatan');
	var $order = array('nik' => 'asc');

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	private function _get_datatables_query()
	{
		
		$this->db->select('nmjabatan,nmdept,a.*, a.tglmasukkerja as tglmasuk');
		$this->db->from('sc_mst.karyawan a');
		$this->db->join('sc_mst.departmen b','a.bag_dept=b.kddept','left');
		$this->db->join('sc_mst.jabatan c','a.jabatan=c.kdjabatan','left');
		$this->db->where("coalesce(upper(a.statuskepegawaian),'')!='KO'");

		$i = 0;
	
		foreach ($this->column as $item) 
		{
			if($_POST['search']['value'])				
				($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
			$column[$i] = $item;
			$i++;
		}
		
		if(isset($_POST['order']))
		{
			$this->db->order_by($column[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} 
		else if(isset($this->order))
		{
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}
	
	function list_karyawan(){
		return $this->db->query("select * from sc_mst.karyawan where coalesce(upper(statuskepegawaian),'')!='KO'");
	}
	
	function list_karyresgn(){
		return $this->db->query("select a.*,a.nik,a.nmlengkap,b.nmjabatan,c.nmdept from sc_mst.karyawan a
		left outer join sc_mst.jabatan b on a.jabatan=b.kdjabatan
		left outer join sc_mst.departmen c on a.bag_dept=c.kddept where coalesce(a.statuskepegawaian,'')='KO'");
	}	
	
	function list_karyborong(){
		return $this->db->query("select a.*,a.nik,a.nmlengkap,b.nmjabatan,c.nmdept from sc_mst.karyawan a
		left outer join sc_mst.jabatan b on a.jabatan=b.kdjabatan
		left outer join sc_mst.departmen c on a.bag_dept=c.kddept where a.tjborong='t' and a.statuskepegawaian<>'KO'");
	}

	
	function cek_exist($nik){
		return $this->db->query("select * from sc_mst.karyawan where nik='$nik'")->num_rows();
	}
	
	function get_datatables()
	{
		$this->_get_datatables_query();
		if($_POST['length'] != -1)
		$this->db->limit($_POST['length'],$_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	function count_filtered()
	{
		$this->_get_datatables_query();
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function count_all()
	{
		$this->db->from($this->table);
		return $this->db->count_all_results();
	}

	public function get_dtl_id($id)
	{				
		return $this->db->query(" select image,trim(nik) as nik,trim(nmlengkap) as nmlengkap,trim(callname) as callname,trim(jk) as jk,trim(b.namanegara) as neglahir,trim(c.namaprov) as provlahir,trim(d.namakotakab) as kotalahir,
									to_char(tgllahir,'dd-mm-yyyy') as tgllahir,trim(kd_agama) as kdagama,stswn,stsfisik,trim(ketfisik) as ketfisik,trim(noktp) as noktp,tgl_ktp,ktp_seumurhdp,ktpdikeluarkan,to_char(tgldikeluarkan,'dd-mm-yyyy') as tgldikeluarkan,
									trim(stastus_pernikahan) as stastus_pernikahan,trim(gol_darah) as goldarah,trim(e.namanegara) as negktp,trim(f.namaprov) as provktp,trim(g.namakotakab) as kotaktp,
									trim(h.namakec) as kecktp,trim(i.namakeldesa) as kelktp,trim(alamatktp) as alamatktp,trim(j.namanegara) as negtinggal,trim(k.namaprov) as provtinggal,trim(l.namakotakab) as kotatinggal,
									trim(m.namakec) as kectinggal,trim(n.namakeldesa) as keltinggal,alamattinggal,nohp1,nohp2,npwp,to_char(tglnpwp,'dd-mm-yyyy') as tglnpwp,trim(bag_dept) as bag_dept,trim(subbag_dept) subbag_dept,
									trim(jabatan) as jabatan,trim(lvl_jabatan) as lvl_jabatan,trim(grade_golongan) as grade_golongan,trim(nik_atasan) as nik_atasan,trim(nik_atasan2) as nik_atasan2,trim(status_ptkp) as status_ptkp,
									besaranptkp,to_char(tglmasukkerja,'dd-mm-yyyy') as tglmasukkerja,tglkeluarkerja,masakerja,trim(statuskepegawaian) as statuskepegawaian,trim(grouppenggajian) as grouppenggajian,
									gajipokok,gajibpjs,trim(namabank) as namabank,namapemilikrekening,
									norek,trim(tjshift) as tjshift,idabsen,email,bolehcuti,sisacuti,a.inputdate,a.inputby,a.updatedate,a.updateby,a.idmesin,a.cardnumber,a.tjlembur,a.tjborong from sc_mst.karyawan a
									left outer join sc_mst.negara b on b.kodenegara=a.neglahir
									left outer join sc_mst.provinsi c on c.kodeprov=a.provlahir
									left outer join sc_mst.kotakab d on d.kodekotakab=a.kotalahir 
									left outer join sc_mst.negara e on e.kodenegara=a.negktp
									left outer join sc_mst.provinsi f on f.kodeprov=a.provktp
									left outer join sc_mst.kotakab g on g.kodekotakab=a.kotaktp
									left outer join sc_mst.kec h on h.kodekec=a.kecktp
									left outer join sc_mst.keldesa i on i.kodekeldesa=a.kelktp 
									left outer join sc_mst.negara j on j.kodenegara=a.negtinggal
									left outer join sc_mst.provinsi k on k.kodeprov=a.provtinggal
									left outer join sc_mst.kotakab l on l.kodekotakab=a.kotatinggal
									left outer join sc_mst.kec m on m.kodekec=a.kectinggal
									left outer join sc_mst.keldesa n on n.kodekeldesa=a.keltinggal where nik='$id'");			
	}
	
	public function get_by_id($id)
	{				
		return $this->db->query(" select trim(nik) as nik,trim(nmlengkap) as nmlengkap,trim(callname) as callname,trim(jk) as jk,trim(neglahir) as neglahir,trim(provlahir) as provlahir,trim(kotalahir) as kotalahir,
						to_char(tgllahir,'dd-mm-yyyy') as tgllahir,trim(kd_agama) as kdagama,stswn,stsfisik,trim(ketfisik) as ketfisik,trim(noktp) as noktp,tgl_ktp,ktp_seumurhdp,ktpdikeluarkan,to_char(tgldikeluarkan,'dd-mm-yyyy') as tgldikeluarkan,
						trim(stastus_pernikahan) as stastus_pernikahan,trim(gol_darah) as goldarah,trim(negktp) as negktp,trim(provktp) as provktp,trim(kotaktp) as kotaktp,
						trim(kecktp) as kecktp,trim(kelktp) as kelktp,trim(alamatktp) as alamatktp,trim(negtinggal) as negtinggal,trim(provtinggal) as provtinggal,trim(kotatinggal) as kotatinggal,
						trim(kectinggal) as kectinggal,trim(keltinggal) as keltinggal,alamattinggal,nohp1,nohp2,npwp,tglnpwp,trim(bag_dept) as bag_dept,trim(subbag_dept) subbag_dept,
						trim(jabatan) as jabatan,trim(lvl_jabatan) as lvl_jabatan,trim(grade_golongan) as grade_golongan,trim(nik_atasan) as nik_atasan,trim(nik_atasan2) as nik_atasan2,trim(status_ptkp) as status_ptkp,
						besaranptkp,to_char(tglmasukkerja,'dd-mm-yyyy') as tglmasukkerja,to_char(tglkeluarkerja,'dd-mm-yyyy') as tglkeluarkerja,masakerja,trim(statuskepegawaian) as statuskepegawaian,trim(grouppenggajian) as grouppenggajian,
						gajipokok,gajibpjs,gajinaker,trim(namabank) as namabank,namapemilikrekening,
						norek,trim(tjshift) as tjshift,idabsen,email,bolehcuti,sisacuti,inputdate,inputby,updatedate,updateby,image,idmesin,cardnumber,tjlembur,tjborong from sc_mst.karyawan where nik='$id'");			
	}

	public function save($data) 
	{
		return $this->db->insert($this->table, $data);
		//return $this->db->insert_id();
	}
	
	public function save_foto($nip,$info) 
	{
		$this->db->where('nik',$nip);
		$this->db->update($this->tablemst, $info);		
	}

	public function update($where, $data)
	{
		$this->db->update($this->tablemst, $data, $where);
		return $this->db->affected_rows();
	}

	public function delete_by_id($id)
	{
		//$this->db->where('nik', $id);
		return $this->db->query("update sc_mst.karyawan set status='D' where nik='$id'");
	}
	
	function list_ptkp(){
		return $this->db->query("select * from sc_mst.status_nikah order by kdnikah");
	}
	
	function q_besaranptkp($status_ptkp){
		return $this->db->query("select cast(besaranpertahun as numeric(18,0)) from sc_mst.ptkp where kodeptkp='$status_ptkp'");
	
	}


}
