<?php 
/*
	@author : Junis
*/
?>
<script type="text/javascript">

    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#table').DataTable();
    });

    function add_person()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tarik Data Absen'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
      save_method = 'update';
	  
	  $('#editform')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('trans/absensi/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           
			$('[name="kdkepegawaian"]').val(data.kdkepegawaian);
            $('[name="nmkepegawaian"]').val(data.nmkepegawaian);                                    			
            // show bootstrap modal when complete loaded
			$('#modal_form').modal('hide');
			$('#edit_form').modal('show');
            $('.modal-title').text('Edit Status Kepegawaian'); // Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');			
        }
    });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

   

    function delete_person(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
          $.ajax({
            url : "<?php echo site_url('trans/absensi/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
				$("#message").html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b> Hapus Data Sukses</b></div>");
			},
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
				
            }
        });
         
      }
    }

  </script>
<legend><?php echo $title.' '.$bul;?></legend>
<?php //echo $message;?>
<div id="message" >	
</div>
<div><?php //echo 'Total data: '.$ttldata['jumlah']; ?></div>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<button href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Jadwal Kerja</button>
					<!--<button href="#" data-toggle="modal" data-target="#input2" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Jadwal Non Regu</button>-->
					<button href="#" data-toggle="modal" data-target="#filter" class="btn btn-primary" style="margin:10px; color:#ffffff;">Filter</button>
					<!--<button class="btn btn-primary" onclick="add_person()" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-plus"></i> Data Mesin Absen</button>-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>																
							<th>No.</th>
							<th>Tanggal Kerja</th>
							<th>Bulan Kerja</th>
							<th>Tahun Kerja</th>
							<!--<th>Shift/Non Shift</th>-->
							<!--<th>Nama Regu</th>
							<th>Kode Jam Kerja</th>-->
							<!--<th>Action</th>-->
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach ($list_jadwal as $la): $no++ ?>
							<tr>																													
								<td><?php echo $no;?></td>	
								<td align="justify"><a href="<?php echo site_url("trans/jadwal_new/detail/$la->tgl");?>"><?php echo $la->tglnya;?></td>								
								<td><?php echo $la->bln;?></td>								
								<td><?php echo $la->tahun;?></td>								
								<!--<td><?php echo $la->kodejamkerja;?></td>-->								
								<!--<td>
								<a  data-toggle="modal" data-target="#<?php echo trim($la->id);?>" href='#' onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-pencil"></i> Edit
								</a>
								<a  href="<?php echo site_url("trans/absensi/hapus_absensi/$la->id")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Delete
								</a>
							</td>-->	
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

 <!-- Bootstrap modal -->
 <form action="<?php echo site_url('trans/jadwal_new/input_jadwal')?>" method="post">
  <div class="modal fade" id="input" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
		<h3 class="modal-title">Input Jadwal Kerja</h3>
      </div>
      <div class="modal-body form">
          <div class="row">
		  <div class="form-body">
              <!--<div class="form-group">
              <label class="control-label col-md-3">Shift Tipe</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="shift" name="shift" required>
							<option value="t">SHIFT</option>																																			
							<option value="f">NON SHIFT</option>																																			
						</select>
              </div>
            </div>-->
			<div class="form-group">
              <label class="control-label col-md-3">Nama Regu</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="kdregu" name="kdregu" required>
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_regu as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>
		 
			<div class="form-group">
              <label class="control-label col-md-3">Tanggal Jadwal Kerja</label>
              <div class="col-md-9">
                <input name="tanggal" id="tgl" data-date-format="dd-mm-yyyy" class="form-control"  type="text">
              </div>
            </div>
			 <div class="form-group">
              <label class="control-label col-md-3">Jadwal Jam Kerja</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="kdjamkerja1" name="kdjamkerja" required>
							<option value="">--Pilih Jam Kerja--</option>
							<?php foreach ($list_jamkerja as $ld){ ?>
							<option value="<?php echo trim($ld->kdjam_kerja);?>"><?php echo $ld->nmjam_kerja;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Jam Kerja</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="nmjamkerja1" name="nmjamkerja" readonly>
							<?php foreach ($list_jamkerja as $ld){ ?>
							<option class="<?php echo trim($ld->kdjam_kerja);?>"><?php echo $ld->jam_masuk.'-'.$ld->jam_pulang;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>		
          </div>
          </div>
          </div>
		  
          <div class="modal-footer">
			<div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
	</form>
  
  <!-- Bootstrap modal -->
  
  <!-- Bootstrap modal -->
 <form action="<?php echo site_url('trans/jadwal_new/input_jadwal_ns')?>" method="post">
  <div class="modal fade" id="input2" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        
		<h3 class="modal-title">Input Jadwal Kerja Non Shift</h3>
      </div>
      <div class="modal-body form">
          <div class="row">
		  <div class="form-body">
             <div class="form-group">
              <label class="control-label col-md-3">Shift Tipe</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="shift" name="shift" required>																																			
							<option value="f">NON SHIFT</option>																																			
						</select>
              </div>
            </div>
			<div class="form-group">
              <label class="control-label col-md-3">Nama Karyawan</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="pilihkaryawan" name="nik" required>
							<option value="">--PILIH KARYAWAN--</option>
							<?php foreach ($list_karyawan as $ld){ ?>
							<option value="<?php echo trim($ld->nik);?>"><?php echo $ld->nmlengkap;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>
		 
			<div class="form-group">
              <label class="control-label col-md-3">Tanggal</label>
              <div class="col-md-9">
                <input name="tanggal" id="tgl2" data-date-format="dd-mm-yyyy" class="form-control"  type="text">
              </div>
            </div>
			 <div class="form-group">
              <label class="control-label col-md-3">Jam Kerja</label>
              <div class="col-md-9">
						<select class="form-control input-sm" id="kdjamkerja" name="kdjamkerja" required>
							<option value="">--Pilih Jam Kerja--</option>
							<?php foreach ($list_jamkerja as $ld){ ?>
							<option value="<?php echo trim($ld->kdjam_kerja);?>"><?php echo $ld->nmjam_kerja;?></option>
							<?php } ?>																																					
						</select>
              </div>
            </div>	
          </div>
          </div>
          </div>
		  
          <div class="modal-footer">
			<div class="form-group">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
          </div>
        </div><!-- /.modal-content -->
      </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
  <!-- End Bootstrap modal -->
	</form>
  
  <!-- Bootstrap modal -->
  
  
  
  <!-- Bootstrap modal -->
 
 <!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filter Jadwal Per Bulan</h4>
      </div>
	  <form action="<?php echo site_url('trans/jadwal_new/index')?>" method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bulan'>
					
					<option value="01" <?php $tgl=date('m'); if($tgl=='01') echo "selected"; ?>>Januari</option>
					<option value="02" <?php $tgl=date('m'); if($tgl=='02') echo "selected"; ?>>Februari</option>
					<option value="03" <?php $tgl=date('m'); if($tgl=='03') echo "selected"; ?>>Maret</option>
					<option value="04" <?php $tgl=date('m'); if($tgl=='04') echo "selected"; ?>>April</option>
					<option value="05" <?php $tgl=date('m'); if($tgl=='05') echo "selected"; ?>>Mei</option>
					<option value="06" <?php $tgl=date('m'); if($tgl=='06') echo "selected"; ?>>Juni</option>
					<option value="07" <?php $tgl=date('m'); if($tgl=='07') echo "selected"; ?>>Juli</option>
					<option value="08" <?php $tgl=date('m'); if($tgl=='08') echo "selected"; ?>>Agustus</option>
					<option value="09" <?php $tgl=date('m'); if($tgl=='09') echo "selected"; ?>>September</option>
					<option value="10" <?php $tgl=date('m'); if($tgl=='10') echo "selected"; ?>>Oktober</option>
					<option value="11" <?php $tgl=date('m'); if($tgl=='11') echo "selected"; ?>>November</option>
					<option value="12" <?php $tgl=date('m'); if($tgl=='12') echo "selected"; ?>>Desember</option>
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="tahun">
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		<!--<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Shift</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="shift" name="shift" required>																																			
							<option value="f">NON SHIFT</option>																																			
							<option value="t">SHIFT</option>																																			
				</select>
			</div>			
		</div>-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>
 
 <script>
 
	//Date range picker
    $('#tgl').datepicker();
    $('#tgl2').datepicker();
	$('#pilihkaryawan').selectize();
	$("[data-mask]").inputmask();
	$("#nmjamkerja1").chained("#kdjamkerja1");		
	$("#disb").chained("#city");	

</script>