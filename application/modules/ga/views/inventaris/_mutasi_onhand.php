<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>
  .table-sm th,.table-sm td{padding:6px 8px!important}
  .text-right{text-align:right}.text-center{text-align:center}
</style>

<div class="table-responsive">
  <table class="table table-bordered table-striped table-sm">
    <thead>
      <tr>
        <th style="width:50px" class="text-center">No</th>
        <th style="width:130px">Tanggal</th>
        <th style="width:80px">Tipe</th>
        <th style="width:120px">Ref No</th>
        <th style="width:90px">WH Loc</th>
        <th style="width:90px">Rack/Bin</th>
        <th style="width:60px">UOM</th>
        <th class="text-right" style="width:90px">Good In</th>
        <th class="text-right" style="width:90px">Good Out</th>
        <th class="text-right" style="width:90px">Reject In</th>
        <th class="text-right" style="width:90px">Reject Out</th>
        <th>Catatan</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($rows)): $no=0; $tg=$tgo=$tr=$tro=0; ?>
        <?php foreach($rows as $r): $no++;
          $tg  += (float)$r->qty_good_in;
          $tgo += (float)$r->qty_good_out;
          $tr  += (float)$r->qty_rej_in;
          $tro += (float)$r->qty_rej_out;
        ?>
        <tr>
          <td class="text-center"><?=$no?></td>
          <td><?=htmlspecialchars(date('Y-m-d H:i', strtotime($r->trans_date)))?></td>
          <td><?=htmlspecialchars($r->trans_type)?></td>
          <td><?=htmlspecialchars($r->ref_no)?></td>
          <td><?=htmlspecialchars($r->wh_loc)?></td>
          <td><?=htmlspecialchars($r->rack_bin)?></td>
          <td><?=htmlspecialchars($r->uom)?></td>
          <td class="text-right"><?=number_format((float)$r->qty_good_in)?></td>
          <td class="text-right"><?=number_format((float)$r->qty_good_out)?></td>
          <td class="text-right"><?=number_format((float)$r->qty_rej_in)?></td>
          <td class="text-right"><?=number_format((float)$r->qty_rej_out)?></td>
          <td><?=htmlspecialchars($r->note)?></td>
        </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="12" class="text-center text-muted">Tidak ada mutasi.</td></tr>
      <?php endif; ?>
    </tbody>
    <?php if (!empty($rows)): ?>
    <tfoot>
      <tr>
        <th colspan="7" class="text-right">TOTAL</th>
        <th class="text-right"><?=number_format($tg)?></th>
        <th class="text-right"><?=number_format($tgo)?></th>
        <th class="text-right"><?=number_format($tr)?></th>
        <th class="text-right"><?=number_format($tro)?></th>
        <th></th>
      </tr>
    </tfoot>
    <?php endif; ?>
  </table>
</div>
