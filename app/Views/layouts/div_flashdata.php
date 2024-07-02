
<?php
use App\Libraries\HUAP_Functions;

if(session()->getFlashdata('success')) { ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert"" id="flashdata">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?php echo session()->getFlashdata('success') ?>
    </div>
<?php } elseif(session()->getFlashdata('failed')) { ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert"" id="flashdata">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?php echo session()->getFlashdata('failed') ?>
    </div>
<?php } elseif(session()->getFlashdata('warning_message')) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert"" id="flashdata">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?php echo session()->getFlashdata('warning_message') ?>
    </div>
<?php } elseif(session()->getFlashdata('nochange')) { ?>
    <div class="alert alert-warning alert-dismissible fade show" role="alert"" id="flashdata">
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        <?php echo session()->getFlashdata('nochange') ?>
    </div>
<?php }
HUAP_Functions::limpa_msgs_flash();
?>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var timeout = 5000; // 5000ms = 5 segundos

        var flashdata = document.getElementById('flashdata');

        if (flashdata) {
            setTimeout(function () {
                flashdata.remove();
            }, timeout);
        }
    });
</script>