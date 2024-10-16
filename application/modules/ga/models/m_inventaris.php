<?php
class M_inventaris extends CI_Model
{
    var $columnspk = array('nodok', 'nodokref', 'nopol', 'nmbarang', 'nmbengkel');
    var $orderspk = array('nodokref' => 'desc', 'nodok' => 'desc');

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }



    function q_versidb($kodemenu)
    {
        return $this->db->query("select * from sc_mst.version where kodemenu='$kodemenu'");
    }
    function q_trxtype_satuan()
    {
        return $this->db->query("select * from sc_mst.trxtype where jenistrx='QTYUNIT' order by uraian asc");
    }
    function q_trxtype_spkasset()
    {
        return $this->db->query("select * from sc_mst.trxtype where jenistrx='SPKPSASSET' order by uraian asc");
    }
    function q_cekscgroup($kdgroup)
    {
        return $this->db->query("select * from sc_mst.mgroup where kdgroup='$kdgroup'");
    }
    function q_cekscsubgroup($kdgroup)
    {
        return $this->db->query("select * from sc_mst.msubgroup where kdgroup='$kdgroup'");
    }
    function q_cekscsubgroup_2p($kdgroup, $kdsubgroup)
    {
        return $this->db->query("select * from sc_mst.msubgroup where kdgroup='$kdgroup' and kdsubgroup='$kdsubgroup'");
    }

    function q_scgroup()
    {
        return $this->db->query("select * from (
									select a.*,coalesce(b.rowdtl,0) as rowdtl from sc_mst.mgroup a
									left outer join (select count(*) as rowdtl,kdgroup from sc_mst.msubgroup 
									group by kdgroup) b on a.kdgroup=b.kdgroup ) x where kdgroup is not null
									order by nmgroup");
    }
    function q_scgroup_atk()
    {
        return $this->db->query("select * from sc_mst.mgroup where kdgroup in ('BRG','JSA') order by nmgroup");
    }

    function q_scgroup_ast()
    {
        return $this->db->query("select * from sc_mst.mgroup where left(kdgroup,3) in ('AST','KDN','BRG') order by nmgroup");
    }


    function q_scsubgroup()
    {
        return $this->db->query("select a.*,coalesce(b.rowdtl,0) as rowdtl from sc_mst.msubgroup a
									left outer join (select count(*) as rowdtl,kdsubgroup from sc_mst.mbarang 
									group by kdsubgroup) b on a.kdsubgroup=b.kdsubgroup
									order by nmsubgroup");
    }

    function q_scsubgroup_atk()
    {
        return $this->db->query("select * from sc_mst.msubgroup where kdgroup in ('BRG','JSA') order by nmsubgroup");
    }

    function q_mstbarang()
    {
        return $this->db->query("select a.*,b.rowstock,case when a.typebarang='LJ' THEN 'BERKELANJUTAN'
				when a.typebarang='SP' then 'SEKALI PAKAI' end as nmtypebarang from sc_mst.mbarang a
				left outer join (select count(stockcode) as rowstock,trim(stockcode) as stockcode from sc_mst.stkgdw 
				group by stockcode) b on a.nodok=b.stockcode
				where a.kdgroup in ('BRG','AST')  order by a.nmbarang");
    }

    function q_mst_barang_param($param)
    {
        $limit = " limit 200";
        return $this->db->query("select * from (select a.*,b.rowstock,case when a.typebarang='LJ' THEN 'BERKELANJUTAN'
				when a.typebarang='SP' then 'SEKALI PAKAI' end as nmtypebarang,c.nmgroup,d.nmsubgroup from sc_mst.mbarang a
				left outer join (select count(stockcode) as rowstock,trim(stockcode) as stockcode from sc_mst.stkgdw 
				group by stockcode) b on a.nodok=b.stockcode
				left outer join sc_mst.mgroup c on a.kdgroup=c.kdgroup
				left outer join sc_mst.msubgroup d on a.kdgroup=d.kdgroup and a.kdsubgroup=d.kdsubgroup
				where a.kdgroup in ('BRG','AST','JSA')  ) as x where nodok is not null $param order by coalesce(inputdate,'2011-02-02 00:57:51'::timestamp) desc $limit
				");
    }

    function q_stkgdw_param1($param1)
    {
        return $this->db->query("select * from (select coalesce(a.onhand,0)as onhand,a.allocated,a.tmpalloca,a.laststatus,a.lastqty,a.lastdate,a.docno,a.stockcode,a.loccode,coalesce(a.onhand,0::numeric) as conhand,b.kdgroup,b.kdsubgroup,b.nmbarang,e.locaname 
                from sc_mst.stkgdw a 
                left outer join sc_mst.mbarang b on a.stockcode=b.nodok  and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
                left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
                left outer join sc_mst.msubgroup d on b.kdgroup=d.kdgroup and  b.kdsubgroup=d.kdsubgroup
                left outer join sc_mst.mgudang e on a.loccode=e.loccode) as x
                where stockcode is not null $param1 order by nmbarang asc
			");
    }
    function optimize_region_stock($param)
    {
        return $this->db->query("
                insert into sc_mst.stkgdw (branch,stockcode,loccode,kdgroup,kdsubgroup,satkecil)
                select branch,nodok as stockcode,'$param' as loccode,kdgroup,kdsubgroup,satkecil from sc_mst.mbarang where kdgroup IN ('BRG','JSA') 
                and nodok not in (select stockcode from sc_mst.stkgdw where loccode='$param');");
    }

    function q_stgblcoitem_param($param1)
    {
        return $this->db->query("select * from (
                                select x.*,b.nmbarang,b.satkecil,c.uraian as nmsatkecil,d.locaname from (
                                select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,a.docno,a.docref,a.qty_sld from sc_trx.stgblco a,
                                (select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,a.docno,max(a.docref) as docref from sc_trx.stgblco a,
                                (select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,max(a.docno) as docno from sc_trx.stgblco a,
                                (select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,max(a.doctype) as doctype from sc_trx.stgblco a,
                                (select branch,loccode,kdgroup,kdsubgroup,stockcode,max(trxdate) as trxdate from sc_trx.stgblco
                                    where branch is not null $param1
                                group by branch,loccode,kdgroup,kdsubgroup,stockcode) as b
                                where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.trxdate=b.trxdate
                                group by a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate) as  b
                                where a.branch=b.branch and a.loccode=b.loccode  and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.trxdate=b.trxdate and a.doctype=b.doctype 
                                group by a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype) as b
                                where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.trxdate=b.trxdate and a.doctype=b.doctype and a.docno=b.docno
                                group by a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,a.docno) as b
                                where a.branch=b.branch and a.loccode=b.loccode and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup and a.stockcode=b.stockcode and a.trxdate=b.trxdate and a.doctype=b.doctype and a.docno=b.docno and a.docref=b.docref
                                group by a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,a.trxdate,a.doctype,a.docno,a.docref) as x
                                left outer join sc_mst.mbarang b on x.kdgroup=b.kdgroup and x.kdsubgroup=x.kdsubgroup and x.stockcode=b.nodok
                                left outer join sc_mst.trxtype c on c.kdtrx=b.satkecil and c.jenistrx='QTYUNIT'
                                left outer join sc_mst.mgudang d on x.loccode=d.loccode)x1 ORDER BY NMBARANG ASC;
			");
    }


    function q_stgblco_param($param1)
    {
        return $this->db->query("select * from (select a.branch,a.loccode,a.kdgroup,a.kdsubgroup,a.stockcode,to_char(a.trxdate,'dd-mm-yyyy hh24:mi:ss')::timestamp as trxdate,a.doctype,a.docno,a.docref,a.qty_in,a.qty_out,a.qty_sld,a.hist,a.ctype,b.nmbarang,e.locaname from sc_trx.stgblco a 
                                left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
                                left outer join sc_mst.mgroup c on b.kdgroup=c.kdgroup
                                left outer join sc_mst.msubgroup d on b.kdsubgroup=d.kdsubgroup
                                left outer join sc_mst.mgudang e on a.loccode=e.loccode) as x
                                where stockcode is not null $param1
                            order by branch,loccode,kdgroup,kdsubgroup,stockcode,trxdate desc
			");
    }
    function q_mstkantor()
    {
        return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang asc");
    }
    function q_gudangwilayah()
    {
        return $this->db->query("select * from sc_mst.mgudang order by locaname");
    }
    function q_masuransi()
    {
        return $this->db->query("select * from sc_mst.masuransi order by nmasuransi");
    }

    function q_listkaryawanbarang()
    {
        return $this->db->query("select a.*,trim(coalesce(b.nodok,'NONE'))as nodok from sc_mst.karyawan a 
							left outer join sc_mst.mbarang b on a.nik=b.userpakai
							where  a.statuskepegawaian<>'KO' and a.tglkeluarkerja is null order by nmlengkap asc");
    }
    function list_karyawan($param2)
    {
        return $this->db->query("select * from sc_mst.karyawan where nik is not null and statuskepegawaian<>'KO' $param2 order by nmlengkap asc");
    }

    function q_hisperawatan($param)
    {
        return $this->db->query("SELECT trim(coalesce(nodok       ::text,'')) as    nodok                 ,
                                    trim(coalesce(dokref      ::text,'')) as    dokref                ,
                                    trim(coalesce(kdgroup     ::text,'')) as    kdgroup               ,
                                    trim(coalesce(kdsubgroup  ::text,'')) as    kdsubgroup            ,
                                    trim(coalesce(stockcode   ::text,'')) as    stockcode             ,
                                    trim(coalesce(descbarang  ::text,'')) as    descbarang            ,
                                    trim(coalesce(nikpakai    ::text,'')) as    nikpakai              ,
                                    trim(coalesce(nikmohon    ::text,'')) as    nikmohon              ,
                                    trim(coalesce(jnsperawatan::text,'')) as    jnsperawatan          ,
                                    trim(coalesce(to_char(tgldok,'dd-mm-yyyy')::text,'')) as tgldok   ,   
                                    trim(coalesce(keterangan  ::text,'')) as    keterangan            ,
                                    trim(coalesce(laporanpk   ::text,'')) as    laporanpk             ,
                                    trim(coalesce(laporanpsp  ::text,'')) as    laporanpsp            ,
                                    trim(coalesce(laporanksp  ::text,'')) as    laporanksp            ,
                                    trim(coalesce(status      ::text,'')) as    status                ,
                                    trim(coalesce(inputdate   ::text,'')) as    inputdate             ,
                                    trim(coalesce(inputby     ::text,'')) as    inputby               ,
                                    trim(coalesce(updatedate  ::text,'')) as    updatedate            ,
                                    trim(coalesce(updateby    ::text,'')) as    updateby              ,
                                    trim(coalesce(nmbarang    ::text,'')) as    nmbarang              ,
                                    trim(coalesce(numberitem  ::text,'')) as    numberitem            ,
                                    trim(coalesce(userpakai   ::text,'')) as    userpakai             ,
                                    trim(coalesce(nmlengkap   ::text,'')) as    nmlengkap             ,
                                    trim(coalesce(bag_dept    ::text,'')) as    bag_dept              ,
                                    trim(coalesce(subbag_dept ::text,'')) as    subbag_dept           ,
                                    trim(coalesce(jabatan     ::text,'')) as    jabatan               ,
                                    trim(coalesce(kdcabang    ::text,'')) as    kdcabang              ,
                                    trim(coalesce(nmdept      ::text,'')) as    nmdept                ,
                                    trim(coalesce(nmsubdept   ::text,'')) as    nmsubdept             ,
                                    trim(coalesce(jabpengguna ::text,'')) as    jabpengguna           ,
                                    trim(coalesce(nmpemohon   ::text,'')) as    nmpemohon             ,
                                    trim(coalesce(jabpemohon  ::text,'')) as    jabpemohon            ,
                                    trim(coalesce(spk         ::text,'')) as    spk                   ,
                                    trim(coalesce(nmspk       ::text,'')) as    nmspk                 ,
                                    trim(coalesce(nmstatus    ::text,'')) as    nmstatus              ,
                                    trim(coalesce(km_awal    ::text,'0')) as    km_awal              ,
                                    trim(coalesce(km_akhir    ::text,'0')) as    km_akhir              ,
                                    trim(coalesce(nopol    ::text,'')) as    nopol              ,
                                    trim(coalesce(nmatasan1   ::text,'')) as    nmatasan1,
                                    trim(coalesce(approvalby   ::text,'')) as    approvalby,
                                    trim(coalesce(approvaldate   ::text,'')) as    approvaldate,
                                    trim(coalesce(cancelby   ::text,'')) as    cancelby,
                                    trim(coalesce(canceldate   ::text,'')) as    canceldate,
                                    trim(coalesce(nmmohon   ::text,'')) as    nmmohon,
                                    trim(coalesce(nmapprovalby   ::text,'')) as    nmapprovalby,
                                    trim(coalesce(nmdeptmohon    ::text,'')) as    nmdeptmohon              ,
                                    trim(coalesce(nmsubdeptmohon ::text,'')) as    nmsubdeptmohon,
									trim(coalesce(nodoktmp ::text,'')) as    nodoktmp  
                                     from (
                                    select x.*,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.kdcabang,b.nmdept,c.nmsubdept,d.nmjabatan as jabpengguna,e.nmlengkap as nmpemohon,h.nmjabatan as jabpemohon,count(i.nodok) as spk,case when count(i.nodok)=0 then 'TIDAK' else 'ADA' end as nmspk ,j.uraian as nmstatus,k.nmlengkap as nmatasan1 
                                    ,e.nmlengkap as nmmohon,l.nmlengkap as nmapprovalby,f.nmdept as nmdeptmohon,g.nmsubdept as nmsubdeptmohon
                                    from (
                                        select a.*,b.nmbarang,b.nopol,
                                        case 	when b.nopol is null or b.nopol='' then b.nodok 
                                            when b.nopol is not null and b.nopol<>'' then b.nopol end as numberitem,
                                        case	when b.userpakai is null or b.userpakai='' then a.nikpakai
                                            when b.userpakai is not null and b.userpakai<>'' then b.userpakai end as userpakai
                                             from sc_his.perawatanasset a 
                                                    left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
                                                    order by nodok desc) as x 
                                                    left outer join sc_mst.karyawan a on x.userpakai=a.nik
                                                    left outer join sc_mst.departmen b on a.bag_dept=b.kddept
                                                    left outer join sc_mst.subdepartmen c on a.bag_dept=c.kddept and a.subbag_dept=c.kdsubdept
                                                    left outer join sc_mst.jabatan d on a.bag_dept=d.kddept and a.subbag_dept=d.kdsubdept and a.jabatan=d.kdjabatan
                                                    left outer join sc_mst.karyawan e on x.nikmohon=e.nik
                                                    left outer join sc_mst.departmen f on e.bag_dept=f.kddept
                                                    left outer join sc_mst.subdepartmen g on e.bag_dept=g.kddept and e.subbag_dept=g.kdsubdept
                                                    left outer join sc_mst.jabatan h on e.bag_dept=h.kddept and e.subbag_dept=h.kdsubdept and e.jabatan=h.kdjabatan
                                                    left outer join sc_his.perawatanspk i on x.nodok=i.nodokref and i.status in ('P','X','F')
                                                    left outer join sc_mst.trxtype j on x.status=j.kdtrx and j.jenistrx='PASSET'
                                                    left outer join sc_mst.karyawan k on a.nik_atasan=k.nik
                                                    left outer join sc_mst.karyawan l on x.approvalby=l.nik
                                    group by x.nodok,x.dokref,x.stockcode,x.descbarang,x.nikpakai,x.nikmohon,x.jnsperawatan,x.tgldok,x.keterangan,x.laporanpk,x.laporanpsp,x.laporanksp,x.status,x.inputdate,x.inputby,x.updatedate,x.updateby,
                                    x.approvaldate,x.approvalby,x.canceldate,x.cancelby,x.nodoktmp,
                                    x.nmbarang,x.kdgroup,x.kdsubgroup,x.numberitem,x.userpakai,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.kdcabang,b.nmdept,c.nmsubdept,d.nmjabatan,e.nmlengkap,h.nmjabatan,j.uraian,k.nmlengkap,x.nopol,x.km_akhir,x.km_awal,l.nmlengkap,f.nmdept,g.nmsubdept
                                    ORDER BY x.tgldok desc) x where nodok is not null $param order by to_char(tgldok,'yyyy') desc, nodok desc
								");
    }

    function q_hisperawatan_tmp($param)
    {
        return $this->db->query("SELECT trim(coalesce(nodok       ::text,'')) as    nodok                 ,
                                    trim(coalesce(dokref      ::text,'')) as    dokref                ,
                                    trim(coalesce(kdgroup     ::text,'')) as    kdgroup               ,
                                    trim(coalesce(kdsubgroup  ::text,'')) as    kdsubgroup            ,
                                    trim(coalesce(stockcode   ::text,'')) as    stockcode             ,
                                    trim(coalesce(descbarang  ::text,'')) as    descbarang            ,
                                    trim(coalesce(nikpakai    ::text,'')) as    nikpakai              ,
                                    trim(coalesce(nikmohon    ::text,'')) as    nikmohon              ,
                                    trim(coalesce(jnsperawatan::text,'')) as    jnsperawatan          ,
                                    trim(coalesce(to_char(tgldok,'dd-mm-yyyy')::text,'')) as tgldok   ,   
                                    trim(coalesce(keterangan  ::text,'')) as    keterangan            ,
                                    trim(coalesce(laporanpk   ::text,'')) as    laporanpk             ,
                                    trim(coalesce(laporanpsp  ::text,'')) as    laporanpsp            ,
                                    trim(coalesce(laporanksp  ::text,'')) as    laporanksp            ,
                                    trim(coalesce(status      ::text,'')) as    status                ,
                                    trim(coalesce(inputdate   ::text,'')) as    inputdate             ,
                                    trim(coalesce(inputby     ::text,'')) as    inputby               ,
                                    trim(coalesce(updatedate  ::text,'')) as    updatedate            ,
                                    trim(coalesce(updateby    ::text,'')) as    updateby              ,
                                    trim(coalesce(nmbarang    ::text,'')) as    nmbarang              ,
                                    trim(coalesce(numberitem  ::text,'')) as    numberitem            ,
                                    trim(coalesce(userpakai   ::text,'')) as    userpakai             ,
                                    trim(coalesce(nmlengkap   ::text,'')) as    nmlengkap             ,
                                    trim(coalesce(bag_dept    ::text,'')) as    bag_dept              ,
                                    trim(coalesce(subbag_dept ::text,'')) as    subbag_dept           ,
                                    trim(coalesce(jabatan     ::text,'')) as    jabatan               ,
                                    trim(coalesce(kdcabang    ::text,'')) as    kdcabang              ,
                                    trim(coalesce(nmdept      ::text,'')) as    nmdept                ,
                                    trim(coalesce(nmsubdept   ::text,'')) as    nmsubdept             ,
                                    trim(coalesce(jabpengguna ::text,'')) as    jabpengguna           ,
                                    trim(coalesce(nmpemohon   ::text,'')) as    nmpemohon             ,
                                    trim(coalesce(jabpemohon  ::text,'')) as    jabpemohon            ,
                                    trim(coalesce(spk         ::text,'')) as    spk                   ,
                                    trim(coalesce(nmspk       ::text,'')) as    nmspk                 ,
                                    trim(coalesce(nmstatus    ::text,'')) as    nmstatus              ,
                                    trim(coalesce(km_awal    ::text,'0')) as    km_awal              ,
                                    trim(coalesce(km_akhir    ::text,'0')) as    km_akhir              ,
                                    trim(coalesce(nopol    ::text,'')) as    nopol              ,
                                    trim(coalesce(nmatasan1   ::text,'')) as    nmatasan1,
                                    trim(coalesce(approvalby   ::text,'')) as    approvalby,
                                    trim(coalesce(approvaldate   ::text,'')) as    approvaldate,
                                    trim(coalesce(cancelby   ::text,'')) as    cancelby,
                                    trim(coalesce(canceldate   ::text,'')) as    canceldate,
                                    trim(coalesce(nmmohon   ::text,'')) as    nmmohon,
                                    trim(coalesce(nmapprovalby   ::text,'')) as    nmapprovalby,
                                    trim(coalesce(nmdeptmohon    ::text,'')) as    nmdeptmohon              ,
                                    trim(coalesce(nmsubdeptmohon ::text,'')) as    nmsubdeptmohon  
                                     from (
                                    select x.*,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.kdcabang,b.nmdept,c.nmsubdept,d.nmjabatan as jabpengguna,e.nmlengkap as nmpemohon,h.nmjabatan as jabpemohon,count(i.nodok) as spk,case when count(i.nodok)=0 then 'TIDAK' else 'ADA' end as nmspk ,j.uraian as nmstatus,k.nmlengkap as nmatasan1 
                                    ,e.nmlengkap as nmmohon,l.nmlengkap as nmapprovalby,f.nmdept as nmdeptmohon,g.nmsubdept as nmsubdeptmohon
                                    from (
                                        select a.*,b.nmbarang,b.nopol,
                                        case 	when b.nopol is null or b.nopol='' then b.nodok 
                                            when b.nopol is not null and b.nopol<>'' then b.nopol end as numberitem,
                                        case	when b.userpakai is null or b.userpakai='' then a.nikpakai
                                            when b.userpakai is not null and b.userpakai<>'' then b.userpakai end as userpakai
                                             from sc_tmp.perawatanasset a 
                                                    left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
                                                    order by nodok desc) as x 
                                                    left outer join sc_mst.karyawan a on x.userpakai=a.nik
                                                    left outer join sc_mst.departmen b on a.bag_dept=b.kddept
                                                    left outer join sc_mst.subdepartmen c on a.bag_dept=c.kddept and a.subbag_dept=c.kdsubdept
                                                    left outer join sc_mst.jabatan d on a.bag_dept=d.kddept and a.subbag_dept=d.kdsubdept and a.jabatan=d.kdjabatan
                                                    left outer join sc_mst.karyawan e on x.nikmohon=e.nik
                                                    left outer join sc_mst.departmen f on e.bag_dept=f.kddept
                                                    left outer join sc_mst.subdepartmen g on e.bag_dept=g.kddept and e.subbag_dept=g.kdsubdept
                                                    left outer join sc_mst.jabatan h on e.bag_dept=h.kddept and e.subbag_dept=h.kdsubdept and e.jabatan=h.kdjabatan
                                                    left outer join sc_his.perawatanspk i on x.nodok=i.nodokref
                                                    left outer join sc_mst.trxtype j on x.status=j.kdtrx and j.jenistrx='PASSET'
                                                    left outer join sc_mst.karyawan k on a.nik_atasan=k.nik
                                                    left outer join sc_mst.karyawan l on x.approvalby=l.nik
                                    group by x.nodok,x.dokref,x.stockcode,x.descbarang,x.nikpakai,x.nikmohon,x.jnsperawatan,x.tgldok,x.keterangan,x.laporanpk,x.laporanpsp,x.laporanksp,x.status,x.inputdate,x.inputby,x.updatedate,x.updateby,
                                    x.approvaldate,x.approvalby,x.canceldate,x.cancelby,x.nodoktmp,
                                    x.nmbarang,x.kdgroup,x.kdsubgroup,x.numberitem,x.userpakai,a.nmlengkap,a.bag_dept,a.subbag_dept,a.jabatan,a.kdcabang,b.nmdept,c.nmsubdept,d.nmjabatan,e.nmlengkap,h.nmjabatan,j.uraian,k.nmlengkap,x.nopol,x.km_akhir,x.km_awal,l.nmlengkap,f.nmdept,g.nmsubdept
                                    ORDER BY x.tgldok desc) x where nodok is not null $param  order by nodoktmp desc
                                                                    ");
    }

    function q_listbarang()
    {
        return $this->db->query("select * from sc_mst.mbarang order by nmbarang");
    }
    function q_listbengkel()
    {
        return $this->db->query("select * from sc_mst.mbengkel order by nmbengkel");
    }
    function q_listsubbengkel()
    {
        return $this->db->query("select * from sc_mst.msubbengkel order by nmbengkel");
    }

    function q_master_branch()
    {
        return $this->db->query("select 
								coalesce(branch    ,'')::text as branch      ,
								coalesce(branchname,'')::text as branchname  ,
								coalesce(address   ,'')::text as address     ,
								coalesce(phone1    ,'')::text as phone1      ,
								coalesce(phone2    ,'')::text as phone2      ,
								coalesce(fax       ,'')::text as fax from sc_mst.branch where coalesce(cdefault,'')='YES'");
    }

    private function _get_query_perawatanspk()
    {
        /*$this->db->select("	
                                  approvalby,
                                  nmbarang,
                                  nmgroup,
                                  nmsubgroup,
                                  desc_cabang",FALSE);
                  $this->db->from('sc_trx.list_po_atk');
                  $this->db->order_by("inputdate","desc");
                  $this->db->order_by("status","desc");*/
        $this->db->select('*');
        $this->db->from('sc_his.perawatanspk_view');
        $this->db->order_by("nodokref", "desc");
        $this->db->order_by("nodok", "desc");


        $i = 0;

        foreach ($this->columnspk as $item) {
            if ($_POST['search']['value'])
                //($i===0) ? $this->db->like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value'])) : $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));
                $this->db->or_like("upper(cast(" . strtoupper($item) . " as varchar))", strtoupper($_POST['search']['value']));

            $columnspk[$i] = $item;
            $i++;
        }

        if (isset($_POST['orderspk'])) {
            $this->db->order_by($columnspk[$_POST['orderspk']['0']['columnspk']], $_POST['orderspk']['0']['dir']);
        } else if (isset($this->orderspk)) {
            $orderspk = $this->orderspk;
            $this->db->order_by(key($orderspk), $orderspk[key($orderspk)]);
        }

    }


    function get_list_perawatanspk()
    {
        $this->_get_query_perawatanspk();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }


    function q_hisperawatanspk($param)
    {
        return $this->db->query("SELECT coalesce(nodok        ,'')::text as nodok          ,     
                                        coalesce(nodokref       ,'')::text as nodokref         ,     
                                        coalesce(descbarang   ,'')::text as descbarang     ,     
                                        coalesce(kdgroup      ,'')::text as kdgroup        ,     
                                        coalesce(kdsubgroup   ,'')::text as kdsubgroup     ,     
                                        coalesce(stockcode    ,'')::text as stockcode      ,     
                                        coalesce(kdbengkel    ,'')::text as kdbengkel      ,     
                                        coalesce(kdsubbengkel ,'')::text as kdsubbengkel   ,     
                                        coalesce(nmbengkel ,'')::text as nmbengkel   ,     
                                        coalesce(upbengkel    ,'')::text as upbengkel      ,     
                                        coalesce(jnsperawatan ,'')::text as jnsperawatan   ,     
                                        coalesce(jnsperawatanref,'')::text as jnsperawatanref,     
                                        coalesce(to_char(tgldok  ,'dd-mm-yyyy' ),'')::text as tgldok         ,     
                                        coalesce(to_char(tglawal ,'dd-mm-yyyy' ),'')::text as tglawal        ,     
                                        coalesce(to_char(tglakhir,'dd-mm-yyyy' ),'')::text as tglakhir       ,     
                                        coalesce(keterangan     ,'')::text as keterangan     ,     
                                        coalesce(status         ,'')::text as status         ,     
                                        coalesce(to_char(inputdate  ,'dd-mm-yyyy' )     ,'')::text as inputdate      ,     
                                        coalesce(inputby        ,'')::text as inputby        ,     
                                        coalesce(to_char(updatedate  ,'dd-mm-yyyy' )    ,'')::text as updatedate     ,     
                                        coalesce(updateby       ,'')::text as updateby       ,     
                                        coalesce(nmbarang       ,'')::text as nmbarang       ,     
                                        coalesce(kdgudang       ,'')::text as kdgudang       ,     
                                        coalesce(nmbengkel      ,'')::text as nmbengkel      ,     
                                        coalesce(addbengkel     ,'')::text as addbengkel     ,     
                                        coalesce(city           ,'')::text as city           ,     
                                        coalesce(phone1         ,'')::text as phone1         ,     
                                        coalesce(phone2         ,'')::text as phone2         ,     
                                        coalesce(nopol          ,'')::text as nopol          ,     
                                        coalesce(branch_address ,'')::text as branch_address ,     
                                        coalesce(branch_phone1  ,'')::text as branch_phone1  ,     
                                        coalesce(branch_phone2  ,'')::text as branch_phone2  ,     
                                        coalesce(branch_fax     ,'')::text as branch_fax ,
                                        coalesce(nikmohon     ,'')::text as nikmohon,
                                        coalesce(nmmohon     ,'')::text as nmmohon,
                                        coalesce(km_awal     ,0)::text as km_awal ,
                                        coalesce(km_akhir     ,0)::text as km_akhir ,
                                        coalesce(ttlservis     ,0)::text as ttlservis, 								
                                        coalesce(ttldiskon    ,0)::text as ttldiskon, 								
                                        coalesce(ttldpp     ,0)::text as ttldpp, 								
                                        coalesce(ttlppn    ,0)::text as ttlppn, 								
                                        coalesce(ttlppnbm,0)::text as ttlppnbm, 								
                                        coalesce(ttlnetto,0)::text as ttlnetto, 								
                                        coalesce(typeservis,'')::text as typeservis, 								
                                        coalesce(kdrangka,'')::text as kdrangka, 								
                                        coalesce(kdmesin,'')::text as kdmesin,								
                                        coalesce(jenisperawatan,'')::text as jenisperawatan,								
                                        coalesce(nmperawatanasset,'')::text as nmperawatanasset,
                                        coalesce(uraian,'')::text as uraian_status				
                                        from (
                                    select a.*,b.nmbarang,b.kdgudang,c.nmbengkel,c.addbengkel,c.city,c.phone1,c.phone2,b.nopol,d.address as branch_address,d.phone1 as branch_phone1,d.phone2 as branch_phone2,d.fax as branch_fax,f.nmlengkap as nmmohon,e.nikmohon
                                    ,b.kdrangka,b.kdmesin,e.jnsperawatan as jenisperawatan,case when e.jnsperawatan='BK' then 'BERKALA' when e.jnsperawatan='IS' then 'ISIDENTIL' else '' end as nmperawatanasset, g.uraian
                                    from sc_his.perawatanspk a
                                    left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
                                    left outer join sc_mst.msubbengkel c on c.kdbengkel=a.kdbengkel and c.kdsubbengkel=a.kdsubbengkel
                                    left outer join sc_mst.branch d on coalesce(d.cdefault,'')='YES'
                                    left outer join sc_his.perawatanasset e on a.nodokref=e.nodok
                                    left outer join sc_mst.karyawan f on f.nik=e.nikmohon
                                    left outer join sc_mst.trxtype g on g.kdtrx=a.status and g.jenistrx='PASSET'
                                    ) x
                                    where nodok is not null  $param order by nodokref desc,nodok desc
							");
    }

    function q_hisperawatanspk_tmp($param)
    {
        return $this->db->query("SELECT coalesce(nodok        ,'')::text as nodok          ,     
                                        coalesce(nodokref       ,'')::text as nodokref         ,     
                                        coalesce(descbarang   ,'')::text as descbarang     ,     
                                        coalesce(kdgroup      ,'')::text as kdgroup        ,     
                                        coalesce(kdsubgroup   ,'')::text as kdsubgroup     ,     
                                        coalesce(stockcode    ,'')::text as stockcode      ,     
                                        coalesce(kdbengkel    ,'')::text as kdbengkel      ,     
                                        coalesce(kdsubbengkel ,'')::text as kdsubbengkel   ,     
                                        coalesce(nmbengkel ,'')::text as nmbengkel   ,     
                                        coalesce(upbengkel    ,'')::text as upbengkel      ,     
                                        coalesce(jnsperawatan ,'')::text as jnsperawatan   ,     
                                        coalesce(jnsperawatanref,'')::text as jnsperawatanref,     
                                        coalesce(to_char(tgldok  ,'dd-mm-yyyy' ),'')::text as tgldok         ,     
                                        coalesce(to_char(tglawal ,'dd-mm-yyyy' ),'')::text as tglawal        ,     
                                        coalesce(to_char(tglakhir,'dd-mm-yyyy' ),'')::text as tglakhir       ,     
                                        coalesce(keterangan     ,'')::text as keterangan     ,     
                                        coalesce(status         ,'')::text as status         ,     
                                        coalesce(to_char(inputdate  ,'dd-mm-yyyy' )     ,'')::text as inputdate      ,     
                                        coalesce(inputby        ,'')::text as inputby        ,     
                                        coalesce(to_char(updatedate  ,'dd-mm-yyyy' )    ,'')::text as updatedate     ,     
                                        coalesce(updateby       ,'')::text as updateby       ,     
                                        coalesce(nmbarang       ,'')::text as nmbarang       ,     
                                        coalesce(kdgudang       ,'')::text as kdgudang       ,     
                                        coalesce(nmbengkel      ,'')::text as nmbengkel      ,     
                                        coalesce(addbengkel     ,'')::text as addbengkel     ,     
                                        coalesce(city           ,'')::text as city           ,     
                                        coalesce(phone1         ,'')::text as phone1         ,     
                                        coalesce(phone2         ,'')::text as phone2         ,     
                                        coalesce(nopol          ,'')::text as nopol          ,     
                                        coalesce(branch_address ,'')::text as branch_address ,     
                                        coalesce(branch_phone1  ,'')::text as branch_phone1  ,     
                                        coalesce(branch_phone2  ,'')::text as branch_phone2  ,     
                                        coalesce(branch_fax     ,'')::text as branch_fax ,
                                        coalesce(nikmohon     ,'')::text as nikmohon,
                                        coalesce(nmmohon     ,'')::text as nmmohon,
                                        coalesce(km_awal     ,0)::text as km_awal ,
                                        coalesce(km_akhir     ,0)::text as km_akhir ,
                                        coalesce(ttlservis     ,0)::text as ttlservis, 								
                                        coalesce(ttldiskon    ,0)::text as ttldiskon, 								
                                        coalesce(ttldpp     ,0)::text as ttldpp, 								
                                        coalesce(ttlppn    ,0)::text as ttlppn, 								
                                        coalesce(ttlppnbm,0)::text as ttlppnbm, 								
                                        coalesce(ttlnetto,0)::text as ttlnetto, 								
                                        coalesce(typeservis,'')::text as typeservis, 								
                                        coalesce(kdrangka,'')::text as kdrangka, 								
                                        coalesce(kdmesin,'')::text as kdmesin,								
                                        coalesce(jenisperawatan,'')::text as jenisperawatan,								
                                        coalesce(nmperawatanasset,'')::text as nmperawatanasset,
                                        coalesce(nodoktmp,'')::text as nodoktmp
                                        from (
                                    select a.*,b.nmbarang,b.kdgudang,c.nmbengkel,c.addbengkel,c.city,c.phone1,c.phone2,b.nopol,d.address as branch_address,d.phone1 as branch_phone1,d.phone2 as branch_phone2,d.fax as branch_fax,f.nmlengkap as nmmohon,e.nikmohon
                                    ,b.kdrangka,b.kdmesin,e.jnsperawatan as jenisperawatan,case when e.jnsperawatan='BK' then 'BERKALA' when e.jnsperawatan='IS' then 'ISIDENTIL' else '' end as nmperawatanasset
                                    from sc_tmp.perawatanspk a
                                    left outer join sc_mst.mbarang b on a.stockcode=b.nodok and a.kdgroup=b.kdgroup and a.kdsubgroup=b.kdsubgroup
                                    left outer join sc_mst.msubbengkel c on c.kdbengkel=a.kdbengkel and c.kdsubbengkel=a.kdsubbengkel
                                    left outer join sc_mst.branch d on coalesce(d.cdefault,'')='YES'
                                    left outer join sc_his.perawatanasset e on a.nodokref=e.nodok
                                    left outer join sc_mst.karyawan f on f.nik=e.nikmohon
                                    ) x
                                    where nodok is not null $param order by nodok desc
							");
    }

    function q_hisperawatan_perawatan_mst_lampiran_tmp($param)
    {
        return $this->db->query("		
						select * from (
						select x.*,x2.rowcount from 
						(select *,trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref from sc_tmp.perawatan_mst_lampiran) x 
						left outer join (
						select coalesce(count(*),0) as rowcount,strtrimref from (
						select  trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref from sc_tmp.perawatan_detail_lampiran
						union all
						select  trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref from sc_tmp.perawatan_lampiran) as x
						group by strtrimref
						) x2 on x.strtrimref=x2.strtrimref) as x
						where nodok is not null $param order by nodok desc");
    }

    function q_hisperawatan_perawatan_mst_lampiran($param)
    {
        return $this->db->query("select * from (
						select x.*,x2.rowcount from 
						(select *,trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref from sc_his.perawatan_mst_lampiran) x 
						left outer join (
						select coalesce(count(*),0) as rowcount,strtrimref from (
						select  trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref from sc_his.perawatan_detail_lampiran
						union all
						select  trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref from sc_his.perawatan_lampiran) as x
						group by strtrimref
						) x2 on x.strtrimref=x2.strtrimref) as x
						where nodok is not null $param order by nodok desc");
    }

    function q_hisperawatan_perawatan_dtl_lampiran($param)
    {
        return $this->db->query("select * from (select *,trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref from sc_his.perawatan_detail_lampiran where nodok is not null  order by nodok,nodokref,id desc) x where nodok is not null $param order by nodok desc");
    }

    function q_hisperawatan_perawatan_dtl_lampiran_tmp($param)
    {
        return $this->db->query("select * from (select *,trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref from sc_tmp.perawatan_detail_lampiran where nodok is not null  order by nodok,nodokref,id desc) x where nodok is not null $param order by nodok desc");
    }

    function cek_spkdouble($nodok)
    {
        return $this->db->query("select * from sc_his.perawatanspk where nodok='$nodok'");
    }

    function q_lampiran_at($param)
    {
        ///return $this->db->query("select * from sc_his.perawatan_lampiran where  trim(nodok)='$nodok' order by id desc");
        return $this->db->query("select * from (select *,trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref  from sc_his.perawatan_lampiran) as x where nodok is not null $param  order by id desc");
    }
    function q_lampiran_at_tmp($param)
    {
        ///return $this->db->query("select * from sc_his.perawatan_lampiran where  trim(nodok)='$nodok' order by id desc");
        return $this->db->query("select * from (select *,trim(nodok)||trim(nodokref)||trim(idfaktur) as strtrimref  from sc_tmp.perawatan_lampiran) as x where nodok is not null $param  order by id desc");
    }

    function insert_attachmentspk($data = array())
    {
        $insert = $this->db->insert_batch('sc_tmp.perawatan_lampiran', $data);
        //$insert = $this->db->insert_batch('sc_his.perawatan_lampiran',$data);
        return $insert ? true : false;
    }



    function q_mapsatuan_barang_param($param)
    {
        $limit = " limit 100 ";
        return $this->db->query("select * from (
									select *,trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim, 0 as referensinya from (
																		select a.*,b.uraian as nmsatkecil,c.uraian as nmsatbesar,d.nmbarang from sc_mst.mapping_satuan_brg a
																			left outer join sc_mst.trxtype b on a.satkecil=b.kdtrx and b.jenistrx='QTYUNIT'
																			left outer join sc_mst.trxtype c on a.satbesar=c.kdtrx and c.jenistrx='QTYUNIT'
																			left outer join sc_mst.mbarang d on a.kdgroup=d.kdgroup and a.kdsubgroup=d.kdsubgroup and a.stockcode=d.nodok) as x
																			where satkecil is not null
									and trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) not in (
									select trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim from sc_mst.mapping_satuan_brg
									where  trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) in (
									select trim(branch)||trim(satkecil)||trim(satminta)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim from (
									select branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode from sc_trx.sppb_dtl where coalesce(satkecil,'')<>'' and coalesce(satminta,'')<>'' group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode
									union all
									select branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode from sc_trx.po_dtlref where coalesce(satkecil,'')<>'' and coalesce(satminta,'')<>'' group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode) as x
									group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode))
									union all
									select *,trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim, 1 as referensinya from (
									select a.*,b.uraian as nmsatkecil,c.uraian as nmsatbesar,d.nmbarang from sc_mst.mapping_satuan_brg a
										left outer join sc_mst.trxtype b on a.satkecil=b.kdtrx and b.jenistrx='QTYUNIT'
										left outer join sc_mst.trxtype c on a.satbesar=c.kdtrx and c.jenistrx='QTYUNIT'
										left outer join sc_mst.mbarang d on a.kdgroup=d.kdgroup and a.kdsubgroup=d.kdsubgroup and a.stockcode=d.nodok) as x
										where satkecil is not null
									and trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) in (
									select trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim from sc_mst.mapping_satuan_brg
									where  trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) in (
									select trim(branch)||trim(satkecil)||trim(satminta)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim from (
									select branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode from sc_trx.sppb_dtl where coalesce(satkecil,'')<>'' and coalesce(satminta,'')<>'' group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode
									union all
									select branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode from sc_trx.po_dtlref where coalesce(satkecil,'')<>'' and coalesce(satminta,'')<>'' group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode) as x
									group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode))) as x
									where stockcode is not null $param
									order by kdgroup,kdsubgroup,stockcode,nmbarang $limit ");
    }

    function q_master_satuan_barang_param($param)
    {
        return $this->db->query("select a.*,count(b.kdsatuan) as kdmaprow from sc_mst.trxtype a
                                        left outer join (
                                        select distinct satkecil as kdsatuan from sc_mst.mapping_satuan_brg
                                        union all
                                        select distinct satbesar as kdsatuan from sc_mst.mapping_satuan_brg) b on a.kdtrx=b.kdsatuan
                                        where jenistrx='QTYUNIT' $param
                                        group by a.kdtrx,jenistrx,uraian
                                        order by uraian asc ");
    }

    function q_mbarang_param($param1)
    {
        return $this->db->query("select * from (
										select a.*,b.uraian as nmsatkecil,c.qty as qtykecilmap from sc_mst.mbarang a
										left outer join sc_mst.trxtype b on a.satkecil=b.kdtrx and b.jenistrx='QTYUNIT'
										left outer join sc_mst.mapping_satuan_brg c on a.satkecil=c.satkecil and a.satkecil=c.satbesar
										and a.kdgroup=c.kdgroup and a.kdsubgroup=c.kdsubgroup and a.nodok=c.stockcode) x where nodok is not null $param1 order by nmbarang asc");
    }

    function trxerror_mapparam($param)
    {
        return $this->db->query("select * from sc_mst.trxerror where modul='MSTMAPSTOCK' $param");
    }
    function trxerror($param)
    {
        return $this->db->query("select * from sc_mst.trxerror where userid is not null $param");
    }


    function cek_delmap()
    {
        return $this->db->query("select *,trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim from (
									select a.*,b.uraian as nmsatkecil,c.uraian as nmsatbesar,d.nmbarang from sc_mst.mapping_satuan_brg a
										left outer join sc_mst.trxtype b on a.satkecil=b.kdtrx and b.jenistrx='QTYUNIT'
										left outer join sc_mst.trxtype c on a.satbesar=c.kdtrx and c.jenistrx='QTYUNIT'
										left outer join sc_mst.mbarang d on a.kdgroup=d.kdgroup and a.kdsubgroup=d.kdsubgroup and a.stockcode=d.nodok) as x
										where satkecil is not null
								and trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) not in (
								select trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim from sc_mst.mapping_satuan_brg
								where  trim(branch)||trim(satkecil)||trim(satbesar)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) in (
								select trim(branch)||trim(satkecil)||trim(satminta)||trim(kdgroup)||trim(kdsubgroup)||trim(stockcode) as strtrim from (
								select branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode from sc_trx.sppb_dtl where coalesce(satkecil,'')<>'' and coalesce(satminta,'')<>'' group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode
								union all
								select branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode from sc_trx.po_dtlref where coalesce(satkecil,'')<>'' and coalesce(satminta,'')<>'' group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode) as x
								group by branch,satkecil,satminta,kdgroup,kdsubgroup,stockcode))");
    }

    function spk_approver($nodok)
    {
        $spk = $this->db
            ->select('a.*,b.status as status_spk,b.ttlservis,c.*')
            ->from('sc_his.perawatanasset a')
            ->join('sc_his.perawatanspk b', 'a.nodok = b.nodokref')
            ->join('sc_mst.karyawan c', 'a.nikmohon = c.nik')
            ->where('b.nodok', $nodok)
            ->get();

        if ($spk->num_rows() > 0) {
            $kode = strlen($spk->row()->status_spk) >= 3 ?
                substr($spk->row()->status_spk, 0, 2) :
                substr($spk->row()->status_spk, 0, 1);
            $superior1 = trim($spk->row()->nik_atasan);
            $superior2 = trim($spk->row()->nik_atasan2);

            $isSPVGA = $this->db->get_where('sc_mst.karyawan', array('nik' => $this->session->userdata('nik'), 'lvl_jabatan' => 'C', 'kdsubdept' => 'HRGA'))->num_rows() > 0;
            // $isMGR = $this->db->get_where('sc_mst.karyawan', array('nik' => $this->session->userdata('nik'), 'lvl_jabatan' => 'B'))->num_rows() > 0;
            $isRSM = $this->db->get_where('sc_mst.karyawan', array('nik' => $this->session->userdata('nik'), 'lvl_jabatan' => 'B', 'jabatan' => 'RSM'))->num_rows() > 0;
            $isGM = $this->db->get_where('sc_mst.karyawan', array('nik' => $this->session->userdata('nik'), 'lvl_jabatan' => 'B', 'jabatan' => 'GMN'))->num_rows() > 0;
            $isMGRKEU = $this->db->get_where('sc_mst.karyawan', array('nik' => $this->session->userdata('nik'), 'lvl_jabatan' => 'B', 'jabatan' => 'MGRKEU'))->num_rows() > 0;
            $isDIR = $this->db->get_where('sc_mst.karyawan', array('nik' => $this->session->userdata('nik'), 'lvl_jabatan' => 'A'))->num_rows() > 0;

            $statusses = array(
                $kode . '1' => $isSPVGA,
                $kode . '2' => $superior2 == $this->session->userdata('nik'),
                $kode . '3' => $isRSM,
                $kode . '4' => $isGM,
                $kode . '5' => $isMGRKEU,
                $kode . '6' => $isDIR,
            );

            $isSpkExist = function ($status) use ($nodok) {
                return $this->db->get_where('sc_his.perawatanspk', array('nodok' => $nodok, 'status' => $status))->num_rows() > 0;
            };

            $opt = $this->db->get_where('sc_mst.option', array('kdoption' => 'SPK:APPROVAL:LEVEL'))->row()->value3;

            if ($spk->row()->ttlservis < 1000000) {
                $statusses = array_slice($statusses, 0, $opt, true);
            }
            if ($spk->row()->ttlservis < 4000000) {
                $statusses = array_slice($statusses, 0, $opt + ($opt < 3 ? 2 : 1), true);
            }
            foreach ($statusses as $status => $isAllowed) {
                if ($isSpkExist($status) && $isAllowed) {
                    $nextStatus = (int) strlen($spk->row()->status_spk) >= 3 ? str_split($status, 1)[2] + 1 : str_split($status, 1)[1] + 1;
                    $nextStatus = "$kode$nextStatus";
                    $nextStatusExists = array_key_exists($nextStatus, $statusses);
                    return array('approve_access' => true, 'next_status' => $nextStatusExists ? "$nextStatus" : (strlen($spk->row()->status_spk) >= 3 ? 'X' : 'P'));
                }
            }
        }

        return false;
    }

    function tolak_faktur($nodok)
    {
        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_his.perawatan_mst_lampiran');

        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_his.perawatan_lampiran');

        $this->db->where('nodok', $nodok);
        $this->db->delete('sc_his.perawatan_detail_lampiran');
    }

    function q_hisperawatanspk_pembayaran_tmp($param)
    {
        return $this->db->query("SELECT *
                                from sc_tmp.perawatanspk_pembayaran
                                where 
                                    nodok is not null 
                                    $param 
                                order by 
                                    nodok desc
                                ");
    }

    function q_hisperawatanspk_pembayaran($param)
    {
        return $this->db->query("SELECT *
                                from sc_his.perawatanspk_pembayaran
                                where 
                                    nodok is not null 
                                    $param 
                                order by 
                                    nodok desc
                                ");
    }
}