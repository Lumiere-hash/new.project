<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
  .modal-backdrop { opacity:.45 !important; }
  .nowrap { white-space:nowrap; }
</style>

<div class="pull-right">Versi: <?=htmlspecialchars($version)?></div>
<legend><?=htmlspecialchars($title)?></legend>

<?php if (!empty($message)) echo $message; ?>

<div class="box">
  <div class="box-header">
    <button class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalAdd">
      + Tambah SJ
    </button>
  </div>

  <div class="box-body table-responsive">
    <table id="tbl_sj" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:55px">No</th>
          <th>SJ No</th>
          <th>Tgl</th>
          <th>Customer</th>
          <th>WH</th>
          <th>Status</th>
          <th class="text-right">Qty</th>
          <th>Approver</th>
          <th style="width:140px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=0; foreach ($list_sj as $r): $no++; ?>
        <tr>
          <td class="text-center"><?=$no?></td>
          <td><?=htmlspecialchars($r->sj_no)?></td>
          <td><?=htmlspecialchars($r->sj_date)?></td>
          <td><?=htmlspecialchars($r->customer_nm)?></td>
          <td><?=htmlspecialchars($r->wh_loc)?></td>
          <td>
            <?php
              $st = trim($r->status);
              $cls = ($st==='APPROVED'?'label-success':($st==='REJECTED'?'label-danger':'label-warning'));
            ?>
            <span class="label <?=$cls?>"><?=htmlspecialchars($st)?></span>
          </td>
          <td class="text-right"><?=number_format((float)$r->total_qty)?></td>
          <td><?=htmlspecialchars($r->approver1_nik)?></td>
          <td class="nowrap">
            <a href="#" class="btn btn-info btn-xs btn-sj-detail"
               data-id="<?=$r->sj_id?>">
              <i class="fa fa-search"></i> Detail
            </a>

            <?php if (trim($r->status) !== 'APPROVED'): ?>
              <form method="post" action="<?=site_url('ga/inventaris/sj_delete')?>" style="display:inline"
                    onsubmit="return confirm('Hapus SJ ini?');">
                <input type="hidden" name="sj_id" value="<?=$r->sj_id?>">
                <button type="submit" class="btn btn-danger btn-xs">
                  <i class="fa fa-trash"></i> Hapus
                </button>
              </form>
            <?php else: ?>
              <a target="_blank"
                 href="<?=site_url('ga/inventaris/sj_print/'.bin2hex($this->encrypt->encode($r->sj_id)))?>"
                 class="btn btn-default btn-xs">
                 <i class="fa fa-print"></i> Cetak
              </a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; if (!$list_sj){ ?>
          <tr><td colspan="9" class="text-center text-muted">Tidak ada data.</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalSjDetail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:96%">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail SJ</h4>
      </div>
      <div class="modal-body" id="sj-detail-body">
        <div class="text-center">Memuat...</div>
      </div>
    </div>
  </div>
</div>

<!-- (opsional) MODAL TAMBAH – jika kamu sudah punya, biarkan saja -->
<div class="modal fade" id="modalAdd" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:96%">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Surat Jalan</h4>
      </div>
      <div class="modal-body">
        <!-- form tambah SJ kamu di sini -->
        <div class="text-muted">Form tambah SJ …</div>
      </div>
    </div>
  </div>
</div>

<script>
(function($){
  $(function(){
    if ($.fn.dataTable) $('#tbl_sj').dataTable();

    // tombol DETAIL
    $(document).on('click', '.btn-sj-detail', function(e){
      e.preventDefault();
      var id = $(this).data('id');

      $('#sj-detail-body').html('<div class="text-center">Memuat...</div>');
      $('#modalSjDetail').modal('show');

      $.ajax({
        url: '<?=site_url('ga/inventaris/sj_detail')?>', // <- endpoint publik
        type: 'POST',
        data: { sj_id: id },
        success: function(html){
          $('#sj-detail-body').html(html);
        },
        error: function(){
          $('#sj-detail-body').html('<div class="alert alert-danger">Gagal memuat data.</div>');
        }
      });
    });
  });
})(jQuery);
</script>
