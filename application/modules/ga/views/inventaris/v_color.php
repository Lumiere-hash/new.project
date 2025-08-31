<?php
// v_color.php
?>
<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<div class="pull-right">Versi: <?php echo isset($version)?$version:''; ?></div>
<legend><?php echo isset($title)?$title:'MASTER MAIN COLOR'; ?></legend>

<?php if (!empty($message)) echo $message; ?>

<!-- FILTER -->
<div class="box box-default">
  <div class="box-header with-border">
    <h3 class="box-title">Filter</h3>
  </div>
  <div class="box-body">
    <form class="form-inline" method="post" action="<?php echo site_url('ga/inventaris/form_color');?>">
      <div class="form-group">
        <label>Group</label>
        <select name="f_kdgroup" id="f_kdgroup" class="form-control input-sm" style="min-width: 220px;">
          <option value="">-- Semua Group --</option>
          <?php if(!empty($list_group)) foreach($list_group as $g): ?>
            <option value="<?php echo trim($g->kdgroup);?>" <?php echo (!empty($f_kdgroup) && $f_kdgroup==trim($g->kdgroup))?'selected':''; ?>>
              <?php echo trim($g->kdgroup).' — '.trim($g->nmgroup);?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-left:10px;">
        <label>Subgroup</label>
        <select name="f_kdsubgroup" id="f_kdsubgroup" class="form-control input-sm" style="min-width: 240px;">
          <option value="">-- Semua Subgroup --</option>
          <?php if(!empty($list_subgroup)) foreach($list_subgroup as $sg): ?>
            <option value="<?php echo trim($sg->kdsubgroup);?>" <?php echo (!empty($f_kdsubgroup) && $f_kdsubgroup==trim($sg->kdsubgroup))?'selected':''; ?>>
              <?php echo trim($sg->kdsubgroup).' — '.trim($sg->nmsubgroup);?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <div class="form-group" style="margin-left:10px;">
        <label>Type</label>
        <select name="f_kdtype" id="f_kdtype" class="form-control input-sm" style="min-width: 240px;">
          <option value="">-- Semua Type --</option>
          <?php if(!empty($list_type)) foreach($list_type as $t): ?>
            <option value="<?php echo trim($t->kdtype);?>" <?php echo (!empty($f_kdtype) && $f_kdtype==trim($t->kdtype))?'selected':''; ?>>
              <?php echo trim($t->kdtype).' — '.trim($t->nmtype);?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <button type="submit" class="btn btn-primary btn-sm" style="margin-left:10px;">Terapkan</button>

      <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#mdlAdd" style="margin-left:10px;">
        <i class="fa fa-plus"></i> Tambah Main Color
      </button>
    </form>
  </div>
</div>

