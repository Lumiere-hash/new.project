CREATE OR REPLACE FUNCTION sc_trx.pr_hanguscuti_nik_manual(vr_nik character, vr_tgl date)
        RETURNS SETOF void
        LANGUAGE plpgsql
    AS $function$
        --author by : Fiky Ashariza 12-01-2019
        --update by : RKM 09/01/2024 => PENYESUAIAN CUTI ULANG TAHUN--
    DECLARE vr_sisacuti integer;
    DECLARE vr_dokumen character(12);
    --DECLARE vr_out integer;
    BEGIN
        vr_dokumen:='HGS'||to_char(vr_tgl,'yyyymm');
        --vr_sisacuti:=sisacuti from sc_mst.karyawan where nik=nike;
        vr_sisacuti:=coalesce(sisacuti,0) from sc_trx.cuti_blc a,
                                               (select a.nik,a.tanggal,a.no_dokumen,max(a.doctype) as doctype from sc_trx.cuti_blc a,
                                                                                                                   (select a.nik,a.tanggal,max(a.no_dokumen) as no_dokumen from sc_trx.cuti_blc a,
                                                                                                                                                                                (select nik,max(tanggal) as tanggal from sc_trx.cuti_blc where nik=vr_nik and tanggal<=vr_tgl
                                                                                                                                                                                 group by nik) as b
                                                                                                                    where a.nik=b.nik and a.tanggal=b.tanggal
                                                                                                                    group by a.nik,a.tanggal) b
                                                where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen
                                                group by a.nik,a.tanggal,a.no_dokumen) b
                     where a.nik=b.nik and a.tanggal=b.tanggal and a.no_dokumen=b.no_dokumen and a.doctype=b.doctype;

        IF (vr_sisacuti>0) THEN --cek global jika tak mendapat cuti/cuti minus
            insert into sc_trx.cuti_blc values
                (vr_nik,cast(to_char(vr_tgl,'yyyy-mm-dd 00:02:02')as timestamp),vr_dokumen,0,vr_sisacuti,0,'HGS','HANGUS');
       END IF;
        RETURN;
    END;

    $function$