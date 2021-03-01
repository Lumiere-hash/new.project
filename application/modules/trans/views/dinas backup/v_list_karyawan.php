<?php 
/*
	@author : Fiky 07/01/2016
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
				$("#tglberangkat").datepicker(); 
				$("#tglkembali").datepicker(); 	
				$("#tgl").daterangepicker({
    top: 1000,
    left: 100000, 
	pickerPosition: "top-left",
}); 				
            });
			


</script>

<legend><?php echo $title;?></legend>



				<div class="col-sm-12">		
					<a href="<?php echo site_url("trans/dinas/index")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<!--input type="button" class="check" value="check all" /-->
					
				</div>
<div class="row">	
				
 <form role="form" action="<?php echo site_url("trans/dinas/add_multinik");?>" method="post">
 	<div class="col-xs-6">
						<div class="box">
							<div class="box-header">
								<div class="col-xs-12">
									<h4>INPUT DINAS KARYAWAN</h4>
								</div>
							</div>
                            <div class="box-body">
								<div class="form-horizontal">
								
				<div class="box box-primary">
					<div class="box-body">
						<div class="form-horizontal">
							<div class="form-group">
								<label class="col-sm-4">Kategori Keperluan</label>	
								<div class="col-sm-8">    
									<select class="form-control input-sm" name="kdkategori" id="kdkategori" required>
									  <option value="">--PILIH KATEGORI KEPERLUAN--</option>
									  <?php foreach($list_kategori as $listkan){ ?>
									  <option value="<?php echo trim($listkan->kdkategori);?>" ><?php echo $listkan->kdkategori.' || '.$listkan->nmkategori;?></option>						  
									  <?php }?>
									</select>
								</div>
							</div>
						
							<div class="form-group">
								<label class="col-sm-4">Keperluan Dinas</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="kepdinas" name="kepdinas"   style="text-transform:uppercase" class="form-control" required ></textarea>
								</div>
							</div>		
							<div class="form-group">
								<label class="col-sm-4">Tujuan Dinas</label>	
								<div class="col-sm-8">    
									<textarea type="text" id="tujdinas" name="tujdinas"   style="text-transform:uppercase" class="form-control" required ></textarea>
								</div>
							</div>	
							<!--div class="form-group">
								<label class="col-sm-4">Tanggal Berangkat</label>	
								<div class="col-sm-8">    
									<input type="text" id="tglberangkat" name="tglberangkat" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div>	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kembali</label>	
								<div class="col-sm-8">    
									<input type="text" id="tglkembali" name="tglkembali" data-date-format="dd-mm-yyyy"  class="form-control" >
								</div>
							</div--->								
							<div class="form-group">
								<label class="col-sm-4">Tanggal Dinas</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl" name="tgl"   data-provide="daterangepicker" data-date-container=#myModalId" class="form-control" >
								</div>
							</div>	
						</div>
					</div><!-- /.box-body -->													
				</div><!-- /.box --> 
			
											
												
												<button class="btn btn-success " type="submit">Proses Lanjutan</button>
									</div>
							</div>
						</div>
	</div>
 <div class="col-xs-6">
				<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
				
			</div><!-- /.box-header -->

			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example1" class="table table-bordered table-striped cobacek" >
				<!--button class="btn btn-success check" type="button" value="check all">CHECK ALL</button>
				 <input type="checkbox" name="checkAll" id="checkAll">CHECK ALL</INPUT--->
					<thead>
						<tr>
							<th>No.</th>
							<th>Action</th>	
							<th>NIK</th>
							<th>Nama Karyawan</th>					
							<th>Department</th>					
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_karyawan as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<td width="8%">
									 <input type="checkbox"  class="cb-element" id="centang" name="centang[]" value="<?php echo $lu->nik;?>"><br>
							</td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							
							
						</tr>
						<?php endforeach;?>
					</tbody>
				</table>
				
			</div><!-- /.box-body -->
<script type="text/javascript">			
						/*$(document).ready(function(){
							$('.check').toggle(function(){
								$('#centang').attr('checked','checked');
								$(this).val('uncheck all')
							},function(){
								$('#centang').removeAttr('checked');
								$(this).val('check all');        
							})
						})*/
	$(".cobacek #checkAll").click(function () {
        if ($("#cobacek #checkAll").is(':checked')) {
            $("#cobacek input[type=checkbox]").each(function () {
                $(this).prop("checked", true);
            });

        } else {
            $("#cobacek input[type=checkbox]").each(function () {
                $(this).prop("checked", false);
            });
        }
    });
</script>
		</div><!-- /.box -->								
	</div>
	</div>	

</form>



</div>





