<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_stock extends CI_Model
{
    private $t_rcv_hdr    = 'sc_trx.rcv_hdr';
    private $t_rcv_dtl    = 'sc_trx.rcv_dtl';
    private $t_stock_card = 'sc_trx.stock_card';

    public function __construct()
    {
        parent::__construct();
    }

    private function _filter_cols($row, $allowed)
    {
        if (!is_array($row)) return array();
        return array_intersect_key($row, array_flip($allowed));
    }

    private function _filter_batch($rows, $allowed)
    {
        $out = array();
        if (!is_array($rows)) return $out;
        foreach ($rows as $r) {
            if (!is_array($r)) continue;
            $f = $this->_filter_cols($r, $allowed);
            if (!empty($f)) $out[] = $f;
        }
        return $out;
    }

    public function list_rcv($limit = 500)
    {
        $sql = "
            SELECT
                h.*,
                COALESCE(SUM(d.qty_good),0)   AS total_good,
                COALESCE(SUM(d.qty_reject),0) AS total_reject
            FROM {$this->t_rcv_hdr} h
            LEFT JOIN {$this->t_rcv_dtl} d ON d.rcv_id = h.rcv_id
            GROUP BY h.rcv_id
            ORDER BY h.rcv_date DESC, h.rcv_id DESC
            LIMIT ?
        ";
        return $this->db->query($sql, array((int)$limit));
    }

    public function insert_rcv_hdr($hdr)
    {
        $allowed = array(
            'branch','rcv_no','rcv_date','supplier','container_no','seal_no',
            'bl_no','vessel','voyage','eta','ata','port_from','port_to',
            'truck_no','driver_name','wh_loc','remark','inputby'
        );
        $row = $this->_filter_cols($hdr, $allowed);
        if (empty($row['rcv_date'])) $row['rcv_date'] = date('Y-m-d');

        $this->db->insert($this->t_rcv_hdr, $row);
        return (int)$this->db->insert_id();
    }

    public function rcv_detail_hdr($rcv_id)
    {
        return $this->db->get_where($this->t_rcv_hdr, array('rcv_id' => (int)$rcv_id));
    }

    public function insert_rcv_dtl_batch($rows)
    {
        if (empty($rows)) return true;

        $allowed = array(
            'rcv_id','line_no','nodok','nmbarang','uom',
            'qty_good','qty_reject','lot_no','mfg_date','exp_date',
            'rack_bin','reject_note','remark'
        );
        $data = $this->_filter_batch($rows, $allowed);
        if (empty($data)) return true;

        return $this->db->insert_batch($this->t_rcv_dtl, $data);
    }

    public function rcv_detail_dtl($rcv_id)
    {
        $this->db->from($this->t_rcv_dtl);
        $this->db->where('rcv_id', (int)$rcv_id);
        $this->db->order_by('line_no', 'ASC');
        return $this->db->get();
    }

    public function delete_rcv($rcv_id)
    {
        $rcv_id = (int)$rcv_id;
        $this->db->trans_begin();

        $this->db->delete($this->t_stock_card, array('ref_type'=>'RCV','ref_id'=>$rcv_id));
        $this->db->delete($this->t_rcv_dtl, array('rcv_id'=>$rcv_id));
        $this->db->delete($this->t_rcv_hdr, array('rcv_id'=>$rcv_id));

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        }
        $this->db->trans_commit();
        return true;
    }

    public function insert_stock_card_batch($rows)
    {
        if (empty($rows)) return true;

        $allowed = array(
            'branch','trans_date','trans_type','ref_type','ref_id','ref_no',
            'nodok','wh_loc','rack_bin','uom',
            'qty_good_in','qty_good_out','qty_rej_in','qty_rej_out','note'
        );
        $data = $this->_filter_batch($rows, $allowed);
        if (empty($data)) return true;

        foreach ($data as &$r) {
            $r['qty_good_in']  = isset($r['qty_good_in'])  ? (float)$r['qty_good_in']  : 0;
            $r['qty_good_out'] = isset($r['qty_good_out']) ? (float)$r['qty_good_out'] : 0;
            $r['qty_rej_in']   = isset($r['qty_rej_in'])   ? (float)$r['qty_rej_in']   : 0;
            $r['qty_rej_out']  = isset($r['qty_rej_out'])  ? (float)$r['qty_rej_out']  : 0;
        }
        unset($r);

        return $this->db->insert_batch($this->t_stock_card, $data);
    }

    public function stock_card($nodok, $wh_loc = null, $dfrom = null, $dto = null)
    {
        $this->db->from($this->t_stock_card);
        $this->db->where('nodok', $nodok);
        if (!empty($wh_loc)) $this->db->where('wh_loc', $wh_loc);
        if (!empty($dfrom))  $this->db->where('trans_date >=', $dfrom.' 00:00:00');
        if (!empty($dto))    $this->db->where('trans_date <=', $dto.' 23:59:59');
        $this->db->order_by('trans_date', 'ASC');
        return $this->db->get();
    }

    public function onhand($nodok = null, $wh_loc = null, $dfrom = null, $dto = null)
    {
        if (!empty($wh_loc)) {
            $select_wh = "wh_loc";
            $group_by  = "nodok, wh_loc";
            $order_by  = "nodok, wh_loc";
        } else {
            $select_wh = "''::varchar AS wh_loc";
            $group_by  = "nodok";
            $order_by  = "nodok";
        }

        $sql = "
            SELECT
                nodok,
                {$select_wh},
                SUM(COALESCE(qty_good_in,0) - COALESCE(qty_good_out,0)) AS onhand_good,
                SUM(COALESCE(qty_rej_in,0)  - COALESCE(qty_rej_out,0))  AS onhand_reject
            FROM {$this->t_stock_card}
            WHERE 1=1
        ";
        $bind = array();
        if (!empty($nodok))  { $sql .= " AND nodok = ?";             $bind[] = $nodok; }
        if (!empty($wh_loc)) { $sql .= " AND wh_loc = ?";            $bind[] = $wh_loc; }
        if (!empty($dfrom))  { $sql .= " AND trans_date::date >= ?"; $bind[] = $dfrom; }
        if (!empty($dto))    { $sql .= " AND trans_date::date <= ?"; $bind[] = $dto;   }

        $sql .= " GROUP BY {$group_by} ORDER BY {$order_by}";
        return $this->db->query($sql, $bind);
    }

    public function onhand_all_locations($nodok = null)
    {
        $sql = "
            SELECT
                nodok,
                wh_loc,
                SUM(COALESCE(qty_good_in,0) - COALESCE(qty_good_out,0)) AS onhand_good,
                SUM(COALESCE(qty_rej_in,0)  - COALESCE(qty_rej_out,0))  AS onhand_reject
            FROM {$this->t_stock_card}
            WHERE 1=1
        ";
        $bind = array();
        if (!empty($nodok)) { $sql .= " AND nodok = ?"; $bind[] = $nodok; }
        $sql .= " GROUP BY nodok, wh_loc ORDER BY nodok, wh_loc";
        return $this->db->query($sql, $bind);
    }

    public function get_rcv($rcv_id)     { return $this->rcv_detail_hdr($rcv_id); }
    public function get_rcv_dtl($rcv_id) { return $this->rcv_detail_dtl($rcv_id); }
}
