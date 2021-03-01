<legend><?php echo $title;?></legend>
<?php echo $message;?>
				<div class="row">
                    <div class="col-xs-6">
						<div class="box">
							<div class="box-header">
                                <button class="btn btn-default"data-toggle="modal" data-target="#filter_option" ><i class="fa fa-gear"></i></button>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
									<form action="<?php echo site_url('trans/absensi/show_mobile_attendance');?>" name="form" role="form" method="post">
										<!--area-->
										<div class="form-group">
											 <label class="col-lg-3">Tanggal Tarikan Terakhir</label>
											<div class="col-lg-9">
												<div class="input-group">
													<input type="input" id="tglakhir" name="tglakhir"  class="form-control pull-right" readonly>
												</div><!-- /.input group -->
											</div>
										</div>
										<div class="form-group">
											 <label class="col-lg-3">Pilih Wilayah</label>
											<div class="col-lg-9">
												<select id="kdcabang" name="kdcabang" required>
												<option value="">--Pilih Wilayah--</option>
												<?php foreach ($list_kanwil as $ld){ ?>
												<option value="<?php echo trim($ld->kdcabang);?>"><?php echo $ld->kdcabang.' || '.$ld->desc_cabang;?></option>
												<?php } ?>
											</select>
											</div>
										</div>


							<script type="text/javascript" charset="utf-8">
							$(function() {
										$('#kdcabang').change(function(){

												var cabang=$(this).val();

												  $.ajax({
													url : "<?php echo site_url('trans/absensi/ajax_tglakhir_mobile_cabang')?>/" + $(this).val(),
													type: "GET",
													dataType: "JSON",
													success: function(data)
													{
													   $('[name="tglakhir"]').val(data.lastdate);
														//alert('cok');
													},
													error: function (jqXHR, textStatus, errorThrown)
													{
														alert('Error get data from ajax');
													}
												});


											});

										});

	</script>

                                        <div class="form-group">
                                            <label class="col-lg-3">Pilih Aplikasi Mobile</label>
                                            <div class="col-lg-9">
                                                <select id="maplikasi" name="maplikasi" required>
                                                    <option value="MCRM"> MOBILE CRM </option>
                                                    <option value="MABS"> MOBILE ABSENSI </option>
                                                </select>
                                            </div>
                                        </div>

										<?php if($akses['aksesconvert']=='t'){?>
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
											<?php } else { echo 'anda tidak diperkenankan mengakses modul ini!!!!';} ?>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>


<div class="modal fade" id="filter_option" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                <h4 class="modal-title" id="myModalLabel"> SETTING OPTION PENGATURAN SERVER DIRECT </h4>
            </div>
            <form action="<?php echo site_url('trans/absensi/save_option')?>" method="post" >
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">BRANCH</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="branch" id="branch" value="<?php echo trim($dtl_opt['branch']); ?>" class="form-control input-sm ratakanan"  >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">HOST ADDRESS</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="c_hostaddr" id="c_hostaddr" value="<?php echo trim(base64_decode($dtl_opt['c_hostaddr'])); ?>" class="form-control input-sm ratakanan"  >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">DB NAME</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="c_dbname" id="c_dbname" value="<?php echo trim(base64_decode($dtl_opt['c_dbname'])); ?>" class="form-control input-sm ratakanan"  >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">USERDB</label>
                                            <div class="col-sm-8">
                                                <input type="password" name="c_userpg" id="c_userpg" value="" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">PASSDB</label>
                                            <div class="col-sm-8">
                                                <input type="password" name="c_passpg" id="c_passpg" value="" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <label class="col-sm-4" for="inputsm">KETERANGAN</label>
                                            <div class="col-sm-8">
                                                <input type="text" name="description" id="description" value="<?php echo trim($dtl_opt['description']); ?>" class="form-control input-sm ratakanan" required >
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                                </div><!-- /.box -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" id="submit"  class="btn btn-primary">SIMPAN</button>
                    </div>
            </form>
        </div>
    </div>
</div>




<script>




	//Date range picker
    $('#tgl').daterangepicker();
    $('#kdcabang').selectize();
    $('#maplikasi').selectize();



</script>
