/**
 * CustomModals - Anpassade modaler för att ersätta standard alert/confirm/prompt
 */
class CustomModals {
    // Toast-färger
    static TOAST_COLORS = {
        success: '#28a745',
        error: '#dc3545',
        warning: '#ffc107',
        info: '#17a2b8'
    };

    /**
     * Visa en success-toast
     * @param {string} message - Meddelandet att visa
     * @param {function} callback - Funktion att köra efter att toasten visats
     */
    static showSuccess(message, callback = null) {
        this._showToast(message, 'success', callback);
    }

    /**
     * Visa en error-toast
     * @param {string} message - Meddelandet att visa
     * @param {function} callback - Funktion att köra efter att toasten visats
     */
    static showError(message, callback = null) {
        this._showToast(message, 'error', callback);
    }

    /**
     * Visa en warning-toast
     * @param {string} message - Meddelandet att visa
     * @param {function} callback - Funktion att köra efter att toasten visats
     */
    static showWarning(message, callback = null) {
        this._showToast(message, 'warning', callback);
    }

    /**
     * Visa en info-toast
     * @param {string} message - Meddelandet att visa
     * @param {function} callback - Funktion att köra efter att toasten visats
     */
    static showInfo(message, callback = null) {
        this._showToast(message, 'info', callback);
    }

    /**
     * Visa en confirm-dialog
     * @param {string} message - Meddelandet att visa
     * @param {function} onConfirm - Funktion att köra vid bekräftelse
     * @param {function} onCancel - Funktion att köra vid avbrytande
     * @param {string} confirmText - Text på bekräfta-knappen
     * @param {string} cancelText - Text på avbryt-knappen
     */
    static confirm(message, onConfirm, onCancel = null, confirmText = 'Bekräfta', cancelText = 'Avbryt') {
        const modalId = `confirmModal-${Date.now()}`;
        
        // Skapa modal-element
        const modalElement = document.createElement('div');
        modalElement.id = modalId;
        modalElement.className = 'modal fade';
        modalElement.setAttribute('tabindex', '-1');
        modalElement.setAttribute('aria-hidden', 'true');
        
        modalElement.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">Bekräfta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">${cancelText}</button>
                        <button type="button" class="btn btn-primary confirm-btn">${confirmText}</button>
                    </div>
                </div>
            </div>
        `;
        
        // Lägg till i DOM
        document.body.appendChild(modalElement);
        
        // Skapa Bootstrap Modal objekt
        const modal = new bootstrap.Modal(modalElement);
        
        // Lägg till event-lyssnare
        const confirmBtn = modalElement.querySelector('.confirm-btn');
        const cancelBtn = modalElement.querySelector('.cancel-btn');
        
        confirmBtn.addEventListener('click', () => {
            modal.hide();
            if (typeof onConfirm === 'function') {
                onConfirm();
            }
        });
        
        cancelBtn.addEventListener('click', () => {
            if (typeof onCancel === 'function') {
                onCancel();
            }
        });
        
        // Ta bort modal från DOM när den stängs
        modalElement.addEventListener('hidden.bs.modal', () => {
            document.body.removeChild(modalElement);
        });
        
        // Visa modal
        modal.show();
    }

    /**
     * Visa en prompt-dialog
     * @param {string} message - Meddelandet att visa
     * @param {function} onSubmit - Funktion att köra vid bekräftelse med inmatat värde
     * @param {function} onCancel - Funktion att köra vid avbrytande
     * @param {string} defaultValue - Standardvärde för input-fältet
     */
    static prompt(message, onSubmit, onCancel = null, defaultValue = '') {
        const modalId = `promptModal-${Date.now()}`;
        
        // Skapa modal-element
        const modalElement = document.createElement('div');
        modalElement.id = modalId;
        modalElement.className = 'modal fade';
        modalElement.setAttribute('tabindex', '-1');
        modalElement.setAttribute('aria-hidden', 'true');
        
        modalElement.innerHTML = `
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">Ange information</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p>${message}</p>
                        <input type="text" class="form-control prompt-input" value="${defaultValue}">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary cancel-btn" data-bs-dismiss="modal">Avbryt</button>
                        <button type="button" class="btn btn-primary submit-btn">OK</button>
                    </div>
                </div>
            </div>
        `;
        
        // Lägg till i DOM
        document.body.appendChild(modalElement);
        
        // Skapa Bootstrap Modal objekt
        const modal = new bootstrap.Modal(modalElement);
        
        // Lägg till event-lyssnare
        const submitBtn = modalElement.querySelector('.submit-btn');
        const cancelBtn = modalElement.querySelector('.cancel-btn');
        const inputField = modalElement.querySelector('.prompt-input');
        
        // Fokusera input-fältet när modalen visas
        modalElement.addEventListener('shown.bs.modal', () => {
            inputField.focus();
        });
        
        // Skicka vid Enter-tangenttryckning
        inputField.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                submitBtn.click();
            }
        });
        
        submitBtn.addEventListener('click', () => {
            modal.hide();
            if (typeof onSubmit === 'function') {
                onSubmit(inputField.value);
            }
        });
        
        cancelBtn.addEventListener('click', () => {
            if (typeof onCancel === 'function') {
                onCancel();
            }
        });
        
        // Ta bort modal från DOM när den stängs
        modalElement.addEventListener('hidden.bs.modal', () => {
            document.body.removeChild(modalElement);
        });
        
        // Visa modal
        modal.show();
    }

    /**
     * Privat metod för att visa toast-meddelanden
     * @param {string} message - Meddelandet att visa
     * @param {string} type - Typ av toast (success, error, warning, info)
     * @param {function} callback - Funktion att köra efter att toasten visats
     * @private
     */
    static _showToast(message, type, callback = null) {
        const toastId = `toast-${Date.now()}`;
        const iconClass = {
            'success': 'lni lni-checkmark-circle',
            'error': 'lni lni-cross-circle',
            'warning': 'lni lni-warning',
            'info': 'lni lni-information'
        };
        
        // Skapa toast container om den inte finns
        let toastContainer = document.querySelector('.toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.className = 'toast-container position-fixed top-0 end-0 p-3';
            document.body.appendChild(toastContainer);
        }
        
        // Skapa toast-element
        const toastElement = document.createElement('div');
        toastElement.id = toastId;
        toastElement.className = 'toast';
        toastElement.setAttribute('role', 'alert');
        toastElement.setAttribute('aria-live', 'assertive');
        toastElement.setAttribute('aria-atomic', 'true');
        
        toastElement.innerHTML = `
            <div class="toast-header" style="background-color: ${this.TOAST_COLORS[type]}; color: white;">
                <i class="${iconClass[type]} me-2"></i>
                <strong class="me-auto">${type.charAt(0).toUpperCase() + type.slice(1)}</strong>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                ${message}
            </div>
        `;
        
        // Lägg till i container
        toastContainer.appendChild(toastElement);
        
        // Skapa Bootstrap Toast objekt
        const toast = new bootstrap.Toast(toastElement, {
            autohide: true,
            delay: 3000
        });
        
        // Kör callback när toasten gömts
        toastElement.addEventListener('hidden.bs.toast', () => {
            toastContainer.removeChild(toastElement);
            if (typeof callback === 'function') {
                callback();
            }
        });
        
        // Visa toast
        toast.show();
    }
} 