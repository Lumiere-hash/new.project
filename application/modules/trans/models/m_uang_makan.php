<?php
class M_uang_makan extends CI_Model{

    function q_uangmakan_absensi($kdcabang,$awal,$akhir){
        return $this->db->query("	
		/*select * from sc_trx.qv_uangmakan where nik in (select trim(nik) from sc_mst.karyawan where kdcabang='$kdcabang') and (to_char(tgl,'yyyy-mm-dd') between '$awal' and '$akhir')*/
		
		select *,cast(nominal as money) as nominalrp from (
												select nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,nominal,rank from (
														select nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,nominal,rank() OVER (
																 PARTITION BY nik order by nik
																 ) from (
														select nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,nominal from (
															select a.*,b.nmlengkap,b.kdcabang,c.kddept,c.nmdept,e.nmjabatan,to_char(tgl,'yyyy-mm-dd')||','||
															case 	 when to_char(tgl, 'Dy')='Mon' then 'Senin'
																 when to_char(tgl, 'Dy')='Tue' then 'Selasa'
																 when to_char(tgl, 'Dy')='Wed' then 'Rabu'
																 when to_char(tgl, 'Dy')='Thu' then 'Kamis'
																 when to_char(tgl, 'Dy')='Fri' then 'Jumat'
																 when to_char(tgl, 'Dy')='Sat' then 'Sabtu'
															else 'Out Date' end as tglhari,case when to_char(checkin,'HH24:MI:SS') is null then '' else to_char(checkin,'HH24:MI:SS') end||'|'||case when to_char(checkout,'HH24:MI:SS') is null then '' else to_char(checkout,'HH24:MI:SS') end as checktime
															from sc_trx.uangmakan a 
															left outer join sc_mst.karyawan b on a.nik=b.nik
															left outer join sc_mst.departmen c on b.bag_dept=c.kddept
															left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept
															left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.jabatan=e.kdjabatan and b.subbag_dept=e.kdsubdept
															where a.nik in (select trim(nik) from sc_mst.karyawan where kdcabang='$kdcabang') and (to_char(tgl,'yyyy-mm-dd') between '$awal' and '$akhir')
															order by b.nmlengkap,tgl) as t1
															union all
															select nik,nmlengkap as nama,null as nmdept,null as nmjabatan,null as tglhari, null as checktime, 'TOTAL' as keterangan,sum(nominal) 
															from (	select a.*,b.nmlengkap,b.kdcabang,c.kddept,c.nmdept,e.nmjabatan,to_char(tgl,'yyyy-mm-dd')||','||
																case 	 when to_char(tgl, 'Dy')='Mon' then 'Senin'
																	 when to_char(tgl, 'Dy')='Tue' then 'Selasa'
																	 when to_char(tgl, 'Dy')='Wed' then 'Rabu'
																	 when to_char(tgl, 'Dy')='Thu' then 'Kamis'
																	 when to_char(tgl, 'Dy')='Fri' then 'Jumat'
																	 when to_char(tgl, 'Dy')='Sat' then 'Sabtu'
																else 'Out Date' end as tglhari,case when to_char(checkin,'HH24:MI:SS') is null then '' else to_char(checkin,'HH24:MI:SS') end||'|'||case when to_char(checkout,'HH24:MI:SS') is null then '' else to_char(checkout,'HH24:MI:SS') end as checktime
																from sc_trx.uangmakan a 
																left outer join sc_mst.karyawan b on a.nik=b.nik
																left outer join sc_mst.departmen c on b.bag_dept=c.kddept
																left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept
																left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.jabatan=e.kdjabatan and b.subbag_dept=e.kdsubdept
																where a.nik in (select trim(nik) from sc_mst.karyawan where kdcabang='$kdcabang') and (to_char(tgl,'yyyy-mm-dd') between '$awal' and '$akhir')
																order by nik,tgl) as t1
																group by nik,nmdept,nmjabatan,nmlengkap 

																) as t1
														group by nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,nominal
														order by nmlengkap,tglhari) as a
												union all
													select nik,'GRAND TOTAL UANG MAKAN' as nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,sum(nominal),cast(null as bigint) as rank from (
														select cast('' as text) as nik,cast('' as text) as nmlengkap,cast('' as text) as nmdept,cast('' as text) as nmjabatan,cast ('' as text) as tglhari,cast( '' as text) as checktime, cast('' as text) as keterangan,sum(nominal) as nominal
													from (	select a.*,b.nmlengkap,b.kdcabang,c.kddept,c.nmdept,e.nmjabatan,to_char(tgl,'yyyy-mm-dd')||','||
														case 	 when to_char(tgl, 'Dy')='Mon' then 'Senin'
															 when to_char(tgl, 'Dy')='Tue' then 'Selasa'
															 when to_char(tgl, 'Dy')='Wed' then 'Rabu'
															 when to_char(tgl, 'Dy')='Thu' then 'Kamis'
															 when to_char(tgl, 'Dy')='Fri' then 'Jumat'
															 when to_char(tgl, 'Dy')='Sat' then 'Sabtu'
														else 'Out Date' end as tglhari,case when to_char(checkin,'HH24:MI:SS') is null then '' else to_char(checkin,'HH24:MI:SS') end||'|'||case when to_char(checkout,'HH24:MI:SS') is null then '' else to_char(checkout,'HH24:MI:SS') end as checktime
														from sc_trx.uangmakan a 
														left outer join sc_mst.karyawan b on a.nik=b.nik
														left outer join sc_mst.departmen c on b.bag_dept=c.kddept
														left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept
														left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.jabatan=e.kdjabatan and b.subbag_dept=e.kdsubdept
														where a.nik in (select trim(nik) from sc_mst.karyawan where kdcabang='$kdcabang') and (to_char(tgl,'yyyy-mm-dd') between '$awal' and '$akhir')
														order by nik,tgl) as t1
														group by nik,nmdept,nmjabatan,nmlengkap ) as x
														group by nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan ) as x2

	
								");
    }
    function q_uangmakan_mst_json($kdcabang,$awal,$akhir,$nama){
        return $this->db->query("select desc_cabang::text as cabang,to_char('$awal'::date,'dd-mm-yyyy') as awal,to_char('$akhir'::date,'dd-mm-yyyy') as akhir,'$nama'::text as username 
									from sc_mst.kantorwilayah where kdcabang='$kdcabang';");
    }

    function q_uangmakan_absensi_json($kdcabang,$awal,$akhir){
        return $this->db->query("select
											trim(coalesce(nomor       ,0)::text)as  nomor    ,
											trim(coalesce(nmlengkap ,'')::text)as  nmlengkap ,
											trim(coalesce(nmdept    ,'')::text)as  nmdept    ,
											trim(coalesce(nmjabatan ,'')::text)as  nmjabatan ,
											trim(coalesce(tglhari   ,'')::text)as  tglhari   ,
											trim(coalesce(checktime ,'')::text)as  checktime ,
											trim(coalesce(keterangan,'')::text)as  keterangan,
											trim(coalesce(nominal   ,0) ::text)as nominal    ,
											trim(coalesce(rank      ,0) ::text)as rank       ,
											trim(coalesce(nominalrp ,'') ::text)as nominalrp  
											from (
											select *,cast(nominal as money) as nominalrp,row_number() over () as nomor  from (
												select nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,nominal,rank from (
														select nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,nominal,rank() OVER (
																 PARTITION BY nik order by nik
																 ) from (
														select nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,nominal from (
															select a.*,b.nmlengkap,b.kdcabang,c.kddept,c.nmdept,e.nmjabatan,to_char(tgl,'yyyy-mm-dd')||','||
															case 	 when to_char(tgl, 'Dy')='Mon' then 'Senin'
																 when to_char(tgl, 'Dy')='Tue' then 'Selasa'
																 when to_char(tgl, 'Dy')='Wed' then 'Rabu'
																 when to_char(tgl, 'Dy')='Thu' then 'Kamis'
																 when to_char(tgl, 'Dy')='Fri' then 'Jumat'
																 when to_char(tgl, 'Dy')='Sat' then 'Sabtu'
															else 'Out Date' end as tglhari,case when to_char(checkin,'HH24:MI:SS') is null then '' else to_char(checkin,'HH24:MI:SS') end||'|'||case when to_char(checkout,'HH24:MI:SS') is null then '' else to_char(checkout,'HH24:MI:SS') end as checktime
															from sc_trx.uangmakan a 
															left outer join sc_mst.karyawan b on a.nik=b.nik
															left outer join sc_mst.departmen c on b.bag_dept=c.kddept
															left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept
															left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.jabatan=e.kdjabatan and b.subbag_dept=e.kdsubdept
															where a.nik in (select trim(nik) from sc_mst.karyawan where kdcabang='$kdcabang') and (to_char(tgl,'yyyy-mm-dd') between '$awal' and '$akhir')
															order by b.nmlengkap,tgl) as t1
															union all
															select nik,nmlengkap as nama,null as nmdept,null as nmjabatan,'TANDA TANGAN'::text as tglhari, null as checktime, 'TOTAL' as keterangan,sum(nominal) 
															from (	select a.*,b.nmlengkap,b.kdcabang,c.kddept,c.nmdept,e.nmjabatan,to_char(tgl,'yyyy-mm-dd')||','||
																case 	 when to_char(tgl, 'Dy')='Mon' then 'Senin'
																	 when to_char(tgl, 'Dy')='Tue' then 'Selasa'
																	 when to_char(tgl, 'Dy')='Wed' then 'Rabu'
																	 when to_char(tgl, 'Dy')='Thu' then 'Kamis'
																	 when to_char(tgl, 'Dy')='Fri' then 'Jumat'
																	 when to_char(tgl, 'Dy')='Sat' then 'Sabtu'
																else 'Out Date' end as tglhari,case when to_char(checkin,'HH24:MI:SS') is null then '' else to_char(checkin,'HH24:MI:SS') end||'|'||case when to_char(checkout,'HH24:MI:SS') is null then '' else to_char(checkout,'HH24:MI:SS') end as checktime
																from sc_trx.uangmakan a 
																left outer join sc_mst.karyawan b on a.nik=b.nik
																left outer join sc_mst.departmen c on b.bag_dept=c.kddept
																left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept
																left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.jabatan=e.kdjabatan and b.subbag_dept=e.kdsubdept
																where a.nik in (select trim(nik) from sc_mst.karyawan where kdcabang='$kdcabang') and (to_char(tgl,'yyyy-mm-dd') between '$awal' and '$akhir')
																order by nik,tgl) as t1
																group by nik,nmdept,nmjabatan,nmlengkap 

																) as t1
														group by nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,nominal
														order by nmlengkap,tglhari) as a
												union all
													select nik,'GRAND TOTAL UANG MAKAN' as nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan,sum(nominal),cast(null as bigint) as rank from (
														select cast('' as text) as nik,cast('' as text) as nmlengkap,cast('' as text) as nmdept,cast('' as text) as nmjabatan,cast ('' as text) as tglhari,cast( '' as text) as checktime, cast('' as text) as keterangan,sum(nominal) as nominal
													from (	select a.*,b.nmlengkap,b.kdcabang,c.kddept,c.nmdept,e.nmjabatan,to_char(tgl,'yyyy-mm-dd')||','||
														case 	 when to_char(tgl, 'Dy')='Mon' then 'Senin'
															 when to_char(tgl, 'Dy')='Tue' then 'Selasa'
															 when to_char(tgl, 'Dy')='Wed' then 'Rabu'
															 when to_char(tgl, 'Dy')='Thu' then 'Kamis'
															 when to_char(tgl, 'Dy')='Fri' then 'Jumat'
															 when to_char(tgl, 'Dy')='Sat' then 'Sabtu'
														else 'Out Date' end as tglhari,case when to_char(checkin,'HH24:MI:SS') is null then '' else to_char(checkin,'HH24:MI:SS') end||'|'||case when to_char(checkout,'HH24:MI:SS') is null then '' else to_char(checkout,'HH24:MI:SS') end as checktime
														from sc_trx.uangmakan a 
														left outer join sc_mst.karyawan b on a.nik=b.nik
														left outer join sc_mst.departmen c on b.bag_dept=c.kddept
														left outer join sc_mst.subdepartmen d on b.bag_dept=d.kddept and b.subbag_dept=d.kdsubdept
														left outer join sc_mst.jabatan e on b.bag_dept=e.kddept and b.jabatan=e.kdjabatan and b.subbag_dept=e.kdsubdept
														where a.nik in (select trim(nik) from sc_mst.karyawan where kdcabang='$kdcabang') and (to_char(tgl,'yyyy-mm-dd') between '$awal' and '$akhir')
														order by nik,tgl) as t1
														group by nik,nmdept,nmjabatan,nmlengkap ) as x
														group by nik,nmlengkap,nmdept,nmjabatan,tglhari,checktime,keterangan ) as x2) as a");
    }

    function q_uangmakan_regu($kdcabang, $awal, $akhir, $callplan, $borong) {
        return $this->db->query("
            SELECT 
                ROW_NUMBER() OVER () AS no, 
                a.nik, 
                a.tgl, 
                CASE 
                    WHEN GROUPING(b.nmlengkap) = 0 THEN b.nmlengkap 
                    ELSE 'GRAND TOTAL UANG MAKAN' 
                END AS nmlengkap, 
                b.callplan, 
                c.nmdept, 
                e.nmjabatan, 
                TO_CHAR(a.tgl, 'TMDAY, DD-MM-YYYY') AS tglhari, 
                a.checkin, 
                a.checkout, 
                CASE 
                    WHEN GROUPING(b.nmlengkap) = 0 AND GROUPING(a.keterangan) = 0 AND (a.checkin IS NOT NULL OR a.checkout IS NOT NULL)
                    THEN CONCAT(LPAD(a.checkin::TEXT, 8), ' | ', a.checkout::TEXT)
                END AS checktime, 
                a.rencanacallplan, 
                a.realisasicallplan,
                CASE 
                    WHEN GROUPING(b.nmlengkap) = 0 AND GROUPING(a.keterangan) = 0 THEN a.keterangan 
                    WHEN GROUPING(b.nmlengkap) = 0 AND GROUPING(a.keterangan) = 1 THEN 'TOTAL' 
                END AS keterangan, COALESCE(SUM(a.nominal), 0) AS nominalrp,
                COALESCE(SUM(a.bbm),0) AS bbm,
                COALESCE(SUM(a.sewa_kendaraan),0) AS sewa_kendaraan,
                COALESCE( SUM(a.bbm), 0) + COALESCE( SUM(a.sewa_kendaraan), 0) + COALESCE( SUM(a.nominal), 0) AS subtotal,
                GROUPING(b.nmlengkap) AS group_nmlengkap, 
                GROUPING(a.keterangan) AS group_keterangan
                FROM sc_trx.uangmakan a 
                LEFT JOIN sc_mst.karyawan b ON a.nik = b.nik
                LEFT JOIN sc_mst.departmen c ON b.bag_dept = c.kddept 
                LEFT JOIN sc_mst.subdepartmen d ON b.bag_dept = d.kddept AND b.subbag_dept = d.kdsubdept 
                LEFT JOIN sc_mst.jabatan e ON b.bag_dept = e.kddept AND b.jabatan = e.kdjabatan AND b.subbag_dept = e.kdsubdept
                WHERE kdcabang = '$kdcabang' AND a.tgl::DATE BETWEEN '$awal' AND '$akhir' AND b.callplan = '$callplan' AND b.tjborong = '$borong'
                GROUP BY GROUPING SETS (
                    (a.nik, a.tgl, b.nmlengkap, b.callplan, c.nmdept, e.nmjabatan, a.checkin, a.checkout, a.rencanacallplan, a.realisasicallplan, a.keterangan,a.nominal, a.bbm, a.sewa_kendaraan), 
                    (a.nik, b.nmlengkap), 
                    ()
                )
            ORDER BY b.nmlengkap, a.tgl
        ");
    }

    function q_kanwil(){
        return $this->db->query("select * from sc_mst.kantorwilayah order by desc_cabang");
    }

    function q_regu($params = "") {
        return $this->db->query("
            SELECT DISTINCT a.kdregu, nmregu
            FROM sc_mst.regu_opr a
            INNER JOIN sc_mst.regu b ON b.kdregu = a.kdregu
            $params
            ORDER BY nmregu        
        ");
    }

    function q_kanwil_dtl($kdcabang){
        return $this->db->query("select * from sc_mst.kantorwilayah where kdcabang='$kdcabang' order by desc_cabang");
    }

    function q_regu_dtl($kdregu){
        return $this->db->query("select * from sc_mst.regu where kdregu='$kdregu'");
    }

    //list kantor
    function q_kantor(){
        return $this->db->query("select * from sc_mst.kantor");
    }

    function q_listpeg(){
        return $this->db->query("select a.nip as list_nip,* from sc_hrd.pegawai a
								left outer join sc_hrd.jabatan b on a.kdjabatan=b.kdjabatan
								left outer join sc_hrd.departement c on a.kddept=c.kddept
								left outer join sc_mst.carea d on a.wilayah=d.area
								left outer join sc_hrd.agama e on a.kdagama=e.kode_agama
								left outer join sc_mst.user f on a.nip=f.nip
								order by a.nmlengkap");
    }

    function q_sisa(){
        return $this->db->query("select * 
		from sc_hrd.pegawai a, sc_hrd.jabatan b, sc_hrd.departement c, sc_hrd.jumlahcuti d
		where a.kddept=c.kddept and a.kdjabatan=b.kdjabatan and a.nip=d.nip and tahun='2014' order by a.nip");
    }



    function simpan_finger($info_finger){
        $this->db->insert("sc_hrd.fingerprint",$info_finger);
    }

    function edit_finger($info_finger,$ip){
        $this->db->where("ipaddress",$ip);
        $this->db->update("sc_hrd.fingerprint",$info_finger);
    }
    function cek_finger($idfinger,$ip,$wil){
        return $this->db->query("select * from sc_hrd.fingerprint where fingerid='$idfinger' and wilayah='$wil' and ipaddress='$ip' ");
    }
    //download user dari finger
    function cek_userfp($ipne,$uid,$idfp,$namafp){
        return $this->db->query("select * from sc_hrd.user_finger where ipaddress='$ipne' and uid='$uid' and id='$idfp' and nama='$namafp'");
    }

    function simpan_tarik_user($info_userfp){
        $this->db->insert("sc_hrd.user_finger",$info_userfp);
    }
    //download log attedance
    function cek_idlogfp($userid,$uid,$ipne,$cktype,$ckdate,$cktime){
        return $this->db->query("select * from sc_hrd.transready where userid='$userid' and ipaddress='$ipne' 
								and badgenumber=(select id from sc_hrd.user_finger where uid='$userid' and ipaddress='$ipne')
								and checkdate='$ckdate' and checktime='$cktime' and checktype='$cktype'
								");
    }
    function simpan_logatt($userid,$uid,$ipne,$cktype,$ckdate,$cktime){
        //$this->db->insert("sc_hrd.transready",$info_logfp);
        $this->db->query("INSERT INTO sc_hrd.transready (userid,badgenumber,ipaddress,checktype,checkdate,checktime) VALUES ('$userid', 
							(select id from sc_hrd.user_finger where uid='$userid' and ipaddress='$ipne'), '$ipne', '$cktype','$ckdate' ,'$cktime')");
    }

    function q_absensi_old($branch,$awal,$akhir){
        return $this->db->query("
								select nmlengkap,badgenumber,checkdate,checkin,checkout,hari,uangmakan,deskripsi,departement,
								case	
									when checkin<'08:00:00' and checkout>'16:00:00' and checkout<'17:00:00' and hari<>'Sabtu' then 'Tepat Waktu'
									when checkin<'08:00:00' and checkout>'13:00:00' and hari='Sabtu' then 'Tepat Waktu'
									when checkin>'08:00:00' and checkout>'13:00:00' and hari='Sabtu' then 'Telat Masuk'
									when checkin<'08:00:00' and checkout>'11:00:00' and checkout<'13:00:00' and hari='Sabtu' then 'Tepat Waktu & Pulang Awal'
									when checkin<'08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' then 'Loyalitas'
									when checkin>'08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' then 'Telat Masuk'
									when checkin<'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' then 'Pulang Awal'
									when checkin>'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' then 'Telat & Pulang Awal'
									when checkin is null and checkout is null and badgenumber<>'TOTAL' and badgenumber<>'GRAND TOTAL' then 'Tidak Ceklog'
									when checkin is null and checkout is not null then 'Tidak Ceklog Masuk'
									when checkin is not null and checkout is null then 'Tidak Ceklog Keluar'
								end as ket
								from (
								select nmlengkap,badgenumber,to_char(checkdate,'dd-mm-YYYY') as checkdate,checkin,checkout,
									case when to_char(checkdate, 'Dy')='Mon' then 'Senin'
										 when to_char(checkdate, 'Dy')='Tue' then 'Selasa'
										 when to_char(checkdate, 'Dy')='Wed' then 'Rabu'
										 when to_char(checkdate, 'Dy')='Thu' then 'Kamis'
										 when to_char(checkdate, 'Dy')='Fri' then 'Jumat'
										 when to_char(checkdate, 'Dy')='Sat' then 'Sabtu'
									else 'Kiamat' end as hari,
									--to_char(checkdate, 'Dy') as hari,
									CASE 
									WHEN deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
									WHEN deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin									
									WHEN deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin	     									
									WHEN deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin
									WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' then c.besaran-kantin
									ELSE '0'
									END
									as uangmakan,
									deskripsi,departement from 
									(select t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement,
									cast(coalesce(cast(tt.besaran as numeric),0) as money) as kantin	from 
										(select b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
										d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
										left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
										left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
										left outer join sc_hrd.departement e on e.kddept=b.kddept			
										where checkdate between '$awal' and '$akhir' and 		
										checktype='IN'
										and a.ipaddress='$branch'
										group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
										union all										
										select b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
											case when to_char(checkdate, 'Dy')='Sat' then max(a.checktime)
												 when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then max(a.checktime)
											end as checkout,
										d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
										left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
										left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
										left outer join sc_hrd.departement e on e.kddept=b.kddept			
										where checkdate between '$awal' and '$akhir' and 
										checktype<>'IN' and a.ipaddress='$branch'
										group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
										order by nmlengkap,checkdate ) as t1
									left outer join sc_hrd.kantin tt on t1.kdcabang=tt.kd_cab
									group by t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement,tt.besaran) as t2
								left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn
								--order by nmlengkap
								union all
								--total
								select ttl.nmlengkap,'TOTAL' as badgenumber,null as checkdate, null as checktin, null as checkout, null as hari,sum(uangmakan),cast(count(nmlengkap)as character varying), null as departement from
									(select nmlengkap,badgenumber,checkdate,checkin,checkout,
										CASE 
										WHEN deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
										WHEN deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin										
										WHEN deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin	     									
										WHEN deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin
										WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' then c.besaran-kantin
										ELSE '0'
											END
											as uangmakan,		
										deskripsi,departement from 
										(select t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement,
									cast(coalesce(cast(tt.besaran as numeric),0) as money) as kantin	from 
										(select b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
										d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
										left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
										left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
										left outer join sc_hrd.departement e on e.kddept=b.kddept			
										where checkdate between '$awal' and '$akhir' and 		
										checktype='IN'
										and a.ipaddress='$branch'
										group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
										union all										
										select b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
											case when to_char(checkdate, 'Dy')='Sat' then max(a.checktime)
												 when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then max(a.checktime)
											end as checkout,
										d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
										left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
										left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
										left outer join sc_hrd.departement e on e.kddept=b.kddept			
										where checkdate between '$awal' and '$akhir' and 
										checktype<>'IN' and a.ipaddress='$branch'
										group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
										order by nmlengkap,checkdate ) as t1
									left outer join sc_hrd.kantin tt on t1.kdcabang=tt.kd_cab
									group by t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement,tt.besaran) as t2
									left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn) as ttl
								group by nmlengkap
								--grand total
								union all
								select null as nmlengkap,'GRAND TOTAL' as badgenumber,null as checkdate, null as checktin, null as checkout, null as hari, sum(uangmakan),cast(count(nmlengkap)as character varying), null as departement from
									(select nmlengkap,badgenumber,checkdate,checkin,checkout,
										CASE 
										WHEN deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
										WHEN deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin
										WHEN deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
										WHEN deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin
										WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' then c.besaran-kantin
										ELSE '0'
											END
											as uangmakan,
										deskripsi,departement from 
										(select t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement,
									cast(coalesce(cast(tt.besaran as numeric),0) as money) as kantin	from 
										(select b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
										d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
										left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
										left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
										left outer join sc_hrd.departement e on e.kddept=b.kddept			
										where checkdate between '$awal' and '$akhir' and 		
										checktype='IN'
										and a.ipaddress='$branch'
										group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
										union all										
										select b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
											case when to_char(checkdate, 'Dy')='Sat' then max(a.checktime)
												 when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then max(a.checktime)
											end as checkout,
										d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
										left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
										left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
										left outer join sc_hrd.departement e on e.kddept=b.kddept			
										where checkdate between '$awal' and '$akhir' and 
										checktype<>'IN' and a.ipaddress='$branch'
										group by b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
										order by nmlengkap,checkdate ) as t1
									left outer join sc_hrd.kantin tt on t1.kdcabang=tt.kd_cab
									group by t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement,tt.besaran) as t2
									left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn) as ttl
								order by nmlengkap,checkdate
								) as um
							");
    }

    function q_pegabsen($branch,$awal,$akhir){
        return $this->db->query("select distinct nmlengkap from sc_hrd.pegawai b
								left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
								where checkdate between '$awal' and '$akhir' and checktype<>'INOUT' and a.ipaddress='$branch'
								order by nmlengkap");
    }

    function q_uang(){
        return $this->db->query("select ID_UM,b.deskripsi as DEKRIPSI,FM_BESARAN from sc_hrd.uangmakan a
								left outer join sc_hrd.jabatan b on b.kdjabatan=a.KDJABATAN");
    }

    function simpan_um($info){
        $this->db->insert("sc_hrd.uangmakan",$info);
    }

    function q_jabatan(){
        return $this->db->query("select * from sc_hrd.jabatan");
    }

    function q_departement(){
        return $this->db->query("select * from sc_hrd.departement");
    }

    function q_subdepartement(){
        return $this->db->query("select * from sc_hrd.subdepartement");
    }
    function q_agama(){
        return $this->db->query("select kode as kode_agama,upper(deskripsi) as desc_agama from sc_mst.trxstatus
								 where trx='HRDA'");
    }
    //Pelatihan
    function q_pelatihan($nip){
        return $this->db->query("select * from sc_hrd.pelatihan where nip='$nip'");
    }

    function q_kdpelatihan(){
        return $this->db->query("select max(kdpelatihan)as kdpelatihan from sc_hrd.pelatihan");
    }

    function input_pelatihan($info_pel){
        $this->db->insert("sc_hrd.pelatihan",$info_pel);
    }

    function edit_pelatihan($nip,$kdpelatihan,$info_pel){
        $this->db->where("nip",$nip);
        $this->db->where("kdpelatihan",$kdpelatihan);
        $this->db->update("sc_hrd.pelatihan",$info_pel);
    }
    function hapus_pelatihan($nip,$kdpelatihan){
        $this->db->where("nip",$nip);
        $this->db->where("kdpelatihan",$kdpelatihan);
        $this->db->delete("sc_hrd.pelatihan");
    }

    //simpan data pegawai
    function save_peg($info_peg){
        $this->db->insert("sc_tmp.pegawai",$info_peg);
    }
    //edit data pegawai
    function edit_peg($oldnip,$info_peg){
        $this->db->where('nip',$oldnip);
        $this->db->update('sc_hrd.pegawai',$info_peg);
    }
    //simpan data jumlah cuti
    function save_jmlcuti($info_cuti){
        $this->db->insert("sc_hrd.jumlahcuti",$info_cuti);
    }
    //simpan foto
    function save_foto($nip,$info){
        $this->db->where('nip',$nip);
        $this->db->update('sc_hrd.pegawai',$info);
    }

    function q_pegawai_filter(){
        if($this->session->userdata('level')=='A'){
            $peg=" ";
        } else
        {
            $nip=$this->session->userdata('nip');
            $peg=$nip;
        }
        return $this->db->query("select a.nip as list_nip,
									case when a.keluarkerja is null then age(a.masukkerja)
									else age(a.keluarkerja,a.masukkerja)
									end as masakerja,g.nmlengkap as nama_atasan,
									b.deskripsi,c.departement,i.subdepartement,e.desc_agama,h.kdkawin,h.desckawin as kawin,
									j.desc_cabang,a.nip,a.kddept,a.nipatasan,a.kdsubdept,a.kdjabatan,a.nmlengkap,
									to_char(a.masukkerja,'dd-mm-YYYY') as masukkerja,
									to_char(a.keluarkerja,'dd-mm-YYYY') as keluarkerja,a.kdkelamin,a.tempatlahir,a.tgllahir,a.alamat,a.kdstrumah,a.kota,a.telepon,a.kdagama,
									a.kdwn,a.ktp,a.kotaktp,a.tglmulaiktp,a.tglakhirktp,a.kdstnikah,a.idabsensi,a.goldarah,
									a.badgenumber,a.bpjs,a.bpjskes,a.npwp,a.norek,a.image,a.kdcabang,a.email,a.kduangmkn,k.descjabatan,a.ktp_seumurhdp,a.* from sc_hrd.pegawai a
									left outer join sc_hrd.jabatan b on a.kdjabatan=b.kdjabatan and a.kddept=b.kddept and a.kdsubdept=b.kdsubdept
									left outer join sc_hrd.departement c on a.kddept=c.kddept
									left outer join sc_hrd.agama e on a.kdagama=e.kode_agama
									left outer join sc_hrd.pegawai g on g.nip=a.nipatasan
									left outer join sc_hrd.kawin h on h.kdkawin=a.kdstnikah
									left outer join sc_hrd.subdepartement i on i.kdsubdept=a.kdsubdept and i.kddept=a.kddept
									left outer join sc_mst.kantor j on j.kodecabang=a.kdcabang
									left outer join sc_hrd.uangmakan k on k.kdjabatan=a.kduangmkn
									where a.nip='$peg'
									order by right(a.nip,3)");
    }

    function q_absensi($branch,$awal,$akhir){

        return $this->db->query("select ipaddress,nmlengkap,badgenumber,checkdate,checkin,checkout,hari,uangmakan,deskripsi,departement,
										case	
											when checkin<'08:00:00' and checkout>'16:00:00' and checkout<'17:00:00' and hari<>'Sabtu' then 'Tepat Waktu'
											when checkin<'08:00:00' and checkout>'13:00:00' and hari='Sabtu' then 'Tepat Waktu'
											when checkin>='08:00:00' and checkout>'13:00:00' and hari='Sabtu' and noijin is null then 'Telat Masuk'
											when checkin>'08:00:00' and checkout>'13:00:00' and hari='Sabtu' and left(noijin,2)='IK' then 'Ijin Khusus Keluar'
											when checkin>'08:00:00' and checkout>'13:00:00' and hari='Sabtu' and left(noijin,2)='PA' then 'Ijin Pulang Awal'
											when checkin>'08:00:00' and checkout>'13:00:00' and hari='Sabtu' and left(noijin,2)='DT' then 'Ijin Datang Terlambat'
											when checkin<'08:00:00' and checkout>'11:00:00' and checkout<'13:00:00' and hari='Sabtu' then 'Tepat Waktu & Pulang Awal'
											when checkin<'08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' then 'Loyalitas'
											when checkin>='08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' and noijin is null then 'Telat Masuk'
											when checkin>'08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' and left(noijin,2)='IK' then 'Ijin Khusus Keluar'
											when checkin>'08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' and left(noijin,2)='PA' then 'Ijin Pulang Awal'
											when checkin>'08:00:00' and checkout>'16:00:00' and hari<>'Sabtu' and left(noijin,2)='DT' then 'Ijin Datang Terlambat'
											when checkin<'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' and noijin is null then 'Pulang Awal'
											when checkin<'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' and left(noijin,2)='IK'  then 'Ijin Khusus Keluar'
											when checkin<'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' and left(noijin,2)='PA'  then 'Ijin Pulang Awal'
											when checkin<'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' and left(noijin,2)='DT'  then 'Ijin Datang Terlambat'
											when checkin>='08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' and noijin is null then 'Telat & Pulang Awal'
											when checkin>'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' and left(noijin,2)='IK' then 'Ijin Khusus Keluar'
											when checkin>'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' and left(noijin,2)='PA' then 'Ijin Pulang Awal'
											when checkin>'08:00:00' and checkout<'16:00:00' and hari<>'Sabtu' and left(noijin,2)='DT' then 'Ijin Datang Terlambat'
											when checkin is null and checkout is null and badgenumber<>'TOTAL' and badgenumber<>'GRAND TOTAL' then 'Tidak Ceklog'
											when checkin is null and checkout is not null and noijin is null then 'Tidak Ceklog Masuk'
											when checkin is null and checkout is not null and left(noijin,2)='IK' then 'Ijin Khusus Keluar'
											when checkin is null and checkout is not null and left(noijin,2)='PA' then 'PULANG AWAL'
											when checkin is null and checkout is not null and left(noijin,2)='DT' then 'TERLAMBAT'
											when checkin is not null and checkout is null and noijin is null then 'Tidak Ceklog Keluar'
											when checkin is not null and checkout is null and noijin is not null then 'Ijin Khusus Keluar'
											
										end as ket
										from (
										select ipaddress,nmlengkap,badgenumber,to_char(checkdate,'dd-mm-YYYY') as checkdate,checkin,checkout,
											case when to_char(checkdate, 'Dy')='Mon' then 'Senin'
												 when to_char(checkdate, 'Dy')='Tue' then 'Selasa'
												 when to_char(checkdate, 'Dy')='Wed' then 'Rabu'
												 when to_char(checkdate, 'Dy')='Thu' then 'Kamis'
												 when to_char(checkdate, 'Dy')='Fri' then 'Jumat'
												 when to_char(checkdate, 'Dy')='Sat' then 'Sabtu'
												 when to_char(checkdate, 'Dy')='Sun' then 'Minggu'
											else 'Outdate' end as hari,
											--to_char(checkdate, 'Dy') as hari,
											CASE 
											WHEN ipaddress!='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
											WHEN ipaddress!='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin									
											WHEN ipaddress!='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin	     									
											WHEN ipaddress!='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin

											WHEN ipaddress='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
											WHEN ipaddress='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin									
											WHEN ipaddress='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin	     									
											WHEN ipaddress='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin
											WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' or noijin is not null then c.besaran-kantin
											
											ELSE '0'
											END
											as uangmakan,
											deskripsi,departement,noijin from 
											(select t1.ipaddress,t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement,
											case
																			when left(d.noijin,2)='DT' and to_char(sum(t1.checkin),'HH24:MI:SS')>='13:00:00' and to_char(sum(t1.checkin),'HH24:MI:SS') is not null then cast(0 as money)
																			when left(d.noijin,2)='IK' and (select cast(to_char(jamawal,'HH24:MI:SS')as time) from sc_hrd.ijin where d.noijin=kdijin||':'||to_char(tglijin,'yymm')||id)<='11:00:00'  then cast(0 as money)
																			else cast(coalesce(cast(tt.besaran as numeric),0) as money)end as kantin,
																			case 
																			when left(d.noijin,2)='IK' and to_char(sum(t1.checkin),'HH24:MI:SS')>='08:05:00' or to_char(sum(t1.checkin),'HH24:MI:SS') is null  then null
																			when left(d.noijin,2)='PA' and to_char(sum(t1.checkin),'HH24:MI:SS')>='08:05:00' and to_char(sum(t1.checkin),'HH24:MI:SS')<='13:00:00' then null
																			else d.noijin

																			end as noijin	from 
												(select a.ipaddress,b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
												d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
												left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
												left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
												left outer join sc_hrd.departement e on e.kddept=b.kddept			
												where checkdate between '$awal' and '$akhir' and 		
												checktype='IN'
												and a.ipaddress='$branch'
												group by a.ipaddress,b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
												union all										
												select a.ipaddress,b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
													case when to_char(checkdate, 'Dy')='Sat' then max(a.checktime)
														 when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then max(a.checktime)
													end as checkout,
												d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
												left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
												left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
												left outer join sc_hrd.departement e on e.kddept=b.kddept			
												where checkdate between '$awal' and '$akhir' and 
												checktype<>'IN' and a.ipaddress='$branch'
												group by a.ipaddress,b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
												order by nmlengkap,checkdate ) as t1
											left outer join sc_hrd.kantin tt on t1.kdcabang=tt.kd_cab
											--tambahan ijin----
											left outer join (select max(noijin) as noijin,nip,max(kdijin) as kdijin,tglijin,max(keterangan_ijin),nmlengkap,max(desc_kdatt),max(deskripsi),tgl,departement,badgenumber,ipaddress 
												from (select  a.kdijin||':'||to_char(a.tglijin,'yymm')||a.id as noijin,a.nip,a.kdijin,a.tglijin,a.keterangan_ijin,b.nmlengkap,c.desc_kdatt,d.deskripsi,to_char(tglijin,'dd-mm-yyyy') as tgl,e.departement,b.badgenumber,f.ipaddress
													from sc_hrd.ijin a
													left outer join sc_hrd.pegawai b on a.nip=b.nip
													left outer join sc_hrd.kodeatt c on c.kdatt=a.kdijin
													left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and b.kdsubdept=d.kdsubdept
													left outer join sc_hrd.departement e on e.kddept=b.kddept
													left outer join sc_hrd.user_finger f on b.badgenumber=f.id
													where ((a.kdijin='IK' and to_char(jamakhir,'HH24:MI:SS')>=
														case when to_char(a.tglijin, 'Dy')='Sat' then '13:00:00'
														else '16:00:00' end and to_char(jamawal,'HH24:MI:SS')>='08:00:00' )  or kdijin='PA' or kdijin='DT') and a.status<>'D' and a.status<>'C'
													order by a.tglijin desc) as t10
												group by nip,tglijin,nmlengkap,tgl,departement,badgenumber,ipaddress) d on d.badgenumber=t1.badgenumber and d.tglijin=t1.checkdate
											group by t1.ipaddress,t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement,tt.besaran,d.noijin) as t2
											--end tambahan ijin---
											--group by ipaddress,t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement,tt.besaran,d.noijin) as t2
										left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn
										--order by nmlengkap
										union all
										--total
										select null as ipaddress,ttl.nmlengkap,'TOTAL' as badgenumber,null as checkdate, null as checktin, null as checkout, null as hari,sum(uangmakan),cast(count(nmlengkap)as character varying), null as departement,null as noijin from
											(
											select nmlengkap,t2.badgenumber,checkdate,checkin,checkout,
												CASE 
											WHEN ipaddress!='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
											WHEN ipaddress!='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin									
											WHEN ipaddress!='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin	     									
											WHEN ipaddress!='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin

											WHEN ipaddress='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
											WHEN ipaddress='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin									
											WHEN ipaddress='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin	     									
											WHEN ipaddress='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin
											WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' or noijin is not null then c.besaran-kantin
											
											ELSE '0'
													END
													as uangmakan,		
												deskripsi,departement,noijin from 
												(

												select t1.ipaddress,t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement,
											case
																			when left(d.noijin,2)='DT' and to_char(sum(t1.checkin),'HH24:MI:SS')>='13:00:00' and to_char(sum(t1.checkin),'HH24:MI:SS') is not null then cast(0 as money)
																			when left(d.noijin,2)='IK' and (select cast(to_char(jamawal,'HH24:MI:SS')as time) from sc_hrd.ijin where d.noijin=kdijin||':'||to_char(tglijin,'yymm')||id)<='11:00:00' then cast(0 as money)
																			else cast(coalesce(cast(tt.besaran as numeric),0) as money) end as kantin,
																			case 
																			when left(d.noijin,2)='IK' and to_char(sum(t1.checkin),'HH24:MI:SS')>='08:05:00' or to_char(sum(t1.checkin),'HH24:MI:SS') is null  then null
																			when left(d.noijin,2)='PA' and to_char(sum(t1.checkin),'HH24:MI:SS')>='08:05:00' and to_char(sum(t1.checkin),'HH24:MI:SS')<='13:00:00' then null
																			else d.noijin

																			end as noijin	from 
												(select a.ipaddress,b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
												d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
												left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
												left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
												left outer join sc_hrd.departement e on e.kddept=b.kddept			
												where checkdate between '$awal' and '$akhir' and 		
												checktype='IN'
												and a.ipaddress='$branch'
												group by a.ipaddress,b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
												union all										
												select a.ipaddress,b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
													case when to_char(checkdate, 'Dy')='Sat' then max(a.checktime)
														 when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then max(a.checktime)
													end as checkout,
												d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
												left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
												left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
												left outer join sc_hrd.departement e on e.kddept=b.kddept			
												where checkdate between '$awal' and '$akhir' and 
												checktype<>'IN' and a.ipaddress='$branch'
												group by a.ipaddress,b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
												order by nmlengkap,checkdate
												) as t1
											left outer join sc_hrd.kantin tt on t1.kdcabang=tt.kd_cab
											--tambahan ijin----
											left outer join (select max(noijin) as noijin,nip,max(kdijin) as kdijin,tglijin,max(keterangan_ijin),nmlengkap,max(desc_kdatt),max(deskripsi),tgl,departement,badgenumber,ipaddress 
												from (select  a.kdijin||':'||to_char(a.tglijin,'yymm')||a.id as noijin,a.nip,a.kdijin,a.tglijin,a.keterangan_ijin,b.nmlengkap,c.desc_kdatt,d.deskripsi,to_char(tglijin,'dd-mm-yyyy') as tgl,e.departement,b.badgenumber,f.ipaddress
													from sc_hrd.ijin a
													left outer join sc_hrd.pegawai b on a.nip=b.nip
													left outer join sc_hrd.kodeatt c on c.kdatt=a.kdijin
													left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and b.kdsubdept=d.kdsubdept
													left outer join sc_hrd.departement e on e.kddept=b.kddept
													left outer join sc_hrd.user_finger f on b.badgenumber=f.id
													where ((a.kdijin='IK' and to_char(jamakhir,'HH24:MI:SS')>=
														case when to_char(a.tglijin, 'Dy')='Sat' then '13:00:00'
														else '16:00:00' end and to_char(jamawal,'HH24:MI:SS')>='08:00:00' ) or kdijin='PA' or kdijin='DT') and a.status<>'D' and a.status<>'C'
													order by a.tglijin desc) as t10
												group by nip,tglijin,nmlengkap,tgl,departement,badgenumber,ipaddress) d on d.badgenumber=t1.badgenumber and d.tglijin=t1.checkdate
											group by t1.ipaddress,t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement,tt.besaran,d.noijin
											--end tambahan ijin---
											) as t2
											left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn
											) as ttl
										group by nmlengkap,badgenumber
										--grand total
										union all
										
										select null as ipaddress,null as nmlengkap,'GRAND TOTAL' as badgenumber,null as checkdate, null as checktin, null as checkout, null as hari, sum(uangmakan),cast(count(nmlengkap)as character varying), null as departement, 
										null as noijin from
											(select ipaddress,nmlengkap,badgenumber,checkdate,checkin,checkout,
												CASE 
												WHEN ipaddress!='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
												WHEN ipaddress!='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
												WHEN ipaddress!='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin									
												WHEN ipaddress!='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin	     									
												WHEN ipaddress!='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:05:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin

												WHEN ipaddress='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin
												WHEN ipaddress='192.168.2.167' and deskripsi='SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin									
												WHEN ipaddress='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'13:00:00' and to_char(checkdate, 'Dy')<>'Sat' then c.besaran-kantin	     									
												WHEN ipaddress='192.168.2.167' and deskripsi<>'SALES REPRESNTATIF' and checkin<'08:10:00' and checkout>'11:00:00' and to_char(checkdate, 'Dy')='Sat' then c.besaran-kantin
												WHEN trim(kduangmkn)='D' or trim(kduangmkn)='E' or noijin is not null then c.besaran-kantin
												ELSE '0'
														END
														as uangmakan,		
												deskripsi,departement from 

												(select t1.ipaddress,t1.nmlengkap,t1.badgenumber,t1.checkdate,sum(t1.checkin) as checkin,sum(t1.checkout) as checkout,t1.deskripsi,t1.kduangmkn,t1.departement,

																			case
																			when left(d.noijin,2)='DT' and to_char(sum(t1.checkin),'HH24:MI:SS')>='13:00:00' and to_char(sum(t1.checkin),'HH24:MI:SS') is not null then cast(0 as money)
																			when left(d.noijin,2)='IK' and (select cast(to_char(jamawal,'HH24:MI:SS')as time) from sc_hrd.ijin where d.noijin=kdijin||':'||to_char(tglijin,'yymm')||id)<='11:00:00' then cast(0 as money)
																			else cast(coalesce(cast(tt.besaran as numeric),0) as money) end as kantin,
																			case 
																			when left(d.noijin,2)='IK' and to_char(sum(t1.checkin),'HH24:MI:SS')>='08:05:00' or to_char(sum(t1.checkin),'HH24:MI:SS') is null  then null
																			when left(d.noijin,2)='PA' and to_char(sum(t1.checkin),'HH24:MI:SS')>='08:05:00' and to_char(sum(t1.checkin),'HH24:MI:SS')<='13:00:00' then null
																			else d.noijin

																			end as noijin from 
																				(

													select a.ipaddress,b.nmlengkap,b.badgenumber,a.checkdate,min(a.checktime) as checkin,null as checkout,
													d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
													left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
													left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
													left outer join sc_hrd.departement e on e.kddept=b.kddept			
													where checkdate between '$awal' and '$akhir' and 		
													checktype='IN'
													and a.ipaddress='$branch' 
													group by ipaddress,b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang 
												union all							
												select a.ipaddress,b.nmlengkap,b.badgenumber,a.checkdate,null as checkin,
													case when to_char(checkdate, 'Dy')='Sat' then max(a.checktime)
														 when to_char(checkdate, 'Dy')<>'Sat' and checktype='OUT' then max(a.checktime)
													end as checkout,
												d.deskripsi,b.kduangmkn,e.departement,b.kdcabang from sc_hrd.pegawai b
												left outer join sc_hrd.transready a  on b.badgenumber=a.badgenumber
												left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and d.kdsubdept=b.kdsubdept and b.kddept=d.kddept
												left outer join sc_hrd.departement e on e.kddept=b.kddept			
												where checkdate between '$awal' and '$akhir' and 
												checktype<>'IN' and a.ipaddress='$branch' 
												group by a.ipaddress,b.nmlengkap,b.badgenumber,a.checktype,a.checkdate,d.deskripsi,b.kduangmkn,e.departement,b.kdcabang
												order by nmlengkap,checkdate ) as t1 
											left outer join sc_hrd.kantin tt on t1.kdcabang=tt.kd_cab
											--tambahan ijin----
											left outer join (select max(noijin) as noijin,nip,max(kdijin) as kdijin,tglijin,max(keterangan_ijin),nmlengkap,max(desc_kdatt),max(deskripsi),tgl,departement,badgenumber,ipaddress 
												from (select  a.kdijin||':'||to_char(a.tglijin,'yymm')||a.id as noijin,a.nip,a.kdijin,a.tglijin,a.keterangan_ijin,b.nmlengkap,c.desc_kdatt,d.deskripsi,to_char(tglijin,'dd-mm-yyyy') as tgl,e.departement,b.badgenumber,f.ipaddress
														from sc_hrd.ijin a
														left outer join sc_hrd.pegawai b on a.nip=b.nip
														left outer join sc_hrd.kodeatt c on c.kdatt=a.kdijin
														left outer join sc_hrd.jabatan d on d.kdjabatan=b.kdjabatan and b.kdsubdept=d.kdsubdept
														left outer join sc_hrd.departement e on e.kddept=b.kddept
														left outer join sc_hrd.user_finger f on b.badgenumber=f.id
														where ((a.kdijin='IK' and to_char(jamakhir,'HH24:MI:SS')>=
														case when to_char(a.tglijin, 'Dy')='Sat' then '13:00:00'
														else '16:00:00' end and to_char(jamawal,'HH24:MI:SS')>='08:00:00' ) or a.kdijin='PA' or kdijin='DT') and a.status<>'D' and a.status<>'C' 
														order by a.tglijin desc) as t10
												group by nip,tglijin,nmlengkap,tgl,departement,badgenumber,ipaddress) d on d.badgenumber=t1.badgenumber and d.tglijin=t1.checkdate
											
											--end tambahan ijin---
											group by t1.ipaddress,t1.nmlengkap,t1.badgenumber,t1.checkdate,t1.kduangmkn,t1.deskripsi,t1.departement,tt.besaran,noijin) as t2

											left outer join sc_hrd.uangmakan c on c.kdjabatan=t2.kduangmkn) as ttl
										order by nmlengkap,checkdate
										) as um		");

    }

    function insert_rencana_kunjungan($host, $dbname, $dbuser, $dbpass, $awal, $akhir) {
        $nik = $this->session->userdata('nik');

        $this->db->query("DELETE FROM sc_tmp.scheduletolocation WHERE scheduledate BETWEEN '$awal' AND '$akhir'");
        return $this->db->query("
            INSERT INTO sc_tmp.scheduletolocation
            SELECT *
            FROM dblink (
                'hostaddr=$host dbname=$dbname user=$dbuser password=$dbpass port=39170',
                'SELECT DISTINCT ON (branch, scheduleid, locationid, locationidlocal)
				s.branch, s.userid, u.nip AS nik, s.scheduleid, s.scheduledate, 
                COALESCE(NULLIF(sl.locationid, ''''), c.custcode, '''') AS locationid, 
                COALESCE(NULLIF(sl.locationidlocal, ''''), c.customercodelocal, '''') AS locationidlocal,
                c.custname, c.grdpaymt AS customertype, ''$nik''::TEXT AS createby, NOW() AS createdate
                FROM sc_trx.schedule s
                INNER JOIN sc_trx.scheduletolocation sl ON sl.scheduleid = s.scheduleid
                LEFT JOIN sc_mst.\"user\" u ON REGEXP_REPLACE(u.userid::TEXT, ''\s'', '''', ''g'') = REGEXP_REPLACE(s.userid::TEXT, ''\s'', '''', ''g'')
                LEFT JOIN sc_mst.customer c ON COALESCE(NULLIF(c.customercodelocal, ''''), c.custcode) = COALESCE(NULLIF(sl.locationidlocal, ''''), sl.locationid)
                WHERE COALESCE(NULLIF(sl.locationidlocal, ''''), sl.locationid) != '''' AND scheduledate BETWEEN ''$awal'' AND ''$akhir''
                ORDER BY branch, scheduleid, locationid, locationidlocal DESC, userid'
            ) AS t1 (
                branch CHARACTER VARYING, userid CHARACTER VARYING, nik CHARACTER(12), scheduleid CHARACTER VARYING, 
                scheduledate DATE, locationid CHARACTER VARYING, locationidlocal CHARACTER VARYING,
                custname CHARACTER VARYING(70), customertype CHARACTER(1),
                createby CHARACTER VARYING, createdate TIMESTAMP WITHOUT TIME ZONE
            );
        ");
    }

    function list_rencana_kunjungan($nik, $tgl) {
        $tgl = $tgl ?: date("Y-m-d");

        return $this->db->query("
            SELECT NULL AS no, locationid, locationidlocal, custname, customertype,
            CASE
                WHEN customertype = 'A' THEN 'KANTOR'
                WHEN customertype = 'B' THEN 'BANK'
                WHEN customertype = 'C' THEN 'CUSTOMER/TOKO'
                ELSE 'BELUM TERDEFINISI'
            END AS nmcustomertype
            FROM sc_tmp.scheduletolocation
            WHERE nik = '$nik' AND scheduledate = '$tgl'::DATE
            ORDER BY custname
        ");
    }

    function list_realisasi_kunjungan($nik, $tgl) {
        $tgl = $tgl ?: date("Y-m-d");

        return $this->db->query("
            with filter AS(
                SELECT
                '$nik'::varchar AS nik,
                '$tgl'::date AS schedule_date
            )
            SELECT
                a.customeroutletcode,
                a.customercodelocal,
                a.custname,
                a.customertype,
               CASE
                   WHEN customertype = 'A' THEN 'KANTOR'
                   WHEN customertype = 'B' THEN 'BANK'
                   WHEN customertype = 'C' THEN 'CUSTOMER/TOKO'
                   ELSE 'BELUM TERDEFINISI'
                END AS nmcustomertype,
                MIN(checktime::TIME) AS checkin,
                MAX(checktime::TIME) AS checkout,
                (SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode_schedule
                 FROM sc_tmp.scheduletolocation xa
                 WHERE xa.nik = (select nik from filter) AND xa.scheduledate = (select schedule_date from filter) AND (xa.locationidlocal = a.customercodelocal OR xa.locationid = a.customeroutletcode)
                 GROUP BY 1 LIMIT 1) schedule_location
            FROM sc_tmp.checkinout a
            WHERE a.checktime::DATE = (select schedule_date from filter) AND a.nik = (select nik from filter)
            GROUP BY 1, 2, 3, 4
            ORDER BY 6, 7
        ");
    }
    function list_realisasi_kunjungan_old($nik, $tgl) {
        $tgl = $tgl ?: date("Y-m-d");

        return $this->db->query("
            SELECT a.customeroutletcode, a.customercodelocal, a.custname, a.customertype,
            CASE
                WHEN customertype = 'A' THEN 'KANTOR'
                WHEN customertype = 'B' THEN 'BANK'
                WHEN customertype = 'C' THEN 'CUSTOMER/TOKO'
                ELSE 'BELUM TERDEFINISI'
            END AS nmcustomertype, MIN(checktime::TIME) AS checkin, MAX(checktime::TIME) AS checkout
            FROM sc_tmp.checkinout a
            WHERE a.checktime::DATE = '$tgl' AND a.nik = '$nik'
            GROUP BY 1, 2, 3, 4
            ORDER BY 6, 7
        ");
    }

    function list_realisasi_kunjungan_all($kdcabang, $awal, $akhir) {
        return $this->db->query("
            select
                *,
                CASE
                    WHEN ss.idcust = ss.schedule_location AND ss.customertype = 'C' THEN 'V'
                    ELSE 'X'
                END AS terhitung
            FROM (
                SELECT *,
                     (SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode_schedule
                      FROM sc_tmp.scheduletolocation xa
                      WHERE xa.nik = s.nik AND xa.scheduledate = s.tgl::date AND (xa.locationidlocal = idcust OR xa.locationid = idcust)
                      GROUP BY 1 LIMIT 1) schedule_location
                FROM(
                      SELECT ROW_NUMBER() OVER (ORDER BY c.nmlengkap, a.checktime::DATE, MIN(checktime::TIME),
                          MAX(checktime::TIME))                                                       AS no,
                             c.nik,
                             c.nmlengkap,
                             d.nmdept,
                             f.nmjabatan,
                             TO_CHAR(MAX(a.checktime), 'DD-MM-YYYY')                   AS tgl,
                             a.customeroutletcode,
                             a.customercodelocal,
                             a.custname,
                             a.customertype,
                             CASE
                                 WHEN customertype = 'A' THEN 'KANTOR'
                                 WHEN customertype = 'B' THEN 'BANK'
                                 WHEN customertype = 'C' THEN 'CUSTOMER/TOKO'
                                 ELSE 'BELUM TERDEFINISI'
                                 END                                                   AS nmcustomertype,
                             CASE
                                 WHEN customertype = 'C' THEN 'V'
                                 ELSE 'X' END                                          AS terhitung,
                             MIN(checktime::TIME)                                      AS checkin,
                             MAX(checktime::TIME)                                      AS checkout,
                             CONCAT(MIN(checktime::TIME), ' | ', MAX(checktime::TIME)) AS checktime,
                             COALESCE(NULLIF(a.customeroutletcode, ''), NULLIF(a.customercodelocal, '')) AS idcust
                      FROM sc_tmp.checkinout a
                               INNER JOIN sc_mst.karyawan c ON c.nik = a.nik AND c.callplan = 't'
                               LEFT JOIN sc_mst.departmen d ON d.kddept = c.bag_dept
                               LEFT JOIN sc_mst.subdepartmen e ON e.kddept = c.bag_dept AND e.kdsubdept = c.subbag_dept
                               LEFT JOIN sc_mst.jabatan f
                                         ON f.kddept = c.bag_dept AND f.kdjabatan = c.jabatan AND f.kdsubdept = c.subbag_dept
                      WHERE c.kdcabang = '$kdcabang'
                        AND a.checktime::DATE BETWEEN '$awal' AND '$akhir'
                      GROUP BY c.nik, d.nmdept, f.nmjabatan, a.checktime::DATE, a.customeroutletcode, a.customercodelocal,
                               a.custname, a.customertype
                      ORDER BY c.nmlengkap, a.checktime::DATE, checkin, checkout
                  ) s
            ) ss
        ");
    }
    function list_realisasi_kunjungan_all_old($kdcabang, $awal, $akhir) {
        return $this->db->query("
            SELECT ROW_NUMBER() OVER (ORDER BY c.nmlengkap, a.checktime::DATE, MIN(checktime::TIME), MAX(checktime::TIME)) AS no, 
            c.nik, c.nmlengkap, d.nmdept, f.nmjabatan, TO_CHAR(MAX(a.checktime), 'DD-MM-YYYY') AS tgl, a.customeroutletcode, a.customercodelocal, a.custname, a.customertype,
            CASE
                WHEN customertype = 'A' THEN 'KANTOR'
                WHEN customertype = 'B' THEN 'BANK'
                WHEN customertype = 'C' THEN 'CUSTOMER/TOKO'
                ELSE 'BELUM TERDEFINISI'
            END AS nmcustomertype, CASE 
                WHEN customertype = 'C' THEN 'V'
                ELSE 'X'
            END AS terhitung, MIN(checktime::TIME) AS checkin, MAX(checktime::TIME) AS checkout, CONCAT(MIN(checktime::TIME), ' | ', MAX(checktime::TIME)) AS checktime
            FROM sc_tmp.checkinout a
            INNER JOIN sc_mst.karyawan c ON c.nik = a.nik AND c.callplan = 't'
            LEFT JOIN sc_mst.departmen d ON d.kddept = c.bag_dept
            LEFT JOIN sc_mst.subdepartmen e ON e.kddept = c.bag_dept AND e.kdsubdept = c.subbag_dept
            LEFT JOIN sc_mst.jabatan f ON f.kddept = c.bag_dept AND f.kdjabatan = c.jabatan AND f.kdsubdept = c.subbag_dept
            WHERE c.kdcabang = '$kdcabang' AND a.checktime::DATE BETWEEN '$awal' AND '$akhir'
            GROUP BY c.nik, d.nmdept, f.nmjabatan, a.checktime::DATE, a.customeroutletcode, a.customercodelocal, a.custname, a.customertype
            ORDER BY c.nmlengkap, a.checktime::DATE, checkin, checkout
        ");
    }


}