<!-- TABEL -->
<div class="box">
  <div class="box-header with-border">
    <h3 class="box-title">Daftar Main Color</h3>
  </div>
  <div class="box-body table-responsive" style="overflow-x:auto;">
    <table id="tblColor" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th style="width:50px;">No</th>
          <th>Kode Group</th>
          <th>Nama Group</th>
          <th>Kode Subgroup</th>
          <th>Nama Subgroup</th>
          <th>Kode Type</th>
          <th>Nama Type</th>
          <th>Kode Color</th>
          <th>Nama Color</th>
          <th>Keterangan</th>
          <th style="width:130px;">Aksi</th>
        </tr>
      </thead>
      <tbody>
      <?php $no=0; if(!empty($list_color)) foreach($list_color as $c): $no++; $rid = trim($c->kdgroup).trim($c->kdsubgroup).trim($c->kdtype).trim($c->kdcolor); ?>
        <tr>
          <td><?php echo $no; ?></td>
          <td><?php echo htmlspecialchars($c->kdgroup); ?></td>
          <td><?php echo htmlspecialchars($c->nmgroup); ?></td>
          <td><?php echo htmlspecialchars($c->kdsubgroup); ?></td>
          <td><?php echo htmlspecialchars($c->nmsubgroup); ?></td>
          <td><?php echo htmlspecialchars($c->kdtype); ?></td>
          <td><?php echo htmlspecialchars($c->nmtype); ?></td>
          <td><?php echo htmlspecialchars($c->kdcolor); ?></td>
          <td><?php echo htmlspecialchars($c->nmcolor); ?></td>
          <td><?php echo htmlspecialchars($c->keterangan); ?></td>
          <td>
            <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#mdlEdit<?php echo $rid; ?>"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-xs btn-danger" data-toggle="modal" data-target="#mdlDel<?php echo $rid; ?>"><i class="fa fa-trash"></i> Hapus</button>
          </td>
        </tr>

        <!-- MODAL EDIT -->
        <div class="modal fade" id="mdlEdit<?php echo $rid; ?>" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <form class="modal-content" method="post" action="<?php echo site_url('ga/inventaris/input_color');?>">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Edit Main Color</h4>
              </div>
              <div class="modal-body">
                <input type="hidden" name="type" value="EDIT">
                <input type="hidden" name="kdgroup" value="<?php echo htmlspecialchars($c->kdgroup); ?>">
                <input type="hidden" name="kdsubgroup" value="<?php echo htmlspecialchars($c->kdsubgroup); ?>">
                <input type="hidden" name="kdtype" value="<?php echo htmlspecialchars($c->kdtype); ?>">

                <div class="form-group">
                  <label>Kode Color</label>
                  <input type="text" name="kdcolor" class="form-control input-sm" value="<?php echo htmlspecialchars($c->kdcolor); ?>" readonly>
                </div>
                <div class="form-group">
                  <label>Nama Color</label>
                  <input type="text" name="nmcolor" class="form-control input-sm" value="<?php echo htmlspecialchars($c->nmcolor); ?>" style="text-transform:uppercase" required>
                </div>
                <div class="form-group">
                  <label>Keterangan</label>
                  <input type="text" name="keterangan" class="form-control input-sm" value="<?php echo htmlspecialchars($c->keterangan); ?>" maxlength="159">
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
        <div class="modal fade" id="mdlDel<?php echo $rid; ?>" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <form class="modal-content" method="post" action="<?php echo site_url('ga/inventaris/input_color');?>">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                <h4 class="modal-title">Hapus Main Color</h4>
              </div>
              <div class="modal-body">
                <p>Hapus color <strong><?php echo htmlspecialchars($c->kdcolor.' — '.$c->nmcolor); ?></strong> ?</p>
                <input type="hidden" name="type" value="DELETE">
                <input type="hidden" name="kdgroup" value="<?php echo htmlspecialchars($c->kdgroup); ?>">
                <input type="hidden" name="kdsubgroup" value="<?php echo htmlspecialchars($c->kdsubgroup); ?>">
                <input type="hidden" name="kdtype" value="<?php echo htmlspecialchars($c->kdtype); ?>">
                <input type="hidden" name="kdcolor" value="<?php echo htmlspecialchars($c->kdcolor); ?>">
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
  </div>
</div>

<!-- MODAL TAMBAH -->
<div class="modal fade" id="mdlAdd" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <form class="modal-content" method="post" action="<?php echo site_url('ga/inventaris/input_color');?>">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
        <h4 class="modal-title">Tambah Main Color</h4>
      </div>
      <div class="modal-body">
        <input type="hidden" name="type" value="INPUT">

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label>Kode Group</label>
              <select name="kdgroup" id="add_kdgroup" class="form-control input-sm" required>
                <option value="">-- pilih --</option>
                <?php if(!empty($list_group)) foreach($list_group as $g): ?>
                  <option value="<?php echo trim($g->kdgroup); ?>">
                    <?php echo trim($g->kdgroup).' — '.trim($g->nmgroup); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
              <label>Kode Subgroup</label>
              <select name="kdsubgroup" id="add_kdsubgroup" class="form-control input-sm" required>
                <option value="">-- pilih group dulu --</option>
              </select>
            </div>
          </div>

          <div class="col-sm-4">
            <div class="form-group">
              <label>Kode Type</label>
              <select name="kdtype" id="add_kdtype" class="form-control input-sm" required>
                <option value="">-- pilih subgroup dulu --</option>
              </select>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-sm-4">
            <div class="form-group">
              <label>Kode Color</label>
              <input type="text" name="kdcolor" class="form-control input-sm" maxlength="6" style="text-transform:uppercase" required>
            </div>
          </div>
          <div class="col-sm-8">
            <div class="form-group">
              <label>Nama Color</label>
              <input type="text" name="nmcolor" class="form-control input-sm" style="text-transform:uppercase" required>
            </div>
          </div>
        </div>

        <div class="form-group">
          <label>Keterangan</label>
          <input type="text" name="keterangan" class="form-control input-sm" maxlength="159">
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Simpan</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </form>
  </div>
</div>

