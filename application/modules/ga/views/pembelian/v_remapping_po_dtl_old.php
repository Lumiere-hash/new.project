<style>
	.ratakanan {
		text-align: right;
	}
</style>
<script type="text/javascript">
	// memformat angka ribuan          

	$(function () {
		$("#example1").dataTable({
			language: {
				aria: {
					sortAscending: ': activate to sort column ascending',
					sortDescending: ': activate to sort column descending',
				},
				emptyTable: 'Tidak ada data yang dapat ditampilkan dari tabel ini...',
				info: 'Menampilkan _START_  sampai _END_  dari _TOTAL_ baris data...',
				infoEmpty: 'Tidak ada baris data...',
				infoFiltered: '(_TOTAL_  terfilter dari _MAX_ total baris data)',
				lengthMenu: '_MENU_ baris...',
				search: 'Pencarian:',
				zeroRecords: 'Tidak ada baris data yang cocok...',
				buttons: {
					copyTitle: 'Menyalin ke clipboard',
					copySuccess: {
						_: 'Disalin %d baris ke clipboard...',
						1: 'Disalin 1 baris ke clipboard...',
					}
				},
				paginate: {
					first: '<i class=\'fa fa-angle-double-left\'></i>',
					previous: '<i class=\'fa fa-angle-left\'></i>',
					next: '<i class=\'fa fa-angle-right\'></i>',
					last: '<i class=\'fa fa-angle-double-right\'></i>',
				},
				processing: 'Memproses...',
			},
			orderCellsTop: true,
			stateSave: false, //state cache
			stateDuration: 60 * 60 * 2,
			responsive: false,
			select: false,
			pagingType: 'full_numbers',
			order: [
				[0, 'asc']
			],
			lengthMenu: [
				[5, 10, 15, 20, 50, 100, 500, 1000, -1],
				[5, 10, 15, 20, 50, 100, 500, 1000, 'Semua']
			],
			pageLength: 5,
			columnDefs: [{
				orderable: false,
				targets: [-1]
			}, {
				searchable: false,
				targets: [-1]
			}, {
				// visible: false,
				// targets: [5]
			}]

		});
		$("#example2").dataTable({
			language: {
				aria: {
					sortAscending: ': activate to sort column ascending',
					sortDescending: ': activate to sort column descending',
				},
				emptyTable: 'Tidak ada data yang dapat ditampilkan dari tabel ini...',
				info: 'Menampilkan _START_  sampai _END_  dari _TOTAL_ baris data...',
				infoEmpty: 'Tidak ada baris data...',
				infoFiltered: '(_TOTAL_  terfilter dari _MAX_ total baris data)',
				lengthMenu: '_MENU_ baris...',
				search: 'Pencarian:',
				zeroRecords: 'Tidak ada baris data yang cocok...',
				buttons: {
					copyTitle: 'Menyalin ke clipboard',
					copySuccess: {
						_: 'Disalin %d baris ke clipboard...',
						1: 'Disalin 1 baris ke clipboard...',
					}
				},
				paginate: {
					first: '<i class=\'fa fa-angle-double-left\'></i>',
					previous: '<i class=\'fa fa-angle-left\'></i>',
					next: '<i class=\'fa fa-angle-right\'></i>',
					last: '<i class=\'fa fa-angle-double-right\'></i>',
				},
				processing: 'Memproses...',
			},
			orderCellsTop: true,
			stateSave: false, //state cache
			stateDuration: 60 * 60 * 2,
			responsive: false,
			select: false,
			pagingType: 'full_numbers',
			order: [
				[0, 'asc']
			],
			lengthMenu: [
				[5, 10, 15, 20, 50, 100, 500, 1000, -1],
				[5, 10, 15, 20, 50, 100, 500, 1000, 'Semua']
			],
			pageLength: 5,
			columnDefs: [{
				orderable: false,
				targets: [-1]
			}, {
				searchable: false,
				targets: [-1]
			}, {
				// visible: false,
				// targets: [5]
			}]
		});
		$("#example3").dataTable();
		$("#dateinput").datepicker();
		$("#dateinput1").datepicker();
		$("#dateinput2").datepicker();
		$("#dateinput3").datepicker();
		$("[data-mask]").inputmask();
		//	$("#kdsubgroup").chained("#kdgroup");
		//	$("#kdbarang").chained("#kdsubgroup");
		//	
		$("#mpkdsubgroup").chained("#mpkdgroup");
		$("#mpkdbarang").chained("#mpkdsubgroup");
		////	$("#onhand").chained("#kdbarang");
		//alert ($('#kdsubgroup').val() != '');

		//	var param1=$('#mpkdgroup').val().trim();
		//	var param2=$('#mpkdsubgroup').val().trim();
		//	var param3=$('#mpkdbarang').val().trim();						
		//	var paramkocok=param1+param2+param3;
		//	var url = "<?php echo site_url('ga/pembelian/add_map_satuan'); ?>/"+paramkocok;
		//	$('#satminta').load(url);
		///	return false;						



		$('.ch').change(function () {
			console.log($('#loccode').val() != '');

			var param1 = $('#mpkdgroup').val().trim();
			var param2 = $('#mpkdsubgroup').val().trim();
			var param3 = $('#mpkdbarang').val().trim();
			var param4 = $('#mploccode').val().trim();
			console.log(param1 + param2 + param3 + param4);
			if ((param1 != '') && (param2 != '') && (param3 != '') && (param4 != '')) {
				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_viewstock_back') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						console.log(data.conhand);
						console.log(data.satkecil);
						console.log(data.nmsatkecil);
						console.log("<?php echo site_url('ga/pembelian/js_viewstock_back') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4)
						$('[name="onhand"]').val(data.conhand);
						$('[name="satkecil"]').val(data.satkecil);
						//$('#mpsatkecil').val(data.satkecil);                             
						$('[name="mpnmsatkecil"]').val(data.nmsatkecil);
						//$('[name="loccode"]').val(data.loccode);                                                          

					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});


			};
		});

		$('#satminta').change(function () {

			//console.log($('#satminta').val().trim());
			//console.log($('#mpsatkecil').val().trim());
			var param1 = $('#mpkdgroup').val().trim();
			var param2 = $('#mpkdsubgroup').val().trim();
			var param3 = $('#mpkdbarang').val().trim();
			var param4 = $('#mpsatkecil').val().trim();
			var param5 = $('#satminta').val().trim();
			var qtKecil = parseInt($('#qtykecil').val().trim());
			if ($('#qtykecil').val() == 'undefined') { var qtKecil = 0; } else { var qtKecil = parseInt($('#qtykecil').val().trim()); }

			console.log(qtKecil);
			console.log(param3 != '');
			if (param3 != '') {
				$.ajax({
					url: "<?php echo site_url('ga/pembelian/js_mapping_satuan') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4 + '/' + param5,
					type: "GET",
					dataType: "JSON",
					success: function (data) {
						console.log(param1 + param2 + param3 + param4 + param5);
						console.log("<?php echo site_url('ga/pembelian/js_mapping_satuan') ?>" + '/' + param1 + '/' + param2 + '/' + param3 + '/' + param4 + '/' + param5)
						//var dataqtybesar=$(this).val(data.qty);
						console.log(data.qty);
						var qtymap = (data.qty);
						var hasil = (qtKecil / qtymap);

						//console.log(qtymap);
						console.log(param3);
						//alert(qtymap);
						if ((qtymap == 'undefined' || qtymap == '' || qtymap == null) && (param3 != null || param3 != '')) {
							if (window.confirm('Peringatan Mapping Satuan Tersebut Masih Belum Tersedia, Click OK Untuk Melakukan Mapping Pada Tab Baru Browser Anda Atau Ubah Kode Satuan Permintaan Dengan Satuan Yang Sesuai')) {
								///window.location.href='https://www.google.com/chrome/browser/index.html';
								window.open("<?php echo site_url('ga/inventaris/master_mapping_satuan_brg') ?>", '_blank');
							};
							console.log(qtymap == 'undefined' || qtymap == '' || qtymap == null);
							$('#submit').prop('disabled', true);
						} else {
							$('#submit').prop('disabled', false);
						}
						$('[name="qtyminta"]').val(hasil);
					},
					error: function (jqXHR, textStatus, errorThrown) {
						alert('Error get data from ajax');
					}
				});
			}



		});

		$('#ttlbrutto,#disc1,#disc2,#disc3').keyup(function () {

			if ($('#ttlbrutto').val() == '') {
				var param1 = parseInt(0);
				$('#satminta').prop('readonly', false);
				$('#satminta2').prop('readonly', false);
				$('#checkdiskon').prop('readonly', false);
				$('#checkppn').prop('readonly', false);
				$('#checkexppn').prop('disabled', false);
				$('#unitprice').prop('readonly', false);
			} else {
				var param1 = parseInt($('#ttlbrutto').val().replace(/\./g, ''));
				// $('#satminta').prop('readonly', true);
				// $('#satminta2').prop('readonly', true);
				// $('#checkdiskon').prop('readonly', true);
				// $('#checkppn').prop('readonly', true);
				// $('#checkexppn').prop('disabled', true);
				// $('#unitprice').prop('readonly', true);
			}
			if ($('#qtyminta').val() == '') { var param2 = parseInt(0); } else { var param2 = parseInt($('#qtyminta').val().replace(/\./g, '')); }
			if ($('#disc1').val() == '') { var paramdisc1 = parseInt(0); } else { var paramdisc1 = parseInt($('#disc1').val().replace(/\./g, '')); }
			if ($('#disc2').val() == '') { var paramdisc2 = parseInt(0); } else { var paramdisc2 = parseInt($('#disc2').val().replace(/\./g, '')); }
			if ($('#disc3').val() == '') { var paramdisc3 = parseInt(0); } else { var paramdisc3 = parseInt($('#disc3').val().replace(/\./g, '')); }

			var paramcheckdiskon = $('#checkdiskon').val();
			var paramcheckppn = $('#checkppn').val();
			var paramcheckexppn = $('#checkexppn').val();
			///var paramdisc1 = parseInt($('#disc1').val().trim());
			///var paramdisc2 = parseInt($('#disc2').val().trim());
			///var paramdisc3 = parseInt($('#disc3').val().trim());
			///console.log(param1);
			var subtotal = param1 * param2;
			if (paramdisc1 > 100) {
				alert('PERINGATAN DISKON 1 TIDAK BOLEH LEBIH DARI 100% MAU CARI GRATISAN ???');
				//window.confirm('PERINGATAN DISKON 1 TIDAK BOLEH LEBIH DARI 100% MAU CARI GRATISAN ???');
				$('#submit').prop('disabled', true);
			} else {
				$('#submit').prop('disabled', false);
			}

			//console.log(paramcheckdiskon=='YES');
			if (paramcheckdiskon == 'YES') {
				var totaldiskon = Math.round((param1 * (paramdisc1 / 100)) + ((param1 * (paramdisc1 / 100)) * (paramdisc2 / 100)) + (((param1 * (paramdisc1 / 100)) * (paramdisc2 / 100)) * (paramdisc3 / 100)));
			} else {
				var totaldiskon = Math.round((param1 * (0 / 100)) + (param1 * (0 / 100)) + (param1 * (0 / 100)));
			}

			if (paramcheckppn == 'YES') {
				if (paramcheckexppn == 'EXC') {
					var totaldpp = Math.round((param1 - totaldiskon) / 1.1);
					//var totalppn=Math.round(((param1-totaldiskon)/1.1)*(10/100));
					var totalppn = Math.round(((param1 - totaldiskon) / 1.1) * 0.1);
					var vattlnetto = (param1 - totaldiskon) + totalppn;
				} else if (paramcheckexppn == 'INC') {
					var totaldpp = Math.round((param1 - totaldiskon) / 1.1);;
					var totalppn = Math.round(((param1 - totaldiskon) / 1.1) * (10 / 100));
					var vattlnetto = (param1 - totaldiskon);
				}

			} else if (paramcheckppn == 'NO') {
				var totaldpp = 0;
				var totalppn = 0;
				var vattlnetto = (param1 - totaldiskon);
			}



			var test = formatangkavalue(subtotal);


			console.log(totaldpp);
			console.log(totalppn);


			///$('#unitprice').val(formatangkavalue(unitprice));   
			$('#ttldpp').val(formatangkavalue(totaldpp));
			$('#ttldiskon').val(formatangkavalue(totaldiskon));
			$('#ttlppn').val(formatangkavalue(totalppn));
			$('#ttlnetto').val(formatangkavalue(vattlnetto));
			$('[name="satminta"]').val($('#satminta').val());


		});
		$('.diskonform').hide();
		$('#checkdiskon').change(function () {
			if ($(this).val().trim() == "YES") {
				$('.diskonform').show();
			} else {
				$('.diskonform').hide();
			}

		});
		$('form').on('focus', 'input[type=number]', function (e) {
			$(this).on('mousewheel.disableScroll', function (e) {
				e.preventDefault()
			})
		});

	});
	/*
					// memformat angka ribuan
	function formatangkaobjek(objek) {
	   a = objek.value.toString();
	 //  alert(a);
	 //  alert(objek);
	   b = a.replace(/[^\d]/g,"");
	   c = "";
	   panjang = b.length;
	   j = 0;
	   for (i = panjang; i > 0; i--) {
		 j = j + 1;
		 if (((j % 3) == 1) && (j != 1)) {
		   c = b.substr(i-1,1) + "." + c;
		 } else {
		   c = b.substr(i-1,1) + c;
		 }
	   }
	   objek.value = c;
	}	
	*/
	
	function formatangkavalue(objek) {
	   a = objek.toString();
	 //  alert(a);
	  // alert(objek);
	   b = a.replace(/[^\d]/g,"");
	   c = "";
	   panjang = b.length;
	   j = 0;
	   for (i = panjang; i > 0; i--) {
		 j = j + 1;
		 if (((j % 3) == 1) && (j != 1)) {
		   c = b.substr(i-1,1) + "." + c;
		 } else {
		   c = b.substr(i-1,1) + c;
		 }
	   }
	  objek = c;
	 ///  alert(objek);
	  return objek;
	 
	}	

