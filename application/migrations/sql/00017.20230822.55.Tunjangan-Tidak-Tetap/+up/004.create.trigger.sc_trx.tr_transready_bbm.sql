
create OR REPLACE function sc_trx.tr_transready_bbm() returns trigger
    language plpgsql
as
$$
DECLARE
    -- Modified By Andika: 23/03/2023
    -- transready BBM
    vr_um_max01 TIME WITHOUT TIME ZONE;
    vr_um_max02 TIME WITHOUT TIME ZONE;
    vr_um_min01 TIME WITHOUT TIME ZONE;
    vr_um_min02 TIME WITHOUT TIME ZONE;
    vr_date_now DATE;
    vr_dok_lembur CHARACTER(25);
    vr_besaran numeric;
BEGIN
    DELETE FROM sc_trx.bbmtrx WHERE nik = new.nik AND tgl = new.tgl;
    vr_date_now := CAST(TO_CHAR(NOW(), 'YYYY-MM-DD') AS DATE);
    vr_besaran := (SELECT value3 as nominal from sc_mst.option where kdoption = 'UB');

    IF(TRIM(new.kdregu) = 'NC') THEN
        vr_um_max01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX01' AND group_option = 'NC'; --'13:00:00'
        vr_um_max02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX02' AND group_option = 'NC'; --'11:00:00'
        vr_um_min01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN01' AND group_option = 'NC'; --'07:55:00'
        vr_um_min02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN02' AND group_option = 'NC'; --'07:55:00'
    ELSE
        vr_um_max01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX01' AND group_option = 'DEFAULT'; --'13:00:00'
        vr_um_max02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMAX02' AND group_option = 'DEFAULT'; --'11:00:00'
        vr_um_min01 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN01' AND group_option = 'DEFAULT'; --'07:55:00'
        vr_um_min02 := value2 FROM sc_mst.option WHERE kdoption = 'HRUMMIN02' AND group_option = 'DEFAULT'; --'07:55:00'
    END IF;

    INSERT INTO sc_trx.bbmtrx (
        SELECT 'SBYNSA', ta.nik, ta.tgl, ta.checkin, ta.checkout,
               CASE
                   WHEN (CASE WHEN checkin < ta.jam_masuk THEN (SELECT abs(extract(epoch from ta.jam_masuk::timestamp - checkout::timestamp)/3600) > 4) ELSE (SELECT abs(extract(epoch from checkin::timestamp - checkout::timestamp)/3600) > 4) END) THEN vr_besaran
                   ELSE NULL
                   END AS nominal,
               CASE
                   WHEN checkin IS NULL AND checkout IS NULL AND td.nodok IS NULL AND tc.nodok IS NULL AND tf.tgl_libur IS NULL AND th.nodok IS NULL THEN 'TIDAK MASUK KANTOR'
                   WHEN checkin IS NULL AND checkout IS NULL AND td.nodok IS NULL  AND tf.tgl_libur IS NOT NULL AND th.nodok IS NULL THEN tf.ket_libur
                   WHEN td.nodok IS NOT NULL AND td.jenis_tujuan = 'LK' THEN 'DINAS LUAR KOTA DENGAN NO DINAS :' || td.nodok || '|| APP TGL: ' || TO_CHAR(td.approval_date, 'YYYY-MM-DD')
                   WHEN td.nodok IS NOT NULL AND td.jenis_tujuan = 'LP' THEN 'DINAS LUAR PULAU DENGAN NO DINAS :' || td.nodok || '|| APP TGL: ' || TO_CHAR(td.approval_date, 'YYYY-MM-DD')
                   WHEN td.nodok IS NOT NULL AND td.jenis_tujuan IS NULL THEN 'DINAS DENGAN NO DINAS :' || td.nodok || '|| APP TGL: ' || TO_CHAR(td.approval_date, 'YYYY-MM-DD')
                   WHEN th.nodok IS NOT NULL THEN 'CUTI DENGAN NO CUTI :' || th.nodok || '|| APP TGL: ' || TO_CHAR(th.approval_date, 'YYYY-MM-DD')
                   WHEN checkin < jam_masuk AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NULL THEN 'TEPAT WAKTU'
                   WHEN checkin < jam_masuk AND checkout > jam_pulang AND te.nodok IS NULL AND tf.tgl_libur IS NOT NULL THEN tf.ket_libur
                   WHEN checkin < jam_masuk AND checkout > jam_pulang AND te.nodok IS NOT NULL THEN 'TEPAT WAKTU + Lembur :' ||te.nodok
                   WHEN checkin >= jam_masuk AND checkout < jam_pulang AND (tk.kdijin_absensi IS NULL AND ti.kdijin_absensi IS NULL AND td.nodok IS NULL) THEN 'TELAT MASUK/PULANG AWAL'
                   WHEN checkin >= jam_masuk AND checkout > jam_pulang AND (tk.kdijin_absensi IS NULL AND tc.kdijin_absensi IS NULL AND td.nodok IS NULL) AND te.nodok IS NULL THEN 'TELAT MASUK'
                   WHEN (checkin < jam_masuk OR checkin >= jam_masuk) AND (checkout > jam_pulang OR checkout <= jam_pulang) AND tc.kdijin_absensi IS NOT NULL AND (tc.tgl_jam_mulai = jam_masuk AND tc.tgl_jam_selesai >= jam_pulang) THEN 'IJIN KELUAR DINAS NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                   WHEN checkin >= jam_masuk AND checkout > jam_pulang AND tk.kdijin_absensi IS NOT NULL AND te.nodok IS NULL THEN 'IJIN DT DINAS NO :' || tk.nodok || '|| APP TGL: ' || TO_CHAR(tk.approval_date, 'YYYY-MM-DD')
                   WHEN checkin >= jam_masuk AND checkout < jam_pulang AND tk.kdijin_absensi IS NOT NULL AND ti.kdijin_absensi IS NOT NULL THEN 'IJIN DT DINAS NO :' || tk.nodok || ' DAN IJIN PA NO :' || ti.nodok || ''
                   WHEN checkin >= jam_masuk AND checkout > jam_pulang AND (tc.kdijin_absensi IS NULL OR tk.kdijin_absensi IS NULL) AND te.nodok IS NOT NULL THEN 'TELAT MASUK + Lembur :' || te.nodok || '|| APP TGL: ' || TO_CHAR(te.approval_date, 'YYYY-MM-DD')
                   WHEN checkin >= jam_masuk AND checkout > jam_pulang AND tc.kdijin_absensi IS NOT NULL THEN 'IJIN KELUAR DINAS NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                   WHEN checkin IS NULL AND checkout IS NULL AND tc.kdijin_absensi IS NOT NULL THEN 'IJIN KELUAR DINAS NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                   WHEN checkin IS NULL AND checkout > jam_pulang AND (tk.kdijin_absensi IS NULL) THEN 'TIDAK CEKLOG MASUK'
                   WHEN checkin IS NULL AND checkout > jam_pulang AND (tk.kdijin_absensi IS NOT NULL) THEN 'IJIN DT DINAS DGN NO :' || tk.nodok || '|| APP TGL: ' || TO_CHAR(tk.approval_date, 'YYYY-MM-DD')
                   WHEN checkin < jam_masuk AND checkout IS NULL AND tc.kdijin_absensi IS NULL THEN 'TIDAK CEKLOG PULANG'
                   WHEN checkin < jam_masuk AND checkout < jam_pulang AND (ti.kdijin_absensi IS NULL AND (tj.kdijin_absensi IS NULL AND tg.kdijin_absensi IS NULL)) THEN 'PULANG AWAL'
                   WHEN checkin < jam_masuk AND checkout < jam_pulang AND (tc.kdijin_absensi IS NULL OR ti.kdijin_absensi IS NULL) THEN 'PULANG AWAL'
                   WHEN checkin < jam_masuk AND checkout < jam_pulang AND tg.tgl_jam_selesai < jam_pulang AND tg.kdijin_absensi IS NOT NULL AND tc.kdijin_absensi IS NULL THEN 'PULANG AWAL'
                   WHEN checkin < jam_masuk AND checkout >= jam_pulang AND tg.tgl_jam_selesai < jam_pulang AND tg.kdijin_absensi IS NOT NULL AND tc.kdijin_absensi IS NULL THEN 'IJIN KELUAR PRIBADI NO :' || tg.nodok || '|| APP TGL: ' || TO_CHAR(tg.approval_date, 'YYYY-MM-DD')
                   WHEN checkin < jam_masuk AND checkout < jam_pulang AND tc.tgl_jam_selesai >= jam_pulang AND tc.kdijin_absensi IS NOT NULL THEN 'IJIN KELUAR DINAS NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                   WHEN checkin < jam_masuk AND checkout < jam_pulang AND tc.tgl_jam_selesai >= jam_pulang AND ti.kdijin_absensi IS NOT NULL THEN 'IJIN PA NO :' || ti.nodok || '|| APP TGL: ' || TO_CHAR(ti.approval_date, 'YYYY-MM-DD')
                   WHEN checkin < jam_masuk AND checkout < jam_pulang AND (tg.kdijin_absensi IS NOT NULL AND ti.kdijin_absensi IS NOT NULL) THEN 'IJIN PA PRIBADI NO :' || tg.nodok || '|| APP TGL: ' || TO_CHAR(tg.approval_date, 'YYYY-MM-DD')
                   WHEN checkin < jam_masuk AND checkout < jam_pulang AND (ti.kdijin_absensi IS NOT NULL AND tj.kdijin_absensi IS NOT NULL) THEN 'IJIN PA DINAS NO :' || tj.nodok || '|| APP TGL: ' || TO_CHAR(tj.approval_date, 'YYYY-MM-DD')
                   WHEN checkin < jam_masuk AND checkout > jam_pulang AND tc.kdijin_absensi = 'IK' THEN 'IJIN KELUAR DINAS NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                   WHEN checkin >= jam_masuk AND (checkout IS NULL OR checkout < jam_pulang) AND tc.kdijin_absensi = 'IK' THEN 'TELAT DATANG + IJIN KELUAR DINAS NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                   WHEN checkin >= jam_masuk AND (checkout IS NULL OR checkout > jam_pulang) AND tc.kdijin_absensi = 'IK' THEN 'TELAT DATANG + IJIN KELUAR DINAS NO :' || tc.nodok || '|| APP TGL: ' || TO_CHAR(tc.approval_date, 'YYYY-MM-DD')
                   WHEN checkin < jam_masuk AND (checkout IS NOT NULL AND checkout < jam_pulang) AND ti.kdijin_absensi = 'PA' THEN 'IJIN PA NO :' || ti.nodok || '|| APP TGL: ' || TO_CHAR(ti.approval_date, 'YYYY-MM-DD')
                   END AS keterangan, vr_date_now AS tgl_dok, CASE WHEN tc.nodok IS NOT NULL THEN tc.nodok ELSE td.nodok END AS nodok
        FROM (
                 SELECT 'SBYNSA' AS branch, a.nik, b.nmlengkap, c.kddept, c.nmdept, e.kdjabatan, e.nmjabatan, e.bbm, a.tgl,
                        CASE
                            WHEN a.jam_masuk_absen = a.jam_pulang_absen AND a.jam_masuk_absen > vr_um_max01 THEN NULL
                            ELSE a.jam_masuk_absen END AS checkin,
                        CASE
                            WHEN a.jam_masuk_absen = a.jam_pulang_absen AND a.jam_pulang_absen <= vr_um_max01 THEN NULL
                            ELSE a.jam_pulang_absen END AS checkout,
                     NULL AS nominal,
                     '' AS keterangan,
                     b.kdcabang,
                     b.lvl_jabatan,
                     a.jam_masuk,
                     a.jam_pulang,
                     f.besaran AS kantin
                 FROM sc_trx.transready a
                          LEFT OUTER JOIN sc_mst.karyawan b ON a.nik = b.nik
                          LEFT OUTER JOIN sc_mst.departmen c ON b.bag_dept = c.kddept
                          LEFT OUTER JOIN sc_mst.subdepartmen d ON b.subbag_dept = d.kdsubdept AND b.bag_dept = d.kddept
                          LEFT OUTER JOIN sc_mst.jabatan e ON b.jabatan = e.kdjabatan AND b.subbag_dept = e.kdsubdept AND b.bag_dept = e.kddept
                          LEFT OUTER JOIN sc_mst.kantin f ON b.kdcabang = f.kdcabang
             ) AS ta
                 --LEFT OUTER JOIN sc_mst.bbmmst tb ON tb.kdlvl = ta.lvl_jabatan
                 LEFT OUTER JOIN (select a.* from sc_trx.ijin_karyawan a
                                                      left outer join sc_trx.dtljadwalkerja b on a.nik=b.nik and a.tgl_kerja=b.tgl
                                                      left outer join sc_mst.jam_kerja c on b.kdjamkerja=c.kdjam_kerja
                                  where a.kdijin_absensi='IK' and a.type_ijin='DN' and status='P'
        ) as tc ON tc.nik = ta.nik AND tc.tgl_kerja = ta.tgl
                 LEFT OUTER JOIN (select a.* from sc_trx.ijin_karyawan a
                                                      left outer join sc_trx.dtljadwalkerja b on a.nik=b.nik and a.tgl_kerja=b.tgl
                                                      left outer join sc_mst.jam_kerja c on b.kdjamkerja=c.kdjam_kerja
                                  where a.kdijin_absensi='PA' and status='P' and a.tgl_jam_selesai < c.jam_pulang
        ) as ti ON ti.nik = ta.nik AND ti.tgl_kerja = ta.tgl
                 LEFT OUTER JOIN (select a.* from sc_trx.ijin_karyawan a
                                                      left outer join sc_trx.dtljadwalkerja b on a.nik=b.nik and a.tgl_kerja=b.tgl
                                                      left outer join sc_mst.jam_kerja c on b.kdjamkerja=c.kdjam_kerja
                                  where a.kdijin_absensi='DT' and a.type_ijin='DN' and status='P' and a.tgl_jam_mulai>=c.jam_masuk
        ) as tk ON tk.nik = ta.nik AND tk.tgl_kerja = ta.tgl
                 LEFT OUTER JOIN sc_trx.dinas td ON td.nik = ta.nik AND (ta.tgl BETWEEN td.tgl_mulai AND td.tgl_selesai) AND td.status = 'P'
            --AND td.jenis_tujuan in ('LK','LP')
                 LEFT OUTER JOIN sc_trx.lembur te ON te.nik = ta.nik AND te.tgl_kerja = ta.tgl AND TO_CHAR(ta.checkout, 'HH24:MI:SS') >= '18:00:00' AND TO_CHAR(te.tgl_jam_selesai, 'HH24:MI:SS') >= '18:00:00' AND (te.status = 'P' OR te.status = 'F') AND te.kdlembur = 'BIASA' AND TO_CHAR(te.tgl_jam_mulai, 'HH24:MI:SS') >= '13:00:00' /*LEMBUR BIASA*/
                 LEFT OUTER JOIN sc_mst.libur tf ON tf.tgl_libur = ta.tgl
                 LEFT OUTER JOIN sc_trx.ijin_karyawan tg ON tg.nik = ta.nik AND tg.tgl_kerja = ta.tgl AND tg.status = 'P' AND tg.type_ijin = 'PB'
                 LEFT OUTER JOIN sc_trx.ijin_karyawan tj ON tj.nik = ta.nik AND tj.tgl_kerja = ta.tgl AND tj.status = 'P' AND tj.type_ijin = 'DN'
                 LEFT OUTER JOIN sc_trx.cuti_karyawan th ON th.nik = ta.nik AND (ta.tgl BETWEEN th.tgl_mulai AND th.tgl_selesai) AND th.status = 'P'
        WHERE ta.lvl_jabatan <> 'A' AND ta.nik = new.nik AND ta.tgl = new.tgl AND ta.bbm = 'T'
        GROUP BY ta.nik, ta.nmlengkap, ta.tgl, ta.checkin, ta.checkout, ta.kdcabang, ta.jam_masuk, ta.jam_pulang, ta.lvl_jabatan, ta.kantin, tc.kdijin_absensi,
                 tg.kdijin_absensi, tg.nodok, tg.tgl_jam_selesai, tg.type_ijin, tc.tgl_kerja, td.nodok, td.approval_date, tc.nodok, tc.approval_date, te.nodok, tf.tgl_libur,
                 tg.kdijin_absensi, tg.nodok, tg.tgl_jam_selesai, tg.type_ijin, tc.tgl_kerja, td.nodok, td.approval_date, tc.nodok, tc.approval_date, te.nodok, tf.tgl_libur,
                 tf.ket_libur, th.nodok, th.approval_date, ti.kdijin_absensi, ti.nodok, ti.tgl_jam_selesai, ti.approval_date, tk.kdijin_absensi, tk.nodok, tk.approval_date,
                 tg.approval_date, te.approval_date, tc.tgl_jam_selesai, tj.kdijin_absensi, tj.nodok, tj.approval_date, tc.tgl_jam_mulai, ta.kdjabatan, td.jenis_tujuan
        ORDER BY nmlengkap
    );

    RETURN new;
END;
$$;
DROP TRIGGER IF EXISTS tr_transready_bbm ON sc_trx.transready;
create trigger tr_transready_bbm
    after insert
    on sc_trx.transready
    for each row
execute procedure sc_trx.tr_transready_bbm();