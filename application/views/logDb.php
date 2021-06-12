<link href="<?php echo base_url('assets/css/datepicker.css');?>" rel="stylesheet" type="text/css" />
<legend>Log Database</legend>
<div class="row">
    <div class="col-xs-12">
        <div class="box" style="padding: 20px 0;">
            <div class="box-header">
                <?php if(sizeof($data) > 0): ?>
                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal1" style="margin:10px"><i class="glyphicon glyphicon-plus"></i> INPUT</a>
                <?php else: ?>
                    <div style="text-align: center;">
                        <button class="btn btn-warning"><i class="fa fa-plus"></i>&nbsp; INSTALL LOG</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="box-body">
                <?php if(sizeof($data) > 0): ?>
                    <table id="example1" class="table table-bordered table-striped" >
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Tag</th>
                                <th>Username</th>
                                <th>Database Name</th>
                                <th>Client Address</th>
                                <th>Exec Time</th>
                                <th>Query</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<script>
    $("#example1").dataTable();
    // $('#tgl').datepicker();
</script>
