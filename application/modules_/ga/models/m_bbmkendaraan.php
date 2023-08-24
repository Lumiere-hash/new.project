<?php
class M_bbmkendaraan extends CI_Model{
	
	function q_versidb($kodemenu){
		return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
	}
    function q_trxerror($paramtrxerror){
        return $this->db->query("select * from (
								select a.*,b.description from sc_mst.trxerror a
								left outer join sc_mst.errordesc b on a.modul=b.modul and a.errorcode=b.errorcode) as x
								where userid is not null $paramtrxerror");
    }
    function q_master_branch(){
        return $this->db->query("select 
								coalesce(branch    ,'')::text as branch      ,
								coalesce(branchname,'')::text as branchname  ,
								coalesce(address   ,'')::text as address     ,
								coalesce(phone1    ,'')::text as phone1      ,
								coalesce(phone2    ,'')::text as phone2      ,
								coalesce(fax       ,'')::text as fax from sc_mst.branch where cdefault='YES'");
    }
    function q_deltrxerror($paramtrxerror){
        return $this->db->query("delete from sc_mst.trxerror where userid is not null $paramtrxerror");
    }
	function q_ceksckendaraan($kdgroup){
		return $this->db->query("select * from sc_mst.mgroup where kdgroup='$kdgroup'");
	}
	
	function q_sckendaraan(){
		return $this->db->query("select * from sc_mst.mgroup where left(kdgroup,3)='KDN' order by nmgroup");
	}

	function q_scsubkendaraan(){
		return $this->db->query("select * from sc_mst.msubgroup where left(kdgroup,3)='KDN' order by nmsubgroup");
	}
	
	function q_mstkendaraan(){
		return $this->db->query("select * from sc_mst.mbarang a left outer join sc_mst.karyawan b on b.nik=a.userpakai where left(kdgroup,3)='KDN' order by nmbarang");
	}
	function q_cekkendaraan($kdrangka){
		return $this->db->query("select * from sc_mst.mbarang where left(kdgroup,3)='KDN' and nodok='$kdrangka' order by nmbarang");
	}
	
	function q_mstkendaraanwil($param1){
		return $this->db->query("select * from sc_mst.mbarang where left(kdgroup,3)='KDN' $param1  order by nmbarang");
	}
	
	function q_mstkantor(){
		return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
	}

    function q_his_bbmkendaraan_mst($param){
	    return $this->db->query("select a.*,b.nmbarang,b.kdgudang,b.nmpemilik,b.addpemilik,b.nopol,b.kdrangka,b.kdmesin,b.lastkmh,z.uraian as nmstatus
                                    from sc_his.bbmkendaraan_mst a
                                    left outer join sc_mst.mbarang b on b.nodok=a.stockcode
                                    left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='STNKB'
                                    where docno is not null $param
                                    order by docno desc");
    }
    function q_tmp_bbmkendaraan_mst($param){
        return $this->db->query("select a.*,b.nmbarang,b.kdgudang,b.nmpemilik,b.addpemilik,b.nopol,b.kdrangka,b.kdmesin,b.lastkmh,z.uraian as nmstatus
                                    from sc_tmp.bbmkendaraan_mst a
                                    left outer join sc_mst.mbarang b on b.nodok=a.stockcode
                                    left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='STNKB'
                                    where docno is not null $param
                                    order by docno desc");
    }
    function insert_tmp_bbmkendaraan($paraminput){
        $nama=trim($this->session->userdata('nik'));
        return $this->db->query("insert into sc_tmp.bbmkendaraan_mst
                                    (docno,docdate,docref,kdgroup,kdsubgroup,stockcode,bahanbakar,km_awal,km_akhir,ttlvalue,description,status,
                                    inputdate,inputby,updatedate,updateby,approvaldate,approvalby,docnotmp)
                                    (select '$nama',to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp,'' as docref,kdgroup,kdsubgroup,nodok as stockcode,bahanbakar,coalesce(lastkmh,0) as km_awal,0 as km_akhir,0 as ttlvalue,'' as description,'I' as status,
                                    to_char(now(),'yyyy-mm-dd hh24:mi:ss')::timestamp as inputdate,'$nama' as inputby,null as updatedate,null as updateby,null as approvaldate,null as approvalby,null as docnotmp from sc_mst.mbarang where nodok is not null $paraminput)
                                ");
    }

    function final_temporary_bbmkendaraan(){
        $nama=trim($this->session->userdata('nik'));
        return $this->db->query(" update sc_tmp.bbmkendaraan_mst set status='F' where docno='$nama'");
    }

    function q_json_bbmkendaraan_his($param){
        return $this->db->query("select 
                                        trim(coalesce(docno                         ::text),'') as docno        , 
                                        trim(coalesce(to_char(docdate,'dd-mm-yyyy') ::text),'') as docdate      ,
                                        trim(coalesce(docref                        ::text),'') as docref       , 
                                        trim(coalesce(kdgroup                       ::text),'') as kdgroup      , 
                                        trim(coalesce(kdsubgroup                    ::text),'') as kdsubgroup   , 
                                        trim(coalesce(stockcode                     ::text),'') as stockcode    , 
                                        trim(coalesce(bahanbakar                    ::text),'') as bahanbakar   , 
                                        trim(coalesce(km_awal                       ::text),'') as km_awal      , 
                                        trim(coalesce(km_akhir                      ::text),'') as km_akhir     , 
                                        trim(coalesce(ttlvalue                      ::text),'') as ttlvalue     , 
                                        trim(coalesce(description                   ::text),'') as description  , 
                                        trim(coalesce(status                        ::text),'') as status       , 
                                        trim(coalesce(inputdate                     ::text),'') as inputdate    , 
                                        trim(coalesce(inputby                       ::text),'') as inputby      , 
                                        trim(coalesce(updatedate                    ::text),'') as updatedate   , 
                                        trim(coalesce(updateby                      ::text),'') as updateby     , 
                                        trim(coalesce(approvaldate                  ::text),'') as approvaldate , 
                                        trim(coalesce(approvalby                    ::text),'') as approvalby   , 
                                        trim(coalesce(docnotmp                      ::text),'') as docnotmp     , 
                                        trim(coalesce(nmbarang                      ::text),'') as nmbarang     , 
                                        trim(coalesce(kdgudang                      ::text),'') as kdgudang     , 
                                        trim(coalesce(nmpemilik                     ::text),'') as nmpemilik    , 
                                        trim(coalesce(addpemilik                    ::text),'') as addpemilik   , 
                                        trim(coalesce(nopol                         ::text),'') as nopol        , 
                                        trim(coalesce(kdrangka                      ::text),'') as kdrangka     , 
                                        trim(coalesce(kdmesin                       ::text),'') as kdmesin      , 
                                        trim(coalesce(lastkmh                       ::text),'') as lastkmh      , 
                                        trim(coalesce(nmstatus                      ::text),'') as nmstatus     , 
                                        trim(coalesce(locaname                      ::text),'') as locaname from (
                                    select a.*,b.nmbarang,b.kdgudang,b.nmpemilik,b.addpemilik,b.nopol,b.kdrangka,b.kdmesin,b.lastkmh,z.uraian as nmstatus,c.locaname
                                    from sc_his.bbmkendaraan_mst a
                                    left outer join sc_mst.mbarang b on b.nodok=a.stockcode
                                    left outer join sc_mst.mgudang c on b.kdgudang=c.loccode
                                    left outer join sc_mst.trxtype z on a.status=z.kdtrx and z.jenistrx='STNKB'
                                    where docno is not null ) as x where docno is not null $param
                                    order by docno desc");
    }

}