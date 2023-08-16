create function pr_ijin_karyawan_after_update() returns trigger
    language plpgsql
as
$$
declare
     
     vr_kdijin char(30);
     --vr_nomor char(30);
     --vr_status char(10);
     /* penambahan notification 2020*/
begin

--select old.status;
if (new.status='P')and(old.status='A') then 

--select * from sc_trx.ijin_karyawan
--select * from sc_mst.ijin_absensi
	/*---SELF SMS----*/

	insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
	select b.nohp1,			
	'Sdr/i '||b.nmlengkap||' Ijin '||c.nmijin_absensi||' | '||case when a.type_ijin='DN' then 'DINAS |' when a.type_ijin='PB' then 'PRIBADI |' else a.type_ijin end||' no. '||a.nodok||' Telah Di Setujui,Tgl: '||to_char(tgl_kerja,'dd-mm-yyyy')
	,nmlengkap
	from sc_trx.ijin_karyawan a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.ijin_absensi c on a.kdijin_absensi=c.kdijin_absensi
	where a.nodok=new.nodok and b.nohp1 is not null;
	
	/*---SMS KE HRD----*/	
	insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
	select telepon,isi,creator from (
	select telepon,'Ijin :'||nmijin_absensi||'|'||case when type_ijin='DN' then 'DINAS |' when type_ijin='PB' then 'PRIBADI |' else type_ijin end||' No : '||coalesce(trim(nodok),'')||' '||coalesce(trim(nmlengkap),'')||' tgl: '||to_char(tgl_kerja,'dd-mm-yyyy')||' Telah Di setujui' as isi,'OSIN' as creator  from
	(select t0.*,trim(t3.nohp1) as telepon,t1.nodok,t1.nik,t1.nmlengkap,t1.tgl_kerja,t1.tgl_jam_mulai,t1.tgl_jam_selesai,t1.nik as nik,t1.nmijin_absensi,t1.type_ijin from sc_mst.notif_sms t0
	left outer join (select	case b.kdcabang	when 'SBYMRG' then 'Y'	end as kanwil_sby,
				case b.kdcabang	when 'SMGDMK' then 'Y'	end as kanwil_dmk,
				case b.kdcabang	when 'SMGCND' then 'Y'	end as kanwil_smg,
				case b.kdcabang	when 'JKTKPK' then 'Y'	end as kanwil_jkt,
				a.*,b.nmlengkap,c.nmijin_absensi from sc_trx.ijin_karyawan a
			left outer join sc_mst.karyawan b on a.nik=b.nik
			left outer join sc_mst.ijin_absensi c on a.kdijin_absensi=c.kdijin_absensi
			where nodok=new.nodok 
			) as t1
			on t0.kanwil_sby=t1.kanwil_sby or
			t0.kanwil_smg=t1.kanwil_smg or
			t0.kanwil_dmk=t1.kanwil_dmk or
			t0.kanwil_jkt=t1.kanwil_jkt
	left outer join sc_mst.karyawan t3 on t0.nik=t3.nik		
	where ijin='Y') as t2 ) as t3
	where telepon is not null and isi is not null and creator is not null;
	/*
	select telepon,'Ijin :'||nmijin_absensi||'|'||case when type_ijin='DN' then 'DINAS |' when type_ijin='PB' then 'PRIBADI |' else type_ijin end||' No : '||coalesce(trim(nodok),'')||' '||coalesce(trim(nmlengkap),'')||' tgl: '||to_char(tgl_kerja,'dd-mm-yyyy')||' Telah Di setujui','OSIN'  from
	(select t0.*,trim(t3.nohp1) as telepon,t1.nodok,t1.nik,t1.nmlengkap,t1.tgl_kerja,t1.tgl_jam_mulai,t1.tgl_jam_selesai,t1.nik as nik,t1.nmijin_absensi,t1.type_ijin from sc_mst.notif_sms t0
	left outer join (select	case b.kdcabang	when 'SBYMRG' then 'Y'	end as kanwil_sby,
				case b.kdcabang	when 'SMGDMK' then 'Y'	end as kanwil_dmk,
				case b.kdcabang	when 'SMGCND' then 'Y'	end as kanwil_smg,
				case b.kdcabang	when 'JKTKPK' then 'Y'	end as kanwil_jkt,
				a.*,b.nmlengkap,c.nmijin_absensi from sc_trx.ijin_karyawan a
			left outer join sc_mst.karyawan b on a.nik=b.nik
			left outer join sc_mst.ijin_absensi c on a.kdijin_absensi=c.kdijin_absensi
			where nodok=new.nodok 
			) as t1
			on t0.kanwil_sby=t1.kanwil_sby or
			t0.kanwil_smg=t1.kanwil_smg or
			t0.kanwil_dmk=t1.kanwil_dmk or
			t0.kanwil_jkt=t1.kanwil_jkt
	left outer join sc_mst.karyawan t3 on t0.nik=t3.nik		
	where ijin='Y') as t2
	where telepon is not null and nodok is not null; */

	/* SMS KE ATASAN 1&2 */
	insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
	select telepon,textdecoded,nmlengkap from 
	(select c.nohp1 as telepon,			
	'Sdr/i '||a.nmlengkap||' Ijin no. '||b.nodok||' Di Setujui,TGL :'||to_char(b.tgl_kerja,'dd-mm-yyyy') as textdecoded
	,a.nmlengkap,a.nik,b.nodok
	from sc_mst.karyawan a  
	left outer join  sc_trx.ijin_karyawan b on b.nik=a.nik
	left outer join  sc_mst.karyawan c on a.nik_atasan=c.nik
	left outer join  sc_mst.karyawan d on a.nik_atasan2=d.nik where b.nodok is not null
	union all
	select d.nohp1 as telepon,			
	'Sdr/i '||a.nmlengkap||' Ijin no. '||b.nodok||' Di Setujui,TGL :'||to_char(b.tgl_kerja,'dd-mm-yyyy') as textdecoded
	,a.nmlengkap,a.nik,b.nodok
	from sc_mst.karyawan a  
	left outer join  sc_trx.ijin_karyawan b on b.nik=a.nik
	left outer join  sc_mst.karyawan c on a.nik_atasan=c.nik
	left outer join  sc_mst.karyawan d on a.nik_atasan2=d.nik where b.nodok is not null) as x
	where nik=new.nik and nodok=new.nodok and telepon is not null and textdecoded is not null and nmlengkap is not null;

	update sc_trx.approvals_system set status='U',asstatus='P' where docno = new.nodok and status!='U';
	
