<?= $this->extend('layouts/main_login'); $this->section('title') ?>
Entrar <?= $this->endSection() ?>
<?= $this->section('content') ?>

<main class="form-signin">
    <form method="post" action="/home/login">
        <?= csrf_field() ?>
        <?php $validation =  \Config\Services::validation(); ?>

        <?= $this->include('layouts/div_flashdata') ?>

        <a href="/"><img class="mb-4" src="<?= base_url() ?>/assets/img/doctor-96.png" alt=""></a>
        <h1 class="h3 mb-3 fw-normal"><?= ENVIRONMENT === 'production' ? HUAP_APPNAME : HUAP_APPNAME.'<br><strong>Desenvolvimento</strong>' ?></h1>


        <div class="card-body p-4">
            <div class="form-group mb-3 has-validation text-start">
                <input type="text" class="form-control <?php if($validation->getError('Usuario')): ?>is-invalid<?php endif ?>" name="Usuario" placeholder="Login EBSERH" autofocus value="<?php echo set_value('Usuario'); ?>"/>
                <?php if ($validation->getError('Usuario')): ?>
                    <div class="invalid-feedback text-center">
                        <?= $validation->getError('Usuario') ?>
                    </div>
                <?php endif; ?>
            </div>
            <div class="form-group text-start">
                <input type="password" data-toggle="password" class="form-control <?php if($validation->getError('Senha')): ?>is-invalid<?php endif ?>" name="Senha" placeholder="Senha" value="<?php echo set_value('Senha'); ?>"/>
                    <?php if ($validation->getError('Senha')): ?>
                    <div class="invalid-feedback text-center">
                        <?= $validation->getError('Senha') ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>

		<button class="w-100 btn btn-lg btn-primary" id="submit" type="submit">Entrar</button>
		<p class="mt-5 mb-3 text-muted">&copy; 2023 - <?= date('Y') ?></p>
	</form>
</main>

<?= $this->endSection() ?>
