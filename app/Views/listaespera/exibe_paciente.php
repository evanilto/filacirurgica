<?php if(isset($paciente) && !empty($paciente)): ?>
    <h6><strong>Paciente</strong></h6>
    <table class="table table-left-aligned table-smaller-font">
        <tbody>
            <tr>
                <td width="40%"><i class="fa-solid fa-hashtag"></i> Ordem Fila</td>
                <td><b><?= $ordemfila == 0 ? '-' : $ordemfila ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-users-line"></i> Fila:</td>
                <td><b><?= $fila ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-folder"></i> Prontuário:</td>
                <td><b><?= $paciente->prontuario ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-user"></i> Nome:</td>
                <td><b><?= $paciente->nome ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-cake-candles"></i> Data Nasc.:</td>
                <td><b><?= $paciente->dt_nascimento ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-person-half-dress"></i> Sexo:</td>
                <td><b><?= $paciente->sexo ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-person-breastfeeding"></i> Mãe:</td>
                <td><b><?= $paciente->nm_mae ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-person-cane"></i> Idade:</td>
                <td><b><?= $paciente->idade ?> anos</b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-id-card"></i> CPF:</td>
                <td><b><?= $paciente->cpf ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-hospital-user"></i> CNS:</td>
                <td><b><?= $paciente->cns ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-mobile-retro"></i> Telefone:</td>
                <td><b><?= $paciente->tel_1 ?>
                <?= $paciente->tel_2 ? ', '.$paciente->tel_2 : '' ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-at"></i> Email:</td>
                <td><b><?= mb_strtolower($paciente->email, 'UTF-8') ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fas fa-map-marker-alt"></i> Endereço</td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-list"></i> Logradouro:</td>
                <td><b><?= $paciente->logradouro ?>, <?= $paciente->num_logr ?>
                <?= $paciente->compl_logr ? ', '.$paciente->compl_logr : '' ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-list"></i> Bairro:</td>
                <td><b><?= $paciente->bairro ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-list"></i> Cidade:</td>
                <td><b><?= $paciente->cidade ?>/<?= $paciente->uf ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-list"></i> CEP:</td>
                <td><b><?= substr($paciente->cep, 0, 5) . '-' . substr($paciente->cep, 5, 3) ?></b></td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <p>Paciente não localizado na base do sistema AGHUX</p>
<?php endif; ?>
