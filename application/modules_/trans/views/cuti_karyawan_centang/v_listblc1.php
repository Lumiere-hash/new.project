<?php 
/*
	@author : junis 10-12-2012\m/
*/
?>
<script type="text/javascript">
            $(function() {
                $("#example1").dataTable();
                $("#kary").selectize();
                $("#moduser").selectize();
                $("#tahun").selectize();
               
				
            });					
</script>

<legend><?php echo $title;?></legend>

<div class="row">
			<form class="form-inline" action="<?php echo site_url('trans/cuti_karyawan/cutibalance');?>" method="post" role="form">
								<!--div class="form-group" role="form"-->
									<label class="col-sm-2">PERIODE CUTI KARYAWAN</label>	
									<div class="col-sm-2"> 
									<select id="tahun" Name='pilihtahun' required>
										<option value=""><?php echo $tahune; ?></option>

										<?php
										for ($ngantukjeh=2020; $ngantukjeh>2000; $ngantukjeh--)
										  { 
											echo'<option value="'.$ngantukjeh.'">'.$ngantukjeh.'</option>'; 
										  } 
										?> 
									</select>
									</div>
		
			<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Dengan Data Yang Di Pilih?')">Lihat Data</button>
			<a href="pr_hitungallcuti" class="btn btn-danger" style="margin:10px; color:#ffffff;"> HITUNG CUTI </a>
			</form>
					

	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>NIK</th>
							<th>NAMA</th>	
							<th>TANGGAL</th>
						
							<th>TIPE DOKUMEN</th>	
							<th>IN CUTI</th>					
							<th>OUT CUTI</th>					
							<th>SALDO AKHIR</th>					
							<th>STATUS</th>	
							<th>ACTION</th>	
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($listblc as $lb): $no++;?>
						<tr>										
							<td><?php echo $no;?></td>																							
							<td><?php echo $lb->nik;?></td>
							<td><?php echo $lb->nmlengkap;?></td>
							<td><?php echo $lb->tanggal;?></td>
						
							<td><?php echo $lb->doctype;?></td>
							<td><?php echo $lb->in_cuti;?></td>
							<td><?php echo $lb->out_cuti;?></td>
							<td><?php echo $lb->sisacuti;?></td>
							<td><?php echo $lb->status;?></td>
							<td><form action="<?php echo site_url('/trans/cuti_karyawan/cutibalancedtl');?>" method="post" >
												<input type="hidden" value="<?php echo trim($lb->nik);?>" name='kdkaryawan'>
												<input type="hidden" value="<?php echo $tahune;?>" name='tahunlek'>
												
												<button type='submit' class="btn btn-success">Detail</button>
								</form>
							</td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


<!--Hitung Cuti Karyawan-->
	<div class="modal fade baru"  role="dialog" >
	  <div class="modal-dialog modal-sm-12">
		<div class="modal-content">
			<form class="form-horizontal" action="<?php echo site_url('trans/cuti_karyawan/cutibalance');?>" method="post">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Tutup</span></button>
				<h4 class="modal-title" id="myModalLabel">Hitung Ulang Cuti Karyawan</h4>
			</div>
			<div class="modal-body">										
			<div class="row">
				<div class="col-lg-12">
					<div class="box box-danger">
						<div class="box-body">
							<div class="form-horizontal">								
								
								<div class="form-group">
									<label class="col-sm-4">PILIH NIK DAN Karyawan</label>
									<div class="col-sm-8">
										<select id="moduser" name="kdkaryawan" required>
											<option value="">--Pilih NIK || Nama Karyawan--></option>
											<?php foreach ($listkaryawan as $db){?>
											<option value="<?php echo trim($db->nik);?>"><?php echo str_pad($db->nik,50).' || '.str_pad($db->nmlengkap,50);?></option>
											<?php }?>
										</select>	
									</div>				
								</div>
							
							</div>
							</div>
						</div><!-- /.box-body -->													
					</div><!-- /.box --> 
				</div>			
			</div><!--row-->
			
			
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-primary" onclick="return confirm('Yakin Akan Di Process?')">Process</button>											
			</div>
			
			</form>
			</div>
		</div> 
	</div>




