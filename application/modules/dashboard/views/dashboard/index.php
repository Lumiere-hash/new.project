<style>
    thead tr th {
        text-align: center;
        text-transform: uppercase;
    }

    thead tr th:first-child {
        padding-right: 8px !important;
    }

    thead tr th,
    tbody tr td {
        border: 0.1px solid #dddddd !important;
    }

    .dataTables_info,
    .dataTables_paginate,
    tbody tr td {
        font-weight: normal;
    }
</style>
<?php if (!is_null($dtlbroadcast)) { ?>
    <div class="row">
        <div class="alert alert-success alert-dismissible" role="alert">
            <button type="button" onclick="this.parentNode.parentNode.removeChild(this.parentNode);" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
            <h4><strong><i class="fa fa-bullhorn"></i>&nbsp; MOHON PERHATIAN !!!</h4>
            <marquee><h1><?= trim($dtlbroadcast['value1']) ?></h1></marquee>
        </div>
    </div>
<?php } ?>

<?php if ($rowakses > 0 || $level == "A") { ?>
    <div class="row" >
        <!-- START OF OJT -->
        <div class="col-md-6">
            <div class="box box-primary" >
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title_ojt; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_ojt" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">NIK</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th width="10%">Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list_ojt as $k => $v):?>
                                    <tr>
                                        <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                        <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                        <td><?php echo trim($v->nmlengkap);?></td>
                                        <td><?php echo trim($v->nmdept);?></td>
                                        <td class="text-nowrap text-center"><?php echo date('d-m-Y',strtotime($v->tgl_selesai));?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/excel_ojt'); ?>','_blank')" class="btn btn-sm btn-success btn-flat pull-left"><i class="fa fa-download"></i>&nbsp; Download Xls </a>
                    <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/list_ojt'); ?>', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=200,width=1200,height=700')" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-eye"></i>&nbsp; View All</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        <!-- END OF OJT -->

        <!--START OF KONTRAK-->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title_kontrak; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_kontrak" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">NIK</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th width="10%">Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list_kontrak as $k => $v): ?>
                                    <tr>
                                        <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                        <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                        <td><?php echo trim($v->nmlengkap);?></td>
                                        <td><?php echo trim($v->nmdept);?></td>
                                        <td class="text-nowrap text-center"><?php echo date('d-m-Y',strtotime($v->tgl_selesai1));?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/excel_kontrak'); ?>','_blank')" class="btn btn-sm btn-success btn-flat pull-left"><i class="fa fa-download"></i>&nbsp; Download Xls </a>
                    <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/list_karkon'); ?>', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=200,width=1200,height=700')" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-eye"></i>&nbsp; View All</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        <!--END OF KONTRAK-->
    </div>

    <div class="row">
        <!--START OF PENSIUN-->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title_pensiun; ?></h3>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_pensiun" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">Nik</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th width="5%">Umur</th>
                                    <th width="10%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list_pensiun as $k => $v):?>
                                    <tr>
                                        <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                        <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                        <td><?php echo trim($v->nmlengkap);?></td>
                                        <td><?php echo trim($v->nmdept);?></td>
                                        <td class="text-nowrap text-right"><?php echo $v->umur;?></td>
                                        <td class="text-nowrap text-center"><?php echo 'TELAH MEMASUKI MASA PENSIUN';?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                    <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/excel_pensiun'); ?>','_blank')" class="btn btn-sm btn-success btn-flat pull-left"><i class="fa fa-download"></i>&nbsp; Download Xls </a>
                    <a href="#" onclick="window.open('<?php echo site_url('trans/stspeg/list_karpen'); ?>', '_blank', 'toolbar=yes,scrollbars=yes,resizable=yes,top=0,left=200,width=1200,height=700')" class="btn btn-sm btn-info btn-flat pull-right"><i class="fa fa-eye"></i>&nbsp; View All</a>
                </div>
                <!-- /.box-footer -->
            </div>
        </div>
        <!--END OF PENSIUN-->

        <!--START OF MAGANG-->
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $title_magang; ?></h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="t_magang" class="display nowrap table table-striped no-margin" style="width:100%">
                            <thead>
                                <tr>
                                    <th width="1%">No</th>
                                    <th width="10%">NIK</th>
                                    <th>Nama</th>
                                    <th>Bagian</th>
                                    <th width="10%">Akhir</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($list_magang as $k => $v): ?>
                                    <tr>
                                        <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                        <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                        <td><?php echo trim($v->nmlengkap);?></td>
                                        <td><?php echo trim($v->nmdept);?></td>
                                        <td class="text-nowrap text-center"><?php echo date('d-m-Y',strtotime($v->tgl_selesai));?></td>
                                    </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.table-responsive -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
        <!--END OF MAGANG-->
    </div>
