<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>
<style>.modal-backdrop{opacity:.45!important}.nowrap{white-space:nowrap}</style>

<div class="pull-right">Versi: <?=$version?></div>
<legend><?=$title?></legend>
<?=$message?>

<div class="box">
  <div class="box-header">
    <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAdd">
      + Tambah SJ
    </button>
  </div>
  <div class="box-body table-responsive">
    <table id="tblSJ" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>No</th><th>SJ No</th><th>Tgl</th><th>Customer</th>
          <th>WH</th><th>Status</th><th>Qty</th><th>Approver</th><th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=0; foreach($list_sj as $r): $no++; ?>
        <tr>
          <td class="text-center"><?=$no?></td>
          <td><?=htmlspecialchars($r->sj_no)?></td>
          <td><?=htmlspecialchars($r->sj_date)?></td>
          <td><?=htmlspecialchars($r->customer_nm)?></td>
          <td><?=htmlspecialchars($r->wh_loc)?></td>
          <td><span class="label label-<?=($r->status=='APPROVED'?'success':($r->status=='REJECTED'?'danger':($r->status=='CANCELLED'?'default':'warning')))?>">
            <?=htmlspecialchars($r->status)?></span></td>
          <td class="text-right"><?=number_format((float)$r->total_qty)?></td>
          <td><?=htmlspecialchars($r->approver1_nik)?></td>
          <td class="nowrap">
            <a href="#" class="btn btn-info btn-xs btn-detail"
               data-id="<?=$r->sj_id?>"><i class="fa fa-search"></i> Detail</a>
            <?php if ($r->status!=='APPROVED'): ?>
              <form action="<?=site_url('ga/inventaris/sj_delete')?>" method="post" style="display:inline" onsubmit="return confirm('Hapus SJ?')">
                <input type="hidden" name="sj_id" value="<?=$r->sj_id?>">
                <button class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</button>
              </form>
            <?php else: ?>
              <a class="btn btn-primary btn-xs" target="_blank"
                 href="<?=site_url('ga/inventaris/sj_print/'.bin2hex($this->encrypt->encode($r->sj_id)))?>">
                 <i class="fa fa-print"></i> Cetak</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- MODAL ADD -->
<div class="modal fade" id="mdlAdd" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
  <form method="post" action="<?=site_url('ga/inventaris/input_sj')?>">
  <div class="modal-header"><button class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Tambah Surat Jalan</h4></div>
  <div class="modal-body">
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group"><label>Tanggal</label>
          <input type="date" name="sj_date" class="form-control input-sm" value="<?=date('Y-m-d')?>"></div>
        <div class="form-group"><label>Warehouse (WH Loc)</label>
          <input type="text" name="wh_loc" class="form-control input-sm" ></div>
        <div class="form-group"><label>No Kendaraan</label>
          <input type="text" name="vehicle_no" class="form-control input-sm"></div>
        <div class="form-group"><label>Driver</label>
          <input type="text" name="driver_name" class="form-control input-sm"></div>
      </div>
      <div class="col-sm-8">
        <div class="form-group"><label>Customer</label>
          <input type="text" name="customer_nm" class="form-control input-sm" required></div>
        <div class="form-group"><label>Alamat Kirim</label>
          <input type="text" name="ship_to" class="form-control input-sm"></div>
        <div class="form-group"><label>Keterangan</label>
          <input type="text" name="remark" class="form-control input-sm"></div>
      </div>
    </div>

    <hr>
    <h4>Detail Barang</h4>
    <table class="table table-bordered" id="tblDtl">
      <thead>
        <tr>
          <th style="width:28%">Kode Stock</th>
          <th>Nama</th><th style="width:80px">UOM</th>
          <th style="width:100px">OnHand</th>
          <th style="width:100px">Qty</th>
          <th>Rack</th><th>Note</th><th style="width:40px"></th>
        </tr>
      </thead>
      <tbody></tbody>
    </table>
    <button type="button" id="btnAddRow" class="btn btn-default btn-xs"><i class="fa fa-plus"></i> Baris</button>
  </div>
  <div class="modal-footer">
    <button class="btn btn-primary">Simpan & Submit</button>
    <button class="btn btn-default" data-dismiss="modal">Tutup</button>
  </div>
  </form>
</div></div></div>

<!-- MODAL DETAIL / APPROVAL -->
<div class="modal fade" id="mdlDetail" tabindex="-1"><div class="modal-dialog modal-lg"><div class="modal-content">
  <div class="modal-header"><button class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Detail SJ</h4></div>
  <div class="modal-body" id="detailBody">Memuat...</div>
</div></div></div>

<script>
(function($){
  $(function(){
    $('#tblSJ').dataTable();

    // add row
    $('#btnAddRow').on('click', function(){
      var row = `
       <tr>
        <td>
          <select name="nodok[]" class="form-control input-sm nodok">
            <option value="">-- pilih --</option>
            <?php foreach($list_barang as $b):?>
              <option value="<?=trim($b->nodok)?>"><?=trim($b->nodok)?> — <?=htmlspecialchars($b->nmbarang)?></option>
            <?php endforeach;?>
          </select>
        </td>
        <td><input name="nmbarang[]" class="form-control input-sm nm" readonly></td>
        <td><input name="uom[]" class="form-control input-sm uom" value="PCS"></td>
        <td><input class="form-control input-sm oh" value="0" readonly></td>
        <td><input name="qty[]" class="form-control input-sm qty" value="0"></td>
        <td><input name="rack_bin[]" class="form-control input-sm"></td>
        <td><input name="note[]" class="form-control input-sm"></td>
        <td><button type="button" class="btn btn-danger btn-xs delrow"><i class="fa fa-trash"></i></button></td>
       </tr>`;
      $('#tblDtl tbody').append(row);
    });

    // delete row
    $(document).on('click','.delrow', function(){ $(this).closest('tr').remove(); });

    // auto fill nm & onhand
    $(document).on('change','.nodok', function(){
      var $tr  = $(this).closest('tr');
      var code = $(this).val();
      // set nama dari text option
      var nm = $(this).find('option:selected').text().split('—').slice(1).join('—').trim();
      $tr.find('.nm').val(nm);
      // hit WH dari form
      var wh = $('[name=wh_loc]').val();
      $.post('<?=site_url('ga/inventaris/ajax_onhand_item')?>',{nodok:code,wh_loc:wh}, function(r){
        $tr.find('.oh').val(r.good || 0);
      }, 'json');
    });

    // detail
    $(document).on('click','.btn-detail', function(e){
      e.preventDefault();
      var id = $(this).data('id');
      $('#detailBody').html('Memuat...');
      $('#mdlDetail').modal('show');
      $.post('<?=site_url('ga/inventaris/_sj_detail')?>', {sj_id:id}, function(html){
        $('#detailBody').html(html);
      });
    });
  });
})(jQuery);
</script>
