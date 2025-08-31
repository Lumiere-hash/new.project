<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php $isApprover = (trim($this->session->userdata('nik'))===trim($hdr['approver1_nik'])); ?>

<div class="row">
  <div class="col-sm-6">
    <table class="table table-condensed">
      <tr><th>SJ No</th><td><?=htmlspecialchars($hdr['sj_no'])?></td></tr>
      <tr><th>Tanggal</th><td><?=htmlspecialchars($hdr['sj_date'])?></td></tr>
      <tr><th>Customer</th><td><?=htmlspecialchars($hdr['customer_nm'])?></td></tr>
      <tr><th>Kirim ke</th><td><?=htmlspecialchars($hdr['ship_to'])?></td></tr>
      <tr><th>WH Loc</th><td><?=htmlspecialchars($hdr['wh_loc'])?></td></tr>
      <tr><th>Status</th><td><?=htmlspecialchars($hdr['status'])?></td></tr>
    </table>
  </div>
  <div class="col-sm-6">
    <table class="table table-condensed">
      <tr><th>Kendaraan</th><td><?=htmlspecialchars($hdr['vehicle_no'])?></td></tr>
      <tr><th>Driver</th><td><?=htmlspecialchars($hdr['driver_name'])?></td></tr>
      <tr><th>Requested by</th><td><?=htmlspecialchars($hdr['requested_nik'])?></td></tr>
      <tr><th>Approver</th><td><?=htmlspecialchars($hdr['approver1_nik'])?></td></tr>
      <tr><th>Catatan</th><td><?=htmlspecialchars($hdr['remark'])?></td></tr>
    </table>
  </div>
</div>

<h4>Detail Barang</h4>
<table class="table table-bordered table-striped">
  <thead>
    <tr><th>No</th><th>Kode</th><th>Nama</th><th>UOM</th><th class="text-right">Qty</th><th>Rack</th><th>Note</th></tr>
  </thead>
  <tbody>
    <?php $no=0; foreach($dtl as $d): $no++; ?>
    <tr>
      <td class="text-center"><?=$no?></td>
      <td><?=htmlspecialchars($d->nodok)?></td>
      <td><?=htmlspecialchars($d->nmbarang)?></td>
      <td><?=htmlspecialchars($d->uom)?></td>
      <td class="text-right"><?=number_format($d->qty)?></td>
      <td><?=htmlspecialchars($d->rack_bin)?></td>
      <td><?=htmlspecialchars($d->note)?></td>
    </tr>
    <?php endforeach;?>
  </tbody>
</table>

<?php if ($hdr['status']=='SUBMITTED' && $isApprover): ?>
<hr>
<form class="form-inline" method="post" action="<?=site_url('ga/inventaris/sj_approve')?>" style="display:inline">
  <input type="hidden" name="sj_id" value="<?=$hdr['sj_id']?>">
  <input type="text" name="note" class="form-control input-sm" placeholder="catatan approve" style="min-width:260px">
  <button class="btn btn-success btn-sm">Approve</button>
</form>

<form class="form-inline" method="post" action="<?=site_url('ga/inventaris/sj_reject')?>" style="display:inline;margin-left:10px">
  <input type="hidden" name="sj_id" value="<?=$hdr['sj_id']?>">
  <input type="text" name="note" class="form-control input-sm" placeholder="alasan reject" style="min-width:260px">
  <button class="btn btn-danger btn-sm">Reject</button>
</form>
<?php else: ?>
<div class="alert alert-info">Approval hanya oleh: <b><?=htmlspecialchars($hdr['approver1_nik'])?></b></div>
<?php endif; ?>
