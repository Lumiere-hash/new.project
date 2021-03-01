<?php 
/*
	@author : Fiky
*/
?>

<script type="text/javascript">
            $(function() {
                $("#table1").dataTable();
                $("#example2").dataTable();
                $("#example3").dataTable();                             
				$("#dateinput").datepicker();                               
				$("#dateinput1").datepicker(); 
				$("#dateinput2").datepicker(); 
				$("#dateinput3").datepicker(); 
				$("[data-mask]").inputmask();	
            });
		
</script>
<legend><?php echo $title.' BULAN '.$bulan.' TAHUN '.$tahun;
//$a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date));
// echo '<br>',$cekdate;
// echo '<br>',$a_date;
?></legend>
<?php echo $message;?>
<div id="message" >	
</div>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--button href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input Jadwal Kerja</button-->
					<a href="<?php echo site_url("trans/jadwal_new/view_jadwalsebulan")?>"  class="btn btn-success" style="margin:10px; color:#ffffff;">Input Jadwal Kerja</a>
					<button href="#" data-toggle="modal" data-target="#offjadwal" class="btn btn-primary" style="margin:10px; color:#ffffff;">Edit Jadwal Per Regu</button>
					<button href="#" data-toggle="modal" data-target="#gr_jadwal" class="btn btn-primary" style="margin:10px; color:#ffffff;">Generate Jadwal</button>
					<a href="<?php echo site_url("trans/jadwal_new/inputjadwal_sama")?>"  class="btn btn-danger" style="margin:10px; color:#ffffff;">Input Jadwal Regu Sama</a>
					<?php if($oprblmjadwal>0) { ?>
					<a href="<?php echo site_url("trans/jadwal_new/opr_belumjadwal");?>" class="btn btn-warning" style="margin:10px; color:#ffffff;">Nik Belum Terjadwal</a>
					<?php } ?>
					<button href="#" data-toggle="modal" data-target="#filter" class="btn btn-primary" style="margin:10px; color:#ffffff;">Filter</button>
					<button href="#" data-toggle="modal" data-target="#download_ex" class="btn btn-default" style="margin:10px; color:#000000;">Download Excel</button>
					
					
					<?php// $a_date="2016-10";echo date("t",strtotime($a_date));?>
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table1" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>																
							<th>No.</th>
							<th>Nik</th>
							<th>NAMA LENGKAP</th>
							<th>KDDEPT</th>
							<th>KDREGU</th>
							<th>BLN/THN</th>
							<th>1</th>
							<th>2</th>
							<th>3</th>
							<th>4</th>
							<th>5</th>
							<th>6</th>
							<th>7</th>
							<th>8</th>
							<th>9</th>
							<th>10</th>
							<th>11</th>
							<th>12</th>
							<th>13</th>
							<th>14</th>
							<th>15</th>
							<th>16</th>
							<th>17</th>
							<th>18</th>
							<th>19</th>
							<th>20</th>
							<th>21</th>
							<th>22</th>
							<th>23</th>
							<th>24</th>
							<th>25</th>
							<th>26</th>
							<th>27</th>
							<?php $a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date)); if($cekdate>=28){ ?><th>28</th><?php } ?> <!-- Fleksibel tanggal bro-->
							<?php $a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date)); if($cekdate>=29){ ?><th>29</th><?php } ?> <!-- Fleksibel tanggal bro-->
							<?php $a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date)); if($cekdate>=30){ ?><th>30</th><?php } ?> <!-- Fleksibel tanggal bro-->
						    <?php $a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date)); if($cekdate>=31){ ?><th>31</th><?php } ?> <!-- Fleksibel tanggal bro-->
							

						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach ($list_jadwal as $ls): $no++ ?>
							<tr>																													
								<td><?php echo $no;?></td>	
								<td><?php echo $ls->nik;?></td>								
								<td><?php echo $ls->nmlengkap;?></td>
								<td><?php echo $ls->bag_dept;?></td>								
								<td><?php echo $ls->kdregu;?></td>								
								<td><?php echo $ls->bulan.'/'.$ls->tahun;?></td>															
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-01'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl1;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-02'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl2;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-03'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl3;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-04'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl4;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-05'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl5;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-06'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl6;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-07'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl7;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-08'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl8;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-09'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl9;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-10'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl10;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-11'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl11;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-12'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl12;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-13'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl13;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-14'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl14;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-15'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl15;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-16'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl16;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-17'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl17;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-18'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl18;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-19'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl19;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-20'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl20;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-21'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl21;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-22'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl22;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-23'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl23;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-24'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl24;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-25'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl25;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-26'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl26;?></a></td>								
								<td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-27'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl27;?></a></td>								
								<?php $a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date)); if($cekdate>=28){ ?><td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-28'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl28;?></a></td><?php } ?>			<!-- Fleksibel tanggal bro-->					
								<?php $a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date)); if($cekdate>=29){ ?><td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-29'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl29;?></a></td><?php } ?>			<!-- Fleksibel tanggal bro-->					
								<?php $a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date)); if($cekdate>=30){ ?><td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-30'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl30;?></a></td><?php } ?>			<!-- Fleksibel tanggal bro-->					
								<?php $a_date=$tahun.'-'.$bulan;$cekdate=date("t",strtotime($a_date)); if($cekdate>=31){ ?><td><a <?php $nik=trim($ls->nik); $bln=trim($ls->bulan); $thn=trim($ls->tahun); $tgl=$thn.'-'.$bln.'-31'; ?> href="<?php echo site_url("trans/jadwal_new/edit_detail/$nik/$tgl");?>"><?php echo $ls->tgl31;?></a></td><?php } ?>			<!-- Fleksibel tanggal bro-->					
									
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>

  
  <!-- Bootstrap modal -->
 
 <!--Modal untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filter Jadwal Per Bulan</h4>
      </div>
	  <form action="<?php echo site_url('trans/jadwal_new/index')?>" method="post">
      <div class="modal-body">
        <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bln' required>
					
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
				<select class="form-control input-sm" name="thn" required>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
					<option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">KARYAWAN</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="pilihkaryawan2" name="nik">
							<option value="">--PILIH KARYAWAN--</option>
							<?php foreach ($list_karyawan as $ld){ ?>
							<option value="<?php echo trim($ld->nik);?>"><?php echo trim($ld->nik).'||'.$ld->nmlengkap;?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div>
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">REGU</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="kdregu2" name="kdregu">
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_regu as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
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
 
 
 <!--Modal Edit untuk Off Jadwal-->
<div class="modal fade" id="offjadwal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Edit Jadwal Per REGU</h4>
      </div>
	  <form action="<?php echo site_url('trans/jadwal_new/edit_jadwaloff')?>" method="post">
      <div class="modal-body">
	  	<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Pilih REGU</label>
			<div class="col-sm-9">
				<select class="form-control input-sm pilihrg" id="kdregu2" name="kdregu2">
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_regu as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div>
        <div class="form-group input-sm ">
		
			<label class="label-form col-sm-3">Pilih Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bln' required>
					
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
			<label class="label-form col-sm-3">Pilih Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="thn" required>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
					<option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">NEXT STEP</button>
      </div>
	  </form>
    </div>
  </div>
</div>

 <!--Modal untuk Filter DOWNLOAD EXCEL-->
<div class="modal fade" id="download_ex" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Filter Download Excel Jadwal Kerja</h4>
      </div>
	  <form action="<?php echo site_url('trans/jadwal_new/excel_dtljadwalall')?>" method="post">
      <div class="modal-body">
         <div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Type Download</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='typedl' required>
					<option value="BS">Download Jadwal Regu</option>
					<option value="BP">Download Jadwal Regu Samping</option>
					<option value="DT">Download Jadwal Detail</option>
					<option value="UP">Download Jadwal Untuk Produksi</option>
					
				</select>
			</div>			
		</div>

		<!--div class="form-group input-sm ">		
			<label class="label-form col-sm-3">REGU</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="kdregu2" name="kdregu">
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_regu as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div-->
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bln' required>
					
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
				<select class="form-control input-sm" name="thn" required>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
					<option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">Download XLS</button>
      </div>
	  </form>
    </div>
  </div>
</div>


 <!--Modal untuk Generate Jadwal Kerja Antar Bulan-->
<div class="modal fade" id="gr_jadwal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Generate Jadwal Kerja Antar Bulan</h4>
      </div>
	  <form action="<?php echo site_url('trans/jadwal_new/v_gr_jadwal')?>" method="post">
      <div class="modal-body">
	  	
		<div class="form-group input-sm ">
		
		<label class="label-form col-sm-3">Pilih Type Generate</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id='type_gr' name='type_gr' required>
					
					<option value="gr_template">Generate Dengan Template</option>
					<!--option value="gr_copying">Generate Copy Tabel Calendar</option-->

				</select>
			</div>			
		</div>
		
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Pilih REGU</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="kdregu3" name="kdregu" required>
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_reguinjadwal as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div>
        
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Bulan Awal/Referensi</label>
			<div class="col-sm-9">
			<input type="number" id="bln_awal" name="bln_awal" style="text-transform:uppercase" maxlength="200" class="form-control" readonly required></input>
			</div>			
		</div>	
		
		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Tahun dari Bulan Awal/Referensi</label>
			<div class="col-sm-9">
			<input type="number" id="thn_awal" name="thn_awal" style="text-transform:uppercase" maxlength="200" class="form-control" readonly required></input>
			</div>			
		</div>	
		<!--div class="form-group input-sm ">
		
			<label class="label-form col-sm-3">Pilih Bulan Awal</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id='bln_awal' name='bln_awal' required readonly>
					
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
		</div-->
		<!--div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Pilih Tahun dari Bulan Awal</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="thn_awal" name="thn_awal" required>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div-->
		<div><br><br><br></div>

		<div class="form-group input-sm ">
		
			<label class="label-form col-sm-3">Pilih Bulan Akhir</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id='bln_akhir' name='bln_akhir' required>
					
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
			<label class="label-form col-sm-3">Pilih Tahun dari Bulan Akhir</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" id="thn_akhir" name="thn_akhir" required>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>												
					<option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>							
					<option value='<?php $tgl=date('Y')+2; echo $tgl; ?>'><?php $tgl=date('Y')+2; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>
		<!--script>
			i = 0;
			$(document).ready(function(){
				$("#bln_akhir").keypress(function(){
					$("#bln_awal").text(i += 1);
				});
			});
		</script-->
		
		
		<script type="text/javascript" charset="utf-8">
							$(function() {
												var bln_akhir=parseInt($('#bln_akhir').val());
												var thn_akhir=parseInt($('#thn_akhir').val());
													if(bln_akhir>1){
													$('#bln_awal').val(bln_akhir-1);
													$('#thn_awal').val(thn_akhir);	
													}else{
													$('#bln_awal').val(12);	
													$('#thn_awal').val(thn_akhir-1);	
													}
											$('#bln_akhir').change(function(){
												var bln_akhir=parseInt($(this).val());
												var thn_akhir=parseInt($('#thn_akhir').val());
												var cekbln=$('#bln_awal').val(bln_akhir-1);
													
													//alert(bln_awal);
													if(bln_akhir>1){
													$('#bln_awal').val(bln_akhir-1);
													$('#thn_awal').val(thn_akhir);	
													}else{
													$('#bln_awal').val(12);	
													$('#thn_awal').val(thn_akhir-1);	
													}
											});
										});	
		</script>
      </div>
      <div class="modal-footer">
	  <button align="left" href="#" data-toggle="modal" data-target="#v_template" class="btn btn-success pull-left" data-dismiss="modal" style="margin:10px; color:#ffffff;">Template</button>
	  <button align="left" href="#" data-toggle="modal" data-target="#reset_jd" class="btn btn-danger pull-left" data-dismiss="modal" style="margin:10px; color:#ffffff;">Reset Jadwal</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-primary">NEXT STEP</button>
      </div>
	  </form>
    </div>
  </div>
</div>


 <!--Modal RESET JADWAL SEBULAN-->
<div class="modal fade" id="reset_jd" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">RESET JADWAL SEBULAN</h4>
      </div>
	  <form action="<?php echo site_url('trans/jadwal_new/reset_jadwal_bulanan')?>" method="post">
      <div class="modal-body">
	  	<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Pilih REGU</label>
			<div class="col-sm-9">
				<select class="form-control input-sm pilihrg" id="kdregu4" name="kdregu">
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_regu as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div>
        <div class="form-group input-sm ">
		
			<label class="label-form col-sm-3">Pilih Bulan</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name='bln' required>
					
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
			<label class="label-form col-sm-3">Pilih Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="thn" required>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
					<option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-danger" onClick="alert('PERINGATAN KETIKA MELAKUKAN RESET MAKA JADWAL KERJA DARI BULAN&TAHUN YG ANDA PILIH DAN SETERUSNYA AKAN TERHAPUS, SILAHKAN CLICK PROSES JIKA ANDA YAKIN UNTUK MELAKUKAN RESET!!')">PROCESS RESET</button>
      </div>
	  </form>
    </div>
  </div>
</div>


 <!--Modal TEMPLATE SATU TAHUN-->
<div class="modal fade" id="v_template" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">LIHAT TEMPLATE 1 TAHUN</h4>

      </div>
	  <form action="<?php echo site_url('trans/jadwal_new/v_template')?>" method="post">
      <div class="modal-body">
	  	<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Pilih REGU</label>
			<div class="col-sm-9">
				<select class="form-control input-sm pilihrg" id="kdregu4" name="kdregu">
							<option value="">--Pilih Nama Regu--</option>
							<?php foreach ($list_regu as $ld){ ?>
							<option value="<?php echo trim($ld->kdregu);?>"><?php echo $ld->nmregu;?></option>
							<?php } ?>																																					
						</select>
			</div>			
		</div>

		<div class="form-group input-sm ">		
			<label class="label-form col-sm-3">Pilih Tahun</label>
			<div class="col-sm-9">
				<select class="form-control input-sm" name="thn" required>
					<option value='<?php $tgl=date('Y'); echo $tgl; ?>'><?php $tgl=date('Y'); echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-1; echo $tgl; ?>'><?php $tgl=date('Y')-1; echo $tgl; ?></option>
					<option value='<?php $tgl=date('Y')-2; echo $tgl; ?>'><?php $tgl=date('Y')-2; echo $tgl; ?></option>					
					<option value='<?php $tgl=date('Y')+1; echo $tgl; ?>'><?php $tgl=date('Y')+1; echo $tgl; ?></option>					
				</select>
			</div>			
		</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="submit1" class="btn btn-success" >PROCESS</button>
      </div>
	  </form>
    </div>
  </div>
</div>


 <script>
 
	//Date range picker
    $('#tgl').datepicker();
    $('#tgl2').datepicker();
	$('#pilihkaryawan').selectize();
	$('#pilihkaryawan2').selectize();
	$('#kdregu').selectize();
	$('#kdregu2').selectize();
	$('#kdregu3').selectize();
	$('.pilihrg').selectize();
	$("[data-mask]").inputmask();
	$("#nmjamkerja1").chained("#kdjamkerja1");		
	$("#disb").chained("#city");	

</script>