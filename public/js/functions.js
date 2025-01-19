
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

function showSpinner(show = true) {
    const container = document.getElementById('spinnerContainer');
    if (container) {
        if (show) {
            container.style.display = 'flex';  
        } else {
            container.style.display = 'none'; 
        }
    }
}


window.showAlert = showAlert;
window.showSpinner = showSpinner;
