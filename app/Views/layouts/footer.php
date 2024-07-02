<style>
html, body {
    height: 100%; /* Ajuste a altura para garantir que o contêiner pai cubra toda a altura da janela */
    margin: 0;
    padding: 0;
}

.wrapper {
    display: flex;
    flex-direction: column;
    min-height: 100vh; /* Altura mínima de 100% da altura da viewport */
}

.content {
    flex: 1; /* Permite que o conteúdo expanda para ocupar o espaço disponível */
}

.footer {
    background-color: #f8f9fa; /* Ajuste conforme necessário */
    color: #6c757d; /* Ajuste conforme necessário */
    text-align: center;
    padding: 10px 0;
}


</style>
<footer class="footer">
    <div class="container text-center">
        <hr />
        <p>&copy; <?= date('Y'); ?> Seu Nome ou da Empresa. Todos os direitos reservados.</p>
    </div>
</footer>
