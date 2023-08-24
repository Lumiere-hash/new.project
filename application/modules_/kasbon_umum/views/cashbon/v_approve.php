<?php
?>
<style>
</style>
<form role="form" class="formapprovecashbon" action="<?php echo site_url('kasbon_umum/cashbon/doapprove/'.bin2hex(json_encode(array('branch' => $employee->branch, 'employeeid' => $employee->nik, 'dutieid' => $cashbon->dutieid, 'cashbonid' => $cashbon->cashbonid, ))))?>" method="post">
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="box box-warning" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Karyawan</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">Nik</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $employee->nik ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Nama Karyawan</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $employee->nmlengkap ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Departemen</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $employee->employee.' '.$employee->nmsubdept ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">No.Telepon</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_phone" class="form-control" value="<?php echo (!$employee->nohp1)?'(belum diatur)':$employee->nohp1 ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">No. Rekening</label>
                                <div class="col-sm-8">
                                    <input type="text" name="emp_account" class="form-control" value="<?php echo (!$employee->norek)?'(belum diatur)':$employee->norek.' ['.$employee->namabank.']' ?>" readonly/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="box box-primary" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Kasbon</h3>
                    </div>
                    <div class="box-body">
                        <div class="form-horizontal">
                            <div class="form-group">
                                <label class="col-sm-4">No. Kasbon</label>
                                <div class="col-sm-8">
                                    <input type="text" class="form-control" value="<?php echo $cashbon->cashbonid ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Tipe</label>
                                <div class="col-sm-8">
                                    <input type="text" name="documenttype" class="form-control" value="<?php echo $cashbon->formattype ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jenis Pembayaran</label>
                                <div class="col-sm-8">
                                    <input type="text" name="" class="form-control" value="<?php echo $paymenttype->text ?>" readonly/>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-sm-4">Jumlah Kasbon</label>
                                <div class="col-sm-8">
                                    <input type="text" name="totalcashbon" readonly class="form-control autonumeric" value="<?php echo $cashbon->totalcashbonformat ?>" placeholder="masukkan nominal kasbon"/>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <?php if ($cashbon->type == 'PO'){ ?>
                    <div class="box box-success" >
                        <div class="box-header">
                            <h3 class="box-title text-muted">Data Detail PO</h3>
                        </div>
                        <div class="box-body">
                            <div class="table-responsive">
                                <table class="table table-hover table-bordered table-striped" id="cashboncomponent">
                                    <?php include APPPATH.'\modules\kasbon_umum\views\cashbon\v_component_po_read.php';?>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
                <div class="box box-success" >
                    <div class="box-header">
                        <h3 class="box-title text-muted">Data Detail Kasbon</h3>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped" id="cashboncomponent">
                                <?php include APPPATH.'\modules\kasbon_umum\views\cashbon\v_component_read.php';?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        <div class="col-sm-12">
            <button type="submit" class="btn btn-success ml-3 pull-right">Setujui</button>
            <button type="reset" class="btn btn-danger ml-3 pull-right">Batal</button>
        </div>
    </div>
</div>
</form>
<script>
    $(document).ready(function() {
        $.extend($.validator.messages, {
            required: 'Bagian ini diperlukan...',
            remote: 'Harap perbaiki bidang ini...',
            email: 'Harap masukkan email yang valid...',
            url: 'Harap masukkan URL yang valid...',
            date: 'Harap masukkan tanggal yang valid...',
            dateISO: 'Harap masukkan tanggal yang valid (ISO)...',
            birthdate: 'Harap masukkan tanggal lahir tidak lebih dari 120 tahun...',
            time: 'Harap masukkan waktu yang valid...',
            number: 'Harap masukkan nomor valid...',
            digits: 'Harap masukkan hanya digit angka...',
            creditcard: 'Harap masukkan nomor kartu kredit yang benar...',
            equalTo: 'Harap masukkan nilai yang sama lagi...',
            accept: 'Harap masukkan nilai dengan ekstensi valid...',
            maxlength: $.validator.format('Harap masukkan tidak lebih dari {0} karakter...'),
            minlength: $.validator.format('Harap masukkan sedikitnya {0} karakter...'),
            rangelength: $.validator.format('Harap masukkan nilai antara {0} dan {1} karakter...'),
            range: $.validator.format('Harap masukkan nilai antara {0} dan {1}...'),
            max: $.validator.format('Harap masukkan nilai kurang dari atau sama dengan {0}...'),
            min: $.validator.format('Harap masukkan nilai lebih besar dari atau sama dengan {0}...'),
            alphanumeric: 'Harap masukkan hanya huruf dan angka',
            longlat: 'Harap masukkan hanya latitude dan longitude',
        });
        $.validator.addMethod('greaterThan', function(value, element, params) {
            if ($(params[0]).val().length && value.length) {
                return $(element).data('DateTimePicker').date().toDate() > $(params[0]).data('DateTimePicker').date().toDate();
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        }, 'Nilai harus lebih besar dari {1}');
        $.validator.addMethod('lessThan', function(value, element, params) {
            if ($(params[0]).val().length && value.length) {
                return $(element).data('DateTimePicker').date().toDate() < $(params[0]).data('DateTimePicker').date().toDate();
            }
            return isNaN(value) && isNaN($(params[0]).val()) || (Number(value) > Number($(params[0]).val()));
        }, 'Nilai harus lebih kecil dari {1}');
        $('form.formapprovecashbon').submit(function(e){
            e.preventDefault();
        }).bind('reset', function(){
            Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-sm ml-3',
                    cancelButton: 'btn btn-sm ml-3',
                    denyButton: 'btn btn-sm ml-3',
                },
                buttonsStyling: false,
            }).fire({
                title: 'Konfirmasi Reset',
                html: 'Konfirmasi reset data <b>Kasbon Karyawan</b> ?',
                icon: 'question',
                showCloseButton: true,
                confirmButtonText: 'Konfirmasi',
            }).then(function (result) {
                if (result.isConfirmed) {
                    window.location.replace('<?php echo site_url('kasbon_umum/cashbon/') ?>');
                }
            });
        }).validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: '',
            messages: {},
            rules: {},
            onfocusout: function(element) {
                $(element).valid();
            },
            invalidHandler: function(event, validator) { },
            errorPlacement: function(error, element) {
                if (element.hasClass('select2') && element.next('.select2-container').length) {
                    error.insertAfter(element.next('.select2-container'));
                } else if (element.is(':checkbox')) {
                    error.insertAfter(element.closest('.md-checkbox-list, .md-checkbox-inline, .checkbox-list, .checkbox-inline'));
                } else if (element.is(':radio')) {
                    error.insertAfter(element.closest('.md-radio-list, .md-radio-inline, .radio-list,.radio-inline'));
                } else {
                    error.insertAfter(element);
                }
            },
            highlight: function(element) {
                $(element).closest('.form-group').addClass('has-error');
            },
            unhighlight: function(element) {
                $(element).closest('.form-group').removeClass('has-error');
            },
            success: function(label) {
                label.closest('.form-group').removeClass('has-error');
            },
            submitHandler: function(form) {
                Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-sm btn-success ml-3',
                        cancelButton: 'btn btn-sm btn-warning ml-3',
                        denyButton: 'btn btn-sm btn-danger ml-3',
                    },
                    buttonsStyling: false,
                }).fire({
                    title: 'Konfirmasi Setujui',
                    html: 'Konfirmasi setujui data <b>Kasbon Karyawan</b> ?',
                    icon: 'question',
                    showCloseButton: true,
                    confirmButtonText: 'Konfirmasi',
                }).then(function (result) {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: $('form.formapprovecashbon').attr('action'),
                            data: $('form.formapprovecashbon').serialize(),
                            type: 'POST',
                            success: function (data) {
                                Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-sm ml-3',
                                        cancelButton: 'btn btn-sm ml-3',
                                        denyButton: 'btn btn-sm ml-3',
                                    },
                                    buttonsStyling: false,
                                }).fire({
                                    position: 'top',
                                    icon: 'success',
                                    title: 'Berhasil Disetujui',
                                    html: data.message,
                                    timer: 3000,
                                    timerProgressBar: true,
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    showDenyButton: true,
                                    denyButtonText: `Tutup`,
                                }).then(function(){
                                    window.location.replace('<?php echo site_url('kasbon_umum/cashbon/') ?>');
                                });
                            },
                            error: function (xhr, status, thrown) {
                                console.log(xhr)
                                Swal.mixin({
                                    customClass: {
                                        confirmButton: 'btn btn-sm btn-success ml-3',
                                        cancelButton: 'btn btn-sm btn-warning ml-3',
                                        denyButton: 'btn btn-sm btn-danger ml-3',
                                    },
                                    buttonsStyling: false,
                                }).fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: 'Gagal Disetujui',
                                    html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                                    showCloseButton: true,
                                    showConfirmButton: false,
                                    showDenyButton: true,
                                    denyButtonText: `Tutup`,
                                }).then(function(){ });
                            },
                        });
                    }
                });
            },
        });
    });
</script>
