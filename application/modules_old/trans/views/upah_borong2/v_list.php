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
<script type="text/javascript">
	
    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#ajaxcuti').DataTable({ 
        
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        
        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('trans/upah_borong/ajax_list')?>",
            "type": "POST"
        },

        //Set column definition initialisation properties.
        "columnDefs": [
        { 
          "targets": [ -1 ], //last column
          "orderable": false, //set not orderable
        },
        ],

      });
    });
	
	$('#cbxShowHide').click(function(){
			this.checked?$('#block').show(1000):$('#block').hide(1000);
		});

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

  </script>
<legend><?php echo $title;?></legend>
<?php echo $message;?>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<!--<a href="#" data-toggle="modal" data-target="#input" class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>-->
					<a href="<?php echo site_url("trans/upah_borong/karyawan")?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Input</a>
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
							<th>Status</th>											
							<th>Action</th>						
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach($list_upah_borong as $lu): $no++;?>
						<tr>										
							<td width="2%"><?php echo $no;?></td>																							
							<!--<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>-->
							<td><a href="#" data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok);?>"><?php echo $lu->nodok;?></a></td>
							<td><?php echo $lu->nik;?></td>
							<td><?php echo $lu->nmlengkap;?></td>
							<td><?php echo $lu->nmdept;?></td>
							<td><?php echo $lu->status1;?></td>
							<td>
								<a href="<?php $nik=trim($lu->nik); echo site_url("trans/upah_borong/detail/$nik/$lu->nodok")?>" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Detail
								</a>
								<?php if (trim($lu->status)<>'C' and trim($lu->status)<>'A') {?>
								<a data-toggle="modal" data-target="#dtl<?php echo trim($lu->nodok);?>" href='#' onclick="return confirm('Anda Yakin Approval Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-edit"></i> Approval
								</a>
								<a  href="<?php $nik=trim($lu->nik); echo site_url("trans/upah_borong/hps_upah_borong/$lu->nodok")?>" onclick="return confirm('Anda Yakin Hapus Data ini?')" class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Hapus
								</a>
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





<!--Modal untuk Detail Bpjs Karyawan-->
<?php foreach ($list_upah_borong as $lb){?>
<div class="modal fade" id="dtl<?php echo trim($lb->nodok); ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Detail Upah Borong Progresif Karyawan</h4>
      </div>
	  <form action="<?php echo site_url('trans/upah_borong/approval')?>" method="post">
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
								<label class="col-sm-4">Periode</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="periode"  value="<?php echo trim($lb->periode); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>
							<!--<div class="form-group">
								<label class="col-sm-4">Tipe Ijin Khusus</label>	
								<div class="col-sm-8">    
									<input type="text" id="nik" name="kdupah_borong"  value="<?php echo trim($lb->nmijin_khusus); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
								</div>
							</div>-->	
							<div class="form-group">
								<label class="col-sm-4">Tanggal Kerja</label>	
								<div class="col-sm-8">    
									<input type="text" id="tgl" value="<?php echo trim($lb->tgl_kerja1); ?>" name="tgl_kerja" data-date-format="dd-mm-yyyy"  class="form-control" readonly>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-4">Total Upah (Rupiah)</label>	
								<div class="col-sm-8">    
									<input type="number" id="gaji" name="durasi" placeholder="0" value="<?php echo trim($lb->total_upah); ?>"  class="form-control" readonly >
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
	<?php if (trim($lb->status)=='I'){ ?>
	
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         <button type="submit"  class="btn btn-primary">APPROVAL</button>  
	  </form>
	</div>  
	<div class="modal-footer">
		<form action="<?php echo site_url('trans/upah_borong/cancel');?>" method="post">
			<input type="hidden" value="<?php echo trim($lb->nodok);?>" name="nodok">
			<input type="hidden" value="<?php echo trim($lb->nik);?>" name="nik">
			<button type="submit" class="btn btn-primary" OnClick="return confirm('Anda Yakin, Membatalkan <?php echo $lb->nodok;?>?')">Cancel</button>
		</form>
		</div> 
		

	
	<?php } ?>
    </div>
  </div>
</div>
<?php } ?>
