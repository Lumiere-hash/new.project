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

<?php foreach ($list_lk as $lb){?>
<form name="autoSumForm" action="<?php echo site_url('trans/lembur/add_lembur')?>" method="post">
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
									<input type="hidden" id="nik" name="atasan"  value="<?php echo trim($lb->nik_atasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="atasan1"  value="<?php echo trim($lb->nmatasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							
							
							
							<div class="form-group">
								<label class="col-sm-4">Tipe Lembur</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdlembur" id="kdgrade">
									  <?php foreach($list_lembur as $listkan){?>
									  <option value="<?php echo trim($listkan->tplembur);?>"><?php echo $listkan->tplembur;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jenis Lembur</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="jenis_lembur" id="kdgrade">
									  
									  <option value="D1">DURASI ABSEN</option>						  
									  <option value="D2">NON-DURASI ABSEN</option>						  
									  
									</select>
								</div>
							</div>
							<script type="text/javascript">
								$(function() {                         
									$("#dateinput<?php echo trim($lb->nik);?>").datepicker();                               
								});
							</script>			
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput<?php echo trim($lb->nik);?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Awal</label>	
								<div class="col-sm-8">    
								<input type="text" name="jam_awal" data-inputmask='"mask": "99:99:99"' data-mask="" onFocus="startCalc();" onBlur="stopCalc();" class="form-control">
								
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Selesai</label>	
								<div class="col-sm-8">    
								<input type="text" name="jam_selesai" data-inputmask='"mask": "99:99:99"' data-mask="" onFocus="startCalc();" onBlur="stopCalc();" class="form-control">				
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Durasi Istirahat(Menit)</label>	
								<div class="col-sm-8">    
									<input type="text"  name="durasi_istirahat" data-inputmask='"mask": "99"' data-mask="" onFocus="startCalc();" onBlur="stopCalc();" class="form-control" required>
								</div>
							</div>
							<!--<div class="form-group">
								<label class="col-sm-4">Total Durasi</label>	
								<div class="col-sm-8">    
									<input type="text"  id="ttltarget" name="ttltarget" class="form-control" readonly>
								</div>
							</div>-->		
							<div class="form-group">
								<label class="col-sm-4">Alasan Lembur</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdtrx" id="kdtrx">
									  <?php foreach($list_trxtype as $listkan){?>
									  <option value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>			
							
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
      <div class="modal-footer">
        <a type="button" class="btn btn-default" href="<?php echo site_url('trans/lembur/karyawan');?>">Close</a>
        <button type="submit"  class="btn btn-primary">SIMPAN</button>
      </div>
</form>
    


<?php } ?>

<script type="text/javascript">
function startCalc(){interval=setInterval("calc()",1)}
function calc(){
target1=document.autoSumForm.jam_awal.value;
target2=document.autoSumForm.jam_selesai.value;
target3=document.autoSumForm.durasi_istirahat.value;


document.autoSumForm.ttltarget.value=(target2*1)-(target1*1)-(target3*1)

}
function stopCalc(){clearInterval(interval)}
</script>
