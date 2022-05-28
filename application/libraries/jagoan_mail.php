<?php
require_once dirname(__FILE__) . '/JagoanMailer/JagoanMailerAutoload.php';

class Jagoan_mail
{
    protected $_CI;

    function __construct()
    {
        $this->_CI =& get_instance();
        $this->_CI->load->library(array('encrypt', 'fiky_encryption'));

        //load utama
        //assets/stimulsoft
        //views/stimulsoft
        //library/stimulsoft
        //fiky_report

    }

    public function send($to, $subject, $message, $from_name, $from, $cc, $bcc, $debug = 0)
    {
        $no_dok = 'NSANBI';
        $config_smtp = $this->_CI->db->query("select * from sc_mst.setup_mail_smtp where no_dok='$no_dok'")->row_array();
        $mail = new PHPMailer;
        $mail->SMTPDebug = $debug; // Ubah menjadi true jika ingin menampilkan sistem debug SMTP Mailer
        $mail->isSMTP();

        // Hapus Semua Tujuan, CC dan BCC
        $mail->ClearAddresses();
        $mail->ClearCCs();
        $mail->ClearBCCs();


        $mail->SMTPAuth             = true;
        $mail->Host                 = trim($config_smtp['smtp_host']);  // Masukkan Server SMTP
        $mail->Port                 = trim($config_smtp['smtp_port']);                                     // Masukkan Port SMTP
        $mail->SMTPSecure           = 'tls';                                    // Masukkan Pilihan Enkripsi ( `tls` atau `ssl` )
        $mail->Username             = trim($config_smtp['smtp_user']);            // Masukkan Email yang digunakan selama proses pengiriman email via SMTP
        $mail->Password             = $this->_CI->encrypt->decode($config_smtp['smtp_pass']);                                      // Masukkan Password dari Email tsb
        $default_email_from         = trim($config_smtp['primarymail']);         // Masukkan default from pada email
        $default_email_from_name    = '';           // Masukkan default nama dari from pada email


        if (empty($from)) $mail->From = $default_email_from;
        else $mail->From = $from;

        if (empty($from_name)) $mail->FromName = $default_email_from_name;
        else $mail->FromName = $from_name;

        // Set penerima email
        if (is_array($to)) {
            foreach ($to as $k => $v) {
                $mail->addAddress($v);
            }
        } else {
            $mail->addAddress($to);
        }

        // Set email CC ( optional )
        if (!empty($cc)) {
            if (is_array($cc)) {
                foreach ($cc as $k => $v) {
                    $mail->addCC($v);
                }
            } else {
                $mail->addCC($cc);
            }
        }

        // Set email BCC ( optional )
        if (!empty($bcc)) {
            if (is_array($bcc)) {
                foreach ($bcc as $k => $v) {
                    $mail->addBCC($v);
                }
            } else {
                $mail->addBCC($bcc);
            }
        }

        // Set isi dari email
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = $message;
        $is_send = $mail->send();
        echo $is_send;

        if (!$is_send) {

            return 1;
        } else
            return 0;
    }


}

