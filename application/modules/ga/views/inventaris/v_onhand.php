<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
  .modal-backdrop{opacity:.45!important}
  .nowrap{white-space:nowrap}
  .table td,.table th{vertical-align:middle!important}
</style>

<div class="pull-right">Versi: <?=htmlspecialchars($version)?></div>
<legend><?=htmlspecialchars($title)?></legend>

<div class="box">
  <div class="box-header"><h4 class="box-title">Filter</h4></div>
  <div class="box-body">
    <form method="post" class="form-inline">
      <!-- Kode stok -->
      <div class="form-group" style="min-width:340px;margin-right:18px">
        <label style="margin-right:8px">Kode Stock (NODOK)</label>
        <select name="f_nodok" class="form-control input-sm" style="min-width:240px">
          <option value="">-- semua --</option>
          <?php foreach ($list_barang as $b): 
            $opt_nodok = trim($b->nodok);
            $opt_nm    = trim($b->nmbarang);
            $sel = ($f_nodok === $opt_nodok) ? 'selected' : '';
          ?>
            <option value="<?=htmlspecialchars($opt_nodok)?>" <?=$sel?>>
              <?=htmlspecialchars($opt_nodok)?> — <?=htmlspecialchars($opt_nm)?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- WH Loc -->
      <div class="form-group" style="margin-right:18px">
        <label style="margin-right:8px">WH Loc</label>
        <input type="text" name="f_wh_loc" value="<?=htmlspecialchars($f_wh_loc)?>" class="form-control input-sm" style="width:200px">
      </div>

      <!-- Periode -->
      <div class="form-group">
        <label style="margin-right:8px">Periode</label>
        <input type="date" name="f_dfrom" value="<?=htmlspecialchars($f_dfrom)?>" class="form-control input-sm">
        <span> s/d </span>
        <input type="date" name="f_dto" value="<?=htmlspecialchars($f_dto)?>" class="form-control input-sm">
      </div>

      <button type="submit" class="btn btn-primary btn-sm" style="margin-left:18px">Terapkan</button>
    </form>
  </div>
</div>

<div class="box">
  <div class="box-header"><h4 class="box-title">Stok On-Hand & Reject</h4></div>
  <div class="box-body table-responsive">
    <table id="tbl_onhand" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:55px">No</th>
          <th>Nodok</th>
          <th>WH Loc</th>
          <th class="text-right">On-Hand (Good)</th>
          <th class="text-right">On-Hand (Reject)</th>
          <th style="width:110px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php
          if (!empty($rows)) {
            $no = 0;
            foreach ($rows as $r) {
              $no++;
              $nodok = isset($r->nodok) ? $r->nodok : '';
              $wh    = isset($r->wh_loc) ? $r->wh_loc : '';
              $og    = isset($r->onhand_good)   ? (float)$r->onhand_good   : 0;
              $orj   = isset($r->onhand_reject) ? (float)$r->onhand_reject : 0;
        ?>
          <tr>
            <td class="text-center"><?=$no?></td>
            <td><?=htmlspecialchars($nodok)?></td>
            <td><?=htmlspecialchars($wh)?></td>
            <td class="text-right"><?=number_format($og)?></td>
            <td class="text-right"><?=number_format($orj)?></td>
            <td class="nowrap">
              <a href="#" class="btn btn-info btn-xs btn-detail"
                 data-nodok="<?=htmlspecialchars($nodok)?>"
                 data-wh="<?=htmlspecialchars($wh)?>">
                <i class="fa fa-search"></i> Detail
              </a>
            </td>
          </tr>
        <?php
            }
          }
        ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalDetail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:96%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">
          Mutasi Stok — <span id="md-nodok"></span> @ <span id="md-wh"></span>
        </h4>
      </div>
      <div class="modal-body" id="md-body">
        <div class="text-center" style="padding:12px">Memuat...</div>
      </div>
    </div>
  </div>
</div>

<script>
(function($){
  $(function(){

    // Inisialisasi DataTables — TANPA baris placeholder di tbody
    if ($.fn.dataTable) {
      $('#tbl_onhand').DataTable({
        language: { emptyTable: "Tidak ada data." },
        columnDefs: [{ orderable:false, targets:[5] }]
      });
    }

    // Detail mutasi (modal)
    $(document).on('click','.btn-detail', function(e){
      e.preventDefault();
      var nodok = $(this).data('nodok');
      var wh    = $(this).data('wh');

      $('#md-nodok').text(nodok || '');
      $('#md-wh').text(wh || '');
      $('#md-body').html('<div class="text-center" style="padding:12px">Memuat...</div>');
      $('#modalDetail').modal('show');

      $.ajax({
        url: '<?=site_url('ga/inventaris/onhand_detail')?>',
        type: 'POST',
        data: {
          nodok: nodok,
          wh_loc: wh,
          dfrom: '<?=htmlspecialchars($f_dfrom)?>',
          dto:   '<?=htmlspecialchars($f_dto)?>'
        },
        success: function(html){ $('#md-body').html(html); },
        error:   function(){ $('#md-body').html('<div class="alert alert-danger">Gagal memuat data.</div>'); }
      });
    });

  });
})(jQuery);
</script>