</script>

<legend><?php echo $title; ?></legend>
<span id="postmessages"></span>

<div class="box">
	<div class="box-content">
		<div class="box-header">
			<h4 class="box-title" id="myModalLabel">MAPPING PEMBELIAN BARANG</h4>
		</div>
		<form action="<?php echo site_url('ga/pembelian/save_po') ?>" method="post" name="inputformPbk">
			<div class="box-body">
				<div class="row">
					<div class="col-sm-12">
						<div class="box box-danger">
							<div class="box-body">
								<div class="form-horizontal">
									<div class="form-group">
										<label class="col-sm-4">NO DOKUMEN REFERENSI</label>
										<div class="col-sm-8">
											<?php if (trim($po_dtl['status']) == 'I') { ?>
												<input type="hidden" id="type" name="type" value="MAP_PODTL_ITEM"
													class="form-control" style="text-transform:uppercase">
											<?php } else if (trim($po_dtl['status']) == 'E') { ?>
													<input type="hidden" id="type" name="type" value="MAP_PODTL_ITEM_EDIT"
														class="form-control" style="text-transform:uppercase">
											<?php } ?>
											<input type="text" id="nodok" name="nodok"
												value="<?php echo trim($po_dtl['nodok']); ?>" class="form-control"
												style="text-transform:uppercase" readonly>
											<input type="hidden" id="id" name="id"
												value="<?php echo trim($po_dtl['id']); ?>" class="form-control"
												style="text-transform:uppercase">
										</div>
									</div>
									<div class="form-group ">
										<label class="col-sm-4" for="inputsm">Kode Barang</label>
										<div class="col-sm-8">
											<input type="hidden" name="kdgroup" id="mpkdgroup"
												value="<?php echo trim($po_dtl['kdgroup']); ?>" class="form-control "
												readonly>
											<input type="hidden" name="kdsubgroup" id="mpkdsubgroup"
												value="<?php echo trim($po_dtl['kdsubgroup']); ?>" class="form-control "
												readonly>
											<input type="input" name="kdbarang" id="mpkdbarang"
												value="<?php echo trim($po_dtl['stockcode']); ?>" class="form-control "
												readonly>
										</div>
									</div>
									<div class="form-group ">
										<label class="col-sm-4" for="inputsm">Nama Barang</label>
										<div class="col-sm-8">
											<input type="input" name="nmbarang"
												value="<?php echo trim($po_dtl['nmbarang']); ?>" class="form-control "
												readonly>
										</div>
									</div>
									<div class="form-group ">
										<label class="col-sm-4">LOKASI GUDANG</label>
										<div class="col-sm-8">
											<input type="text" id="mploccode" name="loccode"
												value="<?php echo trim($po_dtl['loccode']); ?>" class="form-control "
												readonly>

										</div>
									</div>
									<?php if (trim($po_dtl['kdgroup']) != 'JSA') { ?>
										<div class="form-group drst">
											<label class="col-sm-4">Quantity TERKECIL</label>
											<div class="col-sm-8">
												<input type="number" id="qtykecil" name="qtykecil"
													value="<?php echo trim($po_dtl['qtykecil']); ?>" placeholder="0"
													class="form-control drst" readonly>
											</div>
										</div>
										<div class="form-group drst">
											<label class="col-sm-4">SATUAN TERKECIL</label>
											<div class="col-sm-8">
												<input type="text" name="mpnmsatkecil"
													value="<?php echo trim($po_dtl['nmsatkecil']); ?>" class="form-control"
													readonly>
												<input type="hidden" id="mpsatkecil" name="satkecil"
													value="<?php echo trim($po_dtl['satkecil']); ?>"
													class="form-control drst" readonly>
											</div>
										</div>
										<div class="form-group drst">
											<label class="col-sm-4">Quantity Permintaan</label>
											<div class="col-sm-8">
												<input type="number" id="qtyminta" name="qtyminta"
													value="<?php echo trim($po_dtl['qtyminta']); ?>" placeholder="0"
													class="form-control drst cal">
											</div>
										</div>

									<div class="form-group">
										<label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>
										<div class="col-sm-8">
											<select class="form-control input-sm cal" name="satminta" id="satminta"
												required>
												<option value="">---PILIH KDSATUAN || NAMA SATUAN--</option>
												<?php foreach ($trxqtyunit as $sc) { ?>
												<option <?php if (trim($sc->kdtrx) == trim($po_dtl['satminta'])) {
													echo 'selected';
												} ?> value="
													<?php echo trim($sc->kdtrx); ?>">
													<?php echo trim($sc->nmsatbesar) . ' || ' . trim($sc->kdtrx); ?>
												</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<?php } else { ?>
									<input type="hidden" id="qtyminta" name="qtyminta"
										value="<?php echo trim($po_dtl['qtykecil']); ?>" placeholder="0"
										class="form-control drst" readonly>
									<input type="hidden" name="mpnmsatkecil"
										value="<?php echo trim($po_dtl['nmsatkecil']); ?>" class="form-control" readonly>
									<input type="hidden" id="mpsatkecil" name="satkecil"
										value="<?php echo trim($po_dtl['satkecil']); ?>" class="form-control drst"
										readonly>
									<input type="hidden" id="qtykecil" name="qtykecil"
										value="<?php echo trim($po_dtl['qtykecil']); ?>" placeholder="0"
										class="form-control drst" readonly>
									<input type="hidden" id="satminta" name="satminta"
										value="<?php echo $po_dtl['satkecil']; ?>" readonly>
									<?php } ?>
									<div class="form-group row">
										<label class="col-sm-4">Harga Per Satuan (Rp)</label>
										<div class="col-sm-4">
											<input type="number" id="unitprice" name="unitprice"
												value="<?php echo $po_dtl['unitprice']; ?>"
												placeholder="0" class="form-control ratakanan cal" required>
										</div>
									</div>
									<!---?php } ?---->

									<div class="form-group row">
										<label class="col-sm-4">Harga Brutto (Rp)</label>
										<div class="col-sm-4">
											<input type="number" id="ttlbrutto" name="ttlbrutto"
												value="<?php echo str_replace('.', ',', trim($po_dtl['ttlbrutto'])); ?>"
												placeholder="0" class="form-control ratakanan cal" readonly>
										</div>
										<span class="col-sm-4">
											<label class="col-sm-4">DISKON (%)</label>
											<span class="col-sm-6">
												<select class="form-control col-sm-12" name="checkdisc"
													id="checkdiskon">
													<option <?php if (trim($po_dtl['disc1']) + trim($po_dtl['disc2']) + trim($po_dtl['disc3']) == '0') {
														echo 'selected';
													} ?> value="NO"> NO </option>
													<option <?php if (trim($po_dtl['disc1']) + trim($po_dtl['disc2']) + trim($po_dtl['disc3']) > '0') {
														echo 'selected';
													} ?> value="YES"> YES </option>
												</select>
											</span>
										</span>

									</div>
									<div class="form-group row diskonform">
										<label class="col-sm-4">DISKON</label>
										<span class="col-sm-2">
											<label class="col-sm-2">1+</label>
											<input type="number"
												value="<?php echo str_replace('.', ',', trim($po_dtl['disc1'])); ?>"
												id="disc1" name="disc1" placeholder="0" value="0"
												class="form-control col-sm-1 ratakanan cal">
										</span>
										<span class="col-sm-2">
											<label class="col-sm-4">2+</label>
											<input type="number"
												value="<?php echo str_replace('.', ',', trim($po_dtl['disc2'])); ?>"
												id="disc2" name="disc2" placeholder="0" value="0"
												class="form-control col-sm-1 ratakanan cal">
										</span>
										<span class="col-sm-2">
											<label class="col-sm-4">3+</label>
											<input type="number"
												value="<?php echo str_replace('.', ',', trim($po_dtl['disc3'])); ?>"
												id="disc3" name="disc3" placeholder="0" value="0"
												class="form-control col-sm-1 ratakanan cal">
										</span>
									</div>
									<div class="form-group row">
										<label class="col-sm-4">Sub Harga DPP (Rp)</label>
										<div class="col-sm-4">
											<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
											<input type="number" value="<?php echo trim($po_dtl['ttldpp']); ?>"
												id="ttldpp" name="ttldpp" placeholder="0" class="form-control ratakanan"
												readonly>
										</div>
										<span class="col-sm-4">
											<label class="col-sm-4">PPN</label>
											<span class="col-sm-6">
												<input type="hidden" id="pkp"
													value="<?php echo trim($po_mst['pkp']); ?>" name="pkp" readonly>
												<select class="form-control col-sm-12 cal" id="checkppn" disabled>
													<option <?php if (trim($po_mst['pkp']) == 'NO') {
														echo 'selected';
													} ?>
														value="NO"> NO </option>
													<option <?php if (trim($po_mst['pkp']) == 'YES') {
														echo 'selected';
													} ?>
														value="YES"> YES </option>
												</select>
											</span>
										</span>
									</div>
									<div class="form-group">
										<label class="col-sm-4">Sub Harga PPN (Rp)</label>
										<div class="col-sm-4">
											<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
											<input type="number" id="ttlppn" name="ttlppn"
												value="<?php echo trim($po_dtl['ttlppn']); ?>" placeholder="0"
												class="form-control ratakanan" readonly>
										</div>
										<span class="col-sm-4">
											<label class="col-sm-4">INCLUDE/EXCLUDE</label>
											<span class="col-sm-6">
												<input type="hidden" name="exppn"
													value="<?php echo trim($po_mst['exppn']); ?>" readonly>
												<select class="form-control col-sm-12 cal" name="exppn" id="checkexppn">
													<option <?php if ('INC' == trim($po_dtl['exppn'])) {
														echo 'selected';
													} ?> value="INC"> INCLUDE </option>
													<option <?php if ('EXC' == trim($po_dtl['exppn'])) {
														echo 'selected';
													} ?> value="EXC"> EXCLUDE </option>
												</select>
											</span>
										</span>
									</div>
									<div class="form-group row">
										<label class="col-sm-4">Sub Harga Diskon (Rp)</label>
										<div class="col-sm-4">
											<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
											<input type="number" value="<?php echo trim($po_dtl['ttldiskon']); ?>"
												id="ttldiskon" name="ttldiskon" placeholder="0"
												class="form-control ratakanan" readonly>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4">Sub Harga Netto (Rp)</label>
										<div class="col-sm-4">
											<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
											<input type="number" value="<?php echo trim($po_dtl['ttlnetto']); ?>"
												id="ttlnetto" name="ttlnetto" placeholder="0"
												class="form-control ratakanan" readonly>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4">Keterangan</label>
										<div class="col-sm-8">
											<textarea type="text" id="keterangan" name="keterangan"
												style="text-transform:uppercase"
												class="form-control cal"><?php echo trim($po_dtl['keterangan']); ?></textarea>
										</div>
									</div>

								</div>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
				</div>
			</div>
			<div class="box-footer">
				<?php if (trim($po_dtl['status']) == 'I') { ?>
					<a href="<?php echo site_url('ga/pembelian/input_po'); ?>" type="button" class="btn btn-default" />
					Kembali</a>
				<?php } else if (trim($po_dtl['status']) == 'E') { ?>

						<a href="<?php $enc_nodoktmp = bin2hex($this->encrypt->encode(trim($po_mst['nodoktmp'])));
						echo site_url("ga/pembelian/edit_po_atk/$enc_nodoktmp"); ?>" type="button" class="btn btn-default" /> Kembali</a>
				<?php } ?>
				<!--button type="button" class="btn btn-default" data-dismiss="box">Close</button--->
				<button type="submit" id="submit" class="btn btn-primary pull-right">SIMPAN</button>
			</div>
		</form>
	</div>
