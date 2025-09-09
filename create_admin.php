<?php
require_once 'config.php';

// Script para crear un usuario administrador
// IMPORTANTE: Ejecutar este script una sola vez y luego eliminarlo por seguridad

try {
    $pdo = getConnection();
    
    // Verificar si ya existe un administrador
    $stmt = $pdo->prepare("SELECT Id_Usuario FROM tbl_usuario WHERE rol = 'admin'");
    $stmt->execute();
    
    if ($stmt->fetch()) {
        echo "Ya existe un usuario administrador en la base de datos.<br>";
        echo "Si necesitas crear otro administrador, modifica este script.<br>";
        exit;
    }
    
    // Datos del administrador
    $adminData = [
        'nombre' => 'Breiner',
        'contraseña' => 'breiner2025', // Contraseña segura para Breiner
        'correo' => 'breiner@aicroom.com',
        'direccion' => 'Oficina Principal AICROOM',
        'edad' => 28,
        'rol' => 'admin',
        'fecha_registro' => date('Y-m-d')
    ];
    
    // Insertar administrador
    $stmt = $pdo->prepare("
        INSERT INTO tbl_usuario (nombre, contraseña, correo, direccion, edad, rol, fecha_registro) 
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");
    
    $result = $stmt->execute([
        $adminData['nombre'],
        $adminData['contraseña'],
        $adminData['correo'],
        $adminData['direccion'],
        $adminData['edad'],
        $adminData['rol'],
        $adminData['fecha_registro']
    ]);
    
    if ($result) {
        $adminId = $pdo->lastInsertId();
        echo "<h2>✅ Usuario Administrador Creado Exitosamente</h2>";
        echo "<p><strong>ID:</strong> $adminId</p>";
        echo "<p><strong>Nombre:</strong> {$adminData['nombre']}</p>";
        echo "<p><strong>Email:</strong> {$adminData['correo']}</p>";
        echo "<p><strong>Contraseña:</strong> {$adminData['contraseña']}</p>";
        echo "<p><strong>Rol:</strong> {$adminData['rol']}</p>";
        echo "<br>";
        echo "<p><strong>⚠️ IMPORTANTE:</strong></p>";
        echo "<ul>";
        echo "<li>Guarda estas credenciales en un lugar seguro</li>";
        echo "<li>Cambia la contraseña después del primer login</li>";
        echo "<li>Elimina este archivo (create_admin.php) por seguridad</li>";
        echo "</ul>";
        echo "<br>";
        echo "<p><a href='login.html'>Ir al Login</a></p>";
    } else {
        echo "<h2>❌ Error al crear el administrador</h2>";
        echo "<p>Verifica la conexión a la base de datos y los permisos.</p>";
    }
    
} catch (Exception $e) {
    echo "<h2>❌ Error</h2>";
    echo "<p>Error: " . $e->getMessage() . "</p>";
    echo "<p>Verifica que:</p>";
    echo "<ul>";
    echo "<li>La base de datos esté creada</li>";
    echo "<li>Las tablas existan (ejecuta aicroom.sql)</li>";
    echo "<li>Las credenciales en config.php sean correctas</li>";
    echo "</ul>";
}
?> 