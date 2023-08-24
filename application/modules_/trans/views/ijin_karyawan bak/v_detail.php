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


<!--Modal untuk Detail Bpjs Karyawan-->
<a href="<?php echo site_url("trans/ijin_karyawan/")?>"  class="btn btn-primary">Kembali</a>
<?php foreach ($list_ijin_karyawan_dtl as $lb){?>
<form action="<?php echo site_url('trans/ijin_karyawan/approval')?>" method="post">
<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($lb->nodok); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($lb->nik); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="status" name="status"  value="A" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>								
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department"  value="<?php echo trim($lb->nmdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment"  value="<?php echo trim($lb->nmsubdept); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							<!--<div class="form-group">
								<label class="col-sm-4">Level Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan"  value="<?php echo trim($lb->nmjabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($lb->nmatasan1); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								<label class="col-sm-4">Tipe Ijin</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdijin_absensi"  value="<?php echo trim($lb->nmijin_absensi); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput" value="<?php echo trim($lb->tgl_kerja1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Awal</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_awal" value="<?php echo trim($lb->tgl_jam_mulai); ?>" placeholder="HH:MM" data-inputmask='"mask": "99:99"' data-mask="" class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="jam_selesai" value="<?php echo trim($lb->tgl_jam_selesai); ?>" placeholder="HH:MM" data-inputmask='"mask": "99:99"' data-mask="" class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Durasi(jam)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="durasi" placeholder="0" value="<?php echo trim($lb->durasi); ?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($lb->tgl_dok1);?>"class="form-control" readonly>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($lb->keterangan);?></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
									<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
									
								</div>
							</div>		
							
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			</div>
		</div>	
	</div>	
     <div> 
         <?php if (trim($lb->status)=='A'){ ?>
		 <button type="submit"  class="btn btn-primary">APPROVAL</button>  
		 <input type="hidden" id="status" name="status"  value="P" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>	
	  </form>
	</div>  
	<div class="modal-footer">
		<form action="<?php echo site_url('trans/ijin_karyawan/cancel');?>" method="post">
			<input type="hidden" value="<?php echo trim($lb->nodok);?>" name="nodok">
			<input type="hidden" value="<?php echo trim($lb->nik);?>" name="nik">
			<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
			<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
			<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Membatalkan <?php echo $lb->nodok;?>?')">Cancel</button>
		</form>
		</div> 
		

	
	<?php } ?>
    
<?php } ?>
