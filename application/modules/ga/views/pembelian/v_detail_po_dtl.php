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
		$("#mpkdsubgroup").prop("disabled", true);
		$("#mpkdbarang").prop("disabled", true);
		////	$("#onhand").chained("#kdbarang");
		//alert ($('#kdsubgroup').val() != '');

		//	var param1=$('#mpkdgroup').val().trim();
		//	var param2=$('#mpkdsubgroup').val().trim();
		//	var param3=$('#mpkdbarang').val().trim();						
		//	var paramkocok=param1+param2+param3;
		//	var url = "<?php echo site_url('ga/pembelian/add_map_satuan'); ?>/"+paramkocok;
		//	$('#satminta').load(url);
		///	return false;						

	});



</script>

<legend><?php echo $title; ?></legend>
<span id="postmessages"></span>

<div class="box">
	<div class="box-content">
		<div class="box-header">
			<h4 class="box-title" id="myModalLabel">DETAIL PEMBELIAN BARANG</h4>
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
									<div class="form-group drst">
										<label class="col-sm-4" for="inputsm">Kode Group Barang</label>
										<div class="col-sm-8">
											<select class="form-control input-sm ch" name="kdgroup" id="mpkdgroup"
												disabled readonly>
												<option value="">---PILIH KODE GROUP--</option>
												<?php foreach ($list_scgroup as $sc) { ?>
													<option <?php if (trim($sc->kdgroup) == trim($po_dtl['kdgroup'])) {
														echo 'selected';
													} ?> value="<?php echo trim($sc->kdgroup); ?>">
														<?php echo trim($sc->kdgroup) . ' || ' . trim($sc->nmgroup); ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group ">
										<label class="col-sm-4" for="inputsm">Kode Sub Group Barang</label>
										<div class="col-sm-8">
											<select class="form-control input-sm ch" name="kdsubgroup" id="mpkdsubgroup"
												disabled readonly>
												<option value="">---PILIH KODE SUB GROUP--</option>
												<?php foreach ($list_scsubgroup as $sc) { ?>
													<option <?php if (trim($sc->kdsubgroup) == trim($po_dtl['kdsubgroup'])) {
														echo 'selected';
													} ?> value="<?php echo trim($sc->kdsubgroup); ?>"
														class="<?php echo trim($sc->kdgroup); ?>">
														<?php echo trim($sc->kdsubgroup) . ' || ' . trim($sc->nmsubgroup); ?>
													</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group ">
										<label class="col-sm-4" for="inputsm">Kode Barang</label>
										<div class="col-sm-8">
											<select class="form-control input-sm ch" name="kdbarang" id="mpkdbarang"
												disabled readonly>
												<option value="">---PILIH KDBARANG || NAMA BARANG--</option>
												<?php foreach ($list_stkgdw as $sc) { ?>
													<option <?php if (trim($sc->stockcode) == trim($po_dtl['stockcode'])) {
														echo 'selected';
													} ?> value="<?php echo trim($sc->stockcode); ?>"
														class="<?php echo trim($sc->kdsubgroup); ?>">
														<?php echo trim($sc->stockcode) . ' || ' . trim($sc->nmbarang); ?>
													</option>
												<?php } ?>
											</select>
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
												class="form-control drst" readonly>
										</div>
									</div>
									<!---?php if (empty(trim($po_dtl['satminta'])) or trim($po_dtl['satminta'])=='' ) { ?>
							<div class="form-group">
								<label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>	
								<div class="col-sm-8">
									<select class="form-control input-sm"  name="satminta" id="satminta" required>
									 <!--option  value="">---PILIH KDSATUAN || NAMA SATUAN--</option-->
									<!--/select>
								</div>
							</div>
						<!--?php } else { ?--->
									<div class="form-group">
										<label class="col-sm-4" for="inputsm">Kode Satuan Permintaan</label>
										<div class="col-sm-8">
											<select class="form-control input-sm" name="satminta" id="satminta" disabled
												readonly>
												<option value="">---PILIH KDSATUAN || NAMA SATUAN--</option>
												<?php foreach ($trxqtyunit as $sc) { ?>
												<option <?php if (trim($sc->kdtrx) == trim($po_dtl['satminta'])) {
													echo 'selected';
												} ?> value="
													<?php echo trim($sc->kdtrx); ?>">
													<?php echo trim($sc->uraian) . ' || ' . trim($sc->kdtrx); ?>
												</option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group row">
										<label class="col-sm-4">Harga Per Satuan (Rp)</label>
										<div class="col-sm-4">
											<input type="input" id="unitprice" name="unitprice"
												value="<?php echo trim($po_dtl['unitprice']); ?>"
												onkeyup="formatangkaobjek(this)" placeholder="0"
												class="form-control ratakanan" readonly>
										</div>
									</div>
									<!---?php } ?---->

									<div class="form-group row">
										<label class="col-sm-4">Harga (Rp)</label>
										<div class="col-sm-4">
											<input type="input" id="ttlbrutto" name="ttlbrutto"
												value="<?php echo trim($po_dtl['ttlbrutto']); ?>"
												onkeyup="formatangkaobjek(this)" placeholder="0"
												class="form-control ratakanan" disabled readonly>
										</div>
										<!--span class="col-sm-4"> 
									<label class="col-sm-4">DISKON (%)</label>
									<span class="col-sm-6"> 
									<select class="form-control col-sm-12"  name="checkdisc" id="checkdiskon"  disabled readonly>
									 <option  value="NO"> NO  </option> 
									 <option  value="YES">  YES  </option> 
									</select>
									</span>
								</span---->

										<!--span  class="col-sm-3"> 
									<label class="col-sm-2">DISKON</label>
									<span class="col-sm-4"> 
									<input type="checkbox" name="checkdiskon" class="col-sm-1" value="" >
									</span>
								</span--->
									</div>
									<div class="form-group row diskonform">
										<label class="col-sm-4">DISKON</label>
										<span class="col-sm-2">
											<label class="col-sm-2">1+</label>
											<input type="input" value="<?php echo trim($po_dtl['disc1']); ?>" id="disc1"
												name="disc1" placeholder="0" value="0"
												class="form-control col-sm-1 ratakanan" disabled readonly>
										</span>
										<span class="col-sm-2">
											<label class="col-sm-4">2+</label>
											<input type="input" value="<?php echo trim($po_dtl['disc2']); ?>" id="disc2"
												name="disc2" placeholder="0" value="0"
												class="form-control col-sm-1 ratakanan" disabled readonly>
										</span>
										<span class="col-sm-2">
											<label class="col-sm-4">3+</label>
											<input type="input" value="<?php echo trim($po_dtl['disc3']); ?>" id="disc3"
												name="disc3" placeholder="0" value="0"
												class="form-control col-sm-1 ratakanan" disabled readonly>
										</span>
									</div>
									<div class="form-group row">
										<label class="col-sm-4">Sub Total DPP (Rp)</label>
										<div class="col-sm-4">
											<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
											<input type="input" value="<?php echo trim($po_dtl['ttldpp']); ?>"
												id="ttldpp" name="ttldpp" placeholder="0" class="form-control ratakanan"
												readonly>
										</div>
										<span class="col-sm-4">
											<label class="col-sm-4">PPN</label>
											<span class="col-sm-6">
												<input type="hidden" id="pkp"
													value="<?php echo trim($po_mst['pkp']); ?>" name="pkp" readonly>
												<select class="form-control col-sm-12" id="checkppn" disabled>
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
										<label class="col-sm-4">Sub Total PPN (Rp)</label>
										<div class="col-sm-4">
											<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
											<input type="input" id="ttlppn" name="ttlppn"
												value="<?php echo trim($po_dtl['ttlppn']); ?>" placeholder="0"
												class="form-control ratakanan" readonly>
										</div>
										<span class="col-sm-4">
											<label class="col-sm-4">INCLUDE/EXCLUDE</label>
											<span class="col-sm-6">
												<input type="hidden" name="exppn"
													value="<?php echo trim($po_mst['exppn']); ?>" disabled readonly>
												<select class="form-control col-sm-12" name="exppn" id="checkexppn"
													disabled readonly>
													<option <?php if ('EXC' == trim($po_dtl['exppn'])) {
														echo 'selected';
													} ?> value="EXC"> EXCLUDE </option>
													<option <?php if ('INC' == trim($po_dtl['exppn'])) {
														echo 'selected';
													} ?> value="INC"> INCLUDE </option>
												</select>
											</span>
										</span>
									</div>
									<div class="form-group">
										<label class="col-sm-4">Sub Total Netto (Rp)</label>
										<div class="col-sm-4">
											<!--input type="input" id="qtytotalpriceview" name="qtytotalpriceview"  placeholder="0" class="form-control" readonly --->
											<input type="input" value="<?php echo trim($po_dtl['ttlnetto']); ?>"
												id="ttlnetto" name="ttlnetto" placeholder="0"
												class="form-control ratakanan" readonly>
										</div>
									</div>
									<div class="form-group">
										<label class="col-sm-4">Keterangan</label>
										<div class="col-sm-8">
											<textarea type="text" id="keterangan" name="keterangan"
												style="text-transform:uppercase" class="form-control" disabled
												readonly><?php echo trim($po_dtl['keterangan']); ?></textarea>
										</div>
									</div>

								</div>
							</div><!-- /.box-body -->
						</div><!-- /.box -->
					</div>
				</div>
			</div>
			<div class="box-footer">
				<a href="<?= $_SERVER['HTTP_REFERER'] ?>" type="button" class="btn btn-default" /> Kembali</a>
				<!--button type="button" class="btn btn-default" data-dismiss="box">Close</button--->
				<!--button type="submit" id="submit"  class="btn btn-primary pull-right">SIMPAN</button--->
			</div>
		</form>
	</div>
</div>