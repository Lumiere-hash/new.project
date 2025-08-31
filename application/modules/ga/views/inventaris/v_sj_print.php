<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<!DOCTYPE html><html><head>
<meta charset="utf-8"><title><?=$title?></title>
<style>
 body{font-family:sans-serif;font-size:12px}
 table{border-collapse:collapse;width:100%}
 th,td{border:1px solid #000;padding:5px}
 .noborder th,.noborder td{border:none}
</style>
</head><body onload="window.print()">
<h3 style="text-align:center">SURAT JALAN</h3>

<table class="noborder">
<tr><td width="60%">
  <b>No:</b> <?=htmlspecialchars($hdr['sj_no'])?><br>
  <b>Tanggal:</b> <?=htmlspecialchars($hdr['sj_date'])?><br>
  <b>Customer:</b> <?=htmlspecialchars($hdr['customer_nm'])?><br>
  <b>Kirim ke:</b> <?=htmlspecialchars($hdr['ship_to'])?><br>
  <b>WH:</b> <?=htmlspecialchars($hdr['wh_loc'])?>
</td><td>
  <b>Kendaraan:</b> <?=htmlspecialchars($hdr['vehicle_no'])?><br>
  <b>Driver:</b> <?=htmlspecialchars($hdr['driver_name'])?><br>
  <b>Printed:</b> <?=date('Y-m-d H:i')?>
</td></tr></table>

<br>
<table>
  <thead><tr>
    <th style="width:35px">No</th><th>Kode</th><th>Nama Barang</th>
    <th style="width:60px">UOM</th><th style="width:90px">Qty</th><th>Catatan</th>
  </tr></thead>
  <tbody>
    <?php $no=0; foreach($dtl as $d): $no++; ?>
    <tr>
      <td class="text-center"><?=$no?></td>
      <td><?=htmlspecialchars($d->nodok)?></td>
      <td><?=htmlspecialchars($d->nmbarang)?></td>
      <td><?=htmlspecialchars($d->uom)?></td>
      <td style="text-align:right"><?=number_format($d->qty)?></td>
      <td><?=htmlspecialchars($d->note)?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>

<br><br>
<table class="noborder" style="width:100%">
<tr>
  <td style="text-align:center">Dibuat,<br><br><br><br>( <?=$hdr['requested_nik']?> )</td>
  <td style="text-align:center">Disetujui,<br><br><br><br>( <?=$hdr['approver1_nik']?> )</td>
  <td style="text-align:center">Penerima,<br><br><br><br>(....................)</td>
</tr>
</table>
</body></html>