<?php } ?>

<div class="row" >
    <!-- START OF CUTI -->
    <div class="col-md-6">
        <div class="box box-primary" >
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title_cuti; ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="t_cuti" class="display nowrap table table-striped no-margin" style="width:100%">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">NIK</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Tanggal</th>
                                <th width="20%">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_cuti as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                    <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                    <td><?php echo trim($v->nmlengkap);?></td>
                                    <td><?php echo trim($v->bagian);?></td>
                                    <td class="text-nowrap text-center"><?php echo date('d-m-Y',strtotime($v->tgl));?></td>
                                    <td class="text-nowrap text-center"><?php echo trim($v->keterangan);?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!-- END OF CUTI -->

    <!--START OF IJIN-->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title_ijin; ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="t_ijin" class="display nowrap table table-striped no-margin" style="width:100%">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">Nik</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Dokumen</th>
                                <th width="10%">Type</th>
                                <th width="10%">Awal</th>
                                <th width="10%">Akhir</th>
                                <th width="10%">Kategori</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_ijin as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                    <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                    <td><?php echo trim($v->nmlengkap);?></td>
                                    <td><?php echo trim($v->bagian);?></td>
                                    <td class="text-nowrap"><?php echo trim($v->nodok);?></td>
                                    <td class="text-nowrap text-center"><?php echo trim($v->tipe_ijin);?></td>
                                    <td class="text-nowrap text-center"><?php echo empty($v->jam_awal) ? '' : date('d-m-Y',strtotime($v->jam_awal));?></td>
                                    <td class="text-nowrap text-center"><?php echo empty($v->jam_akhir) ? '' : date('d-m-Y',strtotime($v->jam_akhir));?></td>
                                    <td class="text-nowrap text-center"><?php echo trim($v->kategori);?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!--END OF IJIN-->
</div>

<div class="row" >
    <!--START OF LEMBUR-->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title_lembur; ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="t_lembur" class="display nowrap table table-striped no-margin" style="width:100%">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">Nik</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Dokumen</th>
                                <th width="10%">Jam</th>
                                <th width="10%">Jenis</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_lembur as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                    <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                    <td><?php echo trim($v->nmlengkap);?></td>
                                    <td><?php echo trim($v->nmdept);?></td>
                                    <td class="text-nowrap"><?php echo trim($v->nodok);?></td>
                                    <td class="text-nowrap text-center"><?php echo trim($v->jam);?></td>
                                    <td class="text-nowrap text-center"><?php echo trim($v->nmjenis_lembur);?></td>
                                    <td><?php echo trim($v->keterangan);?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!--END OF LEMBUR-->

    <!--START OF DINAS-->
    <div class="col-md-6">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $title_dinas; ?></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="table-responsive">
                    <table id="t_dinas" class="display nowrap table table-striped no-margin" style="width:100%">
                        <thead>
                            <tr>
                                <th width="1%">No</th>
                                <th width="10%">NIK</th>
                                <th>Nama</th>
                                <th>Bagian</th>
                                <th width="10%">Tanggal</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($list_dinas as $k => $v): ?>
                                <tr>
                                    <td class="text-nowrap text-center"><?php echo ($k + 1);?></td>
                                    <td class="text-nowrap"><?php echo trim($v->nik);?></td>
                                    <td><?php echo trim($v->nmlengkap);?></td>
                                    <td><?php echo trim($v->bagian);?></td>
                                    <td class="text-nowrap text-center"><?php echo date('d-m-Y',strtotime($v->tgl));?></td>
                                    <td><?php echo trim($v->tujuan);?></td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>
                </div>
                <!-- /.table-responsive -->
            </div>
            <!-- /.box-body -->
        </div>
    </div>
    <!--END OF DINAS-->
</div>
<!-- /.box -->

<script type="text/javascript">
    $(function() {
        $("#t_ojt").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_kontrak").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_pensiun").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_magang").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_recent").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_cuti").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_dinas").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_ijin").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
        $("#t_lembur").dataTable({
            scrollX: true,
            pageLength: 5,
            lengthMenu: [[5, 25, 50, -1], [5, 25, 50, "All"]],
            order: [],
            columnDefs: [{
                orderable: false,
                targets: 0
            }]
        });
    });
</script>
