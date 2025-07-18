<div class="card-body has-validation">

    <form action="/gerar-pdf" method="post">
        <input name="nome" placeholder="Nome do paciente">
        <input name="data_nascimento" placeholder="Data de nascimento">
        <input name="sexo" value="F">
        <input name="peso" placeholder="Peso">
        <!-- Outros campos do form_requisicao_frente e verso -->
        <button type="submit">Gerar PDF</button>
    </form>

</div>