</div>
<script>
	function calcutlation() {
		bqtyminta = $("#qtyminta").val().toString();
		bunitprice = $("#unitprice").val().toString();
		bdisc1 = $("#disc1").val().toString();
		bdisc2 = $("#disc2").val().toString();
		bdisc3 = $("#disc3").val().toString();
		bqtykecil = $("#qtykecil").val().toString();
		valqtykecil = parseInt(bqtykecil.replace(/[^-?(\d*\)?\d+$;]/g,''));
		valqtyminta = parseInt(bqtyminta.replace(/[^-?(\d*\)?\d+$;]/g,''));
		let valunitprice = parseFloat(bunitprice.replace(/\./g, '').replace(',', '.'));
		valdisc1 = parseInt(bdisc1.replace(/[^-?(\d*\)?\d+$;]/g,''));
		valdisc2 = parseInt(bdisc2.replace(/[^-?(\d*\)?\d+$;]/g,''));
		valdisc3 = parseInt(bdisc3.replace(/[^-?(\d*\)?\d+$;]/g,''));
		checkdisc = $("#checkdisc").val();
		checkppn = $("#checkppn").val();
		exppn = $("#exppn").val();
		satminta = $("#satminta").val();
		satkecil = $("#satkecil").val();
		kdgroup = $("#mpkdgroup").val();
		kdsubgroup = $("#mpkdsubgroup").val();
		stockcode = $("#mpkdbarang").val();
		keterangan = $("#keterangan").val();

		$("#loadMe").modal({
			backdrop: "static", //remove ability to close modal with click
			keyboard: false, //remove option to close with keyboard
			show: true //Display loader!
		});
		var urlx = "<?php echo site_url('ga/pembelian/calculation_remap_detail')?>";
		$.ajax(urlx, {
			type: "POST",
			data: JSON.stringify({
				'success' : true,
				'key': 'KUNCI',
				'message' : '',
				'body' : {
					qtyminta: valqtyminta,
					qtykecil: valqtykecil,
					unitprice: valunitprice,
					checkdisc: checkdisc,
					disc1: valdisc1,
					disc2: valdisc2,
					disc3: valdisc3,
					checkppn: checkppn,
					exppn: exppn,
					satminta: satminta,
					satkecil: satkecil,
					kdgroup: kdgroup,
					kdsubgroup: kdsubgroup,
					stockcode: stockcode,
					keterangan: keterangan,
				},
			}),
			contentType: "application/json",
		}).done(function (data) {
			var js = jQuery.parseJSON(data);
			if( js.enkript === 'KUNCI') {
				$('[name="ttlbrutto"]').val(js.fill.ttlbrutto);
				$('[name="ttlnetto"]').val(js.fill.ttlnetto);
				$('[name="ttldpp"]').val(js.fill.ttldpp);
				$('[name="ttldiskon"]').val(js.fill.ttldiskon);
				$('[name="ttlppn"]').val(js.fill.ttlppn);
				$('[name="keterangan"]').val(js.fill.keterangan);


				console.log(js.fill.ttlbrutto);
				console.log(js.fill.unitprice);
				console.log(js.fill.disc1);
				console.log('success');
			} else { console.log('Fail Key');}
			$("#loadMe").modal("hide");
		}).fail(function (xhr, status, error) {
			alert("Could not reach the API: " + error);
			$("#loadMe").modal("hide");
			return true;
		});

	}
	$(document).ready(function(){
		$(".cal").change(function(){
			calcutlation();
			console.log(('Kalkulasi'))
		});

		
	})
</script>