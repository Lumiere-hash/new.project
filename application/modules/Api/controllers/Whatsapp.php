<?php defined('BASEPATH') or exit('No direct script access allowed');

class WhatsApp extends MX_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model(array(
            'm_setup',
            'm_cabang',
            'm_cuti',
            'm_dinas',
            'm_ijin',
            'm_lembur',
        ));
    }

    public function index()
    {
        $nama = $this->session->userdata('nik');
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        echo json_encode(
            $this->m_cuti->q_whatsapp_collect_where('
            AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
            AND ck.status = \'A\' AND whatsappsent = FALSE
            ORDER BY input_date
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result()
        );
    }

    public function auth()
    {
        $nama = $this->session->userdata('nik');
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'api/token/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'user_name' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-USER:' . $branch . '\'', 'root'),
                'password' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-PASSWORD:' . $branch . '\'', '#Admin#'),
            ),
        ));
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $body = json_decode($response);
        curl_close($curl);
        if ($body) {
            if ($info['http_code'] == 200) {
                try {
                    $setup = $this->m_setup->q_mst_exist(array('kdoption' => 'WA-REFRESH:' . $branch));
                    if ($setup) {
                        $data = array(
                            'value1' => $body->refresh,
                            'status' => 'T',
                            'update_by' => $nama,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('kdoption', 'WA-REFRESH:' . $branch);
                        $this->db->update('sc_mst.option', $data);
                    } else {
                        $data = array(
                            'kdoption' => 'WA-REFRESH:' . $branch,
                            'nmoption' => 'TOKEN WA-REFRESH ' . $branch,
                            'value1' => $body->refresh,
                            'group_option' => 'WA',
                            'status' => 'T',
                            'input_by' => $nama,
                            'input_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('sc_mst.option', $data);
                    }
                    $setup = $this->m_setup->q_mst_exist(array('kdoption' => 'WA-ACCESS:' . $branch));
                    if ($setup) {
                        $data = array(
                            'value1' => $body->access,
                            'status' => 'T',
                            'update_by' => $nama,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('kdoption', 'WA-ACCESS:' . $branch);
                        $this->db->update('sc_mst.option', $data);
                    } else {
                        $data = array(
                            'kdoption' => 'WA-ACCESS:' . $branch,
                            'nmoption' => 'TOKEN WA-ACCESS ' . $branch,
                            'value1' => $body->access,
                            'group_option' => 'WA'
                        );
                        $this->db->insert('sc_mst.option', $data);
                    }
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'return' => true,
                        'info' => $info,
                        'body' => $body,
                    ), JSON_PRETTY_PRINT);
                    return true;
                } catch (\Exception $e) {
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array(
            'return' => false,
            'info' => $info,
            'body' => $body,
        ), JSON_PRETTY_PRINT);
        return false;
    }

    public function refresh()
    {
        $nama = $this->session->userdata('nik');
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'api/token/refresh/',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array('refresh' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-REFRESH:' . $branch . '\'', 'refresh')),
        ));
        $response = curl_exec($curl);
        $info = curl_getinfo($curl);
        $body = json_decode($response);
        curl_close($curl);
        if ($body) {
            if ($info['http_code'] == 200) {
                try {
                    $setup = $this->m_setup->q_mst_exist(array('kdoption' => 'WA-REFRESH:' . $branch));
                    if ($setup) {
                        $data = array(
                            'value1' => $body->refresh,
                            'status' => 'T',
                            'update_by' => $nama,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('kdoption', 'WA-REFRESH:' . $branch);
                        $this->db->update('sc_mst.option', $data);
                    } else {
                        $data = array(
                            'kdoption' => 'WA-REFRESH:' . $branch,
                            'nmoption' => 'TOKEN WA-REFRESH ' . $branch,
                            'value1' => $body->refresh,
                            'group_option' => 'WA',
                            'status' => 'T',
                            'input_by' => $nama,
                            'input_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('sc_mst.option', $data);
                    }
                    $setup = $this->m_setup->q_mst_exist(array('kdoption' => 'WA-ACCESS:' . $branch));
                    if ($setup) {
                        $data = array(
                            'value1' => $body->access,
                            'status' => 'T',
                            'update_by' => $nama,
                            'update_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->where('kdoption', 'WA-ACCESS:' . $branch);
                        $this->db->update('sc_mst.option', $data);
                    } else {
                        $data = array(
                            'kdoption' => 'WA-ACCESS:' . $branch,
                            'nmoption' => 'TOKEN WA-ACCESS ' . $branch,
                            'value1' => $body->access,
                            'group_option' => 'WA',
                            'status' => 'T',
                            'input_by' => $nama,
                            'input_date' => date('Y-m-d H:i:s')
                        );
                        $this->db->insert('sc_mst.option', $data);
                    }
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'return' => true,
                        'info' => $info,
                        'body' => $body,
                    ), JSON_PRETTY_PRINT);
                    return true;
                } catch (\Exception $e) {
                }
            }
        }
        header('Content-Type: application/json');
        echo json_encode(array(
            'return' => false,
            'info' => $info,
            'body' => $body,
        ), JSON_PRETTY_PRINT);
        return false;
    }

    public function shuffle($len = 4)
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $charcode = '';
        for ($loop = 0; $loop < $len; $loop++) {
            $charcode .= str_shuffle($chars)[0];
        }
        return $charcode;
    }

    public function msgcuti()
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $messages = [];
        foreach ($this->m_cuti->q_whatsapp_collect_where('
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.status = \'A\' AND whatsappsent = FALSE
        ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $message = '' .
                '*PERSETUJUAN CUTI*' . PHP_EOL .
                PHP_EOL .
                'NO DOK *' . $item->nodok . '*' . PHP_EOL .
                PHP_EOL .
                'Nama Karyawan: *' . $item->nama . '*' . PHP_EOL .
                'Tipe Pengajuan: *CUTI*' . PHP_EOL .
                'Tanggal Cuti: *' . $item->tgl_mulai . ' sd ' . $item->tgl_selesai . '*' . PHP_EOL .
                'Jumlah Cuti: *' . $item->jumlah_cuti . '* Hari' . PHP_EOL .
                'Keterangan Cuti: *' . $item->keterangan . '*' . PHP_EOL .
                'Pelimpahan Tugas: *' . $item->pelimpahan . '*' . PHP_EOL .
                PHP_EOL .
                '_Balas:_'. PHP_EOL .
                ' _Iya = Setuju, Tidak = Tolak_' . PHP_EOL . 
                PHP_EOL .
                '_Ref:' . $this->shuffle() . '_' .
                '';
            array_push($messages, array(
                'message' => json_encode(
                    array(
                        'message' => $message,
                    )
                ),
                'message_type' => 'conversation',
                'outbox_for' => $item->approverjid,
                'is_interactive' => true,
                'retry' => 1,
                'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                'properties' => array(
                    'type' => 'A.I.C',
                    'objectid' => $item->nodok,
                    'approver' => $item->approver,
                ),
            ));
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($messages),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_cuti->q_trx_update(array(
                            'whatsappsent' => TRUE,
                        ), array('TRIM(nodok)' => $row->properties->objectid));
                        $this->db->insert('sc_log.success_notifications', array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        ));
                    }
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'return' => false,
                        'info' => $info,
                        'body' => $body,
                    ), JSON_PRETTY_PRINT);
                    return true;
                } else {
                    $this->db->insert('sc_log.error_notifications', array(
                        'modul' => 'notification',
                        'message' => json_encode($body),
                        'properties' => json_encode($info),
                        'input_by' => 'SYSTEM',
                        'input_date' => date('Y-m-d H:i:s'),
                    ));
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => false,
                'info' => $info,
                'body' => $body,
            ), JSON_PRETTY_PRINT);
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => true,
                'info' => array(),
                'body' => array(),
                'message' => 'Empty data will skip post to whatsapp bot',
            ), JSON_PRETTY_PRINT);
            return true;
        }
    }

    public function msgijindt()
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $messages = [];
        foreach ($this->m_ijin->q_whatsapp_collect_where(' 
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.kdijin_absensi = \'DT\' AND ck.status = \'A\' AND whatsappsent = FALSE
        ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $message = '' .
                '*PERSETUJUAN ' . $item->jenis_ijin . '* ' . PHP_EOL .
                PHP_EOL .
                'NO DOK *' . $item->nodok . '*' . PHP_EOL .
                PHP_EOL .
                'Nama Karyawan: *' . $item->nama . '*' . PHP_EOL .
                'Tipe Pengajuan: *' . $item->jenis_ijin . ' '.$item->tipe_ijin . '*' . PHP_EOL .
                'Tanggal Izin: *' . $item->tgl_kerja . '*' . PHP_EOL .
                'Jam Datang: *' . $item->jam_mulai . '*' . PHP_EOL .
                'Keterangan Izin: *' . $item->keterangan . '*' . PHP_EOL .
                PHP_EOL .
                '_Balas:_'. PHP_EOL .
                ' _Iya = Setuju, Tidak = Tolak_' . PHP_EOL . 
                PHP_EOL .
                '_Ref:' . $this->shuffle() . '_' .
                '';
            array_push($messages, array(
                'message' => json_encode(
                    array(
                        'message' => $message,
                    )
                ),
                'message_type' => 'conversation',
                'outbox_for' => $item->approverjid,
                'is_interactive' => true,
                'retry' => 1,
                'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                'properties' => array(
                    'type' => 'A.I.I',
                    'objectid' => $item->nodok,
                    'approver' => $item->approver,
                ),
            ));
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($messages),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_ijin->q_trx_update(array(
                            'whatsappsent' => TRUE,
                        ), array('TRIM(nodok)' => $row->properties->objectid));
                        $this->db->insert('sc_log.success_notifications', array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        ));
                    }
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'return' => false,
                        'info' => $info,
                        'body' => $body,
                    ), JSON_PRETTY_PRINT);
                    return true;
                } else {
                    $this->db->insert('sc_log.error_notifications', array(
                        'modul' => 'notification',
                        'message' => json_encode($body),
                        'properties' => json_encode($info),
                        'input_by' => 'SYSTEM',
                        'input_date' => date('Y-m-d H:i:s'),
                    ));
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => false,
                'info' => $info,
                'body' => $body,
            ), JSON_PRETTY_PRINT);
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => true,
                'info' => array(),
                'body' => array(),
                'message' => 'Empty data will skip post to whatsapp bot',
            ), JSON_PRETTY_PRINT);
            return true;
        }
    }

    public function msgijinik()
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $messages = [];
        foreach ($this->m_ijin->q_whatsapp_collect_where(' 
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.kdijin_absensi = \'IK\' AND ck.status = \'A\' AND whatsappsent = FALSE
        ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $message = '' .
                '*PERSETUJUAN ' . $item->jenis_ijin . '* ' . PHP_EOL .
                PHP_EOL .
                'NO DOK *' . $item->nodok . '*' . PHP_EOL .
                PHP_EOL .
                'Nama Karyawan: *' . $item->nama . '*' . PHP_EOL .
                'Tipe Pengajuan: *' . $item->jenis_ijin . ' '.$item->tipe_ijin . '*' . PHP_EOL .
                'Tanggal Izin: *' . $item->tgl_kerja . '*' . PHP_EOL .
                'Jam Datang: *' . $item->jam_mulai . '*' . PHP_EOL .
                'Jam Pulang: *' . $item->jam_selesai . '*' . PHP_EOL .
                'Keterangan Izin: *' . $item->keterangan . '*' . PHP_EOL .
                PHP_EOL .
                '_Balas:_'. PHP_EOL .
                ' _Iya = Setuju, Tidak = Tolak_' . PHP_EOL . 
                PHP_EOL .
                '_Ref:' . $this->shuffle() . '_' .
                '';
            array_push($messages, array(
                'message' => json_encode(
                    array(
                        'message' => $message,
                    )
                ),
                'message_type' => 'conversation',
                'outbox_for' => $item->approverjid,
                'is_interactive' => true,
                'retry' => 1,
                'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                'properties' => array(
                    'type' => 'A.I.I',
                    'objectid' => $item->nodok,
                    'approver' => $item->approver,
                ),
            ));
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($messages),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_ijin->q_trx_update(array(
                            'whatsappsent' => TRUE,
                        ), array('TRIM(nodok)' => $row->properties->objectid));
                        $this->db->insert('sc_log.success_notifications', array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        ));
                    }
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'return' => false,
                        'info' => $info,
                        'body' => $body,
                    ), JSON_PRETTY_PRINT);
                    return true;
                } else {
                    $this->db->insert('sc_log.error_notifications', array(
                        'modul' => 'notification',
                        'message' => json_encode($body),
                        'properties' => json_encode($info),
                        'input_by' => 'SYSTEM',
                        'input_date' => date('Y-m-d H:i:s'),
                    ));
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => false,
                'info' => $info,
                'body' => $body,
            ), JSON_PRETTY_PRINT);
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => true,
                'info' => array(),
                'body' => array(),
                'message' => 'Empty data will skip post to whatsapp bot',
            ), JSON_PRETTY_PRINT);
            return true;
        }
    }

    public function msgijinpa()
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $messages = [];
        foreach ($this->m_ijin->q_whatsapp_collect_where(' 
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.kdijin_absensi = \'PA\' AND ck.status = \'A\' AND whatsappsent = FALSE
        ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $message = '' .
                '*PERSETUJUAN ' . $item->jenis_ijin . '* ' . PHP_EOL .
                PHP_EOL .
                'NO DOK *' . $item->nodok . '*' . PHP_EOL .
                PHP_EOL .
                'Nama Karyawan: *' . $item->nama . '*' . PHP_EOL .
                'Tipe Pengajuan: *' . $item->jenis_ijin . ' '.$item->tipe_ijin . '*' . PHP_EOL .
                'Tanggal Izin: *' . $item->tgl_kerja . '*' . PHP_EOL .
                'Jam Pulang: *' . $item->jam_selesai . '*' . PHP_EOL .
                'Keterangan Izin: *' . $item->keterangan . '*' . PHP_EOL .
                PHP_EOL .
                '_Balas:_'. PHP_EOL .
                ' _Iya = Setuju, Tidak = Tolak_' . PHP_EOL . 
                PHP_EOL .
                '_Ref:' . $this->shuffle() . '_' .
                '';
            array_push($messages, array(
                'message' => json_encode(
                    array(
                        'message' => $message,
                    )
                ),
                'message_type' => 'conversation',
                'outbox_for' => $item->approverjid,
                'is_interactive' => true,
                'retry' => 1,
                'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                'properties' => array(
                    'type' => 'A.I.I',
                    'objectid' => $item->nodok,
                    'approver' => $item->approver,
                ),
            ));
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($messages),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_ijin->q_trx_update(array(
                            'whatsappsent' => TRUE,
                        ), array('TRIM(nodok)' => $row->properties->objectid));
                        $this->db->insert('sc_log.success_notifications', array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        ));
                    }
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'return' => false,
                        'info' => $info,
                        'body' => $body,
                    ), JSON_PRETTY_PRINT);
                    return true;
                } else {
                    $this->db->insert('sc_log.error_notifications', array(
                        'modul' => 'notification',
                        'message' => json_encode($body),
                        'properties' => json_encode($info),
                        'input_by' => 'SYSTEM',
                        'input_date' => date('Y-m-d H:i:s'),
                    ));
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => false,
                'info' => $info,
                'body' => $body,
            ), JSON_PRETTY_PRINT);
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => true,
                'info' => array(),
                'body' => array(),
                'message' => 'Empty data will skip post to whatsapp bot',
            ), JSON_PRETTY_PRINT);
            return true;
        }
    }

    public function msglembur()
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $messages = [];
        foreach ($this->m_lembur->q_whatsapp_collect_where('
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.status = \'A\' AND whatsappsent = FALSE
        ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
            $message = '' .
                '*PERSETUJUAN LEMBUR*' . PHP_EOL .
                PHP_EOL .
                'NO DOK *' . $item->nodok . '*' . PHP_EOL .
                PHP_EOL .
                'Nama Karyawan: *' . $item->nama . '*' . PHP_EOL .
                'Tipe Pengajuan: *LEMBUR* Hari *' . $item->tipe_lembur . '*' . PHP_EOL .
                'Tanggal Kerja: *' . $item->tgl_kerja . '*' .  PHP_EOL .
                'Jam Mulai: *' . $item->jam_mulai . '*' .  PHP_EOL .
                'Jam Selesai: *' . $item->jam_selesai . '*' .  PHP_EOL .
                'Durasi Lembur: *' . $item->durasi . '*' .  PHP_EOL .
                'Keterangan Lembur: *' . $item->keterangan . '*' . PHP_EOL .
                PHP_EOL .
                '_Balas:_'. PHP_EOL .
                '_Iya = Setuju, Tidak = Tolak_' . PHP_EOL . 
                PHP_EOL .
                '_Ref:' . $this->shuffle() . '_' .
                '';
            array_push($messages, array(
                'message' => json_encode(
                    array(
                        'message' => $message,
                    )
                ),
                'message_type' => 'conversation',
                'outbox_for' => $item->approverjid,
                'is_interactive' => true,
                'retry' => 1,
                'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                'properties' => array(
                    'type' => 'A.I.L',
                    'objectid' => $item->nodok,
                    'approver' => $item->approver,
                ),
            ));
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($messages),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_lembur->q_trx_update(array(
                            'whatsappsent' => TRUE,
                        ), array('TRIM(nodok)' => $row->properties->objectid));
                        $this->db->insert('sc_log.success_notifications', array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        ));
                    }
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'return' => false,
                        'info' => $info,
                        'body' => $body,
                    ), JSON_PRETTY_PRINT);
                    return true;
                } else {
                    $this->db->insert('sc_log.error_notifications', array(
                        'modul' => 'notification',
                        'message' => json_encode($body),
                        'properties' => json_encode($info),
                        'input_by' => 'SYSTEM',
                        'input_date' => date('Y-m-d H:i:s'),
                    ));
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => false,
                'info' => $info,
                'body' => $body,
            ), JSON_PRETTY_PRINT);
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => true,
                'info' => array(),
                'body' => array(),
                'message' => 'Empty data will skip post to whatsapp bot',
            ), JSON_PRETTY_PRINT);
            return true;
        }
    }

    public function msgdinas()
    {
        $branch = trim($this->m_cabang->q_mst_download_where(' AND UPPER(a.default)::CHAR = \'Y\' '));

        $messages = [];
        foreach ($this->m_dinas->q_whatsapp_collect_where('
        AND \'WA-SESSION:' . $branch . '\' IN ( SELECT TRIM(kdoption) FROM sc_mst.option WHERE kdoption ILIKE \'%WA-SESSION:%\' )
        AND ck.status = \'A\' AND whatsappsent = FALSE
        ORDER BY input_date desc
            LIMIT ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SEND-LIMIT:' . $branch . '\'', 10))->result() as $index => $item) {
                $message = '' .
                '*PERSETUJUAN DINAS*' . PHP_EOL .
                PHP_EOL .
                'NO DOK *' . $item->nodok . '*' . PHP_EOL .
                PHP_EOL .
                'Nama Karyawan: *' . $item->nama . '*' . PHP_EOL .
                'Tipe Pengajuan: *DINAS ' . $item->jenis_tujuan . '*' . PHP_EOL .
                'Tanggal Dinas: *' . $item->tgl_mulai . ' sd ' . $item->tgl_selesai . '*' . PHP_EOL .
                'Kota Tujuan: *' . $item->tujuan_kota . '* ' . PHP_EOL .
                'Keperluan Dinas: *' . $item->keperluan . '* ' . PHP_EOL .
                'Transportasi Dinas: *' . $item->transportasi . ' ' . $item->tipe_transportasi . '* ' . PHP_EOL .
                PHP_EOL .
                '_Balas:_'. PHP_EOL .
                '_Iya = Setuju, Tidak = Tolak_' . PHP_EOL . 
                PHP_EOL .
                '_Ref:' . $this->shuffle() . '_' .
                '';
            array_push($messages, array(
                'message' => json_encode(
                    array(
                        'message' => $message,
                    )
                ),
                'message_type' => 'conversation',
                'outbox_for' => $item->approverjid,
                'is_interactive' => true,
                'retry' => 1,
                'session' => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-SESSION:' . $branch . '\'', 'session'),
                'properties' => array(
                    'type' => 'A.I.D',
                    'objectid' => $item->nodok,
                    'approver' => $item->approver,
                ),
            ));
        }
        if (count($messages) > 0) {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $this->m_setup->q_mst_read_value(' AND parameter = \'WA-BASE-URL:' . $branch . '\'', 'https://syifarahmat.github.io/whatsapp.bot/') . 'whatsapp/api/outbox/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_SSL_VERIFYPEER => false,
                CURLOPT_SSL_VERIFYHOST => false,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS => json_encode($messages),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer ' . $this->m_setup->q_mst_read_value(' AND parameter = \'WA-ACCESS:' . $branch . '\' ', 'access'),
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            $info = curl_getinfo($curl);
            $body = json_decode($response);
            curl_close($curl);
            if ($body) {
                if ($info['http_code'] == 201) {
                    foreach ($body as $row) {
                        $this->m_dinas->q_trx_update(array(
                            'whatsappsent' => TRUE,
                        ), array('TRIM(nodok)' => $row->properties->objectid));
                        $this->db->insert('sc_log.success_notifications', array(
                            'modul' => 'notification',
                            'message' => json_encode($body),
                            'properties' => json_encode($info),
                            'input_by' => 'SYSTEM',
                            'input_date' => date('Y-m-d H:i:s'),
                        ));
                    }
                    header('Content-Type: application/json');
                    echo json_encode(array(
                        'return' => false,
                        'info' => $info,
                        'body' => $body,
                    ), JSON_PRETTY_PRINT);
                    return true;
                } else {
                    $this->db->insert('sc_log.error_notifications', array(
                        'modul' => 'notification',
                        'message' => json_encode($body),
                        'properties' => json_encode($info),
                        'input_by' => 'SYSTEM',
                        'input_date' => date('Y-m-d H:i:s'),
                    ));
                }
            }
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => false,
                'info' => $info,
                'body' => $body,
            ), JSON_PRETTY_PRINT);
            return false;
        } else {
            header('Content-Type: application/json');
            echo json_encode(array(
                'return' => true,
                'info' => array(),
                'body' => array(),
                'message' => 'Empty data will skip post to whatsapp bot',
            ), JSON_PRETTY_PRINT);
            return true;
        }
    }

    public function sendapprovalcuti()
    {
        if ($this->msgcuti()) {
        } else {
            if ($this->refresh()) {
                $this->msgcuti();
            } else {
                if ($this->auth()) {
                    $this->msgcuti();
                }
            }
        }
    }

    public function sendapprovalijindt()
    {
        if ($this->msgijindt()) {
        } else {
            if ($this->refresh()) {
                $this->msgijindt();
            } else {
                if ($this->auth()) {
                    $this->msgijindt();
                }
            }
        }
    }

    public function sendapprovalijinik()
    {
        if ($this->msgijinik()) {
        } else {
            if ($this->refresh()) {
                $this->msgijinik();
            } else {
                if ($this->auth()) {
                    $this->msgijinik();
                }
            }
        }
    }

    public function sendapprovalijinpa()
    {
        if ($this->msgijinpa()) {
        } else {
            if ($this->refresh()) {
                $this->msgijinpa();
            } else {
                if ($this->auth()) {
                    $this->msgijinpa();
                }
            }
        }
    }

    public function sendapprovallembur()
    {
        if ($this->msglembur()) {
        } else {
            if ($this->refresh()) {
                $this->msglembur();
            } else {
                if ($this->auth()) {
                    $this->msglembur();
                }
            }
        }
    }

    public function sendapprovaldinas()
    {
        if ($this->msgdinas()) {
        } else {
            if ($this->refresh()) {
                $this->msgdinas();
            } else {
                if ($this->auth()) {
                    $this->msgdinas();
                }
            }
        }
    }
}