<!-- JS -->
<script type="text/javascript">
$(function(){
  // datatable
  $('#tblColor').dataTable();

  // ==== CSRF (simple, sama seperti mekanisme TYPE Anda) ====
  var csrfName = '<?php echo $this->security->get_csrf_token_name(); ?>';
  var csrfHash = '<?php echo $this->security->get_csrf_hash(); ?>';

  // === Filter dinamis (opsional) ===
  $('#f_kdgroup').on('change', function(){
    var kdgroup = $(this).val();
    var $sub = $('#f_kdsubgroup'), $typ = $('#f_kdtype');
    $sub.html('<option value="">-- memuat... --</option>');
    $typ.html('<option value="">-- pilih subgroup dulu --</option>');
    if(!kdgroup){ $sub.html('<option value="">-- Semua Subgroup --</option>'); $typ.html('<option value="">-- Semua Type --</option>'); return; }
    var data = { kdgroup: kdgroup }; data[csrfName] = csrfHash;
    $.post('<?php echo site_url('ga/inventaris/ajax_subgroup_by_group'); ?>', data, function(res){
      $sub.empty().append('<option value="">-- Semua Subgroup --</option>');
      $.each(res, function(_, r){ $sub.append($('<option/>',{value:r.kdsubgroup, text:r.kdsubgroup+' — '+r.nmsubgroup})); });
    }, 'json').fail(function(){ $sub.html('<option value="">(gagal memuat)</option>'); });
  });

  $('#f_kdsubgroup').on('change', function(){
    var kdgroup=$('#f_kdgroup').val(), kdsubgroup=$(this).val();
    var $typ = $('#f_kdtype');
    if(!kdgroup || !kdsubgroup){ $typ.html('<option value="">-- Semua Type --</option>'); return; }
    var data = { kdgroup: kdgroup, kdsubgroup: kdsubgroup }; data[csrfName] = csrfHash;
    $.post('<?php echo site_url('ga/inventaris/ajax_type_by_subgroup'); ?>', data, function(res){
      $typ.empty().append('<option value="">-- Semua Type --</option>');
      $.each(res, function(_, r){ $typ.append($('<option/>',{value:r.kdtype, text:r.kdtype+' — '+r.nmtype})); });
    }, 'json').fail(function(){ $typ.html('<option value="">(gagal memuat)</option>'); });
  });

  // === Modal Tambah: Group -> Subgroup ===
  $('#add_kdgroup').on('change', function(){
    var kdgroup = $(this).val();
    var $sub = $('#add_kdsubgroup'), $typ = $('#add_kdtype');
    $sub.html('<option value="">-- memuat... --</option>');
    $typ.html('<option value="">-- pilih subgroup dulu --</option>');
    if(!kdgroup){ $sub.html('<option value="">-- pilih group dulu --</option>'); return; }
    var data = { kdgroup: kdgroup }; data[csrfName] = csrfHash;
    $.post('<?php echo site_url('ga/inventaris/ajax_subgroup_by_group'); ?>', data, function(res){
      $sub.empty().append('<option value="">-- pilih --</option>');
      $.each(res, function(_, r){ $sub.append($('<option/>',{value:r.kdsubgroup, text:r.kdsubgroup+' — '+r.nmsubgroup})); });
    }, 'json').fail(function(){ $sub.html('<option value="">(gagal memuat)</option>'); });
  });

  // === Modal Tambah: Subgroup -> Type ===
  $('#add_kdsubgroup').on('change', function(){
    var kdgroup=$('#add_kdgroup').val(), kdsubgroup=$(this).val();
    var $typ = $('#add_kdtype');
    $typ.html('<option value="">-- memuat... --</option>');
    if(!kdgroup || !kdsubgroup){ $typ.html('<option value="">-- pilih subgroup dulu --</option>'); return; }
    var data = { kdgroup: kdgroup, kdsubgroup: kdsubgroup }; data[csrfName] = csrfHash;
    $.post('<?php echo site_url('ga/inventaris/ajax_type_by_subgroup'); ?>', data, function(res){
      $typ.empty().append('<option value="">-- pilih --</option>');
      $.each(res, function(_, r){ $typ.append($('<option/>',{value:r.kdtype, text:r.kdtype+' — '+r.nmtype})); });
    }, 'json').fail(function(){ $typ.html('<option value="">(gagal memuat)</option>'); });
  });

  // (Jika nanti butuh cascading sampai Color dari Type di form lain, tinggal tambah AJAX ke ajax_color_by_type)
});
</script>
