<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

// ===== helpers monospace =====
function padR($s,$w){ $s=(string)$s; $len=strlen($s); return $len<$w ? $s.str_repeat(' ', $w-$len) : substr($s,0,$w); }
function padL($s,$w){ $s=(string)$s; $len=strlen($s); return $len<$w ? str_repeat(' ', $w-$len).$s : substr($s,-$w); }
function wrapLines($s,$w){
    $s=str_replace(array("\r\n","\r"),"\n",$s);
    $out=array();
    foreach(explode("\n",$s) as $ln){
        $ln=trim($ln);
        while(strlen($ln)>$w){ $out[]=substr($ln,0,$w); $ln=substr($ln,$w); }
        $out[]=$ln;
    }
    return $out;
}
// nama (dibatasi kolom) tetapi selalu berakhiran ")"
function bracketNameFit($name,$w){
    $name = trim((string)$name);
    $min  = 2; // "()"
    if ($w <= $min) return str_repeat(')', $w); // fallback
    $maxName = $w - 2;
    if (strlen($name) > $maxName) $name = substr($name, 0, $maxName);
    $s = '('.$name.')';
    return strlen($s) < $w ? padR($s,$w) : substr($s,0,$w-1).')';
}

$W = isset($company['width']) && (int)$company['width']>0 ? (int)$company['width'] : 132;
$line = str_repeat('-', $W);

// ===== kolom tabel =====
$colNo   = 4;
$colKode = 16;
$colNama = 80;
$colUom  = 6;
$colQty  = 7;
$colNote = $W - ($colNo+$colKode+$colNama+$colUom+$colQty + 6); // +6 untuk pipa & spasi

// ===== header kiri & kanan =====
$hLeft = array_filter(array(
    isset($company['name'])  ? $company['name']  : '',
    isset($company['addr1']) ? $company['addr1'] : '',
    isset($company['addr2']) ? $company['addr2'] : '',
    isset($company['city'])  ? $company['city']  : '',
    (!empty($company['phone']) ? 'Telp: '.$company['phone'] : ''),
    (!empty($company['npwp'])  ? 'NPWP: '.$company['npwp']   : ''),
), function($x){ return trim($x)!=''; });

$hRight = array(
    'No  : '.(isset($hdr['sj_no']) ? $hdr['sj_no'] : ''),
    'Tgl : '.(isset($hdr['sj_date']) ? $hdr['sj_date'] : ''),
    'Customer : '.(isset($customer) ? $customer : ''),
    'Kirim ke : '.(isset($ship_to) ? $ship_to : ''),
    'WH : '.(isset($hdr['wh_loc']) ? $hdr['wh_loc'] : ''),
    'Kendaraan : '.(isset($hdr['vehicle_no']) ? $hdr['vehicle_no'] : ''),
    'Driver    : '.(isset($hdr['driver_name']) ? $hdr['driver_name'] : ''),
    'Printed   : '.date('Y-m-d H:i'),
);
$halft = (int)floor($W/2)-1;

// ===== label & nama tanda tangan =====
$lbl1 = 'Dibuat,';
$lbl2 = 'Disetujui,';
$lbl3 = isset($kn_title) ? $kn_title : 'Mengetahui,';
$lbl4 = 'Penerima,';

$nm1  = isset($req_nm) ? $req_nm : '';
$nm2  = isset($app_nm) ? $app_nm : '';
$nm3  = isset($kn_name) ? $kn_name : '';
$nm4  = ''; // penerima kosong

?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>SURAT JALAN (DOT)</title>
<style>
  @media print {
    @page { size: auto; margin: 5mm; }
    html,body { margin:0; padding:0; }
  }
  body { margin:8px; }
  pre  { font-family: "Courier New", Courier, monospace; font-size: 12px; line-height: 1.1; }
  .title { font-weight:bold; font-size: 15px; } /* sedikit lebih besar */
</style>
</head>
<body onload="window.print()">
<pre><?php
// ===== judul center (pakai span agar bisa lebih besar) =====
$title = 'SURAT JALAN';
$leftPad = (int)floor(($W - strlen($title)) / 2);
echo str_repeat(' ', max(0,$leftPad)).'<span class="title">'.$title.'</span>'."\n\n";

// ===== header kiri/kanan =====
$maxLines = max(count($hLeft), count($hRight));
for($i=0;$i<$maxLines;$i++){
    $L = isset($hLeft[$i])  ? $hLeft[$i]  : '';
    $R = isset($hRight[$i]) ? $hRight[$i] : '';
    echo padR($L, $halft).' '.padR($R, $W-$halft-1)."\n";
}
echo "\n";

// ===== table header =====
echo $line."\n";
echo '| '.padR('No', $colNo).' | '
        .padR('Kode', $colKode).' | '
        .padR('Nama Barang', $colNama).' | '
        .padR('UOM', $colUom).' | '
        .padL('Qty', $colQty).' | '
        .padR('Catatan', $colNote).' |'."\n";
echo $line."\n";

// ===== table rows =====
$no=1;
foreach($dtl as $d){
    $kode  = isset($d->nodok) ? $d->nodok : '';
    $nama  = isset($d->nmbarang) ? $d->nmbarang : '';
    $uom   = isset($d->uom) ? $d->uom : '';
    $qty   = isset($d->qty) ? $d->qty : 0;
    $note  = isset($d->note) ? $d->note : '';

    $wrapNama = wrapLines($nama, $colNama);
    $wrapNote = wrapLines($note, $colNote);
    $rows = max(count($wrapNama), count($wrapNote));
    for($r=0;$r<$rows;$r++){
        echo '| ';
        echo padR($r==0 ? $no : '', $colNo).' | ';
        echo padR($r==0 ? $kode : '', $colKode).' | ';
        echo padR(isset($wrapNama[$r]) ? $wrapNama[$r] : '', $colNama).' | ';
        echo padR($r==0 ? $uom : '', $colUom).' | ';
        echo padL($r==0 ? number_format($qty,0,'.',',') : '', $colQty).' | ';
        echo padR(isset($wrapNote[$r]) ? $wrapNote[$r] : '', $colNote).' |'."\n";
    }
    $no++;
}
echo $line."\n\n";

// ===== area tanda tangan: 4 kolom =====
$C = (int)floor(($W-3)/4); // 3 spasi antar-kolom

$rowLbl = padR($lbl1,$C).' '.padR($lbl2,$C).' '.padR($lbl3,$C).' '.padR($lbl4,$C);
echo $rowLbl."\n\n\n\n";

// nama dipastikan tertutup ")"
$nmRow = bracketNameFit($nm1,$C).' '.bracketNameFit($nm2,$C).' '.bracketNameFit($nm3,$C).' '.bracketNameFit('..................',$C);
echo $nmRow."\n";

?></pre>
</body>
</html>
