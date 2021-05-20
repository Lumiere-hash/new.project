<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:18 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 08:23:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:24:21 --> 404 Page Not Found --> 
ERROR - 19-05-2021 13:37:36 --> Query error: ERROR:  tabel « group_penggajian » tidak ada - Invalid query: drop table sc_im.group_penggajian;
							select * into sc_im.group_penggajian from sc_mst.group_penggajian;
							copy  sc_im.group_penggajian to 'D:\NusaApp\apache2\htdocs\hrms.nusa\assets\export_directory\group_penggajian.CSV' using delimiters ';' csv header;
							
ERROR - 19-05-2021 14:30:49 --> Query error: ERROR:  kolom referensi « kode » ambigu (memiliki dua makna)
LINE 17:         kode        = kode            
                               ^
QUERY:  update sc_mst.detail_formula a set 
        kdrumus     = b.kdrumus     , 
        no_urut     = b.no_urut     , 
        tipe        = b.tipe        , 
        keterangan  = b.keterangan  , 
        input_date  = b.input_date  , 
        input_by    = b.input_by    , 
        update_date = b.update_date , 
        update_by   = b.update_by   , 
        aksi_tipe   = b.aksi_tipe   , 
        aksi        = b.aksi        , 
        taxable     = b.taxable     , 
        tetap       = b.tetap       , 
        deductible  = b.deductible  , 
        regular     = b.regular     , 
        cash        = b.cash        , 
        kode        = kode            
	from sc_im.detail_formula b 
    where a.kdrumus || a.no_urut = b.kdrumus || b.no_urut
CONTEXT:  PL/pgSQL function sc_im.pr_load_new_data(character) line 18 at SQL statement - Invalid query: select sc_im.pr_load_new_data('0321.437');
ERROR - 19-05-2021 14:34:07 --> Query error: server closed the connection unexpectedly
	This probably means the server terminated abnormally
	before or while processing the request. - Invalid query: select sc_im.pr_load_new_data('0321.437');
ERROR - 19-05-2021 14:34:09 --> Unable to connect to the database
ERROR - 19-05-2021 14:38:27 --> Query error: server closed the connection unexpectedly
	This probably means the server terminated abnormally
	before or while processing the request. - Invalid query: select sc_im.pr_load_new_data('0321.437');
ERROR - 19-05-2021 14:38:29 --> Severity: Warning  --> pg_pconnect(): Unable to connect to PostgreSQL server: could not connect to server: Connection refused (0x0000274D/10061)
	Is the server running on host &quot;localhost&quot; (::1) and accepting
	TCP/IP connections on port 5432?
FATAL:  sistem database dalam mode pemulihan D:\NusaApp\apache2\htdocs\hrms.nusa\system\database\drivers\postgre\postgre_driver.php 153
ERROR - 19-05-2021 14:38:29 --> Unable to connect to the database
ERROR - 19-05-2021 14:38:33 --> Unable to connect to the database
ERROR - 19-05-2021 15:34:50 --> Query error: ERROR:  sintaks masukan tidak valid untuk tipe timestamp : « 05/01/2017 00.00 »
CONTEXT:  COPY jadwalkerja, baris 2, kolom inputdate : « 05/01/2017 00.00 » - Invalid query: drop table if exists sc_im.jadwalkerja;
		                        select * into sc_im.jadwalkerja from sc_trx.jadwalkerja limit 1;
		                        truncate sc_im.jadwalkerja;
								copy  sc_im.jadwalkerja from 'D:\NusaApp\apache2\htdocs\hrms.nusa\assets\import_directory\export_directory\JADWAL_KERJA.CSV' using delimiters ';' csv header;
								
ERROR - 19-05-2021 15:37:52 --> Query error: ERROR:  nilai kunci ganda melanggar batasan unik « transready_pkey »
DETAIL:  Kunci « (nik, tgl, kdjamkerja)=(0112.002       , 2021-05-07, NSB  ) » sudah ada.
CONTEXT:  pernyataan SQL « insert into sc_trx.transready (
        select * 
        from sc_im.transready 
        where id not in (
            select id 
            from sc_trx.transready 
            where tgl >= vr_tglawal
        ) and tgl >= vr_tglawal
    ) »
PL/pgSQL function sc_im.pr_load_new_data(character) line 839 at SQL statement - Invalid query: select sc_im.pr_load_new_data('0321.437');
ERROR - 19-05-2021 15:38:51 --> Query error: ERROR:  nilai kunci ganda melanggar batasan unik « transready_pkey »
DETAIL:  Kunci « (nik, tgl, kdjamkerja)=(0112.002       , 2021-05-07, NSB  ) » sudah ada.
CONTEXT:  pernyataan SQL « insert into sc_trx.transready (
        select * 
        from sc_im.transready 
        where id not in (
            select id 
            from sc_trx.transready 
            where tgl >= vr_tglawal
        ) and tgl >= vr_tglawal
    ) »
PL/pgSQL function sc_im.pr_load_new_data(character) line 839 at SQL statement - Invalid query: select sc_im.pr_load_new_data('0321.437');
