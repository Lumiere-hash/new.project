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

<div class="row" id="edit" >
  <div>
    <div>
	       <a href="<?php echo site_url("trans/cuti_karyawan/")?>"  class="btn btn-primary">Kembali</a>
	  <form action="<?php echo site_url('trans/cuti_karyawan/edit_cuti_karyawan')?>" method="post">
		<div class="modal-body">										
		<div class="row">
			<div class="col-sm-6">
				<div class="box box-danger">
					<div class="box-body">
						<div class="form-horizontal">							
							<div class="form-group">
								<label class="col-sm-4">No. Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="status" name="nodok"  value="<?php echo trim($dtl['nodok']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">NIK</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="nik"  value="<?php echo trim($dtl['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<!--input type="hidden" id="status" name="status"  value="A" class="form-control" style="text-transform:uppercase" maxlength="40" readonly-->
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($dtl['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($dtl['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($dtl['kdlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-4">Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="department"  value="<?php echo trim($dtl['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Sub Department</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="subdepartment"  value="<?php echo trim($dtl['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>	
							
							<!--<div class="form-group">
								<label class="col-sm-4">Level Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlvl"  value="<?php echo trim($dtl['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Jabatan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="jabatan"  value="<?php echo trim($dtl['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($dtl['nmatasan1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">NIK Atasan2</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="atasan2"  value="<?php echo trim($dtl['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Alamat</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($dtl['alamat']);?></textarea>
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
								<label class="col-sm-4">Tipe Cuti</label>	<!--colorselector<!--?php echo trim($lb->nik); ?-->
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="tpcuti" id="tpecuti">
									 <option value="A">CUTI</option> 
									 <option value="B">IJIN KHUSUS</option> 
									 <option value="C">DINAS</option> 
									</select>
								</div>
							</div>
							<script type="text/javascript" charset="utf-8">
							$(function() {
		
											$('#tpecuti').change(function(){
												//$('#subcuti').show();
												$('.subcuti' + $(this).val()).hide();
												$('.subcuti' + $(this).val()).hide();
												$('#subcuti' + $(this).val()).show();
												$('.ijin' + $(this).val()).hide();
												$('#ijin' + $(this).val()).show();
											
											});
										});	
							</script>
							<div class="form-group">
								<div id="subcutiA" class="subcutiB subcutiC" >
								<label class="col-sm-4">Subtitusi Cuti</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="statptg" id="<?php echo trim($lb->nik); ?>">
									<option value="">--INPUT SUB Cuti--</option> 
									 <option value="A1">POTONG CUTI</option> 
									 <option value="A2">POTONG GAJI</option> 
									</select>
								</div>
								</div>
							</div>
							<div class="form-group">
							<div id="ijinB" class="ijinA ijinC" style="display:none;">
								<label class="col-sm-4">Tipe Ijin Khusus</label>	
								<div class="col-sm-8">  
									<select class="form-control input-sm" name="kdijin_khusus" id="kdijin_absensi" >
									<option value="">--Input Type Ijin Khusus--</option>
									  <?php foreach($list_ijin_khusus as $listkan){?>
									  <option value="<?php echo trim($listkan->kdijin_khusus);?>" ><?php echo $listkan->nmijin_khusus;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
							</div>
							<script type="text/javascript">
								$(function() {                         
									$("#dateinput<?php echo trim($dtl['nodok']);?>").datepicker();                               
									$("#dateinput1<?php echo trim($dtl['nodok']);?>").datepicker();    
									$("#kdtrx").selectize();	
								});
							</script>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Mulai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput<?php echo trim($dtl['nodok']);?>" value="<?php echo trim($dtl['tgl_mulai1']); ?>" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Selesai</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput1<?php echo trim($dtl['nodok']);?>" value="<?php echo trim($dtl['tgl_selesai1']); ?>" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Jumlah Cuti(Hari)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="jumlah_cuti" placeholder="0" value="<?php echo trim($dtl['jumlah_cuti']); ?>"  class="form-control" required  >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($dtl['tgl_dok1']);?>"class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Pelimpahan Pekerjaan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="pelimpahan" id="kdtrx">
									  <?php foreach($list_karyawan as $listkan){?>
									  <option <?php if (trim($dtl['pelimpahan'])==trim($listkan->nik)) { echo 'selected';}?> value="<?php echo trim($listkan->nik);?>" ><?php echo $listkan->nmlengkap;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" ><?php echo trim($dtl['keterangan']);?></textarea>
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
	
	
      <div class="modal-footer">

         <button type="submit"  class="btn btn-primary">SIMPAN</button>  
	  </form>
	</div>  
	
    </div>
  </div>

