<?php
?>
<style>
    .has-error .help-block,
    .has-error .control-label,
    .has-error .radio,
    .has-error .checkbox,
    .has-error .radio-inline,
    .has-error .checkbox-inline,
    .has-error.radio label,
    .has-error.checkbox label,
    .has-error.radio-inline label,
    .has-error.checkbox-inline label {
        color: #e73d4a;
    }
    input::-webkit-outer-spin-button,
    input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
    }
    input[type=number] {
        -moz-appearance: textfield;
    }
    select[multiple], select[size] {
        height: 34px;
        overflow: hidden;
    }
    select {
        appearance: none;
    }
    .select2-container--bootstrap {
        z-index: 9999;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        visibility: hidden;
    }

    .select2-container--bootstrap .select2-selection {
        border: 1px dashed #c2cad8;
    }
    .select2-container--bootstrap .select2-selection--single .select2-selection__rendered {
        padding: 0 0 0 12px;
    }

</style>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
        </div>
    </div>
    <div class="box-body">
        <form class="container form-component" id="form-component" >
            <div class="form-group row">
                <label for="componentid" class="p-2 col-sm-2 col-form-label font-weight-bold">ID Komponen</label>
                <div class="col-sm-3">
                    <input type="text" name="componentid" class="form-control " id="componentid" placeholder value="<?php echo $data->componentid ?>" autocomplete="off" readonly >
                </div>
            </div>
            <div class="form-group row">
                <label for="description" class="p-2 col-sm-2 col-form-label font-weight-bold">Deskripsi</label>
                <div class="col-sm-3">
                    <input type="text" name="description" class="form-control text-uppercase" id="description" placeholder value="<?php echo $data->description ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label for="unit" class="p-2 col-sm-2 col-form-label font-weight-bold">Unit</label>
                <div class="col-sm-3">
                    <input type="text" name="unit" class="form-control text-uppercase" id="unit" placeholder value="<?php echo $data->unit ?>" >
                </div>
            </div>
            <div class="form-group row">
                <label for="unit" class="p-2 col-sm-2 col-form-label font-weight-bold">Urutan</label>
                <div class="col-sm-3">
                    <input type="number" name="sort" class="form-control " id="sort" placeholder value="<?php echo number_format($data->sort)  ?>" min="1" max="99">
                </div>
            </div>
            <div class="form-group row">
                <label for="calculated" class="p-2 col-sm-2 col-form-label font-weight-bold">Kalkulasi</label>
                <div class="col-sm-3">
                    <select name="calculated" id="calculated" class="form-control select2">
                        <option <?php echo ($data->calculated=='t')?'selected':''; ?> value="true">Ya</option>
                        <option <?php echo ($data->calculated=='f')?'selected':''; ?> value="false">Tidak</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="active" class="p-2 col-sm-2 col-form-label font-weight-bold">Aktif</label>
                <div class="col-sm-3">
                    <select name="active" id="active" class="form-control select2">
                        <option <?php echo ($data->active=='t')?'selected':''; ?> value="true">Ya</option>
                        <option <?php echo ($data->active=='f')?'selected':''; ?> value="false">Tidak</option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="readonly" class="p-2 col-sm-2 col-form-label font-weight-bold">Readonly</label>
                <div class="col-sm-3">
                    <select name="readonly" id="readonly" class="form-control select2">
                        <option <?php echo ($data->readonly=='t')?'selected':''; ?> value="true">Ya</option>
                        <option <?php echo ($data->readonly=='f')?'selected':''; ?> value="false">Tidak</option>
                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-3">
                    <a href="<?php echo $backurl ?>" class="btn btn-sm btn-danger">Kembali</a>
                    <button type="submit" id="btn-save" class="btn btn-sm btn-success pull-right">Simpan</button>
                </div>

            </div>
        </form>
    </div>
</div>
<script>

    $(document).ready(function(){
        $('.select2').select2({
            placeholder : 'Pilih salah satu'
        });

        jQuery.extend(jQuery.validator.messages, {
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
            maxlength: jQuery.validator.format('Harap masukkan tidak lebih dari {0} karakter...'),
            minlength: jQuery.validator.format('Harap masukkan sedikitnya {0} karakter...'),
            rangelength: jQuery.validator.format('Harap masukkan nilai antara {0} dan {1} karakter...'),
            range: jQuery.validator.format('Harap masukkan nilai antara {0} dan {1}...'),
            max: jQuery.validator.format('Harap masukkan nilai kurang dari atau sama dengan {0}...'),
            min: jQuery.validator.format('Harap masukkan nilai lebih besar dari atau sama dengan {0}...'),
            alphanumeric: 'Harap masukkan hanya huruf dan angka',
            longlat: 'Harap masukkan hanya latitude dan longitude',
        });

        $('form.form-component').validate({
            errorElement: 'span',
            errorClass: 'help-block help-block-error',
            focusInvalid: false,
            ignore: '',
            messages: {},
            rules: {
                componentid: {
                    required: true,
                },
                description: {
                    required: true,
                },
                unit:{
                    required: true,
                },
                sort:{
                    required: true,
                    number: true,
                }
            },
            invalidHandler: function(event, validator) {

            },
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
                        confirmButton: 'btn btn-success',
                    },
                    buttonsStyling: false,
                }).fire({
                    title: 'Konfirmasi Simpan',
                    html: 'Konfirmasi simpan data <b>Komponen</b> ?',
                    icon: 'info',
                    showCloseButton: true,
                    confirmButtonText: 'Konfirmasi',
                }).then(function (result) {
                    var response
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '<?php echo $saveurl?>',
                            data: $('form.form-component').serialize(),
                            type: 'POST',
                            success: function (data) {
                                response = jQuery.parseJSON(data)
                                if (response['status']){
                                    Swal.fire({
                                        position: 'top',
                                        icon: 'success',
                                        title: response['title'],
                                        text: response['message'],
                                        showConfirmButton: false,
                                        timer: 3000,
                                    });
                                }else{
                                    Swal.fire({
                                        position: 'top',
                                        icon: 'error',
                                        title: response['title'],
                                        text: response['message'],
                                        showConfirmButton: false,
                                        timer: 3000,
                                    });
                                }

                            },
                            error: function (xhr, status, thrown) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: 'Gagal Disimpan',
                                    text: xhr.statusText,
                                    showConfirmButton: false,
                                    timer: 3000,
                                });
                            },
                        });
                    }
                });
            },
        });
    });
</script>