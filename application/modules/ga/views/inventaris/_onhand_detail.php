<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
$good  = isset($opening['good_open']) ? (float)$opening['good_open'] : 0;
$reject= isset($opening['rej_open'])  ? (float)$opening['rej_open']  : 0;
$period = ($dfrom || $dto) ? ( ($dfrom?:'') . ' s/d ' . ($dto?:'') ) : 'Semua';
?>

<div class="row">
  <div class="col-sm-6">
    <table class="table table-condensed">
      <tr><th style="width:140px">Nodok</th><td><?=htmlspecialchars($nodok)?></td></tr>
      <tr><th>WH Loc</th><td><?=htmlspecialchars($wh_loc)?></td></tr>
      <tr><th>Periode</th><td><?=htmlspecialchars($period)?></td></tr>
    </table>
  </div>
  <div class="col-sm-6">
    <table class="table table-condensed">
      <tr><th style="width:140px">Saldo Awal Good</th><td class="text-right"><?=number_format($good)?></td></tr>
      <tr><th>Saldo Awal Reject</th><td class="text-right"><?=number_format($reject)?></td></tr>
    </table>
  </div>
</div>

<div class="table-responsive">
  <table class="table table-bordered table-striped">
    <thead>
      <tr>
        <th style="width:160px">Tanggal</th>
        <th style="width:70px">Jenis</th>
        <th style="width:90px">Ref</th>
        <th>Catatan</th>
        <th style="width:100px" class="text-right">Good In</th>
        <th style="width:100px" class="text-right">Good Out</th>
        <th style="width:100px" class="text-right">Reject In</th>
        <th style="width:100px" class="text-right">Reject Out</th>
        <th style="width:120px" class="text-right">Good Balance</th>
        <th style="width:120px" class="text-right">Reject Balance</th>
      </tr>
    </thead>
    <tbody>
      <tr class="active">
        <td colspan="8" class="text-right"><b>Saldo Awal</b></td>
        <td class="text-right"><b><?=number_format($good)?></b></td>
        <td class="text-right"><b><?=number_format($reject)?></b></td>
      </tr>
      <?php foreach($rows as $r):
        $gi = (float)$r->qty_good_in;
        $go = (float)$r->qty_good_out;
        $ri = (float)$r->qty_rej_in;
        $ro = (float)$r->qty_rej_out;
        $good   = $good   + $gi - $go;
        $reject = $reject + $ri - $ro;
      ?>
      <tr>
        <td><?=htmlspecialchars($r->trans_date)?></td>
        <td><?=htmlspecialchars($r->trans_type)?></td>
        <td><?=htmlspecialchars($r->ref_no)?></td>
        <td><?=htmlspecialchars($r->note)?></td>
        <td class="text-right"><?=number_format($gi)?></td>
        <td class="text-right"><?=number_format($go)?></td>
        <td class="text-right"><?=number_format($ri)?></td>
        <td class="text-right"><?=number_format($ro)?></td>
        <td class="text-right"><?=number_format($good)?></td>
        <td class="text-right"><?=number_format($reject)?></td>
      </tr>
      <?php endforeach; if(!$rows){ ?>
      <tr><td colspan="10" class="text-center text-muted">Tidak ada mutasi pada periode ini.</td></tr>
      <?php } ?>
    </tbody>
  </table>
</div>
