document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.querySelector('.contact-form');
    const submitBtn = document.querySelector('.submit-btn');
    
    if (!contactForm) {
        console.error('Formulario de contacto no encontrado');
        return;
    }
    
    if (!submitBtn) {
        console.error('Botón de envío no encontrado');
        return;
    }
    
    // Función para mostrar mensajes de error
    function showError(message) {
        const errorDiv = document.createElement('div');
        errorDiv.className = 'error-message';
        errorDiv.style.backgroundColor = '#f8d7da';
        errorDiv.style.color = '#721c24';
        errorDiv.style.padding = '1rem';
        errorDiv.style.borderRadius = '8px';
        errorDiv.style.marginBottom = '1rem';
        errorDiv.style.border = '1px solid #f5c6cb';
        errorDiv.innerHTML = '<i class="fas fa-exclamation-triangle"></i> ' + message;
        
        const form = document.querySelector('.contact-form');
        form.insertBefore(errorDiv, form.firstChild);
        
        setTimeout(() => {
            errorDiv.remove();
        }, 5000);
    }
    
    // Función para mostrar mensajes de éxito
    function showSuccess(message) {
        const successDiv = document.createElement('div');
        successDiv.className = 'success-message';
        successDiv.style.backgroundColor = '#d4edda';
        successDiv.style.color = '#155724';
        successDiv.style.padding = '1rem';
        successDiv.style.borderRadius = '8px';
        successDiv.style.marginBottom = '1rem';
        successDiv.style.border = '1px solid #c3e6cb';
        successDiv.innerHTML = '<i class="fas fa-check-circle"></i> ' + message;
        
        const form = document.querySelector('.contact-form');
        form.insertBefore(successDiv, form.firstChild);
        
        setTimeout(() => {
            successDiv.remove();
        }, 5000);
    }
    
    // Función para validar email
    function isValidEmail(email) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }
    
    // Función para limpiar mensajes anteriores
    function clearMessages() {
        const existingMessages = document.querySelectorAll('.error-message, .success-message');
        existingMessages.forEach(msg => msg.remove());
    }
    
    // Manejo del envío del formulario
    contactForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Limpiar mensajes anteriores
        clearMessages();
        
        // Obtener datos del formulario
        const formData = new FormData(contactForm);
        const name = formData.get('name') ? formData.get('name').trim() : '';
        const email = formData.get('email') ? formData.get('email').trim() : '';
        const company = formData.get('company') ? formData.get('company').trim() : '';
        const message = formData.get('message') ? formData.get('message').trim() : '';
        
        // Debug: Log de datos obtenidos
        console.log('Datos del formulario:', {
            name: name,
            email: email,
            company: company,
            message: message
        });
        
        // Validaciones del lado del cliente
        let isValid = true;
        
        if (!name || name.length < 2) {
            showError('El nombre es requerido y debe tener al menos 2 caracteres');
            isValid = false;
        }
        
        if (!email || !isValidEmail(email)) {
            showError('El correo electrónico es requerido y debe ser válido');
            isValid = false;
        }
        
        if (!message || message.length < 10) {
            showError('El mensaje es requerido y debe tener al menos 10 caracteres');
            isValid = false;
        }
        
        if (!isValid) {
            return;
        }
        
        // Cambiar estado del botón
        const originalText = submitBtn.innerHTML;
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Enviando...';
        
        // Enviar datos al servidor
        fetch('contact_simple.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showSuccess(data.message);
                contactForm.reset();
                
                // Opcional: Redirigir después de un tiempo
                setTimeout(() => {
                    // Puedes agregar redirección aquí si lo deseas
                    // window.location.href = 'index.html';
                }, 3000);
            } else {
                if (Array.isArray(data.data)) {
                    // Mostrar el primer error
                    showError(data.data[0]);
                } else {
                    showError(data.message);
                }
            }
        })
        .catch(error => {
            console.error('Error en el envío:', error);
            showError('Error de conexión. Por favor, inténtalo de nuevo o contáctanos directamente.');
        })
        .finally(() => {
            // Restaurar botón
            submitBtn.innerHTML = originalText;
            submitBtn.disabled = false;
        });
    });
    
    // Validación en tiempo real para el email
    const emailInput = document.getElementById('email');
    if (emailInput) {
        emailInput.addEventListener('blur', function() {
            if (this.value && !isValidEmail(this.value)) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '';
            }
        });
    }
    
    // Validación en tiempo real para el nombre
    const nameInput = document.getElementById('name');
    if (nameInput) {
        nameInput.addEventListener('blur', function() {
            if (this.value && this.value.length < 2) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '';
            }
        });
    }
    
    // Validación en tiempo real para el mensaje
    const messageInput = document.getElementById('message');
    if (messageInput) {
        messageInput.addEventListener('blur', function() {
            if (this.value && this.value.length < 10) {
                this.style.borderColor = '#e74c3c';
            } else {
                this.style.borderColor = '';
            }
        });
    }
});
