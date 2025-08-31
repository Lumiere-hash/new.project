<?php /* v_mstbarang.php */ ?>
<link rel="stylesheet" href="<?php echo base_url('assets/css/datepicker.css');?>" type="text/css"/>

<div class="pull-right">Versi: <?php echo isset($version)?$version:''; ?></div>
<legend><?php echo isset($title)?$title:'FORM MASTER BARANG'; ?></legend>
<?php if (!empty($message)) echo $message; ?>

<div class="row">
  <div class="col-sm-3">
    <div class="dropdown">
      <button class="btn btn-primary dropdown-toggle" style="margin:10px;color:#fff;" data-toggle="dropdown">
        Menu Input <span class="caret"></span>
      </button>
      <ul class="dropdown-menu">
        <li><a data-toggle="modal" data-target="#mdlAdd" href="#">Tambah Master Barang</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="row">
<div class="col-sm-12">
  <div class="nav-tabs-custom">
    <ul class="nav nav-tabs"><li class="active"><a href="#tab_1" data-toggle="tab">Master Barang</a></li></ul>
  </div>

  <div class="tab-content">
    <div class="chart tab-pane active" id="tab_1">
      <div class="row">
        <div class="col-xs-12">
          <div class="box">
            <div class="box-header">
              <legend><?php echo isset($title)?$title:'FORM MASTER BARANG'; ?></legend>
              <?php if(!empty($message)) echo $message; ?>
            </div>
            <div class="box-body table-responsive" style="overflow-x:auto;">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th style="width:50px;">No.</th>
                  <th>Kode (NODOK)</th>
                  <th>Nama Barang</th>
                  <th>Group</th>
                  <th>Subgroup</th>
                  <th>Type</th>
                  <th>Main Color</th>
                  <th>Satuan Dasar</th>
                  <th>Hold</th>
                  <th>Keterangan</th>
                  <th style="width:160px;">Aksi</th>
                </tr>
                </thead>
                <tbody>
                <?php $no=0; if(!empty($list_mstbarang)) foreach($list_mstbarang as $row): $no++; ?>
                  <?php
                    $nodok      = trim($row->nodok);
                    $nmbarang   = isset($row->nmbarang)?trim($row->nmbarang):'';
                    $kdgroup    = isset($row->kdgroup)?trim($row->kdgroup):'';
                    $kdsubgroup = isset($row->kdsubgroup)?trim($row->kdsubgroup):'';
                    $kdtype     = isset($row->kdtype)?trim($row->kdtype):'';
                    $kdcolor    = isset($row->kdcolor)?trim($row->kdcolor):'';
                    $satkecil   = isset($row->satkecil)?trim($row->satkecil):'';
                    $hold_item  = isset($row->hold_item)?trim($row->hold_item):'';
                    $keterangan = isset($row->keterangan)?trim($row->keterangan):'';
                    $rid        = preg_replace('/[^A-Za-z0-9]/','',$nodok); // id unik modal
                  ?>
                  <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo htmlspecialchars($nodok); ?></td>
                    <td><?php echo htmlspecialchars($nmbarang); ?></td>
                    <td><?php echo htmlspecialchars($kdgroup); ?></td>
                    <td><?php echo htmlspecialchars($kdsubgroup); ?></td>
                    <td><?php echo htmlspecialchars($kdtype); ?></td>
                    <td><?php echo htmlspecialchars($kdcolor); ?></td>
                    <td><?php echo htmlspecialchars($satkecil); ?></td>
                    <td><?php echo htmlspecialchars($hold_item); ?></td>
                    <td><?php echo htmlspecialchars($keterangan); ?></td>
                    <td>
                      <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#mdlEdit<?php echo $rid;?>"><i class="fa fa-edit"></i> Edit</button>
                      <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#mdlDel<?php echo $rid;?>"><i class="fa fa-trash"></i> Hapus</button>
                    </td>
                  </tr>

                  <!-- MODAL EDIT -->
                  <div class="modal fade" id="mdlEdit<?php echo $rid;?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog modal-lg">
                      <form class="modal-content" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                          <h4 class="modal-title">Ubah Master Barang</h4>
                        </div>
                        <div class="modal-body">
                          <input type="hidden" name="type" value="EDIT">
                          <input type="hidden" name="nodok" value="<?php echo htmlspecialchars($nodok); ?>">
                          <input type="hidden" name="kdgroup" value="<?php echo htmlspecialchars($kdgroup); ?>">
                          <input type="hidden" name="kdsubgroup" value="<?php echo htmlspecialchars($kdsubgroup); ?>">
                          <input type="hidden" name="kdtype" value="<?php echo htmlspecialchars($kdtype); ?>">
                          <input type="hidden" name="kdcolor_current" value="<?php echo htmlspecialchars($kdcolor); ?>">

                          <div class="row">
                            <div class="col-sm-6">
                              <div class="form-group">
                                <label>Nama Barang</label>
                                <input type="text" name="nmbarang" class="form-control input-sm" value="<?php echo htmlspecialchars($nmbarang);?>" style="text-transform:uppercase" required>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label>Hold Item</label>
                                <select name="hold_item" class="form-control input-sm">
                                  <option value="NO"  <?php echo ($hold_item=='NO')?'selected':''; ?>>TIDAK</option>
                                  <option value="YES" <?php echo ($hold_item=='YES')?'selected':''; ?>>YA</option>
                                </select>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label>Satuan Dasar Barang</label>
                                <select name="satkecil" class="form-control input-sm">
                                  <option value="">---PILIH SATUAN DASAR BARANG--</option>
                                  <?php if(!empty($list_satuan)) foreach($list_satuan as $sc): ?>
                                    <option value="<?php echo trim($sc->kdtrx);?>" <?php echo ($satkecil==trim($sc->kdtrx))?'selected':''; ?>>
                                      <?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?>
                                    </option>
                                  <?php endforeach;?>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="row">
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label>Group</label>
                                <input type="text" class="form-control input-sm" value="<?php echo htmlspecialchars($kdgroup);?>" readonly>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label>Subgroup</label>
                                <input type="text" class="form-control input-sm" value="<?php echo htmlspecialchars($kdsubgroup);?>" readonly>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label>Type</label>
                                <input type="text" class="form-control input-sm" value="<?php echo htmlspecialchars($kdtype);?>" readonly>
                              </div>
                            </div>
                            <div class="col-sm-3">
                              <div class="form-group">
                                <label>Main Color</label>
                                <select class="form-control input-sm" name="kdcolor" id="edt_kdcolor_<?php echo $rid;?>">
                                  <option value="">memuat...</option>
                                </select>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <label>Keterangan</label>
                            <input type="text" name="keterangan" class="form-control input-sm" value="<?php echo htmlspecialchars($keterangan);?>" maxlength="159">
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Simpan</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
                        </div>
                      </form>
                    </div>
                  </div>

                  <!-- MODAL DELETE -->
                  <div class="modal fade" id="mdlDel<?php echo $rid;?>" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                      <form class="modal-content" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                          <h4 class="modal-title">Hapus Master Barang</h4>
                        </div>
                        <div class="modal-body">
                          <p>Hapus data barang <strong><?php echo htmlspecialchars($nodok.' — '.$nmbarang);?></strong> ?</p>
                          <input type="hidden" name="type" value="HAPUS">
                          <input type="hidden" name="nodok" value="<?php echo htmlspecialchars($nodok);?>">
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-danger">Hapus</button>
                          <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                        </div>
                      </form>
                    </div>
                  </div>
                <?php endforeach; ?>
                </tbody>
              </table>
            </div><!-- /.box-body -->
          </div><!-- /.box -->
        </div>
      </div>
    </div>
  </div>
