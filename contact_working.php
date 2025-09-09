<?php
/**
 * Sistema de contacto funcional - Versión simplificada
 * Envía emails a pemma9962@gmail.com
 */

// Configuración
$to_email = 'pemma9962@gmail.com';
$from_email = 'noreply@aicroom.com';

// Función para respuesta JSON
function sendResponse($success, $message, $data = null) {
    header('Content-Type: application/json');
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

// Solo permitir POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    sendResponse(false, 'Método no permitido');
}

// Obtener datos directamente
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$company = $_POST['company'] ?? '';
$message = $_POST['message'] ?? '';

// Limpiar datos
$name = trim($name);
$email = trim($email);
$company = trim($company);
$message = trim($message);

// Log para debug
error_log("Datos recibidos - Nombre: '$name', Email: '$email', Empresa: '$company', Mensaje: '$message'");

// Validaciones simples
$errors = [];

if (strlen($name) < 2) {
    $errors[] = 'El nombre debe tener al menos 2 caracteres';
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'El correo electrónico no es válido';
}

if (strlen($message) < 10) {
    $errors[] = 'El mensaje debe tener al menos 10 caracteres';
}

// Si hay errores, devolverlos
if (!empty($errors)) {
    sendResponse(false, 'Errores de validación', $errors);
}

// Crear el email
$subject = '[AICROOM] Mensaje de contacto de ' . $name;

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

// Headers del email
$headers = [
    'MIME-Version: 1.0',
    'Content-type: text/html; charset=UTF-8',
    'From: ' . $from_email,
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . phpversion()
];

// Enviar email
$mail_sent = mail($to_email, $subject, $email_body, implode("\r\n", $headers));

if ($mail_sent) {
    error_log("Email enviado exitosamente - De: $email, Para: $to_email");
    sendResponse(true, 'Mensaje enviado exitosamente. Te contactaremos pronto.');
} else {
    error_log("Error al enviar email - De: $email, Para: $to_email");
    sendResponse(false, 'Error al enviar el mensaje. Por favor, inténtalo de nuevo.');
}
?>
