<?php
?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-12">
            <h3 class="pull-left"><?php echo $title ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="col-sm-12 table-responsive">
            <?php
                $this->datatablessp->generatetable();
                $this->datatablessp->jquery();
            ?>
        </div>
    </div>
</div>
<div class="modal fade" id="create-component" role="dialog" aria-hidden="true"></div>
<script>
    $(document).ready(function() {
        $('table#table-component-cashbon').DataTable().draw()
        $('table#table-component-cashbon tbody').on('click', 'td a.popup', function () {
            var row = $(this);
            $.getJSON(row.attr('data-href'), {})
                .done(function(data) {
                    if (data.canupdate) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statustext,
                            html: `Rubah Komponen <b>${data.data.description}</b> ?`,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Rubah',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next);
                            }
                        });
                    }
                    if (data.candelete) {
                        Swal.mixin({
                            customClass: {
                                confirmButton: 'btn btn-sm btn-success ml-3',
                                cancelButton: 'btn btn-sm btn-warning ml-3',
                                denyButton: 'btn btn-sm btn-danger ml-3',
                            },
                            buttonsStyling: false,
                        }).fire({
                            icon: 'question',
                            title: data.statustext,
                            html: `Hapus Komponen <b>${data.data.description}</b> ?`,
                            showCloseButton: true,
                            showConfirmButton: true,
                            confirmButtonText: 'Hapus',
                            showDenyButton: true,
                            denyButtonText: `Tutup`,
                        }).then(function (result) {
                            if (result.isConfirmed) {
                                window.location.replace(data.next);
                            }
                        });
                    }
                })
                .fail(function(xhr, status, thrown) {
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
                        title: 'Gagal Memuat Status',
                        html: (xhr.responseJSON && xhr.responseJSON.message ? xhr.responseJSON.message : xhr.statusText),
                        showCloseButton: true,
                        showConfirmButton: false,
                        showDenyButton: true,
                        denyButtonText: `Tutup`,
                    }).then(function () {
                    });
                });
        });
    });

</script>