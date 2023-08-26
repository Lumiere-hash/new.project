<script type="text/javascript">
    var t_rencana, t_realisasi;

    $(function() {
        $("#example1").DataTable({
            order: [],
            ordering: false
        });

        t_rencana = $("#rencana-table").DataTable({
            ajax: {
                url: "<?= site_url('trans/uang_makan/rencana_callplan')?>",
                type: "POST",
                data: function(d) {
                    d.nik = $("#rencana_nik").val(),
                    d.tgl = $("#rencana_tgl").val();
                }
            },
            order: [],
            ordering: false,
            columns: [
                {
                    data: "no",
                    class: "text-nowrap text-center autonum-posint"
                },
                {
                    data: "locationid",
                    class: "text-nowrap"
                },
                {
                    data: "locationidlocal",
                    class: "text-nowrap"
                },
                {
                    data: "custname"
                },
                {
                    data: "nmcustomertype",
                    class: "text-nowrap"
                }
            ]
        });
        t_rencana.on("order.dt search.dt", function() {
            t_rencana.column(0, {
                search: "applied", order: "applied"
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();

        t_realisasi = $("#realisasi-table").DataTable({
            ajax: {
                url: "<?= site_url('trans/uang_makan/realisasi_callplan')?>",
                type: "POST",
                data: function(d) {
                    d.nik = $("#realisasi_nik").val(),
                    d.tgl = $("#realisasi_tgl").val();
                }
            },
            order: [],
            ordering: false,
            columns: [
                {
                    data: "no",
                    class: "text-nowrap text-center autonum-posint"
                },
                {
                    data: "locationid",
                    class: "text-nowrap"
                },
                {
                    data: "locationidlocal",
                    class: "text-nowrap"
                },
                {
                    data: "custname"
                },
                {
                    data: "nmcustomertype",
                    class: "text-nowrap"
                },
                {
                    data: "checktime",
                    class: "text-nowrap"
                },
                {
                    data: "terhitung",
                    class: "text-nowrap text-center"
                }
            ]
        });
        t_realisasi.on("order.dt search.dt", function() {
            t_realisasi.column(0, {
                search: "applied", order: "applied"
            }).nodes().each(function(cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>

<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
        white-space: nowrap;
    }

    thead tr th {
        padding-right: 8px !important;
    }
</style>

<legend>Daftar Absensi Tanggal <?= $tgl ?></legend>

<div class="row">
    <div class="col-xs-12">
        <div class="box">
            <div class="box-header">
                <form action="<?php echo site_url('trans/uang_makan/pdf');?>" name="form" role="form" method="post">
                    <a href="<?= site_url("trans/uang_makan") ?>" class="btn btn-default" style="margin: 5px;"><i class="fa fa-arrow-left"></i>&nbsp; Kembali</a>
                    <input type="hidden" name='kdcabang' value="<?= $kdcabang ?>">
                    <input type="hidden" name='tgl' value="<?= $tgl ?>">
                    <input type="hidden" name='borong' value="<?= $borong ?>">
                    <input type="hidden" name='callplan' value="<?= $callplan ?>">
                    <button type="submit" class="btn btn-primary" style="margin: 5px"><i class="fa fa-file-pdf-o"></i>&nbsp; PDF</button>
                    <a href="<?= site_url("trans/uang_makan/excel_absensi/$kdcabang/$tgl1/$tgl2/$borong/$callplan") ?>" class="btn btn-primary" style="margin: 5px;"><i class="fa fa-file-excel-o"></i>&nbsp; XLS</a>
                    <?php if($callplan == "t"): ?>
                        <a href="<?= site_url("trans/uang_makan/excel_realisasi/$kdcabang/$tgl1/$tgl2") ?>" class="btn btn-warning" style="margin: 5px;"><i class="fa fa-file-excel-o"></i>&nbsp; REALISASI XLS</a>
                    <?php endif; ?>
                    <a href="#" data-toggle="modal" data-target="#filter" class="btn btn-success" style="margin: 5px;"><i class="fa fa-search"></i>&nbsp; FILTER</a>
                    <a href="javascript:void(0)" data-href="<?= site_url("trans/uang_makan/list_um_regenerate/".bin2hex(json_encode(array('kdcabang'=>$kdcabang,'tgl'=>$tgl,'tgl1'=>$tgl1,'tgl2'=>$tgl2,'borong'=>$borong,'callplan'=>$callplan)))) ?>" class="btn btn-instagram regenerate" style="margin: 5px;"><i class="fa fa-refresh"></i>&nbsp; Generate ulang</a>
                </form>
            </div>

            <div class="box-body table-responsive">
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th style="width: 1%;">No</th>
                            <th>NIK</th>
                            <th>Nama</th>
                            <th>Departemen</th>
                            <th>Jabatan</th>
                            <th>Tanggal</th>
                            <th>Checktime</th>
                            <?php if($callplan == "t"): ?>
                                <th>Callplan</th>
                                <th>Realisasi</th>
                            <?php endif; ?>
                            <th>Keterangan</th>
                            <th>Uang Makan</th>
                            <th>BBM</th>
                            <th>Sewa Kendaraan</th>
                            <th>Sub Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; ?>
                        <?php foreach($list_um as $v): ?>
                            <?php $result = array_map("trim", (array)$v); ?>
                            <tr <?= $v->group_nmlengkap == 0 && $v->group_keterangan == 0 ? "" : "class=\"text-bold\"" ?>>
                                <td class="text-nowrap text-center"><?= number_format(($v->group_nmlengkap == 0 && $v->group_keterangan == 0 ? $i : ""), '0', ',', '.') ?></td>
                                <td><?= $v->nik ?></td>
                                <td><?= $v->nmlengkap ?></td>
                                <td><?= $v->nmdept ?></td>
                                <td><?= $v->nmjabatan ?></td>
                                <td class="text-nowrap"><?= $v->tglhari ?></td>
                                <td class="text-nowrap">
                                    <?php if(!is_null($v->checkin) || !is_null($v->checkout)): ?>
                                        <span style="width: 45px; float: left;"><?= $v->checkin ?: "&nbsp;" ?></span>
                                        <span> | </span>
                                        <span style="width: 45px;"><?= $v->checkout ?></span>
                                    <?php endif; ?>
                                </td>
                                <?php if($callplan == "t"): ?>
                                    <td class="text-nowrap text-right">
                                        <?php if($v->rencanacallplan > 0): ?> <a href="#" data-toggle="modal" data-target="#rencana" onclick='addRencana(<?= json_encode($result, JSON_HEX_APOS) ?>)'> <?php endif; ?>
                                                <?= number_format(($v->group_nmlengkap == 0 && $v->group_keterangan == 0 && trim($v->callplan) == "t" ? $v->rencanacallplan : ""), '0', ',', '.') ?>
                                        <?php if($v->rencanacallplan > 0): ?> </a> <?php endif; ?>
                                    </td>
                                    <td class="text-nowrap text-right">
                                        <a href="#" data-toggle="modal" data-target="#realisasi" onclick='addRealisasi(<?= json_encode($result, JSON_HEX_APOS) ?>)'>
                                            <?= number_format(($v->group_nmlengkap == 0 && $v->group_keterangan == 0 && trim($v->callplan) == "t" ? $v->realisasicallplan : ""), '0', ',', '.') ?>
                                        </a>
                                    </td>
                                <?php endif; ?>
                                <td><?= $v->keterangan ?></td>
                                <td class="text-nowrap text-right"><?= $v->nominalrp >= 0 ? number_format($v->nominalrp, '2', ',', '.') : null ?></td>
                                <td class="text-nowrap text-right"><?= $v->bbm >= 0 ? number_format($v->bbm, '2', ',', '.') : null ?></td>
                                <td class="text-nowrap text-right"><?= $v->sewa_kendaraan >= 0 ? number_format($v->sewa_kendaraan, '2', ',', '.') : null ?></td>
                                <td class="text-nowrap text-right"><?= $v->subtotal >= 0 ? number_format($v->subtotal, '2', ',', '.') : null ?></td>
                            </tr>
                            <?php $i = $i + ($v->group_nmlengkap == 0 && $v->group_keterangan == 0 ? 1 : 0); ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!--Modal Untuk Filter-->
<div class="modal fade" id="filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Filter Laporan Absensi</h4>
            </div>
            <form action="<?php echo site_url('trans/uang_makan/list_um');?>" name="form" role="form" method="post">
                <div class="modal-body">
                    <div class="form-group input-sm">
                        <label class="label-form col-sm-3">Wilayah</label>
                        <div class="col-lg-9">
                            <select class="form-control input-sm" id="kanwil" name="kanwil" placeholder="--- WILAYAH ---" required>
                                <option value="" class=""></option>
                                <?php foreach($kanwil as $v): ?>
                                    <?php $result = array_map("trim", (array)$v); ?>
                                    <option value="<?= $result['kdcabang'] ?>" data-data='<?= json_encode($result, JSON_HEX_APOS) ?>'></option>
                                <?php endforeach; ?>
                            </select>
                            <script type="text/javascript">
                                $('#kanwil').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    valueField: 'kdcabang',
                                    searchField: ['kdcabang', 'desc_cabang'],
                                    options: [],
                                    create: false,
                                    initData: true,
                                    render: {
                                        option: function(item, escape) {
                                            return '' +
                                                '<div class=\'row\'>' +
                                                    '<div class=\'col-md-3 text-nowrap\'>' + escape(item.kdcabang) + '</div>' +
                                                    '<div class=\'col-md-9 text-nowrap\'>' + escape(item.desc_cabang) + '</div>' +
                                                '</div>' +
                                            '';
                                        },
                                        item: function(item, escape) {
                                            return '' +
                                                '<div>' +
                                                    escape(item.kdcabang) + ' - ' +
                                                    escape(item.desc_cabang) +
                                                '</div>'
                                            ;
                                        }
                                    }
                                });
                                $("#kanwil").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                    </div>
                    <div class="form-group input-sm">
                        <label class="label-form col-sm-3">Tanggal</label>
                        <div class="col-lg-9">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" id="tgl" name="tgl" data-date-format="dd-mm-yyyy" class="form-control pull-right" value="<?= $tgl ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group input-sm">
                        <label class="col-lg-3">Borong</label>
                        <div class="col-lg-9">
                            <select class="form-control input-sm" id="borong" name="borong" placeholder="--- BORONG ---" required>
                                <option value="" class=""></option>
                                <option value="t">YA</option>
                                <option value="f">TIDAK</option>
                            </select>
                            <script type="text/javascript">
                                $('#borong').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    options: [],
                                    create: false,
                                    initData: true
                                }).on('change', function() {
                                    changeCallplan();
                                });
                                $("#borong").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                    </div>
                    <div class="form-group input-sm callplan-form">
                        <label class="col-lg-3">Callplan</label>
                        <div class="col-lg-9">
                            <select class="form-control input-sm" id="callplan" name="callplan" placeholder="--- CALLPLAN ---" required>
                                <option value="" class=""></option>
                                <option value="t">YA</option>
                                <option value="f">TIDAK</option>
                            </select>
                            <script type="text/javascript">
                                $('#callplan').selectize({
                                    plugins: ['hide-arrow', 'selectable-placeholder'],
                                    options: [],
                                    create: false,
                                    initData: true
                                });
                                $("#callplan").addClass("selectize-hidden-accessible");
                            </script>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit1" class="btn btn-primary">Proses</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!--Modal Untuk Callplan-->
<div class="modal fade" id="rencana" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Callplan</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="rencana_nik" name="rencana_nik" class="form-control" value="0419.350">
                <input type="hidden" id="rencana_tgl" name="rencana_tgl" class="form-control" value="2021-10-09">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group input-sm">
                            <label>Nama</label>
                            <input type="text" id="rencana_nama" name="rencana_nama" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-sm">
                            <label>Tanggal</label>
                            <input type="text" id="rencana_tanggal" name="rencana_tanggal" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="box-body table-responsive" style="margin-top: 35px;">
                    <table id="rencana-table" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kode Customer</th>
                                <th>Customer NOO</th>
                                <th>Nama Customer</th>
                                <th>Tipe Customer</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Modal Untuk Realisasi-->
<div class="modal fade" id="realisasi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Realisasi</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id="realisasi_nik" name="realisasi_nik" class="form-control" value="0419.350">
                <input type="hidden" id="realisasi_tgl" name="realisasi_tgl" class="form-control" value="2021-10-09">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group input-sm">
                            <label>Nama</label>
                            <input type="text" id="realisasi_nama" name="realisasi_nama" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="form-group input-sm">
                            <label>Tanggal</label>
                            <input type="text" id="realisasi_tanggal" name="realisasi_tanggal" class="form-control" readonly>
                        </div>
                    </div>
                </div>

                <div class="box-body table-responsive" style="margin-top: 35px;">
                    <table id="realisasi-table" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Customer</th>
                            <th>Customer NOO</th>
                            <th>Nama Customer</th>
                            <th>Tipe Customer</th>
                            <th>Checktime</th>
                            <th>Terhitung</th>
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    function win_onkeydown_handler() {
        switch (event.keyCode) {

            case 116 : // 'F5'
                event.returnValue = false;
                event.keyCode = 0;
                break;

            case 27: // 'Esc'
                event.returnValue = false;
                event.keyCode = 0;
                break;

            case 08: // 'BackSpace'
                if (event.srcElement.tagName == "INPUT"
                    || event.srcElement.tagName == "TEXTAREA") {
                } else {
                    event.returnValue = false;
                    event.keyCode = 0;
                }
                break;

        }
    }
    //Date range picker
    $('#tgl').daterangepicker();
    $('#kanwil')[0].selectize.setValue("<?= $kdcabang ?>");
    $('#borong')[0].selectize.setValue("<?= $borong ?>");
    $('#callplan')[0].selectize.setValue("<?= $callplan ?>");

    function addRencana(data) {
        $("#rencana_nik").val(data.nik);
        $("#rencana_tgl").val(data.tgl);
        $("#rencana_nama").val(data.nik + " - " + data.nmlengkap);
        $("#rencana_tanggal").val(data.tglhari);

        t_rencana.ajax.reload();
    }

    function addRealisasi(data) {
        $("#realisasi_nik").val(data.nik);
        $("#realisasi_tgl").val(data.tgl);
        $("#realisasi_nama").val(data.nik + " - " + data.nmlengkap);
        $("#realisasi_tanggal").val(data.tglhari);

        t_realisasi.ajax.reload();
    }

    function changeCallplan() {
        if($('#borong').val() == "f") {
            $('.callplan-form').show();
            $('#callplan').prop('required', true);
        } else {
            $('.callplan-form').hide();
            $('#callplan')[0].selectize.setValue("f");
            $('#callplan').prop('required', false);
        }
    }
    changeCallplan();

    $( document ).ready(function() {
        $('a.regenerate').on('click', function (){
            var row = $(this)
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm btn-success ml-3',
                    cancelButton: 'btn btn-sm btn-warning ml-3',
                    denyButton: 'btn btn-sm btn-danger ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi',
                html: 'Konfirmasi regenerate uang makan</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    win_onkeydown_handler();
                    window.location.replace(row.data('href'))
                    swal.fire({
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        html: '<h3>Sedang proses...</h3>',
                        showConfirmButton: false,
                        didOpen: () => {
                            Swal.showLoading();
                        },
                    });

                }
            })
        })
    });
</script>
