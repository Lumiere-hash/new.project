<?php

class LogDb extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->library(array('form_validation','template'));
        if(!$this->session->userdata('nik')) {
            redirect('dashboard');
        }
    }

    function index() {
        ## CHECK IF sc_audit IS EXIST ##
        $checkAudit = $this->db->query("
            SELECT EXISTS (
                SELECT FROM information_schema.tables 
                WHERE table_schema = 'sc_audit'
                AND table_name IN ('audit_ddl_command_end', 'audit_sql_drop')
            );
        ")->row_array();
        $data["audit"] = [];

        if($checkAudit["exists"] == "t") {
            $data["audit"] = $this->db->query("
                SELECT DISTINCT HSTORE_TO_JSON(ctx)::JSONB ->> 'query' AS query, tag, username, datname, client_addr, TO_CHAR(crt_time, 'YYYY-MM-DD HH24:MI:SS') AS crt_time
                FROM sc_audit.audit_ddl_command_end;
            ")->result_array();
        }

        $this->template->display('logDb',$data);
    }

    function createLogDb() {
        $this->db->simple_query("
            DROP SCHEMA IF EXISTS sc_audit CASCADE;
            CREATE SCHEMA sc_audit;
            GRANT USAGE ON SCHEMA sc_audit TO public;

            CREATE EXTENSION HSTORE SCHEMA sc_audit;
            
            CREATE TABLE sc_audit.audit_ddl_command_end (
                event TEXT,
                tag TEXT,
                username NAME DEFAULT CURRENT_USER,
                datname NAME DEFAULT CURRENT_DATABASE(),
                client_addr INET DEFAULT INET_CLIENT_ADDR(),
                client_port INT DEFAULT INET_CLIENT_PORT(),
                crt_time TIMESTAMP DEFAULT NOW(),
                ctx sc_audit.HSTORE,
                xid BIGINT DEFAULT TXID_CURRENT()
            );
             
            CREATE TABLE sc_audit.audit_sql_drop (
                event TEXT,
                tag TEXT,
                username NAME DEFAULT CURRENT_USER,
                datname NAME DEFAULT CURRENT_DATABASE(),
                client_addr INET DEFAULT INET_CLIENT_ADDR(),
                client_port INT DEFAULT INET_CLIENT_PORT(),
                crt_time TIMESTAMP DEFAULT NOW(),
                classid OID,
                objid OID,
                objsubid INT,
                object_type TEXT,
                schema_name TEXT,
                object_name TEXT,
                object_identity TEXT,
                xid BIGINT DEFAULT TXID_CURRENT()
            );
             
            GRANT SELECT, UPDATE, DELETE, INSERT, TRUNCATE ON sc_audit.audit_ddl_command_end TO public;
            GRANT SELECT, UPDATE, DELETE, INSERT, TRUNCATE ON sc_audit.audit_sql_drop TO public;
              
            CREATE OR REPLACE FUNCTION sc_audit.ef_ddl_command_end() RETURNS EVENT_TRIGGER AS $$
            DECLARE
                rec sc_audit.hstore;
            BEGIN
                SELECT sc_audit.hstore(pg_stat_activity.*) INTO rec FROM pg_stat_activity WHERE pid = PG_BACKEND_PID();
                INSERT INTO sc_audit.audit_ddl_command_end(event, tag, ctx) VALUES(TG_EVENT, TG_TAG, rec);
            END;
            $$ LANGUAGE PLPGSQL STRICT;
             
            CREATE OR REPLACE FUNCTION sc_audit.ef_sql_drop() RETURNS EVENT_TRIGGER AS $$
            DECLARE
            BEGIN
                INSERT INTO sc_audit.audit_sql_drop(event, tag, classid, objid, objsubid, object_type, schema_name, object_name, object_identity)
                SELECT TG_EVENT, TG_TAG, classid, objid, objsubid, object_type, schema_name, object_name, object_identity FROM pg_event_trigger_dropped_objects();
            END;
            $$ LANGUAGE PLPGSQL STRICT;
            
            CREATE EVENT TRIGGER ef_ddl_command_end ON ddl_command_end EXECUTE PROCEDURE sc_audit.ef_ddl_command_end();
            CREATE EVENT TRIGGER ef_sql_drop ON sql_drop EXECUTE PROCEDURE sc_audit.ef_sql_drop();
        ");
        redirect('logDb');
    }

}
?>
