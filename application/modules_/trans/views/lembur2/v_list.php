<?php 
/*
	@author : junis 10-12-2012\m/
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
 <script>
    /*$(document).ready(function() {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function(evt) { if (evt.persisted) disableBack() }
    });*/
</script> 

<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<a href="<?php echo site_url("trans/lembur/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
					<a href="#" data-toggle="modal" data-target="#filter" class="btn btn-primary" style="margin:10px; color:#ffffff;">FILTER</a>
				</div>
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<!--<th>NIK</th>
							<th>Nama Karyawan</th>-->
							
							<th>Nomer Dokumen</th>										
							<th>NIK</th>										
							<th>Nama Karyawan</th>										
							<th>Nama Department</th>										
							<th>Tanggal Lembur</th>										
							<th>Durasi Lembur(Jam)</th>										
							<th>Status</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_lembur as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><?php echo $lu->nodok;?></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->tgl_kerja1;?></td>
							<td><?php echo $lu->jam;?></td>
							<td><?php echo $lu->status1;?></td>
							<td>
								<a data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok);?>" href='#' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'P' and trim($lu->status)<>'D') {?>
								<a data-toggle="modal" data-target="#<?php echo trim($lu->nodok);?>" href='#' class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Edit
								</a>
								<?php } ?>
								<?php if (trim($position=="PSO") or trim($position=='IT')){?>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/lembur/hps_lembur/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
								<?php }?>
							</td>
						</tr>
						<?php endforeach;?>
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
        <h4 class="modal-title" id="myModalLabel">Peridoe Lembur</h4>
      </div>
	  <form action="<?php echo site_url('trans/lembur/index')?>" method="post">
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


<!--Modal untuk Edit Nama Bpjs-->
<?php foreach ($list_lembur_dtl as $lb){?>
<div class="modal fade" id="<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Lembur Karyawan</h4>
      </div>
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
							<div class="form-group">
								<label class="col-sm-4">Keterangan</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" ><?php echo trim($lb->keterangan);?></textarea>
									<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
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
									  <?php foreach($list_lembur_edit as $listkan){?>
									  <option <?php if (trim($lb->kdlembur)==trim($listkan->tplembur)) { echo 'selected';}?> value="<?php echo trim($listkan->tplembur);?>" ><?php echo $listkan->tplembur;?></option>						  
									  <?php }?>
									</select>
									</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jenis Lembur</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="jenis_lembur" id="kdgrade">
									  
									  <option <?php if (trim($lb->jenis_lembur)=='D1'){ echo 'selected';} ?> value="D1">DURASI ABSEN</option>						  
									  <option <?php if (trim($lb->jenis_lembur)=='D2'){ echo 'selected';} ?> value="D2">NON-DURASI ABSEN</option>						  
									  
									</select>
								</div>
							</div>
							<script type="text/javascript">
								$(function() {                         
									$("#dateinput<?php echo trim($lb->nodok);?>").datepicker();                               
								});
							</script>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="dateinput<?php echo trim($lb->nodok);?>" value="<?php echo trim($lb->tgl_kerja1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control">
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Awal</label>	
								<div class="col-sm-8">    
								<input type="text" name="jam_awal" data-inputmask='"mask": "99:99:99"' data-mask="" value="<?php echo trim($lb->tgl_jam_mulai);?>" class="form-control">
								
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Jam Selesai</label>	
								<div class="col-sm-8">    
								<input type="text" name="jam_selesai" data-inputmask='"mask": "99:99:99"' data-mask="" value="<?php echo trim($lb->tgl_jam_selesai);?>" class="form-control">				
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Durasi Istirahat(Menit)</label>	
								<div class="col-sm-8">    
									<input type="text"  name="durasi_istirahat" data-inputmask='"mask": "99"' data-mask="" value="<?php echo trim($lb->durasi_istirahat);?>" class="form-control" required>
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
								<label class="col-sm-4">Alasan Lembur</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdtrx" id="kdtrx">
									  <?php foreach($list_trxtype as $listkan){?>
									  <option <?php if (trim($lb->kdtrx)==trim($listkan->kdtrx)) { echo 'selected';}?> value="<?php echo trim($listkan->kdtrx);?>" ><?php echo $listkan->uraian;?></option>						  
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
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="submit"  onclick="return confirm('Anda Yakin Edit Data ini?')" class="btn btn-primary">SIMPAN</button>  
	  </form>
	</div>  
	
    </div>
  </div>
</div>
<?php } ?>


<!--Modal untuk Detail Bpjs Karyawan-->
<?php foreach ($list_lembur_dtl as $lb){?>
<div class="modal fade" id="dtl<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail lembur Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/lembur/approval')?>" method="post">
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
								<label class="col-sm-4">Tipe Lembur</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdlembur"  value="<?php echo trim($lb->kdlembur); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
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
								<label class="col-sm-4">Durasi Istirahat(Menit)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="durasi_istirahat" placeholder="0" value="<?php echo trim($lb->durasi_istirahat); ?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Durasi(Menit)</label>	
								<div class="col-sm-8">    
									<input type="text" id="gaji" name="durasi"  value="<?php echo trim($lb->jam); ?>"  class="form-control" readonly >
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Alasan Lembur</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl1" name="kdtrx"  value="<?php echo trim($lb->uraian);?>"class="form-control" readonly>
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
	<?php if (trim($lb->status)=='A'){ ?>
	
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="submit"  class="btn btn-primary">APPROVAL</button>  
	 
	  
	</div>  
	 </form>
	<div class="modal-footer">
		<form action="<?php echo site_url('trans/lembur/cancel');?>" method="post">
			<input type="hidden" value="<?php echo trim($lb->nodok);?>" name="nodok">
			<input type="hidden" value="<?php echo trim($lb->nik);?>" name="nik">
			<input type="hidden" id="tgl1" name="tgl"  value="<?php echo date('d-m-Y H:i:s');?>"class="form-control" readonly>
			<input type="hidden" id="inputby" name="inputby"  value="<?php echo $this->session->userdata('nik');?>" class="form-control" readonly>
			<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Membatalkan <?php echo $lb->nodok;?>?')">Cancel</button>
		
	</div> 
		</form>

	
	<?php } ?>
    </div>
  </div>
</div>
<?php } ?>


