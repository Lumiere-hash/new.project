<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
  .table td, .table th { padding:6px; }
  .small { font-size:12px; color:#666; }
  tfoot th { font-weight:600; }
</style>

<?php
$H = isset($hdr) && is_array($hdr) ? $hdr : array();
function h($s){ return htmlspecialchars($s, ENT_QUOTES, 'UTF-8'); }
$rcv_no = isset($rcv_no) ? $rcv_no : (isset($H['rcv_no']) ? $H['rcv_no'] : '');
?>

<div class="row">
  <div class="col-sm-6">
    <table class="table table-bordered">
      <tr><th style="width:120px">RCV No</th><td><?= h($rcv_no) ?></td></tr>
      <tr><th>Tanggal</th><td><?= h(isset($H['rcv_date'])?$H['rcv_date']:'') ?></td></tr>
      <tr><th>Supplier</th><td><?= h(isset($H['supplier'])?$H['supplier']:'') ?></td></tr>
      <tr><th>WH Loc</th><td><?= h(isset($H['wh_loc'])?$H['wh_loc']:'') ?></td></tr>
      <tr><th>Keterangan</th><td><?= h(isset($H['remark'])?$H['remark']:'') ?></td></tr>
    </table>
  </div>
  <div class="col-sm-6">
    <table class="table table-bordered">
      <tr><th style="width:120px">Container</th><td><?= h(isset($H['container_no'])?$H['container_no']:'') ?></td></tr>
      <tr><th>Seal</th><td><?= h(isset($H['seal_no'])?$H['seal_no']:'') ?></td></tr>
      <tr><th>BL</th><td><?= h(isset($H['bl_no'])?$H['bl_no']:'') ?></td></tr>
      <tr><th>Vessel/Voy</th><td><?= h(isset($H['vessel'])?$H['vessel']:'') ?> / <?= h(isset($H['voyage'])?$H['voyage']:'') ?></td></tr>
      <tr><th>ETA / ATA</th><td><?= h(isset($H['eta'])?$H['eta']:'') ?> / <?= h(isset($H['ata'])?$H['ata']:'') ?></td></tr>
    </table>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:50px">Line</th>
        <th style="width:130px">Kode</th>
        <th>Nama</th>
        <th style="width:80px">UOM</th>
        <th class="text-right" style="width:90px">Good</th>
        <th class="text-right" style="width:90px">Reject</th>
        <th style="width:120px">Lot</th>
        <th style="width:100px">MFG</th>
        <th style="width:100px">EXP</th>
        <th style="width:120px">Rack/Bin</th>
        <th style="min-width:160px">Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $n=0; $tg=0; $tr=0;
      if (!empty($dtl)) {
        foreach($dtl as $d){
          $n++;
          $g = isset($d->qty_good)? (float)$d->qty_good : 0;
          $r = isset($d->qty_reject)? (float)$d->qty_reject : 0;
          $tg += $g; $tr += $r;
      ?>
      <tr>
        <td class="text-center"><?= $n ?></td>
        <td><?= h(isset($d->nodok)?$d->nodok:'') ?></td>
        <td><?= h(isset($d->nmbarang)?$d->nmbarang:'') ?></td>
        <td><?= h(isset($d->uom)?$d->uom:'') ?></td>
        <td class="text-right"><?= number_format($g) ?></td>
        <td class="text-right"><?= number_format($r) ?></td>
        <td><?= h(isset($d->lot_no)?$d->lot_no:'') ?></td>
        <td><?= h(isset($d->mfg_date)?$d->mfg_date:'') ?></td>
        <td><?= h(isset($d->exp_date)?$d->exp_date:'') ?></td>
        <td><?= h(isset($d->rack_bin)?$d->rack_bin:'') ?></td>
        <td><?= h(isset($d->remark)?$d->remark:'') ?></td>
      </tr>
      <?php }} else { ?>
      <tr><td colspan="11" class="text-center small">Tidak ada detail.</td></tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="4" class="text-right">TOTAL</th>
        <th class="text-right"><?= number_format(isset($tg)?$tg:0) ?></th>
        <th class="text-right"><?= number_format(isset($tr)?$tr:0) ?></th>
        <th colspan="5"></th>
      </tr>
    </tfoot>
  </table>
</div>
