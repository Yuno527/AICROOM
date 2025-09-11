document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form');
    const submitBtn = document.querySelector('.submit-btn');
    
    if (!contactForm || !submitBtn) {
        console.error('Formulario o botón no encontrado');
        return;
    }
    
    // Función para mostrar mensajes
    function showMessage(message, isError = false) {
        // Limpiar mensajes anteriores
        const existingMessages = document.querySelectorAll('.message-display');
        existingMessages.forEach(msg => msg.remove());
        
        const messageDiv = document.createElement('div');
        messageDiv.className = 'message-display';
        messageDiv.style.padding = '1rem';
        messageDiv.style.borderRadius = '8px';
        messageDiv.style.marginBottom = '1rem';
        messageDiv.style.fontWeight = 'bold';
        
        if (isError) {
            messageDiv.style.backgroundColor = '#f8d7da';
            messageDiv.style.color = '#721c24';
            messageDiv.style.border = '1px solid #f5c6cb';
            messageDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + message;
        } else {
            messageDiv.style.backgroundColor = '#d4edda';
            messageDiv.style.color = '#155724';
            messageDiv.style.border = '1px solid #c3e6cb';
            messageDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + message;
        }
        
        contactForm.insertBefore(messageDiv, contactForm.firstChild);
        
        setTimeout(() => {
            messageDiv.remove();
        }, 5000);
    }
    
    // Manejo del formulario
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Obtener datos del formulario
        const formData = new FormData(contactForm);
        
        // Validación básica
        const name = formData.get('name') || '';
        const email = formData.get('email') || '';
        const message = formData.get('message') || '';
        
        if (name.length < 2) {
            showMessage('El nombre debe tener al menos 2 caracteres', true);
            return;
        }
        
        if (!email.includes('@') || email.length < 5) {
            showMessage('El correo electrónico no es válido', true);
            return;
        }
        
        if (message.length < 10) {
            showMessage('El mensaje debe tener al menos 10 caracteres', true);
            return;
        }
        
        // Cambiar estado del botón
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        
        // Enviar datos
        fetch('contact_working.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage(data.message, false);
                contactForm.reset();
            } else {
                if (Array.isArray(data.data)) {
                    showMessage(data.data[0], true);
                } else {
                    showMessage(data.message, true);
                }
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showMessage('Error de conexión. Por favor, inténtalo de nuevo.', true);
        })
        .finally(() => {
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
});
