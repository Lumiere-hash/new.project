CREATE OR REPLACE FUNCTION sc_trx.pr_hanguscuti_nik_manual(vr_nik character, vr_tgl date)
    RETURNS SETOF void
    LANGUAGE plpgsql
AS $function$
    --author by : Fiky Ashariza 12-01-2019
    --update by : RKM 09/01/2024 => PENYESUAIAN CUTI ULANG TAHUN--
DECLARE vr_sisacuti integer;
    DECLARE vr_dokumen character(12);
    DECLARE vr_check_adjustment INT;
    DECLARE last_year_balance INT;
    DECLARE adjusment_balance INT;
    --DECLARE vr_out integer;
BEGIN
    vr_dokumen:='HGS'||to_char(vr_tgl,'yyyymm');
    vr_check_adjustment := COUNT(*) FROM sc_trx.cuti_blc WHERE nik = vr_nik AND no_dokumen = 'ADJ'|| TO_CHAR(vr_tgl, 'YYYY') AND doctype = 'IN';
    --vr_sisacuti:=sisacuti from sc_mst.karyawan where nik=nike;
    vr_sisacuti := coalesce(sisacuti, 0)
                   from sc_trx.cuti_blc a,
                        (select a.nik, a.tanggal, a.no_dokumen, max(a.doctype) as doctype
                         from sc_trx.cuti_blc a,
                              (select a.nik, a.tanggal, max(a.no_dokumen) as no_dokumen
                               from sc_trx.cuti_blc a,
                                    (select nik, max(tanggal) as tanggal
                                     from sc_trx.cuti_blc
                                     where nik = vr_nik
                                       and tanggal <= vr_tgl
                                     group by nik) as b
                               where a.nik = b.nik
                                 and a.tanggal = b.tanggal
                               group by a.nik, a.tanggal) b
                         where a.nik = b.nik
                           and a.tanggal = b.tanggal
                           and a.no_dokumen = b.no_dokumen
                         group by a.nik, a.tanggal, a.no_dokumen) b
                   where a.nik = b.nik
                     and a.tanggal = b.tanggal
                     and a.no_dokumen = b.no_dokumen
                     and a.doctype = b.doctype;
    adjusment_balance := coalesce(in_cuti, 0) as adjusment from sc_trx.cuti_blc where TRUE
                                                                                  AND nik = vr_nik
                                                                                  AND no_dokumen = 'ADJ2024';
    last_year_balance := coalesce(last_year_balanced, 0) - coalesce(out_balance, 0) as balance
                         from (select SUM(out_cuti) over (partition by nik) as out_balance,
                                      nik
                               from sc_trx.cuti_blc a
                               where TRUE
                                 AND nik = vr_nik
                                 and tanggal <= '2024-03-01'::date
                                 AND tanggal >= '2024-01-01'::date
                               ORDER BY tanggal DESC
                               LIMIt 1) aa
                                  left join lateral (
                             select coalesce(sisacuti, 0) - coalesce(in_cuti, 0) AS last_year_balanced,
                                    nik
                             from sc_trx.cuti_blc a
                             where TRUE
                               AND nik = vr_nik
                               AND no_dokumen = 'ADJ2024'
                             ORDER BY tanggal DESC
                             LIMIt 1
                             ) bb ON aa.nik = bb.nik;
    --hitung
    IF (vr_sisacuti>0) THEN --cek global jika tak mendapat cuti/cuti minus
        IF (to_char(vr_tgl,'YYYYMMDD') < to_char('2024-03-01'::date,'YYYYMMDD')) THEN
            insert into sc_trx.cuti_blc values(
                vr_nik,
                cast(to_char(vr_tgl,'yyyy-mm-dd 00:02:02')as timestamp),
                vr_dokumen,
                0,
                adjusment_balance,
                (select case when (adjusment_balance - last_year_balance) > 0 THEN adjusment_balance - last_year_balance ELSE 0 END AS balanced ),
                'HGS',
                'HANGUS ADJUSTMENT'
            );
        ELSE
            insert into sc_trx.cuti_blc values
                (vr_nik,cast(to_char(vr_tgl,'yyyy-mm-dd 00:02:02')as timestamp),vr_dokumen,0,vr_sisacuti,0,'HGS','HANGUS');
        end if;

    END IF;
    RETURN;
END;

$function$