</div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="mdlAdd" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" action="<?php echo site_url('ga/inventaris/input_mstbarang');?>" method="post">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">Tambah Master Barang</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="type" value="INPUT">

        <!-- NODOK auto -->
        <input type="hidden" name="nodok" id="nodok">
        <div class="form-group">
          <label>Kode Barang (otomatis)</label>
          <input type="text" id="nodok_view" class="form-control input-sm" placeholder="Akan tergenerate otomatis" readonly>
          <small class="text-muted">Format: KDGROUP-KDSUBGROUP-KDTYPE-KDCOLOR-SATUAN</small>
        </div>

        <div class="row">
          <div class="col-sm-6">
            <div class="form-group">
              <label>Nama Barang</label>
              <input type="text" class="form-control input-sm" name="nmbarang" id="nmbarang" style="text-transform:uppercase" required>
            </div>
          </div>
          <div class="col-sm-6">
            <div class="form-group">
              <label>SATUAN DASAR BARANG</label>
              <select class="form-control input-sm satkecil" name="satkecil" id="satkecil" required>
                <option value="">---PILIH SATUAN DASAR BARANG--</option>
                <?php if(!empty($list_satuan)) foreach($list_satuan as $sc){ ?>
                  <option value="<?php echo trim($sc->kdtrx);?>"><?php echo trim($sc->uraian).' || '.trim($sc->kdtrx);?></option>
                <?php } ?>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class='col-sm-3'>
            <div class="form-group">
              <label>Kode Group</label>
              <select class="form-control input-sm" name="kdgroup" id="kdgroup" required>
                <option value="">-- pilih --</option>
                <?php if(!empty($list_scgroup)) foreach($list_scgroup as $g): ?>
                  <option value="<?php echo trim($g->kdgroup);?>"><?php echo trim($g->kdgroup).' — '.trim($g->nmgroup);?></option>
                <?php endforeach;?>
              </select>
            </div>
          </div>
          <div class='col-sm-3'>
            <div class="form-group">
              <label>Kode Subgroup</label>
              <select class="form-control input-sm" name="kdsubgroup" id="kdsubgroup" required>
                <option value="">-- pilih GROUP dulu --</option>
              </select>
            </div>
          </div>
          <div class='col-sm-3'>
            <div class="form-group">
              <label>Kode Type</label>
              <select class="form-control input-sm" name="kdtype" id="kdtype" required>
                <option value="">-- pilih SUBGROUP dulu --</option>
              </select>
            </div>
          </div>
          <div class='col-sm-3'>
            <div class="form-group">
              <label>Main Color</label>
              <select class="form-control input-sm" name="kdcolor" id="kdcolor">
                <option value="">-- pilih TYPE dulu --</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class='col-sm-3'>
            <div class="form-group">
              <label>Hold Item</label>
              <select class="form-control input-sm" name="hold_item" id="hold_item">
                <option value="NO">TIDAK</option>
                <option value="YES">YA</option>
              </select>
            </div>
          </div>
          <div class='col-sm-9'>
            <div class="form-group">
              <label>Keterangan</label>
              <input type="text" class="form-control input-sm" name="keterangan" maxlength="159">
            </div>
          </div>
        </div>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </form>
  </div>
