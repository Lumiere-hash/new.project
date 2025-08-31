<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php if (!$hdr) { ?>
  <div class="alert alert-warning">Data tidak ditemukan.</div>
<?php } else { ?>

<div class="row">
  <div class="col-sm-6">
    <table class="table table-condensed">
      <tr><th style="width:140px">No SJ</th><td><?=htmlspecialchars($hdr['sj_no'])?></td></tr>
      <tr><th>Tanggal</th><td><?=htmlspecialchars($hdr['sj_date'])?></td></tr>
      <tr><th>Status</th><td><?=htmlspecialchars($hdr['status'])?></td></tr>
      <tr><th>Warehouse</th><td><?=htmlspecialchars($hdr['wh_loc'])?></td></tr>
      <tr><th>Customer</th><td><?=htmlspecialchars($hdr['customer_nm'])?></td></tr>
      <tr><th>Alamat Kirim</th><td><?=htmlspecialchars($hdr['ship_to'])?></td></tr>
    </table>
  </div>
  <div class="col-sm-6">
    <table class="table table-condensed">
      <tr><th style="width:140px">No Kendaraan</th><td><?=htmlspecialchars($hdr['vehicle_no'])?></td></tr>
      <tr><th>Driver</th><td><?=htmlspecialchars($hdr['driver_name'])?></td></tr>
      <tr><th>Requester</th><td><?=htmlspecialchars($hdr['requested_nik'])?></td></tr>
      <tr><th>Approver</th><td><?=htmlspecialchars($hdr['approver1_nik'])?></td></tr>
      <tr><th>Keterangan</th><td><?=htmlspecialchars($hdr['remark'])?></td></tr>
    </table>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:55px">No</th>
        <th>Kode Stock (Nodok)</th>
        <th>Nama</th>
        <th>UOM</th>
        <th class="text-right">Qty</th>
        <th>Rack/Bin</th>
        <th>Note</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=0; foreach($dtl as $d): $i++; ?>
      <tr>
        <td class="text-center"><?=$i?></td>
        <td><?=htmlspecialchars($d->nodok)?></td>
        <td><?=htmlspecialchars($d->nmbarang)?></td>
        <td><?=htmlspecialchars($d->uom)?></td>
        <td class="text-right"><?=number_format((float)$d->qty)?></td>
        <td><?=htmlspecialchars($d->rack_bin)?></td>
        <td><?=htmlspecialchars($d->note)?></td>
      </tr>
      <?php endforeach; if ($i==0){ ?>
        <tr><td colspan="7" class="text-center text-muted">Tidak ada detail.</td></tr>
      <?php } ?>
    </tbody>
  </table>
</div>

<?php } // endif hdr ?>
