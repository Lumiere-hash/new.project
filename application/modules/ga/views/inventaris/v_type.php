<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<div class="pull-right">Versi: <?php echo $version; ?></div>
<legend><?php echo $title; ?></legend>

<?php echo isset($message)?$message:''; ?>

<!-- Filter -->
<div class="box box-default">
  <div class="box-header with-border"><h3 class="box-title">Filter</h3></div>
  <div class="box-body">
    <form class="form-inline" method="post" action="<?php echo site_url('ga/inventaris/form_type');?>">
      <div class="form-group">
        <label>Group</label>
        <select name="f_kdgroup" id="f_kdgroup" class="form-control input-sm" style="min-width:200px">
          <option value="">-- Semua Group --</option>
          <?php foreach($list_group as $g): ?>
            <option value="<?php echo trim($g->kdgroup);?>" <?php echo ($f_kdgroup==trim($g->kdgroup)?'selected':''); ?>>
              <?php echo trim($g->kdgroup).' — '.trim($g->nmgroup);?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="form-group" style="margin-left:10px">
        <label>Subgroup</label>
        <select name="f_kdsubgroup" id="f_kdsubgroup" class="form-control input-sm" style="min-width:200px">
          <option value="">-- Semua Subgroup --</option>
          <?php foreach($list_subgroup as $sg): ?>
            <option value="<?php echo trim($sg->kdsubgroup);?>" <?php echo ($f_kdsubgroup==trim($sg->kdsubgroup)?'selected':''); ?>>
              <?php echo trim($sg->kdsubgroup).' — '.trim($sg->nmsubgroup);?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>
      <button type="submit" class="btn btn-primary btn-sm" style="margin-left:10px">Terapkan</button>

      <button type="button" class="btn btn-success btn-sm pull-right" data-toggle="modal" data-target="#mdlAdd">
        <i class="fa fa-plus"></i> Tambah Type
      </button>
    </form>
  </div>
</div>

<!-- Tabel -->
<div class="box">
  <div class="box-header with-border"><h3 class="box-title">Daftar Type</h3></div>
  <div class="box-body table-responsive" style="overflow-x:auto;">
    <table id="tblType" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th width="5%">No</th>
          <th>Kode Group</th>
          <th>Nama Group</th>
          <th>Kode Subgroup</th>
          <th>Nama Subgroup</th>
          <th>Kode Type</th>
          <th>Nama Type</th>
          <th>Keterangan</th>
          <th width="16%">Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php $no=0; foreach($list_type as $t): $no++; ?>
        <tr>
          <td><?php echo $no;?></td>
          <td><?php echo htmlspecialchars($t->kdgroup);?></td>
          <td><?php echo htmlspecialchars($t->nmgroup);?></td>
          <td><?php echo htmlspecialchars($t->kdsubgroup);?></td>
          <td><?php echo htmlspecialchars($t->nmsubgroup);?></td>
          <td><?php echo htmlspecialchars($t->kdtype);?></td>
          <td><?php echo htmlspecialchars($t->nmtype);?></td>
          <td><?php echo htmlspecialchars($t->keterangan);?></td>
          <td>
            <button class="btn btn-xs btn-success" data-toggle="modal" data-target="#mdlEdit<?php echo $t->kdgroup.$t->kdsubgroup.$t->kdtype;?>"><i class="fa fa-edit"></i> Edit</button>
            <button class="btn btn-xs btn-danger"  data-toggle="modal" data-target="#mdlDel<?php echo $t->kdgroup.$t->kdsubgroup.$t->kdtype;?>"><i class="fa fa-trash"></i> Hapus</button>
          </td>
        </tr>

        <!-- Modal Edit -->
        <div class="modal fade" id="mdlEdit<?php echo $t->kdgroup.$t->kdsubgroup.$t->kdtype;?>" tabindex="-1" role="dialog">
          <div class="modal-dialog"><form class="modal-content" method="post" action="<?php echo site_url('ga/inventaris/input_type');?>">
            <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Edit Type</h4></div>
            <div class="modal-body">
              <input type="hidden" name="type" value="EDIT">
              <input type="hidden" name="kdgroup" value="<?php echo htmlspecialchars($t->kdgroup);?>">
              <input type="hidden" name="kdsubgroup" value="<?php echo htmlspecialchars($t->kdsubgroup);?>">
              <div class="form-group"><label>Kode Type</label>
                <input type="text" name="kdtype" class="form-control input-sm" value="<?php echo htmlspecialchars($t->kdtype);?>" readonly>
              </div>
              <div class="form-group"><label>Nama Type</label>
                <input type="text" name="nmtype" class="form-control input-sm" value="<?php echo htmlspecialchars($t->nmtype);?>" style="text-transform:uppercase" required>
              </div>
              <div class="form-group"><label>Keterangan</label>
                <input type="text" name="keterangan" class="form-control input-sm" value="<?php echo htmlspecialchars($t->keterangan);?>" maxlength="159">
              </div>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-primary">Simpan</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
            </div>
          </form></div>
        </div>

        <!-- Modal Delete -->
        <div class="modal fade" id="mdlDel<?php echo $t->kdgroup.$t->kdsubgroup.$t->kdtype;?>" tabindex="-1" role="dialog">
          <div class="modal-dialog"><form class="modal-content" method="post" action="<?php echo site_url('ga/inventaris/input_type');?>">
            <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Hapus Type</h4></div>
            <div class="modal-body">
              <p>Hapus type <strong><?php echo htmlspecialchars($t->kdtype.' — '.$t->nmtype);?></strong>?</p>
              <input type="hidden" name="type" value="DELETE">
              <input type="hidden" name="kdgroup" value="<?php echo htmlspecialchars($t->kdgroup);?>">
              <input type="hidden" name="kdsubgroup" value="<?php echo htmlspecialchars($t->kdsubgroup);?>">
              <input type="hidden" name="kdtype" value="<?php echo htmlspecialchars($t->kdtype);?>">
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-danger">Hapus</button>
              <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            </div>
          </form></div>
        </div>

        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal Tambah -->
