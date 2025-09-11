<?php
require_once 'config.php';

echo "<h2>Verificación de Base de Datos - Aicroom</h2>";

echo "<h3>1. Configuración actual:</h3>";
echo "<ul>";
echo "<li><strong>Host:</strong> " . DB_HOST . "</li>";
echo "<li><strong>Base de datos:</strong> " . DB_NAME . "</li>";
echo "<li><strong>Usuario:</strong> " . DB_USER . "</li>";
echo "<li><strong>Contraseña:</strong> " . (empty(DB_PASS) ? 'Vacía' : 'Configurada') . "</li>";
echo "</ul>";

echo "<h3>2. Prueba de conexión:</h3>";
try {
    $pdo = getConnection();
    echo "<p style='color: green;'> Conexión exitosa a la base de datos</p>";
    
    // Verificar tabla
    if (tableExists($pdo, 'tbl_usuario')) {
        echo "<p style='color: green;'> La tabla tbl_usuario existe</p>";
        
        // Verificar columnas
        $stmt = $pdo->query("DESCRIBE tbl_usuario");
        $columns = $stmt->fetchAll();
        echo "<p>📋 Columnas encontradas: " . count($columns) . "</p>";
        
        echo "<ul>";
        foreach ($columns as $column) {
            echo "<li><strong>" . $column['Field'] . "</strong> - " . $column['Type'] . "</li>";
        }
        echo "</ul>";
        
        // Contar usuarios
        $stmt = $pdo->query("SELECT COUNT(*) as total FROM tbl_usuario");
        $count = $stmt->fetch();
        echo "<p>👥 Usuarios registrados: " . $count['total'] . "</p>";
        
    } else {
        echo "<p style='color: red;'> La tabla tbl_usuario NO existe</p>";
        echo "<p>Importa el archivo aicroom.sql para crear la tabla</p>";
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'> Error de conexión: " . $e->getMessage() . "</p>";
    echo "<p>Verifica:</p>";
    echo "<ul>";
    echo "<li>Que MySQL esté ejecutándose</li>";
    echo "<li>Las credenciales en config.php</li>";
    echo "<li>Que la base de datos 'aicroom' exista</li>";
    echo "</ul>";
}

echo "<h3>3. Prueba de registro:</h3>";
echo "<p>Para probar el registro, ve a <a href='register.html'>register.html</a></p>";

echo "<h3>4. Prueba de login:</h3>";
echo "<p>Para probar el login, ve a <a href='login.html'>login.html</a></p>";

echo "<hr>";
echo "<p><small>Archivo de verificación generado el " . date('Y-m-d H:i:s') . "</small></p>";
?> 