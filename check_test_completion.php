<?php
// Evitar que se muestren errores PHP en la salida
error_reporting(0);
ini_set('display_errors', 0);

session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['completed' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

$userId = $_SESSION['user_id'];

try {
    $pdo = getConnection();
    
    // Verificar si el usuario ya tiene un historial completado
    $stmt = $pdo->prepare("
        SELECT h.Id_historial 
        FROM tbl_historial h 
        WHERE h.Id_UsuarioFK = ? AND h.estado = 'Completado'
        LIMIT 1
    ");
    
    $stmt->execute([$userId]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo json_encode(['completed' => true]);
    } else {
        echo json_encode(['completed' => false]);
    }
    
} catch(PDOException $e) {
    echo json_encode(['completed' => false, 'error' => 'Error de base de datos']);
}
?> 