<div class="modal fade" id="mdlAdd" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg">
    <form class="modal-content" method="post" action="<?php echo site_url('ga/inventaris/input_type');?>">
      <div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Tambah Type</h4></div>
      <div class="modal-body">
        <input type="hidden" name="type" value="INPUT">
        <div class="row">
          <div class="col-sm-4">
            <div class="form-group"><label>Kode Group</label>
              <select name="kdgroup" id="add_kdgroup" class="form-control input-sm" required>
                <option value="">-- pilih --</option>
                <?php foreach($list_group as $g): ?>
                  <option value="<?php echo trim($g->kdgroup);?>"><?php echo trim($g->kdgroup).' — '.trim($g->nmgroup);?></option>
                <?php endforeach;?>
              </select>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group"><label>Kode Subgroup</label>
              <select name="kdsubgroup" id="add_kdsubgroup" class="form-control input-sm" required>
                <option value="">-- pilih group dulu --</option>
              </select>
            </div>
          </div>
          <div class="col-sm-4">
            <div class="form-group"><label>Kode Type</label>
              <input type="text" name="kdtype" maxlength="6" class="form-control input-sm" style="text-transform:uppercase" required>
            </div>
          </div>
        </div>
        <div class="form-group"><label>Nama Type</label>
          <input type="text" name="nmtype" class="form-control input-sm" style="text-transform:uppercase" required>
        </div>
        <div class="form-group"><label>Keterangan</label>
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

<script type="text/javascript">
$(function(){
  $('#tblType').dataTable();

  // isi ulang Subgroup berdasarkan Group tanpa reload
  $('#add_kdgroup').on('change', function(e){
    e.preventDefault();
    var kdgroup = $(this).val();
    var $sub    = $('#add_kdsubgroup');

    $sub.empty().append('<option value="">-- memuat... --</option>');

    if (!kdgroup){
      $sub.html('<option value="">-- pilih group dulu --</option>');
      return;
    }

    $.post('<?php echo site_url('ga/inventaris/ajax_subgroup_by_group'); ?>',
      { kdgroup: kdgroup
        <?php if ($this->security->get_csrf_token_name()) { ?>,
          '<?php echo $this->security->get_csrf_token_name(); ?>':
          '<?php echo $this->security->get_csrf_hash(); ?>'
        <?php } ?>
      },
      function(res){
        $sub.empty().append('<option value="">-- pilih --</option>');
        $.each(res, function(_, r){
          $sub.append(
            $('<option/>',{value:r.kdsubgroup,text:r.kdsubgroup+' — '+r.nmsubgroup})
          );
        });
      },
      'json'
    ).fail(function(){
      $sub.html('<option value="">(gagal memuat)</option>');
    });
  });
});
</script>

