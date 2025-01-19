<div class="modal fade" id="documentModal" tabindex="-1" aria-labelledby="modalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Detalhes do Documento</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="modalContent">
                    Carregando...
                </div>

                <div class="text-center">
                    <button type="button" class="btn btn-primary validarAssinatura">Validar Assinaturas</button>
                    <button type="button" class="btn btn-success verificarStatus">Verificar Status</button>
                </div>

                <div id="modalContentDocument">
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('.view-document').on('click', function () {
            const documentId = $(this).data('id');

            $('#modalContent').html('Carregando...');
            $.ajax({
                url: '/documentos',
                method: 'POST',
                data: { documentId },
                success: function (response) {
                    const data = JSON.parse(response);

                    if (data.sucess && data.dados) {
                        let tableHtml = '<table class="table table-hover text-center"><thead><tr><th>Nome</th><th>Email</th><th>Link de Assinatura</th></tr></thead><tbody>';

                        data.dados.forEach(function (signer) {
                            tableHtml += `
                                <tr>
                                    <td>${signer.username}</td>
                                    <td>${signer.useremail}</td>
                                    <td>
                                        <button class="btn btn-sm btn-warning text-white" onclick="window.open('${signer.signurl}', '_blank')">
                                            <i class="bi bi-eye-fill"></i>
                                        </button>
                                    </td>
                                </tr>`;
                        });

                        tableHtml += '</tbody></table>';
                        $('#modalContent').html(tableHtml);
                        $('#documentModal .validarAssinatura').data('id', documentId);
                        $('#documentModal .verificarStatus').data('id', documentId);
                    } else {
                        $('#modalContent').html('Nenhum dado disponível.');
                    }
                },
                error: function () {
                    $('#modalContent').html('Erro ao carregar os detalhes do documento.');
                },
            });
        });

        // Validar Assinaturas
        $('.validarAssinatura').on('click', function () {
            $('#modalContentDocument').html('Carregando Validar...');
            const documentId = $(this).data('id');
            $.ajax({
                url: '/documentos/verificarAssinatura',
                method: 'POST',
                data: { documentId },
                dataType: 'json',
                success: function (response) {
                    const documentData = JSON.parse(response.dados);
                    const tableHtml = `
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>Campo</th>
                                    <th>Valor</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Nome do Documento</td><td>${documentData.documentName || 'N/A'}</td></tr>
                                <tr><td>Chave</td><td>${documentData.key || 'N/A'}</td></tr>
                                <tr><td>Data de Criação</td><td>${documentData.creationDate || 'N/A'}</td></tr>
                                <tr><td>Hash do Documento</td><td>${documentData.documentHash || 'N/A'}</td></tr>
                                <tr><td>É Válido?</td><td>${documentData.isValid ? 'Sim' : 'Não'}</td></tr>
                                <tr><td>Versão Original Disponível</td><td>${documentData.hasOriginalVersion ? 'Sim' : 'Não'}</td></tr>
                                <tr><td>Pode Baixar o Protocolo</td><td>${documentData.canDownloadProtocol ? 'Sim' : 'Não'}</td></tr>
                                <tr><td>Padrão de Assinatura</td><td>${documentData.patternSignature || 'N/A'}</td></tr>
                            </tbody>
                        </table>`;
                    $('#modalContentDocument').html(tableHtml);
                },
                error: function () {
                    $('#modalContentDocument').html('Erro ao validar assinatura.');
                },
            });
        });

        // Verificar Status
        $('.verificarStatus').on('click', function () {
            $('#modalContentDocument').html('Carregando Status...');
            const documentId = $(this).data('id');
            $.ajax({
                url: '/documentos/verificarStatus',
                method: 'POST',
                data: { documentId },
                dataType: 'json',
                success: function (response) {
                    const documentData = JSON.parse(response.dados);
                    let tableHtml = '<table class="table table-bordered"><thead><tr><th>Campo</th><th>Valor</th></tr></thead><tbody>';

                    tableHtml += `<tr><td>ID</td><td>${documentData.id}</td></tr>`;
                    tableHtml += `<tr><td>Nome</td><td>${documentData.name}</td></tr>`;
                    tableHtml += `<tr><td>Criador</td><td>${documentData.creator}</td></tr>`;
                    tableHtml += `<tr><td>Empresa</td><td>${documentData.company}</td></tr>`;
                    tableHtml += `<tr><td>Tipo de Documento</td><td>${documentData.documentType}</td></tr>`;
                    tableHtml += `<tr><td>Data da Versão Atual</td><td>${documentData.currentVersion.date}</td></tr>`;
                    tableHtml += `<tr><td>Nome da Versão Atual</td><td>${documentData.currentVersion.name}</td></tr>`;
                    tableHtml += `<tr><td>Assinaturas Pendentes</td><td>${documentData.pendingElectronicSignatures ? 'Sim' : 'Não'}</td></tr>`;
                    tableHtml += `<tr><td>Concluído</td><td>${documentData.completed ? 'Sim' : 'Não'}</td></tr>`;
                    tableHtml += `<tr><td>Bloqueado</td><td>${documentData.blocked ? 'Sim' : 'Não'}</td></tr>`;
                    tableHtml += '</tbody></table>';

                    $('#modalContentDocument').html(tableHtml);
                },
                error: function () {
                    $('#modalContentDocument').html('Erro ao verificar status.');
                },
            });
        });
    });
</script>
