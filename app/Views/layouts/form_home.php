<?= $this->extend('layouts/main_default') ?>

<?= $this->section('content') ?>

        <style>
            .content {
                background: url('<?= base_url('assets/img/cirurgia-950.png') ?>') no-repeat center center fixed;
                background-size: cover;
            }

            #sidebar {
                text-align: center; 
                max-width: auto; 
                margin: 0 auto; 
                overflow: hidden; /* Para cobrir toda a área do sidebar */
                background-color: white;
            }

            .sidebar-image {
                max-width: 100%; 
                height: auto;
            }
        </style>

        <div class="content" id="content">
            <div class="content-container">
                <?= $this->include('layouts/div_flashdata') ?>
                <?= $this->renderSection('subcontent') ?>
            </div>

            <?php use App\Libraries\HUAP_Functions; HUAP_Functions::limpa_msgs_flash(); ?>
            <?php include 'modal_aguarde.php'; ?>
        </div>

        <script>

            document.addEventListener("DOMContentLoaded", function() {

                event.preventDefault(); // Previne a submissão padrão do formulário

                const xhr = new XMLHttpRequest();
                xhr.open('POST', '<?= base_url('mapacirurgico/verificacirurgiasemaprovacao') ?>', true); 
                xhr.setRequestHeader('Content-Type', 'application/json');
                xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');

                xhr.onload = function() {
                    if (xhr.status >= 200 && xhr.status < 400) {
                        const response = JSON.parse(xhr.responseText);

                        if (response.success) {

                            Swal.fire({
                                title: 'Há cirurgia(s) em aprovação. Deseja verificar agora?',
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonText: 'Sim',
                                cancelButtonText: 'Não'
                            }).then((result) => {
                                    if (result.isConfirmed) {
                                        $('#janelaAguarde').show(); 
                                            const url = '<?= base_url('mapacirurgico/vercirurgiasemaprovacao') ?>';
                                            window.location.href = url;
                                    } else {
                                        $('#janelaAguarde').hide(); 
                                    }
                            });

                        }

                    } else {
                        console.error('Erro ao enviar os dados:', xhr.statusText);
                        alert('Erro na comunicação com o servidor.');
                        $('#janelaAguarde').hide();
                        return false;  
                    }
                };

                xhr.send();
            });

            $(document).ready(function() {
                $('#idForm').submit(function() {
                    $('#janelaAguarde').show();
                });

                $('#sidebar').html('<img src="<?= base_url('assets/img/huap.png') ?>" class="sidebar-image" alt="huap"><img src="<?= base_url('assets/img/huap_gerencia2.png') ?>" class="sidebar-image" alt="gerencia">');
            
                //$('#sidebar').html('<p>Teste</p>');

            });
        </script>

<?= $this->endSection() ?>
