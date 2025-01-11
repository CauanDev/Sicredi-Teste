
/**
 * Função para exibir mensagens de alerta do Bootstrap.
 * @param {string} message - A mensagem que será exibida no alerta.
 * @param {string} type - O tipo do alerta (success, danger, warning, info).
 * @param {string} [containerId="alertContainer"] - O ID do contêiner onde o alerta será exibido.
 */
function showAlert(message, type, containerId = "alertContainer") {
    const alertHTML = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <strong>${type === 'success' ? 'Sucesso!' : 'Erro!'}</strong> ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    const container = document.getElementById(containerId);
    if (container) {
        container.innerHTML = alertHTML;
    } else {
        console.error(`Contêiner com ID "${containerId}" não encontrado.`);
    }
}

function showSpinner(){
    const spinnerHTML = `
    <div class="position-fixed top-50 start-50 translate-middle" style="z-index: 1050; width: 3rem; height: 3rem;">
        <div class="spinner-grow text-success" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>`;

    const container = document.getElementById('spinnerContainer');
    if (container) {
        container.innerHTML = spinnerHTML;
    } 
}

// Registrar globalmente
window.showAlert = showAlert;
window.showSpinner = showSpinner;
