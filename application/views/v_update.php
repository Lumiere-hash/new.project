<style>
    .loader {
        border: 16px solid #f3f3f3;
        border-radius: 50%;
        border-top: 16px solid #3498db;
        width: 120px;
        height: 120px;
        -webkit-animation: spin 2s linear infinite; /* Safari */
        animation: spin 2s linear infinite;
    }

    /* Safari */
    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>

<div class="container" style="margin-top: 70px;">
    <div class="well text-center">
        <h2>UPDATE WEBSITE</h2>
        <hr>
        <div class="col-md-8 col-md-offset-2">
            <div class="loader"></div>
            <div class="msg alert alert-success text-center" style="display: none; font-size: large; margin-bottom: 0;"></div>
            <div class="msg-info alert alert-info text-center" style="display: none; font-size: large; margin-bottom: 0;"></div>
            <div class="msg-danger alert alert-danger text-center" style="display: none; font-size: large; margin-bottom: 0;"></div>
        </div>
        <div class="clearfix"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('.msg').hide();
        $('.msg-info').hide();
        $('.msg-danger').hide();
        $('.loader').show();

        $.ajax({
            type: 'POST',
            url: HOST_URL + "update/exec",
            dataType: "json",
            contentType: false,
            processData: false,
            success: function (response) {
                $('.loader').hide();

                if(response.status === "true") {
                    $("#loadMe").modal("hide");
                    $('.msg').html("WEBSITE BERHASIL DI UPDATE !!!");
                    $('.msg').show();
                } else if(response.status === "false") {
                    var msg = "WEBSITE SUDAH UP-TO-DATE !!";
                    $('.msg-info').html(msg);
                    $('.msg-info').show();
                } else {
                    var msg = "TERJADI KESALAHAN SAAT UPDATE. HUBUNGI TIM IT !!!!!";
                    $('.msg-danger').html(msg);
                    $('.msg-danger').show();
                }
            }
        });
    });
</script>
