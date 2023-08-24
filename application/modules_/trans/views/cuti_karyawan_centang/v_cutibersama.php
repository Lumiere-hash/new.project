<script type="text/javascript">
            $(function() {
                $("#test1").dataTable();
                $("#example1").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
				<?php foreach($listhiscuti as $jvascpt){  
					echo	'$("#'.trim($jvascpt->nodok).'").dataTable(); ';
					//echo	'$("#tgl'.trim().'").datepicker(); ';-->
				}?>
            });
		
</script>

<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">	
				<a href="<?php echo site_url("trans/cuti_karyawan/addcutibersama")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
			</div>
		</div>
	</div>
	<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							
							<th>Nomer Dokumen</th>
							<th>TGL DOKUMEN</th>	
							<th>STATUS</th>										
							<th>TGL AWAL</th>
							<th>TGL AKHIR</th>
							<th>Jumlah Cuti</th>
							<th>KETERANGAN</th>										
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($listhiscuti as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>	
							<td><a href="#" data-toggle="modal" data-target=".<?php echo $lu->nodok;?>"><?php echo $lu->nodok;?></a></td>							
							<!--td><?php echo $lu->nodok;?></td-->
							<td><?php echo $lu->tgl_dok;?></td>
							<td><?php echo $lu->status;?></td>
							
							<td><?php echo $lu->tgl_awal;?></td>
							<td><?php echo $lu->tgl_akhir;?></td>
							<td><?php echo $lu->jumlahcuti;?></td>
							<td><?php echo $lu->keterangan;?></td>
							<td>
								<?php if (trim($lu->status)<>'P' and trim($lu->status)<>'F') {?>
								<a href="<?php echo site_url("trans/cuti_karyawan/cutibersamaoto/$lu->nodok");?>"  class="btn btn-success">Save Final</a>
								<a href="<?php echo site_url("trans/cuti_karyawan/hps_cutibersama/$lu->nodok");?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-danger">Hapus</a>
								<?php } ?>
								<?php if (trim($lu->status)=='P') {
								 
								echo "Final"; } ?>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
		</div><!-- /.box-body -->	
	</div>
</div>

	<!--Modal untuk edit-->
<?php $no=0; foreach($listhiscuti as $lu){ $no++;?>								
		<div class="modal fade <?php echo trim($lu->nodok,'');?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
				<div class="modal-dialog modal-lg">
									<div class="modal-content">
										<form class="form-horizontal" action="<?php echo site_url('dashboard/edit_user');?>" method="post">
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
											<h4 class="modal-title" id="myModalLabel">EDIT</h4>
										</div>
										<div class="modal-body">
										
											<div class="row">
												<div class="box">
													<div class="box-body table-responsive">
														<table id="example3" class="table table-bordered table-striped" >
															<thead>
																<tr>																	
																	<th>Pilih</th> 
																	<th>Nik</th>
																	<th>Nama Karyawan</th>
																	<th>Departemen</th>
																</tr>
															</thead>
															<tbody>
																<?php $no=0; foreach($listkary as $db){ $no++;?>
																<tr>																	
																	<td><input name="<?php echo trim($db->nik);?>" value="Y" type="checkbox" <?php foreach ($listblc as $usr) {																		
																		if ($usr->no_dokumen==$lu->nodok and $db->nik==$usr->nik){
																			echo 'checked';
																		} 
																	}//if ($col->userid==$row->userid) { echo 'checked';}?>></td>															
																	<td><?php echo $db->nik;?></td>
																	<td><?php echo $db->nmlengkap;?></td>
																	<td><?php echo $db->bag_dept;?></td>																	
																</tr>
																<?php }?>
															</tbody>
														</table>
													</div><!-- /.box-body -->
												</div>
											</div>
											
										</div>
										<div class="modal-footer">											
											<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Simpan Perubahan User: <?php echo $lu->nodok;?>?')">Simpan</button>	
											<a class="btn btn-primary" href="<?php echo site_url('dashboard/hapus_user/'.$lu->nodok);?>" data-toggle="tooltip" data-placement="top" title="Hapus" onclick="return confirm('Hapus User: <?php echo $lu->nodok;?>?')"><i class="glyphicon glyphicon-trash"></i>Hapus</a>											
											<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
										</div>
										</form>
									</div>
								  </div>
								</div>
								<?php }?>
								
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
</div>
	