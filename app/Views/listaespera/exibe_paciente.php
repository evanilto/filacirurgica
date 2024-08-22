<?php if(isset($paciente) && !empty($paciente)): ?>
    <h6><strong>Paciente</strong></h6>
    <table class="table table-left-aligned table-smaller-font">
        <tbody>
            <tr>
                <td width="40%"><i class="fa-solid fa-hashtag"></i> Ordem:</td>
                <td><b><?= $ordemfila ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-users-line"></i> Fila:</td>
                <td><b><?= $fila ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-folder"></i> Prontuário:</td>
                <td><b><?= $paciente[0]->prontuario ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-user"></i> Nome:</td>
                <td><b><?= $paciente[0]->nome ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-cake-candles"></i> Data Nasc.:</td>
                <td><b><?= $paciente[0]->dt_nascimento ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-person-half-dress"></i> Sexo:</td>
                <td><b><?= $paciente[0]->sexo ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-person-breastfeeding"></i> Mãe:</td>
                <td><b><?= $paciente[0]->nm_mae ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-person-cane"></i> Idade:</td>
                <td><b><?= $paciente[0]->idade ?> anos</b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-id-card"></i> CPF:</td>
                <td><b><?= $paciente[0]->cpf ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-hospital-user"></i> CNS:</td>
                <td><b><?= $paciente[0]->cns ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-mobile-retro"></i> Telefone:</td>
                <td><b><?= $paciente[0]->tel_1 ?>
                <?= $paciente[0]->tel_2 ? ', '.$paciente[0]->tel_2 : '' ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-at"></i> Email:</td>
                <td><b><?= mb_strtolower($paciente[0]->email, 'UTF-8') ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fas fa-map-marker-alt"></i> Endereço</td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-list"></i> Logradouro:</td>
                <td><b><?= $paciente[0]->logradouro ?>, <?= $paciente[0]->num_logr ?>
                <?= $paciente[0]->compl_logr ? ', '.$paciente[0]->compl_logr : '' ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-list"></i> Bairro:</td>
                <td><b><?= $paciente[0]->bairro ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-list"></i> Cidade:</td>
                <td><b><?= $paciente[0]->cidade ?>/<?= $paciente[0]->uf ?></b></td>
            </tr>
            <tr>
                <td width="40%"><i class="fa-solid fa-list"></i> CEP:</td>
                <td><b><?= substr($paciente[0]->cep, 0, 5) . '-' . substr($paciente[0]->cep, 5, 3) ?></b></td>
            </tr>
        </tbody>
    </table>
<?php else: ?>
    <p>Paciente não localizado na base do sistema AGHUX</p>
<?php endif; ?>