elseif (new.status='C')and(old.status='P') then 
		/*---SELF SMS----*/
	insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
	select b.nohp1,			
	'Sdr/i '||b.nmlengkap||' Ijin '||c.nmijin_absensi||' | '||case when a.type_ijin='DN' then 'DINAS |' when a.type_ijin='PB' then 'PRIBADI |' else a.type_ijin end||' no. '||a.nodok||' Dibatalkan,Tgl: '||to_char(tgl_kerja,'dd-mm-yyyy')
	,nmlengkap
	from sc_trx.ijin_karyawan a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.ijin_absensi c on a.kdijin_absensi=c.kdijin_absensi
	where a.nodok=new.nodok and b.nohp1 is not null;
	
	/*---SMS KE HRD----*/	
	insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
	select telepon,isi,creator from (
	select telepon,'Ijin :'||nmijin_absensi||'|'||case when type_ijin='DN' then 'DINAS |' when type_ijin='PB' then 'PRIBADI |' else type_ijin end||' No : '||nodok||' '||nmlengkap||' tgl: '||to_char(tgl_kerja,'dd-mm-yyyy')||' Telah Di Batalkan' as isi,'OSIN' as creator from
	(select t0.*,trim(t3.nohp1) as telepon,t1.nodok,t1.nik,t1.nmlengkap,t1.tgl_kerja,t1.tgl_jam_mulai,t1.tgl_jam_selesai,t1.nik as nik,t1.nmijin_absensi,t1.type_ijin from sc_mst.notif_sms t0
	left outer join (select	case b.kdcabang	when 'SBYMRG' then 'Y'	end as kanwil_sby,
				case b.kdcabang	when 'SMGDMK' then 'Y'	end as kanwil_dmk,
				case b.kdcabang	when 'SMGCND' then 'Y'	end as kanwil_smg,
				case b.kdcabang	when 'JKTKPK' then 'Y'	end as kanwil_jkt,
				a.*,b.nmlengkap,c.nmijin_absensi from sc_trx.ijin_karyawan a
			left outer join sc_mst.karyawan b on a.nik=b.nik
			left outer join sc_mst.ijin_absensi c on a.kdijin_absensi=c.kdijin_absensi
			where nodok=new.nodok 
			) as t1
			on t0.kanwil_sby=t1.kanwil_sby or
			t0.kanwil_smg=t1.kanwil_smg or
			t0.kanwil_dmk=t1.kanwil_dmk or
			t0.kanwil_jkt=t1.kanwil_jkt
	left outer join sc_mst.karyawan t3 on t0.nik=t3.nik		
	where ijin='Y') as t2) as t3
	where telepon is not null and isi is not null and creator is not null;

	/* SMS KE ATASAN 1&2 */
	insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
	select telepon,textdecoded,nmlengkap from 
	(select c.nohp1 as telepon,			
	'Sdr/i '||a.nmlengkap||' Ijin no. '||b.nodok||' Di Batalkan,TGL :'||to_char(b.tgl_kerja,'dd-mm-yyyy') as textdecoded
	,a.nmlengkap,a.nik,b.nodok
	from sc_mst.karyawan a  
	left outer join  sc_trx.ijin_karyawan b on b.nik=a.nik
	left outer join  sc_mst.karyawan c on a.nik_atasan=c.nik
	left outer join  sc_mst.karyawan d on a.nik_atasan2=d.nik where b.nodok is not null
	union all
	select d.nohp1 as telepon,			
	'Sdr/i '||a.nmlengkap||' Ijin no. '||b.nodok||' Di Batalkan,TGL :'||to_char(b.tgl_kerja,'dd-mm-yyyy') as textdecoded
	,a.nmlengkap,a.nik,b.nodok
	from sc_mst.karyawan a  
	left outer join  sc_trx.ijin_karyawan b on b.nik=a.nik
	left outer join  sc_mst.karyawan c on a.nik_atasan=c.nik
	left outer join  sc_mst.karyawan d on a.nik_atasan2=d.nik where b.nodok is not null) as x
	where nik=new.nik and nodok=new.nodok and telepon is not null and textdecoded is not null and nmlengkap is not null;

	update sc_trx.approvals_system set status='C',asstatus='C' where docno = new.nodok and status!='C';
