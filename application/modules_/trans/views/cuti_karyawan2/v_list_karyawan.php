<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
            });
		
</script>

<legend><?php echo $title;?></legend>

<div class="row">
				<div class="col-sm-12">		
					<a href="<?php echo site_url("trans/cuti_karyawan/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
				</div>
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Action</th>	
							<th>NIK</th>
							<th>Nama Karyawan</th>					
							<th>Department</th>					
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_karyawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->nik);?>" href='#' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Input Ijin
								</a>
							</td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<?php foreach ($list_lk as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->nik); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Input Cuti/Ijin Khusus Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/cuti_karyawan/add_cuti_karyawan')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="nodok"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->lvl_jabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department1"  value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="department"  value="<?php echo trim($lb->bag_dept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment1"  value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="subdepartment"  value="<?php echo trim($lb->subbag_dept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan1"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="jabatan"  value="<?php echo trim($lb->jabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan1"  value="<?php echo trim($lb->nmatasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="atasan"  value="<?php echo trim($lb->nik_atasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Alamat</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="alamat"   style="text-transform:uppercase" class="form-control"></textarea>
								</div>
							</div>		
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box -->													
			</div>	
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<script type="text/javascript">
							$(function() {
								$("#colorselector<?php echo trim($lb->nik); ?>").change(function(){
								$(".colors<?php echo trim($lb->nik); ?>").hide();
								$('#' + $(this).val()).show();
								});
							});
							</script>
							<div class="form-group">
								<label class="col-sm-4">Tipe Cuti</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="tpcuti" id="colorselector<?php echo trim($lb->nik); ?>">
									 <option value="A<?php echo trim($lb->nik); ?>">CUTI</option> 
									 <option value="B<?php echo trim($lb->nik); ?>">IJIN KHUSUS</option> 
									 <option value="C<?php echo trim($lb->nik); ?>">DINAS</option> 
									</select>
								</div>
							</div>
							<div class="form-group">
							<div id="B<?php echo trim($lb->nik); ?>" class="colors<?php echo trim($lb->nik); ?>" style="display:none;">
								<label class="col-sm-4">Tipe Ijin Khusus</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdijin_khusus" id="kdijin_absensi" >
									  <?php foreach($list_ijin_khusus as $listkan){?>
									  <option value="<?php echo trim($listkan->kdijin_khusus);?>" ><?php echo $listkan->nmijin_khusus;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							</div>
							<script type="text/javascript">
								$(function() {                         
									$("#dateinput<?php echo trim($lb->nik);?>").datepicker();                               
									$("#dateinput1<?php echo trim($lb->nik);?>").datepicker();                               
								});
							</script>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput<?php echo trim($lb->nik);?>" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1<?php echo trim($lb->nik);?>" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti (Hari)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="jumlah_cuti" placeholder="0"   class="form-control" required >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pelimpahan Pekerjaan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="pelimpahan" id="pelimpahan">
									  <?php foreach($list_karyawan as $listkan){?>
									  <option value="<?php echo trim($listkan->nik);?>" ><?php echo $listkan->nmlengkap;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
								
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control"></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="tgl1" name="tgl_dok"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
									
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
	  </form>
    </div>
  </div>
</div>
<?php } ?>





