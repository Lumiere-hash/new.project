<?php 
/*
	@author : hanif_anak_metal \m/
*/
error_reporting(0);
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $('#example2').dataTable({
                    "bPaginate": true,
                    "bLengthChange": false,
                    "bFilter": false,
                    "bInfo": true,
                    "bSort": true,
                    "bAutoWidth": false
                });
            });
</script>
<legend>Daftar Absensi Tanggal <?php echo $tgl;?></legend>

<div class="row">
                        <div class="col-xs-12">                            
                            <div class="box">
								<div class="box-header">
								
									<form action="<?php echo site_url('trans/uang_makan/pdf');?>" name="form" role="form" method="post">		
										<input type="hidden" name='kdcabang' value="<?php echo $kdcabang;?>">
										<input type="hidden" name='tgl' value="<?php echo $tgl;?>">										
										<button type="submit" class="btn btn-primary" style="margin:10px">
										
										<i class="glyphicon glyphicon-file"></i> PDF</button>
										<a href="<?php echo site_url("trans/uang_makan/excel_absensi/$kdcabang/$tgl1/$tgl2");?>" class="btn btn-primary" style="margin:10px; color:#ffffff;">XLS</a>
										<a href="<?php echo site_url("trans/uang_makan/cetak_uangmakan/$kdcabang/$tgl1/$tgl2");?>" class="btn btn-primary" style="margin:10px; color:#ffffff;">CETAK</a>
										<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-success" style="margin:10px; color:#ffffff;">FILTER</a>
									</form>
									
                                </div><!-- /.box-header -->
								
                                <div class="box-body table-responsive">
                                    <table id="example1" class="table table-bordered table-striped" >
                                        <thead>
											<tr>
												<th>No.</th>
												<th>Nama</th>
												<th>Departemen</th>
												<th>Jabatan</th>
												<th>Tanggal</th>
												<th>Checktime</th>																					
												<th>Keterangan</th>												
												<th>Uang Makan</th>												
											</tr>
										</thead>
                                        <tbody>
                                            <?php $no=0; foreach($list_um as $um){ $no++;?>
											<tr>
												<td><?php echo $no;?></td>
												<td><?php echo $um->nmlengkap;?></td>
												<td><?php echo $um->nmdept;?></td>
												<td><?php echo $um->nmjabatan;?></td>
												<td><?php echo $um->tglhari;?></td>
												<td><?php echo $um->checktime;?></td>
												<td><?php echo $um->keterangan;?></td>												
												<td><?php echo $um->nominalrp;?></td>
											</tr>
											<?php }?>
                                        </tbody>
                                    </table>
                                </div><!-- /.box-body -->
                            </div><!-- /.box -->
                        </div>
</div>
<!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filter Laporan Absensi</h4>
      </div>
	  <form action="<?php echo site_url('trans/uang_makan/list_um');?>" name="form" role="form" method="post">	
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Wilayah</label>
				<div class="col-lg-9">    
					<select class='form-control' name="kanwil">
						<?php foreach ($kanwil as $fpwil){?>
							<option value="<?php echo $fpwil->kdcabang;?>"><?php echo $fpwil->desc_cabang;?></option>
						<?php }?>
					</select>
				</div>
		</div>		
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tanggal</label>
			<div class="col-lg-9">
			<div class="input-group">
					<div class="input-group-addon">
						<i class="fa fa-calendar"></i>
					</div>
					<input type="text" id="tgl" name="tgl" data-date-format="dd-mm-yyyy" class="form-control pull-right">
				</div><!-- /.input group -->
			</div>	
		</div>

    
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-success">Process</button>
      </div>
	  </form>
    </div>
  </div>
</div>


<script>
	//Date range picker
    $('#tgl').daterangepicker();
</script>