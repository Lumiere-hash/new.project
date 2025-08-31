<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
  .modal-backdrop { opacity:.45 !important; }
  .modal-content  { background:#fff; }
  .nowrap { white-space:nowrap; }
</style>

<div class="pull-right">Versi: <?=htmlspecialchars($version)?></div>
<legend><?=htmlspecialchars($title)?></legend>

<div class="box">
  <div class="box-header"><h4 class="box-title">Filter</h4></div>
  <div class="box-body">
    <form method="post" class="form-inline">
      <div class="form-group" style="min-width:340px">
        <label style="margin-right:8px">Kode Stock (NODOK)</label>
        <select name="f_nodok" class="form-control input-sm" style="min-width:240px">
          <option value="">-- semua --</option>
          <?php foreach($list_barang as $b): ?>
          <option value="<?=trim($b->nodok)?>" <?=($f_nodok==trim($b->nodok)?'selected':'')?>>
            <?=trim($b->nodok).' — '.trim($b->nmbarang)?>
          </option>
          <?php endforeach;?>
        </select>
      </div>

      <div class="form-group" style="margin-left:20px">
        <label style="margin-right:8px">WH Loc</label>
        <input type="text" name="f_wh_loc" value="<?=htmlspecialchars($f_wh_loc)?>" class="form-control input-sm" style="width:200px">
      </div>

      <div class="form-group" style="margin-left:20px">
        <label style="margin-right:8px">Periode</label>
        <input type="date" name="f_dfrom" value="<?=htmlspecialchars($f_dfrom)?>" class="form-control input-sm">
        <span> s/d </span>
        <input type="date" name="f_dto" value="<?=htmlspecialchars($f_dto)?>" class="form-control input-sm">
      </div>

      <button type="submit" class="btn btn-primary btn-sm" style="margin-left:20px">Terapkan</button>
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
        <?php $no=0; foreach($rows as $r): $no++; ?>
        <tr>
          <td class="text-center"><?=$no?></td>
          <td><?=htmlspecialchars($r->nodok)?></td>
          <td><?=htmlspecialchars($r->wh_loc)?></td>
          <td class="text-right"><?=number_format((float)$r->onhand_good)?></td>
          <td class="text-right"><?=number_format((float)$r->onhand_reject)?></td>
          <td class="nowrap">
            <a href="#" class="btn btn-info btn-xs btn-detail"
               data-nodok="<?=htmlspecialchars(trim($r->nodok))?>"
               data-wh="<?=htmlspecialchars(trim($r->wh_loc))?>">
              <i class="fa fa-search"></i> Detail
            </a>
          </td>
        </tr>
        <?php endforeach; if(!$rows){ ?>
        <tr><td colspan="6" class="text-center text-muted">Tidak ada data.</td></tr>
        <?php } ?>
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
        <div class="text-center p-3">Memuat...</div>
      </div>
    </div>
  </div>
</div>

<script>
(function($){
  $(function(){
    if ($.fn.dataTable) $('#tbl_onhand').dataTable();

    // buka modal detail + load partial
    $(document).on('click','.btn-detail',function(e){
      e.preventDefault();
      var nodok = $(this).data('nodok');
      var wh    = $(this).data('wh');

      $('#md-nodok').text(nodok);
      $('#md-wh').text(wh);
      $('#md-body').html('<div class="text-center p-3">Memuat...</div>');
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
        error: function(){ $('#md-body').html('<div class="alert alert-danger">Gagal memuat data.</div>'); }
      });
    });
  });
})(jQuery);
</script>
