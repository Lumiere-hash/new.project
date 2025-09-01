<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
  .modal-backdrop { opacity:.45 !important; }
  .modal-content  { background:#fff; }
  .nowrap{ white-space:nowrap; }
  .table td input.form-control{ height:28px; padding:3px 6px; }
  .table td .form-control[readonly]{ background:#f7f7f7; }
</style>

<div class="pull-right">Versi: <?=htmlspecialchars($version)?></div>
<legend><?=htmlspecialchars($title)?></legend>

<?php if(!empty($message)) echo $message; ?>

<div class="box">
  <div class="box-header">
    <button class="btn btn-primary btn-sm" id="btnAddSJ">
      <i class="fa fa-plus"></i> Tambah SJ
    </button>
  </div>

  <div class="box-body table-responsive">
    <table id="tbl_sj" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:55px">No</th>
          <th style="width:120px">SJ No</th>
          <th style="width:95px">Tgl</th>
          <th>Customer</th>
          <th style="width:120px">WH</th>
          <th style="width:110px">Status</th>
          <th style="width:80px" class="text-right">Qty</th>
          <th style="width:120px">Approver</th>
          <th style="width:210px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=0; $me = trim($this->session->userdata('nik')); ?>
        <?php foreach($list_sj as $r): $no++; ?>
        <tr>
          <td class="text-center"><?=$no?></td>
          <td><?=htmlspecialchars($r->sj_no)?></td>
          <td><?=htmlspecialchars($r->sj_date)?></td>
          <td><?=htmlspecialchars($r->customer_nm)?></td>
          <td><?=htmlspecialchars($r->wh_loc)?></td>
          <td>
            <?php if($r->status==='APPROVED'): ?>
              <span class="label label-success">APPROVED</span>
            <?php elseif($r->status==='REJECTED'): ?>
              <span class="label label-warning">REJECTED</span>
            <?php else: ?>
              <span class="label label-default">SUBMITTED</span>
            <?php endif; ?>
          </td>
          <td class="text-right">
  <?= number_format( isset($r->qty_total) ? (float)$r->qty_total : 0 ) ?>
</td>
          <td><?=htmlspecialchars(trim($r->approver1_nik))?></td>
          <td class="nowrap">
            <a href="#" class="btn btn-info btn-xs btn-detail" data-id="<?=$r->sj_id?>">
              <i class="fa fa-search"></i> Detail
            </a>

            <?php if ($r->status==='SUBMITTED' && trim($r->approver1_nik)===$me): ?>
              <button class="btn btn-success btn-xs btn-appr" data-id="<?=$r->sj_id?>">
                <i class="fa fa-check"></i> Approve
              </button>
              <button class="btn btn-warning btn-xs btn-rej" data-id="<?=$r->sj_id?>">
                <i class="fa fa-times"></i> Reject
              </button>
            <?php endif; ?>

            <?php if ($r->status!=='APPROVED'): ?>
              <button class="btn btn-danger btn-xs btn-del" data-id="<?=$r->sj_id?>">
                <i class="fa fa-trash"></i> Hapus
              </button>
           <?php else:
  $sid = bin2hex($this->encrypt->encode($r->sj_id)); ?>
  <!-- <a target="_blank" class="btn btn-default btn-xs" href="<?=site_url('ga/inventaris/sj_print/'.$sid)?>">
    <i class="fa fa-print"></i> Print
  </a> -->
  <a target="_blank" class="btn btn-default btn-xs" href="<?=site_url('ga/inventaris/sj_print_dot/'.$sid)?>">
    <i class="fa fa-print"></i> Print (Dot)
  </a>
<?php endif; ?>

          </td>
        </tr>
        <?php endforeach; if(empty($list_sj)){ ?>
          <tr><td colspan="9" class="text-center text-muted">Belum ada data.</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- ================== MODAL: TAMBAH SJ ================== -->
<div class="modal fade" id="mdlSJ" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:96%;">
    <div class="modal-content">
      <form method="post" action="<?=site_url('ga/inventaris/input_sj')?>" id="frmSJ">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Surat Jalan</h4>
      </div>

      <div class="modal-body">
        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Tanggal</label>
              <input type="date" name="sj_date" class="form-control" value="<?=date('Y-m-d')?>" required>
            </div>
            <div class="form-group">
              <label>Warehouse (WH Loc)</label>
              <input type="text" name="wh_loc" id="wh_loc" class="form-control" required>
            </div>
            <div class="form-group">
              <label>No Kendaraan</label>
              <input type="text" name="vehicle_no" class="form-control">
            </div>
            <div class="form-group">
              <label>Driver</label>
              <input type="text" name="driver_name" class="form-control">
            </div>
          </div>

          <div class="col-sm-6">
            <div class="form-group">
              <label>Customer</label>
              <input type="text" name="customer_nm" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Alamat Kirim</label>
              <input type="text" name="ship_to" class="form-control" required>
            </div>
            <div class="form-group">
              <label>Keterangan</label>
              <input type="text" name="remark" class="form-control">
            </div>
          </div>
        </div>

        <hr>
        <h4>Detail Barang</h4>
        <div class="table-responsive">
          <table class="table table-bordered" id="tbl_dtl">
            <thead>
              <tr>
                <th style="width:260px">Kode Stock</th>
                <th>Nama</th>
                <th style="width:90px">UOM</th>
                <th style="width:90px">OnHand</th>
                <th style="width:90px">Qty</th>
                <th style="width:110px">Rack</th>
                <th style="width:160px">Note</th>
                <th style="width:42px"></th>
              </tr>
            </thead>
            <tbody></tbody>
          </table>
        </div>
        <button type="button" class="btn btn-default btn-sm" id="btnAddRow">
          <i class="fa fa-plus"></i> Baris
        </button>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">
          Simpan & Submit
        </button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- ============== MODAL: DETAIL SJ ============== -->
<div class="modal fade" id="mdlDetail" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:96%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Detail SJ</h4>
      </div>
      <div class="modal-body" id="detailBody">
        <div class="text-center">Memuat...</div>
      </div>
    </div>
  </div>
</div>

<script>
(function($){
  var barangOptions = `<?php
    // option dengan data-nm & data-uom untuk autofill
    $out = [];
    foreach ($list_barang as $b) {
      $nodok = htmlspecialchars(trim($b->nodok));
      $nm    = htmlspecialchars(trim($b->nmbarang));
      $uom   = htmlspecialchars(trim($b->satkecil));
      $out[] = "<option value=\"{$nodok}\" data-nm=\"{$nm}\" data-uom=\"{$uom}\">{$nodok} — {$nm}</option>";
    }
    echo implode("", $out);
  ?>`;

  function addRow(){
    var tr = $(
      '<tr>\
        <td>\
          <select name="nodok[]" class="form-control sel-nodok" required>\
            <option value="">-- pilih --</option>'+barangOptions+'\
          </select>\
        </td>\
        <td><input name="nmbarang[]" class="form-control nm" readonly></td>\
        <td style="width:90px"><input name="uom[]" class="form-control uom" readonly></td>\
        <td style="width:90px"><input class="form-control onhand text-right" readonly value="0"></td>\
        <td style="width:90px"><input name="qty[]" class="form-control text-right qty" type="number" min="0" step="1" required></td>\
        <td style="width:110px"><input name="rack_bin[]" class="form-control"></td>\
        <td style="width:160px"><input name="note[]" class="form-control"></td>\
        <td class="text-center"><button type="button" class="btn btn-danger btn-xs btn-delrow"><i class="fa fa-trash"></i></button></td>\
      </tr>'
    );
    $('#tbl_dtl tbody').append(tr);
  }

  function fetchOnhand(tr){
    var nodok = tr.find('.sel-nodok').val();
    var wh    = $('#wh_loc').val();
    if (!nodok || !wh){ tr.find('.onhand').val('0'); return; }
    $.post('<?=site_url('ga/inventaris/ajax_onhand_item')?>',
      {nodok:nodok, wh_loc:wh},
      function(o){
        var g = (o && typeof o.good !== 'undefined') ? o.good : 0;
        tr.find('.onhand').val(g);
      }, 'json'
    ).fail(function(){
      tr.find('.onhand').val('0');
    });
  }

  $(function(){
    if ($.fn.dataTable) $('#tbl_sj').dataTable();

    // open modal add
    $('#btnAddSJ').on('click', function(){
      $('#tbl_dtl tbody').empty();
      addRow();
      $('#mdlSJ').modal('show');
    });

    // add row
    $('#btnAddRow').on('click', function(){ addRow(); });

    // delete row
    $(document).on('click','.btn-delrow', function(){ $(this).closest('tr').remove(); });

    // fill nm & uom, then get onhand
    $(document).on('change','.sel-nodok', function(){
      var tr = $(this).closest('tr');
      var opt = $(this).find('option:selected');
      tr.find('.nm').val(opt.data('nm')||'');
      tr.find('.uom').val(opt.data('uom')||'');
      fetchOnhand(tr);
    });

    // refresh onhand when WH changed
    $('#wh_loc').on('change keyup', function(){
      $('#tbl_dtl tbody tr').each(function(){ fetchOnhand($(this)); });
    });

    // DETAIL
    $(document).on('click','.btn-detail', function(e){
      e.preventDefault();
      var id = $(this).data('id');
      $('#detailBody').html('<div class="text-center">Memuat...</div>');
      $('#mdlDetail').modal('show');
      $.post('<?=site_url('ga/inventaris/sj_detail')?>', {sj_id:id}, function(html){
        $('#detailBody').html(html);
      }).fail(function(){
        $('#detailBody').html('<div class="alert alert-danger">Gagal memuat data.</div>');
      });
    });

    // APPROVE
    $(document).on('click','.btn-appr', function(e){
      e.preventDefault();
      if(!confirm('Approve SJ ini?')) return;
      $.post('<?=site_url('ga/inventaris/sj_approve')?>', {sj_id:$(this).data('id'), note:''}, function(){
        location.reload();
      }).fail(function(){ alert('Gagal approve'); });
    });

    // REJECT
    $(document).on('click','.btn-rej', function(e){
      e.preventDefault();
      var note = prompt('Alasan reject (opsional):','');
      $.post('<?=site_url('ga/inventaris/sj_reject')?>', {sj_id:$(this).data('id'), note:note||''}, function(){
        location.reload();
      }).fail(function(){ alert('Gagal reject'); });
    });

    // DELETE
    $(document).on('click','.btn-del', function(e){
      e.preventDefault();
      if(!confirm('Hapus SJ ini?')) return;
      $.post('<?=site_url('ga/inventaris/sj_delete')?>', {sj_id:$(this).data('id')}, function(){
        location.reload();
      }).fail(function(){ alert('Gagal menghapus'); });
    });

    // validasi on submit (qty <= onhand)
    $('#frmSJ').on('submit', function(){
      var ok = true;
      $('#tbl_dtl tbody tr').each(function(){
        var onh = parseFloat($(this).find('.onhand').val()||'0');
        var qty = parseFloat($(this).find('.qty').val()||'0');
        if (qty>onh){
          alert('Qty melebihi On-Hand untuk item '+$(this).find('.sel-nodok').val());
          ok=false; return false;
        }
      });
      return ok;
    });
  });
})(jQuery);
</script>
