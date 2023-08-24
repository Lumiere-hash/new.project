<?php 
/*
	@author : Junis
*/
?>
<script type="text/javascript">

    var save_method; //for save method string
    var table;
    $(document).ready(function() {
      table = $('#table').DataTable();
    });

    function add_person()
    {
      save_method = 'add';
      $('#form')[0].reset(); // reset form on modals
      $('#modal_form').modal('show'); // show bootstrap modal
      $('.modal-title').text('Tarik Data Absen'); // Set Title to Bootstrap modal title
    }

    function edit_person(id)
    {
      save_method = 'update';
	  
	  $('#editform')[0].reset(); // reset form on modals

      //Ajax Load data from ajax
      $.ajax({
        url : "<?php echo site_url('trans/absensi/ajax_edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
           
			$('[name="kdkepegawaian"]').val(data.kdkepegawaian);
            $('[name="nmkepegawaian"]').val(data.nmkepegawaian);                                    			
            // show bootstrap modal when complete loaded
			$('#modal_form').modal('hide');
			$('#edit_form').modal('show');
            $('.modal-title').text('Edit Status Kepegawaian'); // Set title to Bootstrap modal title
            
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            alert('Error get data from ajax');			
        }
    });
    }

    function reload_table()
    {
      table.ajax.reload(null,false); //reload datatable ajax 
    }

   

    function delete_person(id)
    {
      if(confirm('Are you sure delete this data?'))
      {
        // ajax delete data to database
          $.ajax({
            url : "<?php echo site_url('trans/absensi/ajax_delete')?>/"+id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
               //if success reload ajax table
               $('#modal_form').modal('hide');
               reload_table();
				$("#message").html("<div class='alert alert-warning alert-dismissable'><i class='fa fa-check'></i><button type='button' class='close' data-dismiss='alert' aria-hidden='true'>×</button><b> Hapus Data Sukses</b></div>");
			},
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error adding / update data');
				
            }
        });
         
      }
    }

  </script>
<legend><?php echo $title;?></legend>
<h3></h3>
<div id="message" >	
	<?php echo $message;?>
</div>
<div><?php //echo 'Total data: '.$ttldata['jumlah']; ?></div>
<div class="row">
	<div class="col-sm-12">										
		<div class="box">
			<div class="box-header">
				<div class="col-sm-12">		
					<a href="<?php echo site_url('payroll/ceklembur/shift');?>"  class="btn btn-primary" style="margin:10px; color:#ffffff;">Kembali</a>
					<a href="#" data-toggle="modal" data-target="#input" class="btn btn-success" style="margin:10px; color:#ffffff;">INPUT</a>
					<!--<button class="btn btn-primary" onclick="add_person()" style="margin:10px; color:#ffffff;"><i class="glyphicon glyphicon-plus"></i> Data Mesin Absen</button>-->
				</div>
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
					<thead>
						<tr>							
																
							<th width="5%">No.</th>
							<th>Nama</th>
							<th>NIK</th>
							<th>Nominal</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						<?php $no=0; foreach ($list_shift as $la): $no++ ?>
							<tr>																					
								<td><?php echo $no;?></td>																
								<td><?php echo $la->nmlengkap;?></td>																
								<td><?php echo $la->nik;?></td>									
								<td><?php echo $la->nominal1;?></td>		
								<td>
								
								<a  href="<?php  $nik=trim($la->nik); echo site_url("payroll/ceklembur/lihat_shift/$tglawal/$tglakhir/$kddept/$nik")?>"  class="btn btn-default  btn-sm">
									<i class="fa fa-trash-o"></i> Detail
								</a>
							</td>	
							</tr>
						<?php endforeach ?>
					</tbody>
					
						
					
				</table>
			</div><!-- /.box-body -->
		</div><!-- /.box -->								
	</div>
</div>


 
  
 
 <script>

  

	
	//Date range picker
    $('#tgl').datepicker();
	$('#pilihkaryawan').selectize();
	$("[data-mask]").inputmask();

</script>