</div>

<style>
  /* Pastikan modal tampil solid, tidak transparan */
  .modal-content{
    background:#fff !important;
    border:0;
    border-radius:6px;
    box-shadow:0 20px 60px rgba(0,0,0,.35);
  }
  .modal-header,
  .modal-body,
  .modal-footer{
    background:#fff !important;
  }

  /* Backdrop gelap & berada di bawah modal */
  .modal-backdrop{ 
    background:#000;
    z-index:1040; /* backdrop di bawah modal */
  }
  .modal-backdrop.in,
  .modal-backdrop.show{
    opacity:.5 !important; /* gelapkan background */
    filter:alpha(opacity=50);
  }

  /* Modal di atas semua konten AdminLTE */
  .modal{ z-index:1060; }
  .modal-dialog{ margin-top:80px; } /* opsional: turunkan sedikit dari topbar */

  /* Jika pakai select2/selectize di dalam modal, jangan sampai tertutup */
  .select2-container,
  .selectize-dropdown{
    z-index: 1070; /* di atas modal-content */
  }
</style>


<script type="text/javascript">
$(function(){
  $("#example1").dataTable();

  // CSRF sederhana (sesuai pola Type Anda)
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

  // generator NODOK dengan strip
  function genNodok(){
    var g = ($('#kdgroup').val()||'').toUpperCase().trim();
    var s = ($('#kdsubgroup').val()||'').toUpperCase().trim();
    var t = ($('#kdtype').val()||'').toUpperCase().trim();
    var c = ($('#kdcolor').val()||'').toUpperCase().trim();
    var u = ($('#satkecil').val()||'').toUpperCase().trim(); // satuan dasar

    var ok   = g && s && t && c && u;
    var code = ok ? [g, s, t, c, u].join('-') : '';

    $('#nodok').val(code);
    $('#nodok_view').val(code);
  }

  // ADD: Group -> Subgroup
  $('#kdgroup').on('change', function(){
    var kdgroup = $(this).val();
    var $sub = $('#kdsubgroup'), $typ = $('#kdtype'), $col = $('#kdcolor');
    $sub.html('<option value="">memuat...</option>');
    $typ.html('<option value="">-- pilih SUBGROUP dulu --</option>');
    $col.html('<option value="">-- pilih TYPE dulu --</option>');
    genNodok();

    if(!kdgroup){ $sub.html('<option value="">-- pilih GROUP dulu --</option>'); return; }

    var data = { kdgroup: kdgroup }; data[csrfName] = csrfHash;
    $.post('<?php echo site_url('ga/inventaris/ajax_subgroup_by_group'); ?>', data, function(res){
      $sub.empty().append('<option value="">-- pilih --</option>');
      $.each(res, function(_, r){ $sub.append($('<option/>',{value:r.kdsubgroup,text:r.kdsubgroup+' — '+r.nmsubgroup})); });
    }, 'json').fail(function(){ $sub.html('<option value="">(gagal memuat)</option>'); });
  });

  // ADD: Subgroup -> Type
  $('#kdsubgroup').on('change', function(){
    var kdgroup=$('#kdgroup').val(), kdsubgroup=$(this).val();
    var $typ=$('#kdtype'), $col=$('#kdcolor');
    $typ.html('<option value="">memuat...</option>');
    $col.html('<option value="">-- pilih TYPE dulu --</option>');
    genNodok();

    if(!kdgroup || !kdsubgroup){ $typ.html('<option value="">-- pilih SUBGROUP dulu --</option>'); return; }

    var data={ kdgroup: kdgroup, kdsubgroup: kdsubgroup }; data[csrfName]=csrfHash;
    $.post('<?php echo site_url('ga/inventaris/ajax_type_by_subgroup'); ?>', data, function(res){
      $typ.empty().append('<option value="">-- pilih --</option>');
      $.each(res, function(_, r){ $typ.append($('<option/>',{value:r.kdtype,text:r.kdtype+' — '+r.nmtype})); });
    }, 'json').fail(function(){ $typ.html('<option value="">(gagal memuat)</option>'); });
  });

  // ADD: Type -> Main Color
  $('#kdtype').on('change', function(){
    var kdgroup=$('#kdgroup').val(), kdsubgroup=$('#kdsubgroup').val(), kdtype=$(this).val();
    var $col=$('#kdcolor'); $col.html('<option value="">memuat...</option>'); genNodok();

    if(!kdgroup || !kdsubgroup || !kdtype){ $col.html('<option value="">-- pilih TYPE dulu --</option>'); return; }

    var data={ kdgroup: kdgroup, kdsubgroup: kdsubgroup, kdtype: kdtype }; data[csrfName]=csrfHash;
    $.post('<?php echo site_url('ga/inventaris/ajax_color_by_type'); ?>', data, function(res){
      $col.empty().append('<option value="">-- pilih --</option>');
      $.each(res, function(_, r){ $col.append($('<option/>',{value:r.kdcolor,text:r.kdcolor+' — '+r.nmcolor})); });
    }, 'json').fail(function(){ $col.html('<option value="">(gagal memuat)</option>'); });
  });

  // ADD: generate nodok saat pilih color & satuan
  $('#kdcolor, #satkecil').on('change', genNodok);

  // EDIT: load color list saat modal dibuka
  $('div[id^="mdlEdit"]').on('shown.bs.modal', function () {
    var $m   = $(this);
    var $sel = $m.find('select[id^="edt_kdcolor_"]');
    var kdgroup    = $m.find('input[name="kdgroup"]').val();
    var kdsubgroup = $m.find('input[name="kdsubgroup"]').val();
    var kdtype     = $m.find('input[name="kdtype"]').val();
    var selected   = $m.find('input[name="kdcolor_current"]').val();

    $sel.html('<option value="">memuat...</option>');
    var data = { kdgroup: kdgroup, kdsubgroup: kdsubgroup, kdtype: kdtype }; data[csrfName]=csrfHash;

    $.post('<?php echo site_url('ga/inventaris/ajax_color_by_type'); ?>', data, function(res){
      $sel.empty().append('<option value="">-- pilih --</option>');
      $.each(res, function(_, r){ $sel.append($('<option/>',{value:r.kdcolor,text:r.kdcolor+' — '+r.nmcolor})); });
      if (selected){ $sel.val(selected); }
    }, 'json').fail(function(){ $sel.html('<option value="">(gagal memuat)</option>'); });
  });
});
</script>
