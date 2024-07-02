<table class="table table-left-aligned table-smaller-font">
    <tbody>
        <tr>
            <td width="20%"><i class="fa-solid fa-address-card"></i> Prontuário:</td>
            <td><b><?= $paciente->prontuario . ((!is_null($paciente->volume) && $paciente->volume != "") ? ('-V' . $paciente->volume) : '') ?></b></td>
        </tr>
        <tr>
            <td width="20%"><i class="fa-solid fa-id-card-clip"></i> Nome do Paciente:</td>
            <td><b><?= $paciente->nome ?></b></td>
        </tr>
        <tr>
            <td width="20%"><i class="fa-solid fa-cake-candles"></i> Data de Nascimento:</td>
            <td><b><?= date_format(date_create($paciente->dt_nascimento), 'd/m/Y') ?></b></td>
        </tr>
    </tbody>
</table>