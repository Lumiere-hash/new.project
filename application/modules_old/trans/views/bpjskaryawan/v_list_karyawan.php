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
				$("[data-mask]").inputmask();	
            });
</script>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <legend>
            <?php echo $title;?>
        </legend>
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
    </section>
</div>

<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped" >
					<thead>
						<tr>
							<th>No.</th>
							<th>Action</th>	
							<th>NIK</th>
							<th>Nama Karyawan</th>					
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_karyawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td>
								<a href='<?php echo site_url("trans/bpjskaryawan/index/$lu->nik")?>' onclick="return confirm('Anda Yakin Input Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail BPJS Karyawan
								</a>
							</td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>





