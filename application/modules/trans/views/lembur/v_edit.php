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
<?php echo $message;?>
<!--Modal untuk Edit Lembur-->
<?php foreach ($list_lembur_dtl as $lb){?>
<form action="<?php echo site_url('trans/lembur/edit_lembur')?>" method="post">
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
									<input type="hidden" id="status" name="status"  value="I" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Nama Karyawan</label>	
								<div class="col-sm-8">    
									<input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($lb->nmlengkap); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
									<input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($lb->kdlvljabatan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
									<input type="text" id="nik" name="atasan"  value="<?php echo trim($lb->nmatasan); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								<label class="col-sm-4">Pilih Lintas Hari</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="lintashari" id="lintashari">
									  <option <?php if (trim($lb->tgl_kerja1)==trim($lb->tgl_kerja2)){ echo 'selected';} ?> value="f">TIDAK</option>
									  <option <?php if (trim($lb->tgl_kerja1)<>trim($lb->tgl_kerja2)){ echo 'selected';} ?> value="t">YA</option>						  
									  </select>
								</div>
							</div>
							
							<div class="form-group">
								<label class="col-sm-4">Tipe Lembur</label>	
									<div class="col-sm-8">
									<select class="form-control input-sm" name="kdlembur" id="kdgrade">
									  <?php foreach($list_lembur_edit as $listkan){?>
									  <option <?php if (trim($lb->kdlembur)==trim($listkan->tplembur)) { echo 'selected';}?> value="<?php echo trim($listkan->tplembur);?>" ><?php echo $listkan->tplembur;?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jenis Lembur</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="jenis_lembur" id="jenis_lembur">
									  <option <?php if (trim($lb->jenis_lembur)=='D1'){ echo 'selected';} ?> value="D1">DURASI ABSEN</option>						  
									  <option <?php if (trim($lb->jenis_lembur)=='D2'){ echo 'selected';} ?> value="D2">NON-DURASI ABSEN</option>						  
									</select>
								</div>
							</div>
							<script type="text/javascript">
								$(function() {                         
								//	$("#dateinput<?php echo trim($lb->nodok);?>").datepicker();     
							$(".tgl_kerja").datepicker().on('changeDate',function(ev){
																			var tglkerja = $(this).val();
																			var strVardate = parseInt(tglkerja.substring(0,2));
																			var strVarmonth = parseInt(tglkerja.substring(3,5));
																			var strVaryear = parseInt(tglkerja.substring(6,10));
																			var strVardatestr = tglkerja.substring(0,2);
																			var strVarmonthstr = tglkerja.substring(3,5);
																			
																			var datelast = new Date(strVaryear, strVarmonth, 0);
																			var cekmonth = strVarmonthstr.toString().length;
																				if(cekmonth == 2){
																					var tglskrng = datelast.getDate()+'-'+strVarmonthstr+'-'+datelast.getFullYear();	
																				} else {
																					var tglskrng = datelast.getDate()+'-'+'0'+strVarmonthstr+'-'+datelast.getFullYear();
																				}
																			var akhirthn = '31'+'-'+'12'+'-'+datelast.getFullYear();
																			
																			//$('#tgllin').val(tglskrng);
																			
																			if((tglskrng == tglkerja) && (tglkerja != akhirthn)){
																				var strVarmonthp=(strVarmonth+1).toString().length;
																				if(strVarmonthp == 2){
																					$('#tgllin').val('01'+'-'+ (strVarmonth+1) +'-'+strVaryear );
																				}else{
																					$('#tgllin').val('01'+'-'+'0'+(strVarmonth+1) +'-'+strVaryear );
																				}
																				
																			} else if(akhirthn == tglkerja) {
																				$('#tgllin').val('01'+'-'+ '01' +'-'+ (strVaryear + 1 ));
																			} else {
																				var strVardate=strVardate+1;
																				var strVardatep=strVardate.toString().length;
																				var strVarmonthp=strVarmonth.toString().length;
																				if((strVardatep == 2) && (strVarmonthp == 2 )){
																					$('#tgllin').val(strVardate+'-'+ strVarmonth +'-'+strVaryear );
																				} else if (strVardatep == 2 && strVarmonthp == 1 ) {
																					$('#tgllin').val(strVardate+'-'+ '0'+strVarmonth +'-'+strVaryear );
																				} else if (strVardatep == 1 && strVarmonthp == 2 ) {
																					$('#tgllin').val('0'+strVardate+'-'+strVarmonth +'-'+strVaryear );
																				} else if (strVardatep == 1 && strVarmonthp == 1 ) {
																					$('#tgllin').val('0'+strVardate+'-'+'0'+strVarmonth +'-'+strVaryear );
																				} 
																					
																			}
																			
											});    								
								});
							</script>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput<?php echo trim($lb->nodok);?>" value="<?php echo trim($lb->tgl_kerja1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control tgl_kerja">
								</div>
							</div>
							<script type="text/javascript" charset="utf-8">
							$(function() {
													//	$('#tgllin').hide();
													//	$('.tgllin').hide();
													//	$('#tgllin').removeAttr('required');
												var tplintas=$('#lintashari').val();
													if(tplintas=='t'){
														$('#tgllin').show();
														$('.tgllin').show();
														$('#jenis_lembur').val('D2').attr('disabled', true);
														$('#tgllin').prop('readonly', true);
														$('#tgllin').prop('required',true);
													} else{
														$('#tgllin').hide();
														$('.tgllin').hide();
														$('#jenis_lembur').attr('disabled', false);
														$('#tgllin').prop('readonly', false);
														$('#tgllin').removeAttr('required');
														
													}			
														
														$('#lintashari').change(function(){
												var tplintas=$('#lintashari').val();
													if(tplintas=='t'){
														$('#tgllin').show();
														$('.tgllin').show();
														$('#jenis_lembur').val('D2').attr('disabled', true);
														$('#tgllin').prop('readonly', true);
														$('#tgllin').prop('required',true);
													} else{
														$('#tgllin').hide();
														$('.tgllin').hide();
														$('#jenis_lembur').attr('disabled', false);
														$('#tgllin').prop('readonly', false);
														$('#tgllin').prop('disabled', true);
														$('#tgllin').removeAttr('required');
														
													}
									
									/* manipulasi string tanggal logic is realllllllllll*/
											$(".tgl_kerja").datepicker().on('changeDate',function(ev){
																			var tglkerja = $(this).val();
																			var strVardate = parseInt(tglkerja.substring(0,2));
																			var strVarmonth = parseInt(tglkerja.substring(3,5));
																			var strVaryear = parseInt(tglkerja.substring(6,10));
																			var strVardatestr = tglkerja.substring(0,2);
																			var strVarmonthstr = tglkerja.substring(3,5);
																			
																			var datelast = new Date(strVaryear, strVarmonth, 0);
																			var cekmonth = strVarmonthstr.toString().length;
																				if(cekmonth == 2){
																					var tglskrng = datelast.getDate()+'-'+strVarmonthstr+'-'+datelast.getFullYear();	
																				} else {
																					var tglskrng = datelast.getDate()+'-'+'0'+strVarmonthstr+'-'+datelast.getFullYear();
																				}
																			var akhirthn = '31'+'-'+'12'+'-'+datelast.getFullYear();
																			
																			//$('#tgllin').val(tglskrng);
																			
																			if((tglskrng == tglkerja) && (tglkerja != akhirthn)){
																				var strVarmonthp=(strVarmonth+1).toString().length;
																				if(strVarmonthp == 2){
																					$('#tgllin').val('01'+'-'+ (strVarmonth+1) +'-'+strVaryear );
																				}else{
																					$('#tgllin').val('01'+'-'+'0'+(strVarmonth+1) +'-'+strVaryear );
																				}
																				
																			} else if(akhirthn == tglkerja) {
																				$('#tgllin').val('01'+'-'+ '01' +'-'+ (strVaryear + 1 ));
																			} else {
																				var strVardate=strVardate+1;
																				var strVardatep=strVardate.toString().length;
																				var strVarmonthp=strVarmonth.toString().length;
																				if((strVardatep == 2) && (strVarmonthp == 2 )){
																					$('#tgllin').val(strVardate+'-'+ strVarmonth +'-'+strVaryear );
																				} else if (strVardatep == 2 && strVarmonthp == 1 ) {
																					$('#tgllin').val(strVardate+'-'+ '0'+strVarmonth +'-'+strVaryear );
																				} else if (strVardatep == 1 && strVarmonthp == 2 ) {
																					$('#tgllin').val('0'+strVardate+'-'+strVarmonth +'-'+strVaryear );
																				} else if (strVardatep == 1 && strVarmonthp == 1 ) {
																					$('#tgllin').val('0'+strVardate+'-'+'0'+strVarmonth +'-'+strVaryear );
																				} 
																					
																			}
																			
											});    

											
											});
										});	
							</script>
							<div class="form-group tgllin">
								<label class="col-sm-4">Tanggal Kerja Lintas Hari</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgllin" name="tgllin" data-date-format="dd-mm-yyyy" value="<?php echo trim($lb->tgl_kerja2);?>" class="form-control" >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Awal</label>	
								<div class="col-sm-8">    
								<input type="text" name="jam_awal" data-inputmask='"mask": "99:99:99"' data-mask="" value="<?php echo trim($lb->jam_awal);?>" class="form-control">
								
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Selesai</label>	
								<div class="col-sm-8">    
								<input type="text" name="jam_selesai" data-inputmask='"mask": "99:99:99"' data-mask="" value="<?php echo trim($lb->jam_akhir);?>" class="form-control">				
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Durasi Istirahat(Menit)</label>	
								<div class="col-sm-8">    
									<input type="text"  name="durasi_istirahat" data-inputmask='"mask": "999"' data-mask="" value="<?php echo trim($lb->durasi_istirahat);?>" class="form-control" required>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Durasi Waktu(Jam)</label>	
								<div class="col-sm-8">    
									<input type="text"  name="durasi"  value="<?php echo trim($lb->jam);?>" class="form-control" readonly>
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dokumen</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($lb->tgl_dok1);?>"class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Kategori Lembur</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdtrx" id="kdtrx">
									  <?php foreach($list_trxtype as $listkan){?>
									  <option <?php if (trim($lb->kdtrx)==trim($listkan->kdtrx)) { echo 'selected';}?> value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>			
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" required><?php echo trim($lb->keterangan);?></textarea>
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
        <a type="button" class="btn btn-default" href="<?php echo site_url("trans/lembur/index");?>">Close</a>
         <button type="submit"  onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-primary">SIMPAN</button>  
	  </form>
	</div>  
	
   
<?php } ?>