<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>

ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 08:15:09 --> 404 Page Not Found --> 
ERROR - 20-05-2021 09:02:54 --> Query error: ERROR:  nilai kunci ganda melanggar batasan unik « option_pkey »
DETAIL:  Kunci « (kdoption, group_option)=(HRUMMAX01, DEFAULT             ) » sudah ada.
CONTEXT:  pernyataan SQL « update sc_mst.option a set 
        kdoption        = b.kdoption        , 
        nmoption        = b.nmoption        , 
        value1          = b.value1          , 
        value2          = b.value2          , 
        value3          = b.value3          , 
        status          = b.status          , 
        keterangan      = b.keterangan      , 
        input_by        = b.input_by        , 
        update_by       = b.update_by       , 
        input_date      = b.input_date      , 
        update_date     = b.update_date     , 
        group_option    = b.group_option      
	from sc_im.option b 
    where a.kdoption = b.kdoption »
PL/pgSQL function sc_im.pr_load_new_data(character) line 16 at SQL statement - Invalid query: select sc_im.pr_load_new_data('0321.437');
ERROR - 20-05-2021 09:06:23 --> Query error: ERROR:  nilai kunci ganda melanggar batasan unik « option_pkey »
DETAIL:  Kunci « (kdoption, group_option)=(HRUMMAX01, DEFAULT             ) » sudah ada.
CONTEXT:  pernyataan SQL « update sc_mst.option a set 
        kdoption        = b.kdoption        , 
        nmoption        = b.nmoption        , 
        value1          = b.value1          , 
        value2          = b.value2          , 
        value3          = b.value3          , 
        status          = b.status          , 
        keterangan      = b.keterangan      , 
        input_by        = b.input_by        , 
        update_by       = b.update_by       , 
        input_date      = b.input_date      , 
        update_date     = b.update_date     , 
        group_option    = b.group_option      
	from sc_im.option b 
    where a.kdoption = b.kdoption »
PL/pgSQL function sc_im.pr_load_new_data(character) line 16 at SQL statement - Invalid query: select sc_im.pr_load_new_data('0321.437');
