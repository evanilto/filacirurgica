<?php
 $session = \Config\Services::session();
 
 if (!isset($_SESSION)) {
    return redirect()->to('/');
 }
 
 ?>
<nav class="navbar navbar-expand-lg navbar-dark fixed-top bg-primary pt-1 pb-1">
    <img class="mb-6" src="<?= base_url() ?>/assets/img/doctor-32.png" alt="">
    <div class="container-fluid">
        <strong><a class="navbar-brand" href="<?= base_url('home') ?>"><?= HUAP_APPNAME ?></a></strong>
        <div class="ms-auto me-3 text-warning fs-6 text-end">
            <span><i class="fa-solid fa-circle-user"></i> <?= $_SESSION['Sessao']['Nome']?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>
            <!-- <span id="clock" class="ms-2"></span> -->
        </div>
        <a class="btn btn-danger my-2 my-sm-0" href="<?= base_url('') ?>"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
    </div>
</nav>

<input type="hidden" name="timeout" value="<?= env('huap.session.expires') ?>" />

