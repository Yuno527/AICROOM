<?php
// Evitar que se muestren errores PHP en la salida
error_reporting(0);
ini_set('display_errors', 0);

session_start();
require_once 'config.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Usuario no autenticado']);
    exit;
}

// Verificar si el usuario ya completó el test (doble verificación)
try {
    $pdo = getConnection();
    $stmt = $pdo->prepare("
        SELECT h.Id_historial 
        FROM tbl_historial h 
        WHERE h.Id_UsuarioFK = ? AND h.estado = 'Completado'
        LIMIT 1
    ");
    
    $stmt->execute([$_SESSION['user_id']]);
    $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {
        echo json_encode(['success' => false, 'message' => 'Ya has completado la evaluación anteriormente']);
        exit;
    }
} catch(PDOException $e) {
    echo json_encode(['success' => false, 'message' => 'Error verificando estado del usuario']);
    exit;
}

// Obtener datos del POST
$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
    exit;
}

// OPCIÓN DE DESARROLLO: resetear historial del usuario si se recibe 'resetUser' en el POST
if (isset($input['resetUser']) && $input['resetUser'] === true) {
    // Borrar resultados y respuestas del usuario actual
    $userId = $_SESSION['user_id'];
    $pdo = getConnection();
    // Obtener todos los historiales del usuario
    $stmt = $pdo->prepare("SELECT Id_historial FROM tbl_historial WHERE Id_UsuarioFK = ?");
    $stmt->execute([$userId]);
    $historiales = $stmt->fetchAll(PDO::FETCH_COLUMN);
    if ($historiales) {
        // Borrar resultados
        $in = str_repeat('?,', count($historiales) - 1) . '?';
        $pdo->prepare("DELETE FROM tbl_resultados WHERE Id_historiaLFK IN ($in)")->execute($historiales);
        // Borrar respuestas
        $pdo->prepare("DELETE FROM tbl_respuestas WHERE Id_historial IN ($in)")->execute($historiales);
        // Borrar historiales
        $pdo->prepare("DELETE FROM tbl_historial WHERE Id_historial IN ($in)")->execute($historiales);
    }
    echo json_encode(['success' => true, 'message' => 'Historial del usuario reseteado para pruebas']);
    exit;
}

$userId = $_SESSION['user_id'];
$answers = $input['answers'];
$totalScore = $input['totalScore'];
$resultFinal = $input['resultFinal'];

try {
    $pdo = getConnection();
    
    // Iniciar transacción
    $pdo->beginTransaction();
    
    // 1. Crear registro en historial
    $stmt = $pdo->prepare("
        INSERT INTO tbl_historial (Id_UsuarioFK, fecha, estado) 
        VALUES (?, CURDATE(), 'Completado')
    ");
    $stmt->execute([$userId]);
    $historialId = $pdo->lastInsertId();
    
    // 2. Guardar cada respuesta
    $stmt = $pdo->prepare("
        INSERT INTO tbl_respuestas (Id_historial, pregunta, respuesta, puntaje) 
        VALUES (?, ?, ?, ?)
    ");
    
    foreach ($answers as $answer) {
        $stmt->execute([
            $historialId,
            $answer['question'],
            $answer['answer'],
            $answer['score']
        ]);
    }
    
    // 3. Guardar resultado final
    $stmt = $pdo->prepare("
        INSERT INTO tbl_resultados (Id_historiaLFK, puntaje_total, resultado_final, fecha_registro) 
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->execute([$historialId, $totalScore, $resultFinal]);
    
    // Confirmar transacción
    $pdo->commit();
    
    echo json_encode(['success' => true, 'message' => 'Resultados guardados exitosamente']);
    
} catch(PDOException $e) {
    // Revertir transacción en caso de error
    if ($pdo->inTransaction()) {
        $pdo->rollback();
    }
    echo json_encode(['success' => false, 'message' => 'Error guardando resultados: ' . $e->getMessage()]);
}
?> 