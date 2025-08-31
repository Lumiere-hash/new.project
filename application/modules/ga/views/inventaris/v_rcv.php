<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<style>
  /* bikin modal tidak transparan */
  .modal-backdrop { opacity:.45 !important; }
  .modal-content  { background:#fff; }
  .nowrap { white-space:nowrap; }
  .table tfoot th { font-weight:600; }
</style>

<div class="pull-right">Versi: <?=htmlspecialchars($version)?></div>
<legend><?=htmlspecialchars($title)?></legend>

<?php if (!empty($message)) echo $message; ?>

<div class="row">
  <div class="col-sm-12">
    <button class="btn btn-primary" data-toggle="modal" data-target="#mdlAdd">
      <i class="fa fa-plus"></i> Penerimaan Kontainer
    </button>
  </div>
</div>
<br>

<div class="box">
  <div class="box-header"><h4 class="box-title">Daftar Penerimaan</h4></div>
  <div class="box-body table-responsive">
    <table id="tbl_rcv" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:50px">No</th>
          <th>RCV No</th>
          <th>Tgl</th>
          <th>Supplier</th>
          <th>Container</th>
          <th>Seal</th>
          <th>BL</th>
          <th>Vessel/Voy</th>
          <th>WH Loc</th>
          <th class="text-right">Good</th>
          <th class="text-right">Reject</th>
          <th style="width:140px">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=0; foreach($list_rcv as $r): $no++; ?>
        <tr>
          <td class="text-center"><?=$no?></td>
          <td><?=htmlspecialchars(trim($r->rcv_no))?></td>
          <td><?=htmlspecialchars($r->rcv_date)?></td>
          <td><?=htmlspecialchars($r->supplier)?></td>
          <td><?=htmlspecialchars($r->container_no)?></td>
          <td><?=htmlspecialchars($r->seal_no)?></td>
          <td><?=htmlspecialchars($r->bl_no)?></td>
          <td><?=htmlspecialchars($r->vessel).' / '.htmlspecialchars($r->voyage)?></td>
          <td><?=htmlspecialchars($r->wh_loc)?></td>
          <td class="text-right"><?=number_format((float)$r->total_good)?></td>
          <td class="text-right"><?=number_format((float)$r->total_reject)?></td>
          <td class="nowrap">
            <a href="#" class="btn btn-info btn-xs btn-rcv-detail"
               data-rcv-id="<?= (int)$r->rcv_id ?>"
               data-rcv-no="<?= htmlspecialchars(trim($r->rcv_no)) ?>">
               <i class="fa fa-search"></i> Detail
            </a>
            <a href="#" class="btn btn-danger btn-xs btn-rcv-del"
               data-rcv-id="<?= (int)$r->rcv_id ?>">
               <i class="fa fa-trash"></i> Hapus
            </a>
          </td>
        </tr>
        <?php endforeach; if(!$list_rcv){ ?>
        <tr><td colspan="12" class="text-center text-muted">Belum ada penerimaan.</td></tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<!-- =======================================
     MODAL TAMBAH PENERIMAAN
     ======================================= -->
<div class="modal fade" id="mdlAdd" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:96%;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Tambah Penerimaan (Kontainer)</h4>
      </div>
      <form action="<?=site_url('ga/inventaris/input_rcv')?>" method="post" id="frm-rcv">
      <div class="modal-body">

        <!-- HEADER -->
        <div class="row">
          <div class="col-sm-3">
            <div class="form-group">
              <label>RCV No (opsional)</label>
              <input type="text" name="rcv_no" class="form-control input-sm" placeholder="Kosongkan untuk auto-generate">
            </div>
          </div>
          <div class="col-sm-3">
            <div class="form-group">
              <label>Tanggal</label>
              <input type="date" name="rcv_date" class="form-control input-sm" value="<?=date('Y-m-d')?>">
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>Supplier</label>
              <input type="text" name="supplier" class="form-control input-sm" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            <div class="form-group">
              <label>Container No</label>
              <input type="text" name="container_no" class="form-control input-sm" required>
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Seal No</label>
              <input type="text" name="seal_no" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>BL No</label>
              <input type="text" name="bl_no" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Vessel</label>
              <input type="text" name="vessel" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Voyage</label>
              <input type="text" name="voyage" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>WH Loc</label>
              <input type="text" name="wh_loc" class="form-control input-sm" required>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-2">
            <div class="form-group">
              <label>ETA</label>
              <input type="date" name="eta" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>ATA</label>
              <input type="date" name="ata" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Port From</label>
              <input type="text" name="port_from" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Port To</label>
              <input type="text" name="port_to" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>No Truck</label>
              <input type="text" name="truck_no" class="form-control input-sm">
            </div>
          </div>
          <div class="col-sm-2">
            <div class="form-group">
              <label>Driver</label>
              <input type="text" name="driver_name" class="form-control input-sm">
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Keterangan</label>
          <input type="text" name="remark" class="form-control input-sm">
        </div>

        <hr>

        <!-- DETAIL -->
        <div class="row">
          <div class="col-sm-12">
            <h4 style="margin-top:0">Detail Barang</h4>
            <div class="text-right" style="margin-bottom:8px">
              <button type="button" id="btnAddRow" class="btn btn-success btn-xs">
                <i class="fa fa-plus"></i> Tambah Baris
              </button>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered table-striped" id="tbl_dtl">
                <thead>
                  <tr>
                    <th style="width:45px">#</th>
                    <th style="min-width:210px">Kode Stock (NODOK)</th>
                    <th style="min-width:220px">Nama</th>
                    <th style="width:70px">UOM</th>
                    <th style="width:90px" class="text-right">Good</th>
                    <th style="width:90px" class="text-right">Reject</th>
                    <th style="min-width:120px">Lot No</th>
                    <th style="width:110px">MFG</th>
                    <th style="width:110px">EXP</th>
                    <th style="min-width:110px">Rack/Bin</th>
                    <th style="min-width:160px">Ket/Reject</th>
                    <th style="width:60px">Aksi</th>
                  </tr>
                </thead>
                <tbody><!-- baris akan ditambah via JS --></tbody>
              </table>
            </div>
          </div>
        </div>

      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Simpan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="modalRcv" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" style="width:96%;">
    <div class="modal-content">
      <div class="modal-header">
        <button class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="modalRcvTitle">Detail RCV</h4>
      </div>
      <div class="modal-body" id="modalRcvBody">
        Memuat...
      </div>
    </div>
  </div>
</div>

<form id="frm-del" method="post" action="<?=site_url('ga/inventaris/rcv_delete')?>" style="display:none">
  <input type="hidden" name="rcv_id" id="del_rcv_id">
</form>

<script>
(function($){
  $(function(){
    if ($.fn.dataTable) $('#tbl_rcv').dataTable();

    // ===== master barang untuk auto-fill nama & uom =====
    var BARANG = {
      <?php foreach($list_barang as $b): 
            $key = trim($b->nodok);
            $nm  = isset($b->nmbarang) ? trim($b->nmbarang) : '';
            $uom = isset($b->satkecil) ? trim($b->satkecil) : (isset($b->uom)?trim($b->uom):'');
      ?>
      "<?=addslashes($key)?>": {nm:"<?=addslashes($nm)?>", uom:"<?=addslashes($uom)?>"},
      <?php endforeach; ?>
    };

    function rowTemplate(idx){
      var opt = '<option value="">-- pilih --</option>';
      <?php foreach($list_barang as $b): ?>
        opt += '<option value="<?=trim($b->nodok)?>"><?=trim($b->nodok)?> — <?=htmlspecialchars(trim($b->nmbarang))?></option>';
      <?php endforeach; ?>

      return ''+
      '<tr>'+
        '<td class="text-center no">'+idx+'</td>'+
        '<td><select name="nodok[]" class="form-control input-sm sel-nodok">'+opt+'</select></td>'+
        '<td><input type="text" name="nmbarang[]" class="form-control input-sm nmbarang" readonly></td>'+
        '<td><input type="text" name="uom[]" class="form-control input-sm uom" style="width:70px" readonly></td>'+
        '<td><input type="number" step="1" min="0" name="qty_good[]" class="form-control input-sm text-right" value="0"></td>'+
        '<td><input type="number" step="1" min="0" name="qty_reject[]" class="form-control input-sm text-right" value="0"></td>'+
        '<td><input type="text" name="lot_no[]" class="form-control input-sm"></td>'+
        '<td><input type="date" name="mfg_date[]" class="form-control input-sm"></td>'+
        '<td><input type="date" name="exp_date[]" class="form-control input-sm"></td>'+
        '<td><input type="text" name="rack_bin[]" class="form-control input-sm"></td>'+
        '<td><input type="text" name="reject_note[]" class="form-control input-sm"></td>'+
        '<td class="text-center"><button type="button" class="btn btn-danger btn-xs btn-del-row"><i class="fa fa-trash"></i></button></td>'+
      '</tr>';
    }

    function renumber(){
      $('#tbl_dtl tbody tr').each(function(i){
        $(this).find('td.no').text(i+1);
      });
    }

    $('#btnAddRow').on('click', function(){
      var idx = $('#tbl_dtl tbody tr').length + 1;
      $('#tbl_dtl tbody').append(rowTemplate(idx));
    });

    $(document).on('click','.btn-del-row', function(){
      $(this).closest('tr').remove();
      renumber();
    });

    // auto-fill nama & uom saat pilih nodok
    $(document).on('change','.sel-nodok',function(){
      var code = ($(this).val() || '').trim();
      var $tr  = $(this).closest('tr');
      if (BARANG[code]){
        $tr.find('.nmbarang').val(BARANG[code].nm);
        $tr.find('.uom').val(BARANG[code].uom);
      } else {
        $tr.find('.nmbarang').val('');
        $tr.find('.uom').val('');
      }
    });

    // tombol DETAIL
    $(document).on('click','.btn-rcv-detail',function(e){
      e.preventDefault();
      var id = $(this).data('rcv-id');
      var no = $(this).data('rcv-no') || '';
      $('#modalRcvTitle').text('Detail RCV: ' + no);
      $('#modalRcvBody').html('Memuat...');
      $('#modalRcv').modal('show');

      $.post('<?=site_url('ga/inventaris/rcv_detail')?>', { rcv_id:id, rcv_no:no })
        .done(function(html){ $('#modalRcvBody').html(html); })
        .fail(function(){ $('#modalRcvBody').html('<div class="alert alert-danger">Gagal memuat detail.</div>'); });
    });

    // tombol HAPUS
    $(document).on('click','.btn-rcv-del',function(e){
      e.preventDefault();
      var id = $(this).data('rcv-id');
      if (!confirm('Hapus data RCV ini?')) return;
      $('#del_rcv_id').val(id);
      $('#frm-del').submit();
    });

    // default: siapkan 1 baris detail
    $('#btnAddRow').trigger('click');
  });
})(jQuery);
</script>
