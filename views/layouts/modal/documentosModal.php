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
    $(document).ready(function() {
        // Evento de clique nos botões de visualização
        $('.view-document').on('click', function() {
            const documentId = $(this).data('id');
            
            $('#modalContent').html('Carregando...');
            $.ajax({
                url: '/documentos',
                method: 'POST',
                data: {
                    documentId
                },
                success: function(response) {
                    var data = JSON.parse(response);

                    if (data.sucess && data.dados) {
                        var tableHtml = '<table class="table table-hover text-center"><thead><tr><th>Nome</th><th>Email</th><th>Link de Assinatura</th></tr></thead><tbody>';

                        data.dados.forEach(function(signer) {
                            tableHtml += '<tr><td>' + signer.username + '</td><td>' + signer.useremail + '</td><td><button class="btn btn-sm btn-warning text-white" onclick="window.open(\'' + signer.signurl + '\', \'_blank\')"><i class="bi bi-eye-fill"></i></button></td></tr>';
                        });

                        tableHtml += '</tbody></table>';

                        $('#modalContent').html(tableHtml);

                        $('#documentModal .validarAssinatura').data('id', documentId);
                        $('#documentModal .verificarStatus').data('id', documentId);
                    } else {
                        $('#modalContent').html('Nenhum dado disponível.');
                    }
                },
                error: function() {
                    $('#modalContent').html('Erro ao carregar os detalhes do documento.');
                }
            });
        });

        // Validar Assinaturas
        $('.validarAssinatura').on('click', function() {
            $('#modalContentDocument').html('Carregando Validar...');
            const documentId = $(this).data('id');
            $.ajax({
                url: '/documentos/validarAssinatura',
                method: 'POST',
                data: {
                    documentId
                },
                success: function(response) {
                    $('#modalContentDocument').html('Assinatura validada com sucesso!');
                },
                error: function() {
                    $('#modalContentDocument').html('Erro ao validar assinatura.');
                }
            });
        });

        // Verificar Status
        $('.verificarStatus').on('click', function() {
            $('#modalContentDocument').html('Carregando Status...');
            const documentId = $(this).data('id');
            console.log(documentId);
            $.ajax({
                url: '/documentos/verificarStatus',
                method: 'POST',
                data: {
                    documentId
                },
                success: function(response) {
                    console.log(response);
                    $('#modalContentDocument').html('Status verificado com sucesso!');
                },
                error: function() {
                    $('#modalContentDocument').html('Erro ao verificar status.');
                }
            });
        });
    });
</script>
