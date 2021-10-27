<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Uang_makan_sales extends CI_Migration {
    protected $_version =  "00004.20211021.10.Uang-Makan-Sales";

    ################################################## DO NOT CHANGE THIS LINE !!! ##################################################
    public function up() {
        $files = glob(APPPATH . "migrations/sql/" . $this->_version . "/+up/*");
        $filelog = APPPATH . "migrations/logs/db.txt";
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;

        foreach($files as $file) {
            file_put_contents($filelog,  "\tBEGIN EXECUTING \"$file\"...\n\n", FILE_APPEND);
            if(!@$this->db->query(file_get_contents($file))) {
                file_put_contents($filelog,  "\t\t[ERROR]\n" . json_encode($this->db->error(), JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
                $this->db->db_debug = $db_debug;
                return FALSE;
            } else {
                file_put_contents($filelog,  "\t\t[SUCCESS]\n\n", FILE_APPEND);
            }
            file_put_contents($filelog,  "\tFINISH\n\n", FILE_APPEND);
        }
        $this->db->db_debug = $db_debug;
        return TRUE;
    }

    public function down() {
        $files = glob(APPPATH . "migrations/sql/" . $this->_version . "/-down/*");
        $filelog = APPPATH . "migrations/logs/db.txt";
        $db_debug = $this->db->db_debug;
        $this->db->db_debug = FALSE;

        foreach(array_reverse($files) as $file) {
            file_put_contents($filelog,  "\tBEGIN EXECUTING \"$file\"...\n\n", FILE_APPEND);
            if(!@$this->db->query(file_get_contents($file))) {
                file_put_contents($filelog,  "\t\t[ERROR]\n" . json_encode($this->db->error(), JSON_PRETTY_PRINT) . "\n", FILE_APPEND);
                $this->db->db_debug = $db_debug;
                return FALSE;
            } else {
                file_put_contents($filelog,  "\t\t[SUCCESS]\n\n", FILE_APPEND);
            }
            file_put_contents($filelog,  "\tFINISH\n\n", FILE_APPEND);
        }
        $this->db->db_debug = $db_debug;
        return TRUE;
    }
    ################################################## DO NOT CHANGE THIS LINE !!! ##################################################
}
