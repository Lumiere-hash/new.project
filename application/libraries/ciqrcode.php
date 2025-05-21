<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ciqrcode
{
    private $CI;

    public function __construct()
    {
        $this->CI =& get_instance();
    }

    public function generateqr($data, $directory, $size)
    {
        require_once 'phpqrcode/qrlib.php';

        if (!file_exists($directory))
            mkdir($directory);

        $generatedqr = $directory . $data . '-qr.png';
        QRcode::png($data, $generatedqr, QR_ECLEVEL_H, $size);

        return $generatedqr;
    }

    public function generatebase64qr($data)
    {
        require_once 'phpqrcode/qrlib.php';

        $pngAbsoluteFilePath = tempnam(sys_get_temp_dir(), 'qrcode');
        QRcode::png($data['string'], $pngAbsoluteFilePath, QR_ECLEVEL_H, $data['size'], 0);

        $QR = file_get_contents($pngAbsoluteFilePath);
        unlink($pngAbsoluteFilePath);

        $QR = base64_encode($QR);

        return $QR;
    }
}