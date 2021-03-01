<?php
class M_instock extends CI_Model{
	
	
	public function __construct() {
		parent::__construct();
		$this->load->database();
	}
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}
	
	function q_kdgroup_param($param){
		return $this->db->query("select 
								trim(coalesce(branch    ::text,''))as  branch      ,
								trim(coalesce(kdgroup   ::text,''))as  kdgroup     ,
								trim(coalesce(nmgroup   ::text,''))as  nmgroup     ,
								trim(coalesce(grouphold ::text,''))as  grouphold   ,
								trim(coalesce(keterangan::text,''))as  keterangan  ,
								trim(coalesce(inputdate ::text,''))as  inputdate   ,
								trim(coalesce(inputby   ::text,''))as  inputby     ,
								trim(coalesce(updatedate::text,''))as  updatedate  ,
								trim(coalesce(updateby  ::text,''))as  updateby  from sc_mst.mgroup where kdgroup is not null $param ");
	}
	
	function q_kdsubgroup_param($param){
		return $this->db->query("select trim(coalesce(branch    ::text,'')) as branch      ,
								trim(coalesce(kdsubgroup::text,'')) as kdsubgroup  ,
								trim(coalesce(kdgroup   ::text,'')) as kdgroup     ,
								trim(coalesce(nmsubgroup::text,'')) as nmsubgroup  ,
								trim(coalesce(grouphold ::text,'')) as grouphold   ,
								trim(coalesce(ujikir    ::text,'')) as ujikir      ,
								trim(coalesce(keterangan::text,'')) as keterangan  ,
								trim(coalesce(inputdate ::text,'')) as inputdate   ,
								trim(coalesce(inputby   ::text,'')) as inputby     ,
								trim(coalesce(updatedate::text,'')) as updatedate  ,
								trim(coalesce(updateby  ::text,'')) as updateby from sc_mst.msubgroup where kdsubgroup is not null $param ");
	}
	
	function q_stockcode_param($param){
		return $this->db->query("select 
								trim(coalesce(branch        ::text,'')) as  branch        ,
								trim(coalesce(nodok         ::text,'')) as  nodok         ,
								trim(coalesce(nodokref      ::text,'')) as  nodokref      ,
								trim(coalesce(nmbarang      ::text,'')) as  nmbarang      ,
								trim(coalesce(kdgroup       ::text,'')) as  kdgroup       ,
								trim(coalesce(kdsubgroup    ::text,'')) as  kdsubgroup    ,
								trim(coalesce(kdgudang      ::text,'')) as  kdgudang      ,
								trim(coalesce(nmpemilik     ::text,'')) as  nmpemilik     ,
								trim(coalesce(addpemilik    ::text,'')) as  addpemilik    ,
								trim(coalesce(kdasuransi    ::text,'')) as  kdasuransi    ,
								trim(coalesce(kdrangka      ::text,'')) as  kdrangka      ,
								trim(coalesce(kdmesin       ::text,'')) as  kdmesin       ,
								trim(coalesce(nopol         ::text,'')) as  nopol         ,
								trim(coalesce(hppemilik     ::text,'')) as  hppemilik     ,
								trim(coalesce(typeid        ::text,'')) as  typeid        ,
								trim(coalesce(jenisid       ::text,'')) as  jenisid       ,
								trim(coalesce(modelid       ::text,'')) as  modelid       ,
								trim(coalesce(tahunpembuatan::text,'')) as  tahunpembuatan,
								trim(coalesce(silinder      ::text,'')) as  silinder      ,
								trim(coalesce(warna         ::text,'')) as  warna         ,
								trim(coalesce(bahanbakar    ::text,'')) as  bahanbakar    ,
								trim(coalesce(warnatnkb     ::text,'')) as  warnatnkb     ,
								trim(coalesce(tahunreg      ::text,'')) as  tahunreg      ,
								trim(coalesce(nobpkb        ::text,'')) as  nobpkb        ,
								trim(coalesce(kdlokasi      ::text,'')) as  kdlokasi      ,
								trim(coalesce(expstnkb      ::text,'')) as  expstnkb      ,
								trim(coalesce(exppkbstnkb   ::text,'')) as  exppkbstnkb   ,
								trim(coalesce(nopkb         ::text,'')) as  nopkb         ,
								trim(coalesce(nominalpkb    ::text,'')) as  nominalpkb    ,
								trim(coalesce(pprogresif    ::text,'')) as  pprogresif    ,
								trim(coalesce(brand         ::text,'')) as  brand         ,
								trim(coalesce(hold_item     ::text,'')) as  hold_item     ,
								trim(coalesce(typebarang    ::text,'')) as  typebarang    ,
								trim(coalesce(qty           ::text,'')) as  qty           ,
								trim(coalesce(expdate       ::text,'')) as  expdate       ,
								trim(coalesce(expasuransi   ::text,'')) as  expasuransi   ,
								trim(coalesce(userpakai     ::text,'')) as  userpakai     ,
								trim(coalesce(kddept        ::text,'')) as  kddept        ,
								trim(coalesce(kdsubdept     ::text,'')) as  kdsubdept     ,
								trim(coalesce(kdjabatan     ::text,'')) as  kdjabatan     ,
								trim(coalesce(startpakai    ::text,'')) as  startpakai    ,
								trim(coalesce(endpakai      ::text,'')) as  endpakai      ,
								trim(coalesce(keterangan    ::text,'')) as  keterangan    ,
								trim(coalesce(inputdate     ::text,'')) as  inputdate     ,
								trim(coalesce(inputby       ::text,'')) as  inputby       ,
								trim(coalesce(updatedate    ::text,'')) as  updatedate    ,
								trim(coalesce(updateby      ::text,'')) as  updateby      ,
								trim(coalesce(onhand        ::text,'')) as  onhand        ,
								trim(coalesce(allocated     ::text,'')) as  allocated     ,
								trim(coalesce(uninvoiced    ::text,'')) as  uninvoiced    ,
								trim(coalesce(tmpalloca     ::text,'')) as  tmpalloca     ,
								trim(coalesce(satkecil      ::text,'')) as  satkecil      ,
								trim(coalesce(kdsubasuransi ::text,'')) as  kdsubasuransi ,
								trim(coalesce(lasttrxdate   ::text,'')) as  lasttrxdate   ,
								trim(coalesce(lasttrxdoc    ::text,'')) as  lasttrxdoc,   
								trim(
								coalesce(nmbarang    ::text,'')||'   '||
								coalesce(nopol    ::text,'')
								) as  nmbarangfull   
								from sc_mst.mbarang where nodok is not null $param ");
	}
	
	function q_karyawan($param){
		return $this->db->query("select coalesce(trim(branch              ::text),'') as branch              ,
										coalesce(trim(nik                 ::text),'') as nik                 ,
										coalesce(trim(nmlengkap           ::text),'') as nmlengkap           ,
										coalesce(trim(callname            ::text),'') as callname            ,
										coalesce(trim(jk                  ::text),'') as jk                  ,
										coalesce(trim(neglahir            ::text),'') as neglahir            ,
										coalesce(trim(provlahir           ::text),'') as provlahir           ,
										coalesce(trim(kotalahir           ::text),'') as kotalahir           ,
										coalesce(trim(tgllahir            ::text),'') as tgllahir            ,
										coalesce(trim(kd_agama            ::text),'') as kd_agama            ,
										coalesce(trim(stswn               ::text),'') as stswn               ,
										coalesce(trim(stsfisik            ::text),'') as stsfisik            ,
										coalesce(trim(ketfisik            ::text),'') as ketfisik            ,
										coalesce(trim(noktp               ::text),'') as noktp               ,
										coalesce(trim(ktp_seumurhdp       ::text),'') as ktp_seumurhdp       ,
										coalesce(trim(ktpdikeluarkan      ::text),'') as ktpdikeluarkan      ,
										coalesce(trim(tgldikeluarkan      ::text),'') as tgldikeluarkan      ,
										coalesce(trim(status_pernikahan   ::text),'') as status_pernikahan   ,
										coalesce(trim(gol_darah           ::text),'') as gol_darah           ,
										coalesce(trim(negktp              ::text),'') as negktp              ,
										coalesce(trim(provktp             ::text),'') as provktp             ,
										coalesce(trim(kotaktp             ::text),'') as kotaktp             ,
										coalesce(trim(kecktp              ::text),'') as kecktp              ,
										coalesce(trim(kelktp              ::text),'') as kelktp              ,
										coalesce(trim(alamatktp           ::text),'') as alamatktp           ,
										coalesce(trim(negtinggal          ::text),'') as negtinggal          ,
										coalesce(trim(provtinggal         ::text),'') as provtinggal         ,
										coalesce(trim(kotatinggal         ::text),'') as kotatinggal         ,
										coalesce(trim(kectinggal          ::text),'') as kectinggal          ,
										coalesce(trim(keltinggal          ::text),'') as keltinggal          ,
										coalesce(trim(alamattinggal       ::text),'') as alamattinggal       ,
										coalesce(trim(nohp1               ::text),'') as nohp1               ,
										coalesce(trim(nohp2               ::text),'') as nohp2               ,
										coalesce(trim(npwp                ::text),'') as npwp                ,
										coalesce(trim(tglnpwp             ::text),'') as tglnpwp             ,
										coalesce(trim(bag_dept            ::text),'') as bag_dept            ,
										coalesce(trim(subbag_dept         ::text),'') as subbag_dept         ,
										coalesce(trim(jabatan             ::text),'') as jabatan             ,
										coalesce(trim(lvl_jabatan         ::text),'') as lvl_jabatan         ,
										coalesce(trim(grade_golongan      ::text),'') as grade_golongan      ,
										coalesce(trim(nik_atasan          ::text),'') as nik_atasan          ,
										coalesce(trim(nik_atasan2         ::text),'') as nik_atasan2         ,
										coalesce(trim(status_ptkp         ::text),'') as status_ptkp         ,
										coalesce(trim(besaranptkp         ::text),'') as besaranptkp         ,
										coalesce(trim(tglmasukkerja       ::text),'') as tglmasukkerja       ,
										coalesce(trim(tglkeluarkerja      ::text),'') as tglkeluarkerja      ,
										coalesce(trim(masakerja           ::text),'') as masakerja           ,
										coalesce(trim(statuskepegawaian   ::text),'') as statuskepegawaian   ,
										coalesce(trim(kdcabang            ::text),'') as kdcabang            ,
										coalesce(trim(branchaktif         ::text),'') as branchaktif         ,
										coalesce(trim(grouppenggajian     ::text),'') as grouppenggajian     ,
										coalesce(trim(gajipokok           ::text),'') as gajipokok           ,
										coalesce(trim(gajibpjs            ::text),'') as gajibpjs            ,
										coalesce(trim(namabank            ::text),'') as namabank            ,
										coalesce(trim(namapemilikrekening ::text),'') as namapemilikrekening ,
										coalesce(trim(norek               ::text),'') as norek               ,
										coalesce(trim(tjshift             ::text),'') as tjshift             ,
										coalesce(trim(idabsen             ::text),'') as idabsen             ,
										coalesce(trim(email               ::text),'') as email               ,
										coalesce(trim(bolehcuti           ::text),'') as bolehcuti           ,
										coalesce(trim(sisacuti            ::text),'') as sisacuti            ,
										coalesce(trim(inputdate           ::text),'') as inputdate           ,
										coalesce(trim(inputby             ::text),'') as inputby             ,
										coalesce(trim(updatedate          ::text),'') as updatedate          ,
										coalesce(trim(updateby            ::text),'') as updateby            ,
										coalesce(trim(image               ::text),'') as image               ,
										coalesce(trim(idmesin             ::text),'') as idmesin             ,
										coalesce(trim(cardnumber          ::text),'') as cardnumber          ,
										coalesce(trim(status              ::text),'') as status              ,
										coalesce(trim(tgl_ktp             ::text),'') as tgl_ktp             ,
										coalesce(trim(costcenter          ::text),'') as costcenter          ,
										coalesce(trim(tj_tetap            ::text),'') as tj_tetap            ,
										coalesce(trim(gajitetap           ::text),'') as gajitetap           ,
										coalesce(trim(gajinaker           ::text),'') as gajinaker           ,
										coalesce(trim(tjlembur            ::text),'') as tjlembur            ,
										coalesce(trim(tjborong            ::text),'') as tjborong            ,
										coalesce(trim(kdregu              ::text),'') as kdregu              ,
										coalesce(trim(nmdept              ::text),'') as nmdept              ,
										coalesce(trim(nmsubdept           ::text),'') as nmsubdept           ,
										coalesce(trim(nmlvljabatan        ::text),'') as nmlvljabatan        ,
										coalesce(trim(nmjabatan           ::text),'') as nmjabatan           ,
										coalesce(trim(nmatasan            ::text),'') as nmatasan            ,
										coalesce(trim(nmatasan2           ::text),'') as nmatasan2            from 
								(select a.*,b.nmdept,c.nmsubdept,d.nmlvljabatan,e.nmjabatan,f.nmlengkap as nmatasan,g.nmlengkap as nmatasan2 from sc_mst.karyawan a
								left outer join sc_mst.departmen b on a.bag_dept=b.kddept
								left outer join sc_mst.subdepartmen c on a.subbag_dept=c.kdsubdept and c.kddept=a.bag_dept
								left outer join sc_mst.lvljabatan d on a.lvl_jabatan=d.kdlvl 
								left outer join sc_mst.jabatan e on a.jabatan=e.kdjabatan and e.kdsubdept=a.subbag_dept and e.kddept=a.bag_dept
								left outer join sc_mst.karyawan f on a.nik_atasan=f.nik
								left outer join sc_mst.karyawan g on a.nik_atasan2=g.nik
								where a.tglkeluarkerja is null) as x where nik is not null $param
								");
	}
	
}


