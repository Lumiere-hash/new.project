create function pr_ijin_karyawan_after_insert() returns trigger
    language plpgsql
as
$$
declare
vr_kdijin character(25);

begin

update sc_trx.ijin_karyawan set status='A' where new.status='I' and nodok=new.nodok;
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

return new;

end;
$$;

alter function pr_ijin_karyawan_after_insert() owner to postgres;

