<div class="modal-dialog modal-md" role="document">
    <div class="modal-content">
        <form enctype="multipart/form-data" class="form-horizontal formcreatearmada" role="form">
            <div class="modal-header">
                <h2 class="modal-title"><?php echo $title ?></h2>
            </div>
            <div class="modal-body">
                <div class="form-group row">
                    <label for="police_number" class="col-sm-2 col-form-label">Nomor Polisi</label>
                    <div class="col-sm-3">
                        <input type="text" name="police_number" class="form-control " id="police_number" placeholder value="<?php echo $document ?>" autocomplete="off" readonly >
                    </div>
                </div>
                <div class="form-group row">
                    <label for="type_transportation" class="col-sm-2 col-form-label">Jenis Angkutan</label>
                    <div class="col-sm-10">
                        <select name="type_transportation" class="select2 form-control " id="type_transportation">
                            <option></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-md btn-success action col-sm-2" id="submit">Simpan</button>
                <button type="reset" class="btn btn-md btn-danger action col-sm-2" data-dismiss="modal">Batal</button>
            </div>
        </form>
    </div>
</div>