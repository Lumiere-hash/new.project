<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_sj extends CI_Model
{
    private $t_hdr = 'sc_trx.sj_hdr';
    private $t_dtl = 'sc_trx.sj_dtl';
    private $t_log = 'sc_trx.sj_applog';

    public function list_hdr($limit = 500)
    {
        $sql = "SELECT h.*,
                   COALESCE(SUM(d.qty),0) AS total_qty
                FROM {$this->t_hdr} h
                LEFT JOIN {$this->t_dtl} d ON d.sj_id=h.sj_id
                GROUP BY h.sj_id
                ORDER BY h.sj_id DESC
                LIMIT ?";
        return $this->db->query($sql, [(int)$limit]);
    }

    public function hdr($sj_id)  { return $this->db->get_where($this->t_hdr, ['sj_id'=>(int)$sj_id]); }
    public function dtl($sj_id)
    {
        $this->db->from($this->t_dtl);
        $this->db->where('sj_id', (int)$sj_id);
        $this->db->order_by('line_no','ASC');
        return $this->db->get();
    }

    public function insert_hdr(array $row)
    {
        $this->db->insert($this->t_hdr, $row);
        $id = (int)$this->db->insert_id();
        $this->db->insert($this->t_log, [
            'sj_id'=>$id,'actor_nik'=>$row['requested_nik'],
            'action'=>'SUBMIT','note'=>'Create/Submit'
        ]);
        return $id;
    }

    public function insert_dtl_batch(array $rows)
    {
        if (!$rows) return true;
        return $this->db->insert_batch($this->t_dtl, $rows);
    }

    public function update_hdr($sj_id, array $row)
    {
        $this->db->where('sj_id',(int)$sj_id)->update($this->t_hdr,$row);
        return $this->db->affected_rows();
    }

    public function delete_sj($sj_id)
    {
        return $this->db->delete($this->t_hdr, ['sj_id'=>(int)$sj_id]);
    }

    public function applog($sj_id, $actor, $action, $note='')
    {
        return $this->db->insert($this->t_log, [
            'sj_id'=>(int)$sj_id, 'actor_nik'=>$actor, 'action'=>$action, 'note'=>$note
        ]);
    }

    public function gen_sj_no($branch)
    {
        // contoh: SJ-SBY-YYYYMMDD-HHMMSS
        return 'SJ-'.trim($branch).'-'.date('Ymd-His');
    }
}
