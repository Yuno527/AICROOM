<?php
/**
 * Manejador simplificado del formulario de contacto
 * Envía emails a pemma9962@gmail.com
 */

// Configuración de email
$to_email = 'pemma9962@gmail.com';
$from_email = 'noreply@aicroom.com';
$subject_prefix = '[AICROOM] Nuevo mensaje de contacto';

// Función para generar respuesta JSON
function sendResponse($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Función para limpiar datos de entrada
function sanitizeInput($data) {
    if (is_null($data)) return '';
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Función para validar email
function isValidEmail($email) {
    return filter_var($email, FILTER_VALIDATE_EMAIL) !== false;
}

// Permitir solo peticiones POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Método no permitido');
}

// Debug: Log de datos recibidos
error_log("Contact form data received: " . print_r($_POST, true));

// Obtener datos del formulario de manera más robusta
$name = '';
$email = '';
$company = '';
$message = '';

// Intentar obtener datos de diferentes maneras
if (isset($_POST['name'])) {
    $name = sanitizeInput($_POST['name']);
}
if (isset($_POST['email'])) {
    $email = sanitizeInput($_POST['email']);
}
if (isset($_POST['company'])) {
    $company = sanitizeInput($_POST['company']);
}
if (isset($_POST['message'])) {
    $message = sanitizeInput($_POST['message']);
}

// Si no hay datos en POST, intentar con input raw
if (empty($name) && empty($email) && empty($message)) {
    $raw_data = file_get_contents('php://input');
    if (!empty($raw_data)) {
        parse_str($raw_data, $parsed_data);
        $name = isset($parsed_data['name']) ? sanitizeInput($parsed_data['name']) : '';
        $email = isset($parsed_data['email']) ? sanitizeInput($parsed_data['email']) : '';
        $company = isset($parsed_data['company']) ? sanitizeInput($parsed_data['company']) : '';
        $message = isset($parsed_data['message']) ? sanitizeInput($parsed_data['message']) : '';
    }
}

// Debug: Log de datos limpiados
error_log("Cleaned data - Name: '$name', Email: '$email', Company: '$company', Message: '$message'");

// Validaciones
$errors = [];

// Validar nombre
if (empty($name) || strlen($name) < 2) {
    $errors[] = 'El nombre es requerido y debe tener al menos 2 caracteres';
}

// Validar email
if (empty($email) || !isValidEmail($email)) {
    $errors[] = 'El correo electrónico es requerido y debe ser válido';
}

// Validar mensaje
if (empty($message) || strlen($message) < 10) {
    $errors[] = 'El mensaje es requerido y debe tener al menos 10 caracteres';
}

// Debug: Log de errores
if (!empty($errors)) {
    error_log("Validation errors: " . print_r($errors, true));
}

// Si hay errores, devolverlos
if (!empty($errors)) {
    sendResponse(false, 'Errores de validación', $errors);
}

try {
    // Preparar el contenido del email
    $subject = $subject_prefix . ' - ' . $name;
    
    // Crear el cuerpo del email en HTML
    $email_body = "
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset='UTF-8'>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
            .header { background-color: #2c3e50; color: white; padding: 20px; text-align: center; }
            .content { background-color: #f9f9f9; padding: 20px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #2c3e50; }
            .value { margin-top: 5px; }
            .message-box { background-color: white; padding: 15px; border-left: 4px solid #3498db; margin-top: 10px; }
            .footer { background-color: #34495e; color: white; padding: 15px; text-align: center; font-size: 12px; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Nuevo mensaje de contacto - AICROOM</h2>
            </div>
            
            <div class='content'>
                <div class='field'>
                    <div class='label'>Nombre:</div>
                    <div class='value'>" . htmlspecialchars($name) . "</div>
                </div>
                
                <div class='field'>
                    <div class='label'>Correo electrónico:</div>
                    <div class='value'>" . htmlspecialchars($email) . "</div>
                </div>";
    
    if (!empty($company)) {
        $email_body .= "
                <div class='field'>
                    <div class='label'>Empresa:</div>
                    <div class='value'>" . htmlspecialchars($company) . "</div>
                </div>";
    }
    
    $email_body .= "
                <div class='field'>
                    <div class='label'>Mensaje:</div>
                    <div class='message-box'>" . nl2br(htmlspecialchars($message)) . "</div>
                </div>
            </div>
            
            <div class='footer'>
                <p>Este mensaje fue enviado desde el formulario de contacto de AICROOM</p>
                <p>Fecha: " . date('d/m/Y H:i:s') . "</p>
            </div>
        </div>
    </body>
    </html>";
    
    // Configurar headers del email
    $headers = [
        'MIME-Version: 1.0',
        'Content-type: text/html; charset=UTF-8',
        'From: ' . $from_email,
        'Reply-To: ' . $email,
        'X-Mailer: PHP/' . phpversion()
    ];
    
    // Enviar el email
    $mail_sent = mail($to_email, $subject, $email_body, implode("\r\n", $headers));
    
    if ($mail_sent) {
        // Log del envío exitoso
        error_log("Email de contacto enviado exitosamente - De: $email, Para: $to_email");
        
        sendResponse(true, 'Mensaje enviado exitosamente. Te contactaremos pronto.', [
            'name' => $name,
            'email' => $email,
            'timestamp' => date('Y-m-d H:i:s')
        ]);
    } else {
        // Log del error
        error_log("Error al enviar email de contacto - De: $email, Para: $to_email");
        
        sendResponse(false, 'Error al enviar el mensaje. Por favor, inténtalo de nuevo o contáctanos directamente.');
    }
    
} catch (Exception $e) {
    // Log del error
    error_log("Error inesperado en contact_simple.php: " . $e->getMessage());
    
    sendResponse(false, 'Error inesperado. Por favor, inténtalo de nuevo.');
}
?>
