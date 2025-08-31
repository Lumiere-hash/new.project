<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<?php
// $hdr   : array header RCV (lihat controller rcv_detail())
// $dtl   : array of objects detail RCV
// $rcv_no: string (opsional untuk judul)
$hdr = is_array($hdr) ? $hdr : array();
?>

<div class="row">
  <div class="col-sm-6">
    <table class="table table-condensed">
      <tr><th style="width:140px">RCV No</th><td><?=htmlspecialchars($hdr['rcv_no'])?></td></tr>
      <tr><th>Tanggal</th><td><?=htmlspecialchars($hdr['rcv_date'])?></td></tr>
      <tr><th>Supplier</th><td><?=htmlspecialchars($hdr['supplier'])?></td></tr>
      <tr><th>WH Loc</th><td><?=htmlspecialchars($hdr['wh_loc'])?></td></tr>
      <tr><th>Keterangan</th><td><?=htmlspecialchars($hdr['remark'])?></td></tr>
    </table>
  </div>
  <div class="col-sm-6">
    <table class="table table-condensed">
      <tr><th style="width:140px">Container</th><td><?=htmlspecialchars($hdr['container_no'])?></td></tr>
      <tr><th>Seal</th><td><?=htmlspecialchars($hdr['seal_no'])?></td></tr>
      <tr><th>BL</th><td><?=htmlspecialchars($hdr['bl_no'])?></td></tr>
      <tr><th>Vessel/Voy</th><td><?=htmlspecialchars($hdr['vessel']).' / '.htmlspecialchars($hdr['voyage'])?></td></tr>
      <tr><th>ETA / ATA</th><td><?=htmlspecialchars($hdr['eta']).' / '.htmlspecialchars($hdr['ata'])?></td></tr>
    </table>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:45px">Line</th>
        <th>Kode</th>
        <th>Nama</th>
        <th style="width:70px">UOM</th>
        <th class="text-right" style="width:90px">Good</th>
        <th class="text-right" style="width:90px">Reject</th>
        <th>Lot</th>
        <th style="width:110px">MFG</th>
        <th style="width:110px">EXP</th>
        <th>Rack/Bin</th>
        <th>Keterangan</th>
      </tr>
    </thead>
    <tbody>
      <?php
        $total_g = 0; $total_r = 0; $i=0;
        foreach($dtl as $r):
          $i++;
          $g = (float)$r->qty_good;
          $t = (float)$r->qty_reject;
          $total_g += $g; $total_r += $t;
      ?>
      <tr>
        <td class="text-center"><?=$i?></td>
        <td><?=htmlspecialchars($r->nodok)?></td>
        <td><?=htmlspecialchars($r->nmbarang)?></td>
        <td><?=htmlspecialchars($r->uom)?></td>
        <td class="text-right"><?=number_format($g)?></td>
        <td class="text-right"><?=number_format($t)?></td>
        <td><?=htmlspecialchars($r->lot_no)?></td>
        <td><?=htmlspecialchars($r->mfg_date)?></td>
        <td><?=htmlspecialchars($r->exp_date)?></td>
        <td><?=htmlspecialchars($r->rack_bin)?></td>
        <td><?=htmlspecialchars($r->remark)?></td>
      </tr>
      <?php endforeach; if(!$dtl){ ?>
      <tr><td colspan="11" class="text-center text-muted">Tidak ada detail.</td></tr>
      <?php } ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="4" class="text-right">TOTAL</th>
        <th class="text-right"><?=number_format($total_g)?></th>
        <th class="text-right"><?=number_format($total_r)?></th>
        <th colspan="5"></th>
      </tr>
    </tfoot>
  </table>
</div>
