<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />

<legend><?php echo $title;?></legend>
				<div class="row">
                    <div class="col-xs-6">
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>Laporan Absensi Uang Makan</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('trans/uang_makan/list_um');?>" name="form" role="form" method="post">										
										<div class="form-group">
											<label class="col-lg-3">Wilayah</label>	
												<div class="col-lg-9">    
													<select class='form-control' name="kanwil">
														<?php foreach ($kanwil as $kl){?>
															<option value="<?php echo $kl->kdcabang;?>"><?php echo $kl->desc_cabang;?></option>
														<?php }?>
													</select>
												</div>
										</div>
										<!--area-->
										
										<div class="form-group">
											 <label class="col-lg-3">Tanggal</label>
											<div class="col-lg-9">
												<div class="input-group">
													<div class="input-group-addon">
														<i class="fa fa-calendar"></i>
													</div>
													<input type="text" id="tgl" name="tgl"  class="form-control pull-right">
												</div><!-- /.input group -->
											</div>
										</div>
										<div class="form-group"> 
											<div class="col-lg-4">
												<button type='submit' class='btn btn-primary' ><i class="glyphicon glyphicon-search"></i> Proses</button>
											   <!-- <button id="tampilkan" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i> Tampilkan</button>-->
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
		
	

<script>

  

	
	//Date range picker
    $('#tgl').daterangepicker();

  

</script>