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
<legend><?php echo $title;?></legend>

<div class="row" id="edit" >
    <div>
        <div>
            <a href="<?php echo site_url("trans/cuti_karyawan/")?>"  class="btn btn-primary">Kembali</a>
            <form action="<?php echo site_url('trans/cuti_karyawan/edit_cuti_karyawan')?>" method="post">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="box box-danger">
                                <div class="box-body">
                                    <div class="form-horizontal">
                                        <div class="form-group">
                                            <label class="col-sm-4">No. Dokumen</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="status" name="nodok"  value="<?php echo trim($dtl['nodok']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">NIK</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="nik" name="nik"  value="<?php echo trim($dtl['nik']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Nama Karyawan</label>
                                            <div class="col-sm-8">
                                                <input type="hidden" id="nik" name="kdlvl1"  value="<?php echo trim($dtl['nmlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                                <input type="text" id="nik" name="kdlvl1"  value="<?php echo trim($dtl['nmlengkap']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                                <input type="hidden" id="nik" name="kdlvl"  value="<?php echo trim($dtl['kdlvljabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Department</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="nik" name="department"  value="<?php echo trim($dtl['nmdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Sub Department</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="nik" name="subdepartment"  value="<?php echo trim($dtl['nmsubdept']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Jabatan</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="nik" name="jabatan"  value="<?php echo trim($dtl['nmjabatan']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">NIK Atasan</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="nik" name="atasan"  value="<?php echo trim($dtl['nmatasan1']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">NIK Atasan2</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="nik" name="atasan2"  value="<?php echo trim($dtl['nmatasan2']); ?>" class="form-control" style="text-transform:uppercase" maxlength="40" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Alamat</label>
                                            <div class="col-sm-8">
                                                <textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" readonly><?php echo trim($dtl['alamat']);?></textarea>
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
                                        <script type="text/javascript">
                                            $(function() {
                                                $("#colorselector<?php echo trim($lb->nik); ?>").change(function(){
                                                    $(".colors<?php echo trim($lb->nik); ?>").hide();
                                                    $('#' + $(this).val()).show();
                                                });
                                            });
                                        </script>
                                        <div class="form-group">
                                            <label class="col-sm-4">Tipe Cuti</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" id="tpecuti" name="tpcuti" onchange="changetipeCuti()" required>
                                                    <option value="">--TIPE CUTI--</option>
                                                    <option value="A" <?= trim($dtl["tpcuti"]) == "A" ? "selected" : "" ?>>CUTI</option>
                                                    <option value="B" <?= trim($dtl["tpcuti"]) == "B" ? "selected" : "" ?>>IJIN KHUSUS</option>
                                                    <option value="C" <?= trim($dtl["tpcuti"]) == "C" ? "selected" : "" ?>>DINAS</option>
                                                </select>
                                            </div>
                                        </div>
                                        <script type="text/javascript" charset="utf-8">
                                            function changetipeCuti() {
                                                $(".subtitusi-cuti").hide();
                                                $(".ijin-khusus").hide();
                                                $("#statptg").prop("required", false);
                                                $("#kdijin_khusus").prop("required", false);

                                                if($("#tpecuti").val() == "A") {
                                                    $(".subtitusi-cuti").show();
                                                    $("#statptg").prop("required", true);
                                                } else if($("#tpecuti").val() == "B") {
                                                    $(".ijin-khusus").show();
                                                    $("#kdijin_khusus").prop("required", true);
                                                }
                                            }

                                            $(function() {
                                                changetipeCuti();
                                            });
                                        </script>
                                        <div class="form-group subtitusi-cuti">
                                            <label class="col-sm-4">Subtitusi Cuti</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" id="statptg" name="statptg">
                                                    <option value="">--SUBTITUSI CUTI--</option>
                                                    <option value="A1" <?= trim($dtl["status_ptg"]) == "A1" ? "selected" : "" ?>>POTONG CUTI</option>
                                                    <option value="A2" <?= trim($dtl["status_ptg"]) == "A2" ? "selected" : "" ?>>POTONG GAJI</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group ijin-khusus">
                                            <label class="col-sm-4">Tipe Ijin Khusus</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" id="kdijin_khusus" name="kdijin_khusus">
                                                    <option value="">--TIPE IJIN KHUSUS--</option>
                                                    <?php foreach($list_ijin_khusus as $listkan): ?>
                                                        <option value="<?= trim($listkan->kdijin_khusus) ?>"<?= trim($dtl["kdijin_khusus"]) == trim($listkan->kdijin_khusus) ? "selected" : "" ?>><?= trim($listkan->nmijin_khusus) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <script type="text/javascript">
                                            $(function() {
                                                $("#dateinput<?php echo trim($dtl['nodok']);?>").datepicker({
                                                    startDate: '<?= $opsi_cuti ?>'
                                                });
                                                $("#dateinput1<?php echo trim($dtl['nodok']);?>").datepicker({
                                                    startDate: '<?= $opsi_cuti ?>'
                                                });
                                                $("#kdtrx").selectize();
                                            });
                                        </script>
                                        <div class="form-group">
                                            <label class="col-sm-4">Tanggal Mulai</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="dateinput<?php echo trim($dtl['nodok']);?>" value="<?php echo trim($dtl['tgl_mulai1']); ?>" name="tgl_awal" data-date-format="dd-mm-yyyy"  class="form-control">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Tanggal Selesai</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="dateinput1<?php echo trim($dtl['nodok']);?>" value="<?php echo trim($dtl['tgl_selesai1']); ?>" name="tgl_selesai" data-date-format="dd-mm-yyyy"  class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="col-sm-4">Jumlah Cuti(Hari)</label>
                                            <div class="col-sm-8">
                                                <input type="number" id="gaji" name="jumlah_cuti" placeholder="0" value="<?php echo trim($dtl['jumlah_cuti']); ?>"  class="form-control" required  >
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Tanggal Dokumen</label>
                                            <div class="col-sm-8">
                                                <input type="text" id="tgl1" name="tgl_dok"  value="<?php echo trim($dtl['tgl_dok1']);?>"class="form-control" readonly>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Pelimpahan Pekerjaan</label>
                                            <div class="col-sm-8">
                                                <select class="form-control input-sm" name="pelimpahan" id="kdtrx">
                                                    <?php foreach($list_karyawan as $listkan): ?>
                                                        <option value="<?= trim($listkan->nik) ?>" <?= trim($dtl["pelimpahan"]) == trim($listkan->nik) ? "selected" : "" ?>><?= $listkan->nmlengkap ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-4">Keterangan</label>
                                            <div class="col-sm-8">
                                                <textarea type="text" id="nmdept" name="keterangan"   style="text-transform:uppercase" class="form-control" ><?php echo trim($dtl['keterangan']);?></textarea>
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">SIMPAN</button>
            </form>
        </div>
    </div>
</div>

