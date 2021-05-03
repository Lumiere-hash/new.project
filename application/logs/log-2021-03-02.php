<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 02-03-2021 16:56:45 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 02-03-2021 16:56:45 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 02-03-2021 16:56:45 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 02-03-2021 16:56:45 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 16:56:46 --> 404 Page Not Found --> 
ERROR - 02-03-2021 20:54:34 --> Query error: ERROR:  nilai kunci ganda melanggar batasan unik « deklarasi_mst_pkey »
DETAIL:  Kunci « (nik, nodok)=(0321.434    , false       ) » sudah ada.
CONTEXT:  pernyataan SQL « insert into sc_trx.deklarasi_mst  
		  (branch,nik,nodok,tgl_dok,status,total,uangmuka,sisa,keterangan,update_date,update_by,input_date,input_by, nodok_ref, approval_by,approval_date) 
		  (select branch,nik,new.nodok_ref as nodok,tgl_dok,'P' as status,total,uangmuka,sisa,keterangan,update_date,update_by,input_date,input_by, new.nodok as nodok_ref, approval_by,approval_date
		  from sc_tmp.deklarasi_mst where  nik=new.nik and nodok_ref=new.nodok_ref and nodok=new.nodok) »
PL/pgSQL function sc_tmp.tr_deklarasi_mst() line 26 at SQL statement - Invalid query: UPDATE "sc_tmp"."deklarasi_mst" SET "status" =  E'P'
WHERE "nik" =  E'0321.434'
AND "nodok_ref" =  E'false'
ERROR - 02-03-2021 23:14:19 --> 404 Page Not Found --> 
