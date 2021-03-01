<?php 
/*
	@author : Fiky Ashariza 07/01/2017
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
<ol class="breadcrumb">
    <div class="pull-right"><i style="color:transparent;"><?php echo $t; ?></i> Versi: <?php echo $version; ?></div>
    <?php foreach ($y as $y1) { ?>
        <?php if( trim($y1->kodemenu)!=trim($kodemenu)) { ?>
            <li><a href="<?php echo site_url( trim($y1->linkmenu)) ; ?>"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo  trim($y1->namamenu); ?></a></li>
        <?php } else { ?>
            <li class="active"><i class="fa <?php echo trim($y1->iconmenu); ?>"></i> <?php echo trim($y1->namamenu); ?></li>
        <?php } ?>
    <?php } ?>
</ol>
<h3><?php echo $title; ?></h3>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<?php if($akses['aksesinput']=='t') { ?>
					<a href="<?php echo site_url("trans/dinas/input")?>"  class="btn btn-success" style="margin:10px; color:#ffffff;"><i class="fa fa-plus"></i> Input</a>
					<?php } ?>
					<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-default" style="margin:10px; color:#000000;"><i class="fa fa-search"></i> FILTER</a>
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
						
							<th>Nomer Dokumen</th>										
							<th>NIK</th>																			
							<th>Nama Karyawan</th>																			
							<th>Department</th>																			
							<th>Keperluan</th>																			
							<!--th>Tujuan</th-->
							<th>Tanggal Mulai</th>																			
							<th>Tanggal Selesai</th>																			
							<th>Status</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_dinas as $lu): $no++;?>
						<tr>										
							<td width="1%"><?php echo $no;?></td>
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->keperluan;?></td>
							<!--td><?php echo $lu->tujuan;?></td-->
							<td><?php echo date('d-m-Y',strtotime($lu->tgl_mulai));?></td>
							<td><?php echo date('d-m-Y',strtotime($lu->tgl_selesai));?></td>
							<td><?php echo $lu->status1;?></td>
							<td align="8%">
                                <a href="<?php
                                $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                echo site_url("trans/dinas/detail".'/'.$enc_nodok);?>" class="btn btn-default  btn-sm" title="Detail">
                                    <i class="fa fa-bars"></i>
                                </a>
								<?php if (trim($lu->nik)!=trim($nama) or trim($lu->status)=='P' or trim($lu->status)=='D' or trim($lu->status)=='C') { ?>

                                <?php if (($userhr>0 or $level_akses=='A') and trim($lu->status)=='P') { ?>
                                        <a  href="<?php $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                            echo site_url("trans/dinas/batal_dinas".'/'.$enc_nodok)?>" onclick="return confirm('Anda Yakin Membatalkan Data ini?')" class="btn btn-danger  btn-sm" title="Batalkan">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                <?php } ?>
								<?php } ?>	
								<?php if (trim($lu->status)=='P') { ?>
									<button class="button btn btn-warning  btn-sm" onClick="window.open('<?php
                                    $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                    echo site_url("trans/dinas/cetak_tok".'/'.$enc_nodok);?>');" title="Cetak Dinas"><i class="fa fa-print"></i></button>
								<?php } ?>	
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'P' and trim($lu->status)<>'D') {?>
									<?php if ($akses['aksesupdate']=='t') { ?>
									<a href="<?php
                                        $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                        echo site_url("trans/dinas/edit".'/'.$enc_nodok);?>"onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-primary  btn-sm" title="Ubah">
										<i class="fa fa-gear"></i>
									</a>
                                    <a href="<?php
                                    $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                    echo site_url("trans/dinas/resend_sms".'/'.$enc_nodok)?>"  class="btn btn-warning  btn-sm"  title="Kirim Ulang SMS Approval"><i class="fa fa-envelope-o"></i></a>
                                    </a>
                                    <a  href="<?php $enc_nodok=bin2hex($this->encrypt->encode(trim($lu->nodok)));
                                    echo site_url("trans/dinas/batal_dinas".'/'.$enc_nodok)?>" onclick="return confirm('Anda Yakin Membatalkan Data ini?')" class="btn btn-danger  btn-sm" title="Batalkan">
                                        <i class="fa fa-trash-o"></i>
                                    </a>
									<?php } ?>
								<?php } ?>
							</td>
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

<!--Modal Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Periode DINAS Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/dinas/index')?>" method="post">
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
				    <option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Status</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="status">
					<option value="">SEMUA</option>
					<option value="P">DISETUJUI</option>
					<option value="A">PERLU PERSETUJUAN</option>
					<option value="C">DIBATALKAN</option>				
					<option value="D">DIHAPUS</option>				
				</select>
			</div>			
		</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">Filter</button>
      </div>
	  </form>
    </div>
  </div>
</div>




