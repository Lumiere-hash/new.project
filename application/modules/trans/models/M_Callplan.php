<?php

class M_Callplan extends CI_Model
{
    function check($nik,$date){
        return $this->db->query("
            with filter AS (
                select
                    '$date'::date AS fdate,
                    '$nik'::varchar AS fnik
            )
            select
                COALESCE(TRIM(a.nik),'') AS nik,
                TRIM(a.callplan) = 't' AS is_callplan,
                (select fdate from filter) AS date,
                b.schedule,
                c.realization,
                CASE
                    WHEN COALESCE(c.realization,0) >= COALESCE(b.schedule,0) THEN 1
                    ELSE 0
                END AS achieved
            from sc_mst.karyawan a
            LEFT JOIN LATERAL (
                SELECT count(*) AS schedule
                FROM sc_tmp.scheduletolocation xa
                WHERE xa.nik = a.nik AND xa.scheduledate = (select fdate from filter)
                ) b ON TRUE
            LEFT JOIN LATERAL (
                SELECT COUNT(x.custcode) AS realization
                FROM (
                         SELECT COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) AS custcode
                         FROM sc_tmp.checkinout xa
                         WHERE xa.checktime::DATE = (select fdate from filter)
                           AND xa.nik = a.nik
                           AND xa.customertype = 'C'
                           AND COALESCE(NULLIF(xa.customeroutletcode, ''), NULLIF(xa.customercodelocal, '')) IN (
                             SELECT COALESCE(NULLIF(xa.locationid, ''), NULLIF(xa.locationidlocal, '')) AS custcode
                             FROM sc_tmp.scheduletolocation xa
                             WHERE xa.nik = a.nik AND xa.scheduledate = (select fdate from filter)
                             GROUP BY 1
                         )
                         GROUP BY 1
                     ) x
                )c ON TRUE
            WHERE TRUE
            AND a.nik = (select fnik from filter)
        ");
    }
}