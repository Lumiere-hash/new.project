<link href="<?php echo base_url('assets/css/datepicker.css'); ?>" rel="stylesheet" type="text/css" />
<script type="text/javascript">
	$(document).ready(function () {
        function disableBack() { window.history.forward() }

        window.onload = disableBack();
        window.onpageshow = function (evt) { if (evt.persisted) disableBack() }
    });
	$(function () {
		$("#example1").dataTable();
		/*    var table = $('#example1').DataTable({
			   lengthMenu: [ [2, 4, 8, -1], [2, 4, 8, "All"] ],
			   pageLength: 4
			}); */
		var save_method; //for save method string
		var table;
		table = $('#example2').DataTable({

			"processing": true, //Feature control the processing indicator.
			"serverSide": true, //Feature control DataTables' server-side processing mode.

			// Load data for the table's content from an Ajax source
			"ajax": {
				"url": "<?php echo site_url('ga/pembelian/cobapagin') ?>",
				"type": "POST"
			},

			//Set column definition initialisation properties.
			"columnDefs": [
				{
					"targets": [-1], //last column
					"orderable": false, //set not orderable
				},
			],

		});
		$modal = $('.pp');
		$('#example2').on('click', '.show', function () {
			//var data = $('#example1').DataTable().row( this ).data();
			//alert( 'You clicked on '+data[0]+'\'s row' );
			var el = $(this);
			//alert(el.attr('data-url'));
			$modal.load(el.attr('data-url'), '', function () {
				$modal.modal();


			});
		});




		$("#example3").dataTable();
		$("#example4").dataTable();
		$("#kdsubgroup").chained("#kdgroup");
		$("#kdbarang").chained("#kdsubgroup");
		/*						if 	($('#kdbarang').val() != '') {						
									var param1=$('#kdbarang').val();
									  $.ajax({
										url : "<!?php echo site_url('ga/permintaan/js_viewstock')?>/" + param1,
										type: "GET",
										dataType: "JSON",
										success: function(data)
										{			   
											$('[name="onhand"]').val(data.conhand);                        
											$('[name="loccode"]').val(data.loccode);                                                          
								
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											alert('Error get data from ajax');
										}
									}); 
								};	
					////	$("#onhand").chained("#kdbarang");
					//alert ($('#kdsubgroup').val() != '');
							$('.kdbarang').change(function(){
								console.log($('#kdbarang').val() != '');
								if 	($('#kdbarang').val() != '') {						
									var param1=$(this).val();
									  $.ajax({
										url : "<!?php echo site_url('ga/permintaan/js_viewstock')?>/" + param1,
										type: "GET",
										dataType: "JSON",
										success: function(data)
										{			   
											$('[name="onhand"]').val(data.conhand);                        
											$('[name="loccode"]').val(data.loccode);                                                          
								
										},
										error: function (jqXHR, textStatus, errorThrown)
										{
											alert('Error get data from ajax');
										}
									}); 
								};				
							});*/
		//////////////////////////////////////////////
		$('#qtyunitprice').change(function () {
			if ($(this).val() == '') { var param1 = parseInt(0); } else { var param1 = parseInt($(this).val()); }
			if ($('#qtypo').val() == '') { var param2 = parseInt(0); } else { var param2 = parseInt($('#qtypo').val()); }

			$('#qtytotalprice').val(param1 * param2);
		});
		//////////////////////////////////////////////
		$('#qtypo').change(function () {
			if ($(this).val() == '') { var param2 = parseInt(0); } else { var param2 = parseInt($(this).val()); }
			if ($('#qtyunitprice').val() == '') { var param1 = parseInt(0); } else { var param1 = parseInt($('#qtyunitprice').val()); }

			$('#qtytotalprice').val(param1 * param2);
		});
	});

	function reload_table() {
		table.ajax.reload(null, false); //reload datatable ajax 
	}


</script>
<div class="pull-right">Versi: <?php echo $version; ?></div>
<!--div class="nav-tabs-custom"-->
<legend><?php echo $title; ?></legend>

<?php echo $message; ?>

<div class="row">
	<div class="col-sm-3">
		<!--div class="container"--->
		<div class="dropdown ">
			<button class="btn btn-primary dropdown-toggle " style="margin:10px; color:#ffffff;" id="menu1"
				type="button" data-toggle="dropdown">Menu Input
				<span class="caret"></span></button>
			<ul class="dropdown-menu" role="menu" aria-labelledby="menu1">
				<li role="presentation"><a role="menuitem" tabindex="-1" data-toggle="modal" data-target="#filter"
						href="#"><i class="fa fa-search"></i> Filter Pencarian</a></li>
				<li role="presentation"><a role="menuitem" tabindex="-1"
						href="<?php echo site_url("ga/pembelian/input_po") ?>"><i class="fa fa-plus"></i> Input PO</a>
				</li>
			</ul>
		</div>
		<!--/div-->
	</div><!-- /.box-header -->
</div>
</br>
<div class="row">
	<div class="col-sm-12">
		<div class="box">
			<div class="box-header">
			</div><!-- /.box-header -->
			<div class="box-body table-responsive" style='overflow-x:scroll;'>
				<table id="example2" class="table table-bordered table-striped">
					<thead>
						<tr>
							<th width="2%">No.</th>
							<th>DOKUMEN</th>
							<th>NAMA SUPPLIER</th>
							<th>TOTAL HARGA</th>
							<th>NAMA BARANG</th>
							<!--th>INPUTDATE</th>
											<th>APPROVALBY</th>
											<th>APPROVALDATE</th-->
							<th>KETERANGAN</th>
							<th>STATUS</th>
							<th width="10%">AKSI</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div><!-- /.box-body -->
		</div>
	</div>
</div><!--/ nav -->


<script>
	//Date range picker
	$("#tgl").datepicker();
	$(".tglan").datepicker(); 
</script>