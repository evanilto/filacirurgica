<?php echo form_open('transfusao/salvar_testes', ['class' => 'form-horizontal']); ?>
<div class="container border p-4">
    <h5 class="text-center fw-bold">TESTES PRÉ-TRANSFUSIONAIS (PREENCHIMENTO EXCLUSIVO DA HEMOTERAPIA)</h5>

    <!-- Amostra Recebida -->
    <div class="row mb-3">
        <div class="col-md-6">
            <label>Amostra Recebida Por:</label>
            <input type="text" name="amostra_recebida_por" class="form-control" value="<?= set_value('amostra_recebida_por') ?>">
        </div>
        <div class="col-md-3">
            <label>Data:</label>
            <input type="date" name="data_amostra" class="form-control" value="<?= set_value('data_amostra') ?>">
        </div>
        <div class="col-md-3">
            <label>Hora:</label>
            <input type="time" name="hora_amostra" class="form-control" value="<?= set_value('hora_amostra') ?>">
        </div>
    </div>

    <!-- ABO/Rh -->
    <div class="mb-3">
        <label class="form-label">ABO/Rh</label>
        <div class="row g-2">
            <?php foreach (['A', 'B', 'AB', 'D', 'C', 'RA1', 'RB'] as $tipo): ?>
                <div class="col">
                    <input type="checkbox" class="form-check-input" name="abo_rh[]" value="<?= $tipo ?>"> <?= $tipo ?>
                </div>
            <?php endforeach; ?>
            <div class="col">
                <input type="text" name="responsavel" class="form-control" placeholder="Responsável" value="<?= set_value('responsavel') ?>">
            </div>
        </div>
    </div>

    <!-- PAI e Fenótipos -->
    <div class="mb-3">
        <div class="row">
            <?php foreach (['pai_i', 'pai_ii', 'dia', 'cd', 'ac'] as $campo): ?>
                <div class="col">
                    <input type="text" class="form-control" name="<?= $campo ?>" placeholder="<?= strtoupper(str_replace('_', ' ', $campo)) ?>" value="<?= set_value($campo) ?>">
                </div>
            <?php endforeach; ?>
        </div>
        <label class="form-label mt-2">FENÓTIPO:</label>
        <div class="row g-2">
            <?php foreach (['C', 'Cw', 'c', 'E', 'e', 'K', 'Jka', 'Jkb'] as $fenotipo): ?>
                <div class="col">
                    <input type="checkbox" class="form-check-input" name="fenotipo[]" value="<?= $fenotipo ?>"> <?= $fenotipo ?>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Anticorpos -->
    <div class="mb-3">
        <label class="form-label">Anticorpos Identificados:</label>
        <textarea class="form-control" name="anticorpos" rows="2"><?= set_value('anticorpos') ?></textarea>
    </div>

    <!-- Expedição de Hemocomponentes -->
    <div class="mb-3">
        <label class="form-label">Expedição de Hemocomponentes</label>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Data</th>
                        <th>Tipo</th>
                        <th>Número</th>
                        <th>ABO/Rh</th>
                        <th>VOL.</th>
                        <th>Origem</th>
                        <th>PC</th>
                        <th>TH</th>
                        <th>IV</th>
                        <th>Resp</th>
                        <th>Filtro</th>
                        <th>Fenot</th>
                        <th>Irrad</th>
                        <th>Lavada</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < 7; $i++): ?>
                    <tr>
                        <td><input type="date" name="data_expedicao[]" class="form-control form-control-sm" value="<?= set_value('data_expedicao['.$i.']') ?>"></td>
                        <td><input type="text" name="tipo[]" class="form-control form-control-sm" value="<?= set_value('tipo['.$i.']') ?>"></td>
                        <td><input type="text" name="numero[]" class="form-control form-control-sm" value="<?= set_value('numero['.$i.']') ?>"></td>
                        <td><input type="text" name="abo_rh_expedicao[]" class="form-control form-control-sm" value="<?= set_value('abo_rh_expedicao['.$i.']') ?>"></td>
                        <td><input type="text" name="volume[]" class="form-control form-control-sm" value="<?= set_value('volume['.$i.']') ?>" placeholder="ml"></td>
                        <td>
                            <select name="origem[]" class="form-select form-select-sm">
                                <option value="1">1</option>
                                <option value="2">2</option>
                            </select>
                        </td>
                        <td>
                            <div class="form-check">
                                <input type="radio" name="pc_<?= $i ?>" value="C" class="form-check-input"> C<br>
                                <input type="radio" name="pc_<?= $i ?>" value="I" class="form-check-input"> I
                            </div>
                        </td>
                        <td><input type="checkbox" name="th_<?= $i ?>" class="form-check-input"></td>
                        <td><input type="checkbox" name="iv_<?= $i ?>" class="form-check-input"></td>
                        <td><input type="text" name="responsavel_expedicao[]" class="form-control form-control-sm" value="<?= set_value('responsavel_expedicao['.$i.']') ?>"></td>
                        <td><input type="checkbox" name="filtro_<?= $i ?>" class="form-check-input"></td>
                        <td><input type="checkbox" name="fenot_<?= $i ?>" class="form-check-input"></td>
                        <td><input type="checkbox" name="irrad_<?= $i ?>" class="form-check-input"></td>
                        <td><input type="checkbox" name="lavada_<?= $i ?>" class="form-check-input"></td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Observações -->
    <div class="mb-3">
        <label class="form-label">Observações:</label>
        <textarea class="form-control" name="observacoes" rows="3"><?= set_value('observacoes') ?></textarea>
    </div>

    <div class="small text-muted">
        <strong>LEGENDAS:</strong> ORIGEM 1 = HUAP, 2 = IEHE ou SIGLA correspondente / PC = prova cruzada, C = compatível, I = Incompatível / TH = Teste de Hemólise / IV = Inspeção visual
    </div>
</div>
<?php echo form_close(); ?>