elseif ((new.status='C')and(old.status='A')) then
		/*---SELF SMS----*/
	insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
	select b.nohp1,			
	'Sdr/i '||b.nmlengkap||' Ijin '||c.nmijin_absensi||' | '||case when a.type_ijin='DN' then 'DINAS |' when a.type_ijin='PB' then 'PRIBADI |' else a.type_ijin end||' no. '||a.nodok||' Ditolak/Dibatalkan,Tgl: '||to_char(tgl_kerja,'dd-mm-yyyy')
	,nmlengkap
	from sc_trx.ijin_karyawan a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.ijin_absensi c on a.kdijin_absensi=c.kdijin_absensi
	where a.nodok=new.nodok and b.nohp1 is not null;

	update sc_trx.approvals_system set status='C',asstatus='C' where docno = new.nodok and status!='C';
	
/* RESEND SMS */
elseif ((new.status='M') and (old.status='A')) then
vr_kdijin:=trim(kdijin_absensi) from sc_trx.ijin_karyawan where nodok=new.nodok;
	--select * from sc_trx.ijin_karyawan

	--ijin pulang awal
	if (vr_kdijin='PA') then
        insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
        select telepon,left(sms,160),pengirim from 
        (select c.nohp1 as telepon,
'No. Ijin PULANG: '||case when a.type_ijin='DN' then 'DINAS ' when a.type_ijin='PB' then 'PRIBADI ' else a.type_ijin end||'
'||case when a.nodok is null then '' else a.nodok end||'
Nama: '||b.nmlengkap||'
Tgl: '||case when to_char(tgl_kerja,'dd-mm-yyyy') is null then '' else to_char(tgl_kerja,'dd-mm-yyyy') end||'
Jam: '||case when to_char(tgl_jam_selesai,'HH24:MI') is null then '' else to_char(tgl_jam_selesai,'HH24:MI:SS') end||'
Conf: Y/N
Ket: '||keterangan as sms,
	'OSIN' as pengirim
	from sc_trx.ijin_karyawan a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	where nodok=new.nodok and c.nohp1 is not null
	) as t1;
	end if;

	--ijin datang Terlambat
	if (vr_kdijin='DT') then
        insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
        select telepon,left(sms,160),pengirim from 
        (select c.nohp1 as telepon,
'No. Ijin TERLAMBAT: '||case when a.type_ijin='DN' then 'DINAS ' when a.type_ijin='PB' then 'PRIBADI ' else a.type_ijin end||'
'||case when a.nodok is null then '' else a.nodok end||'
Nama: '||b.nmlengkap||'
Tgl: '||case when to_char(tgl_kerja,'dd-mm-yyyy') is null then '' else to_char(tgl_kerja,'dd-mm-yyyy') end||'
Jam: '||case when to_char(tgl_jam_mulai,'HH24:MI') is null then '' else to_char(tgl_jam_mulai,'HH24:MI') end||'
Conf: Y/N
Ket: '||keterangan as sms,
	'OSIN' as pengirim
	from sc_trx.ijin_karyawan a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	where nodok=new.nodok and c.nohp1 is not null
	) as t1;
	end if;

	--ijin Surat Keterangan Dokter
	if (vr_kdijin='KD') then
        insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
        select telepon,left(sms,160),pengirim from 
        (select c.nohp1 as telepon,
'No. Ijin SAKIT: '||case when a.nodok is null then '' else a.nodok end||'
Nama: '||b.nmlengkap||'
Tgl: '||case when to_char(tgl_kerja,'dd-mm-yyyy') is null then '' else to_char(tgl_kerja,'dd-mm-yyyy') end||'
Conf: Y/N
Ket: '||keterangan as sms,
	'OSIN' as pengirim
	from sc_trx.ijin_karyawan a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	where nodok=new.nodok and c.nohp1 is not null
	) as t1;
	end if;
	
	--ijin keluar
	if (vr_kdijin='IK') then
        insert into outbox ("DestinationNumber","TextDecoded","CreatorID")
        select telepon,left(sms,160),pengirim from 
        (select c.nohp1 as telepon,
'No. Ijin KELUAR: '||case when a.type_ijin='DN' then 'DINAS ' when a.type_ijin='PB' then 'PRIBADI ' else a.type_ijin end||'
'||case when a.nodok is null then '' else a.nodok end||'
Nama: '||b.nmlengkap||'
Tgl: '||case when to_char(tgl_kerja,'dd-mm-yyyy') is null then '' else to_char(tgl_kerja,'dd-mm-yyyy') end||'
Jam: '||case when to_char(tgl_jam_mulai,'HH24:MI') is null then '' else to_char(tgl_jam_mulai,'HH24:MI') end||'
s/d '||case when to_char(tgl_jam_selesai,'HH24:MI') is null then '' else to_char(tgl_jam_selesai,'HH24:MI') end||'
Conf: Y/N
Ket: '||keterangan as sms,
	'OSIN' as pengirim
	from sc_trx.ijin_karyawan a
	left outer join sc_mst.karyawan b on a.nik=b.nik
	left outer join sc_mst.karyawan c on c.nik=b.nik_atasan
	where nodok=new.nodok and c.nohp1 is not null
	) as t1;
	end if;	

	update sc_trx.ijin_karyawan set status=old.status where nodok=new.nodok;

elseif (new.status='A' and old.status='I') then

	delete from sc_mst.trxerror where modul='IJIN' and userid=new.input_by;
	insert into sc_mst.trxerror
	(userid,errorcode,nomorakhir1,nomorakhir2,modul) VALUES
	(new.input_by,0,new.nodok,'','IJIN');

-- perform sc_trx.pr_capture_approvals_system();
--select * from sc_trx.ijin_karyawan;
--select * from sc_mst.trxerror
end if;
return new;

end;
$$;

alter function pr_ijin_karyawan_after_update() owner to postgres;

