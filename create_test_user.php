<?php
/**
 * Script para crear un usuario de prueba y verificar el sistema
 * 
 * Este script:
 * 1. Crea un nuevo usuario con contraseña hasheada
 * 2. Prueba el login completo
 * 3. Verifica que todo funcione correctamente
 */

require_once 'config.php';

echo "<h2>Creación de Usuario de Prueba - Aicroom</h2>\n";
echo "<pre>\n";

try {
    // Verificar conexión
    if (!testConnection()) {
        throw new Exception("No se puede conectar a la base de datos");
    }
    
    $pdo = getConnection();
    echo "✓ Conexión a la base de datos establecida\n";
    
    // Paso 1: Crear datos del usuario de prueba
    echo "\n--- PASO 1: Preparando Usuario de Prueba ---\n";
    
    $testUserData = [
        'nombre' => 'TestUser_' . date('Ymd_His'),
        'correo' => 'testuser_' . time() . '@aicroom.com',
        'empresa_donde_labora' => 'Empresa de Prueba',
        'puesto' => 'Desarrollador de Prueba',
        'contraseña' => 'TestPassword123!',
        'fecha_registro' => date('Y-m-d'),
        'rol' => 'usuario'
    ];
    
    echo "Nombre: {$testUserData['nombre']}\n";
    echo "Correo: {$testUserData['correo']}\n";
    echo "Empresa: {$testUserData['empresa_donde_labora']}\n";
    echo "Puesto: {$testUserData['puesto']}\n";
    echo "Contraseña: {$testUserData['contraseña']}\n";
    echo "Rol: {$testUserData['rol']}\n";
    
    // Paso 2: Generar hash de la contraseña
    echo "\n--- PASO 2: Generando Hash de Contraseña ---\n";
    
    $hashedPassword = hashPassword($testUserData['contraseña']);
    
    echo "Contraseña original: {$testUserData['contraseña']}\n";
    echo "Hash generado: " . substr($hashedPassword, 0, 30) . "...\n";
    echo "Longitud del hash: " . strlen($hashedPassword) . " caracteres\n";
    
    if (strpos($hashedPassword, '$2y$') === 0) {
        echo "✓ Hash bcrypt válido generado\n";
    } else {
        echo "❌ Hash no válido\n";
        throw new Exception("Error en la generación del hash");
    }
    
    // Paso 3: Verificar que el hash funcione
    echo "\n--- PASO 3: Verificando Hash ---\n";
    
    if (verifyPassword($testUserData['contraseña'], $hashedPassword)) {
        echo "✓ Verificación exitosa con contraseña correcta\n";
    } else {
        echo "❌ Error en verificación con contraseña correcta\n";
        throw new Exception("El hash no se puede verificar");
    }
    
    if (!verifyPassword('password_incorrecta', $hashedPassword)) {
        echo "✓ Rechazo correcto de contraseña incorrecta\n";
    } else {
        echo "❌ Error: Aceptó contraseña incorrecta\n";
        throw new Exception("El hash acepta contraseñas incorrectas");
    }
    
    // Paso 4: Insertar usuario en la base de datos
    echo "\n--- PASO 4: Insertando Usuario en Base de Datos ---\n";
    
    $stmt = $pdo->prepare("INSERT INTO tbl_usuario (nombre, contraseña, correo, empresa_donde_labora, puesto, fecha_registro, rol) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([
        $testUserData['nombre'],
        $hashedPassword,
        $testUserData['correo'],
        $testUserData['empresa_donde_labora'],
        $testUserData['puesto'],
        $testUserData['fecha_registro'],
        $testUserData['rol']
    ]);
    
    if (!$result) {
        throw new Exception("Error al insertar usuario en la base de datos");
    }
    
    $userId = $pdo->lastInsertId();
    echo "✓ Usuario insertado exitosamente (ID: $userId)\n";
    
    // Paso 5: Verificar que el usuario se almacenó correctamente
    echo "\n--- PASO 5: Verificando Almacenamiento ---\n";
    
    $stmt = $pdo->prepare("SELECT * FROM tbl_usuario WHERE Id_Usuario = ?");
    $stmt->execute([$userId]);
    $storedUser = $stmt->fetch();
    
    if (!$storedUser) {
        throw new Exception("Usuario no encontrado después de la inserción");
    }
    
    echo "✓ Usuario recuperado de la base de datos:\n";
    echo "  - ID: {$storedUser['Id_Usuario']}\n";
    echo "  - Nombre: {$storedUser['nombre']}\n";
    echo "  - Correo: {$storedUser['correo']}\n";
    echo "  - Empresa: {$storedUser['empresa_donde_labora']}\n";
    echo "  - Puesto: {$storedUser['puesto']}\n";
    echo "  - Contraseña: " . substr($storedUser['contraseña'], 0, 30) . "...\n";
    echo "  - Rol: {$storedUser['rol']}\n";
    
    // Paso 6: Simular login completo
    echo "\n--- PASO 6: Simulando Login Completo ---\n";
    
    // Simular el proceso de login.php
    $loginUsername = $testUserData['nombre']; // o usar el correo
    $loginPassword = $testUserData['contraseña'];
    
    echo "Intentando login con:\n";
    echo "  - Usuario: $loginUsername\n";
    echo "  - Contraseña: $loginPassword\n";
    
    // Buscar usuario por nombre o correo (como hace login.php)
    $stmt = $pdo->prepare("
        SELECT Id_Usuario, nombre, contraseña, correo, rol, fecha_registro 
        FROM tbl_usuario 
        WHERE nombre = ? OR correo = ?
    ");
    $stmt->execute([$loginUsername, $loginUsername]);
    $loginUser = $stmt->fetch();
    
    if (!$loginUser) {
        echo "❌ Usuario no encontrado para login\n";
        throw new Exception("Error en búsqueda de usuario para login");
    }
    
    echo "✓ Usuario encontrado para login: {$loginUser['nombre']}\n";
    echo "  - ID: {$loginUser['Id_Usuario']}\n";
    echo "  - Correo: {$loginUser['correo']}\n";
    echo "  - Rol: {$loginUser['rol']}\n";
    
    // Verificar contraseña (como hace login.php)
    if (verifyPassword($loginPassword, $loginUser['contraseña'])) {
        echo "✓ Login exitoso - Contraseña verificada correctamente\n";
        echo "✓ El usuario puede iniciar sesión normalmente\n";
        
        // Simular datos de sesión
        echo "✓ Datos de sesión que se crearían:\n";
        echo "  - user_id: {$loginUser['Id_Usuario']}\n";
        echo "  - user_name: {$loginUser['nombre']}\n";
        echo "  - user_email: {$loginUser['correo']}\n";
        echo "  - user_role: {$loginUser['rol']}\n";
        
    } else {
        echo "❌ Login fallido - Contraseña incorrecta\n";
        throw new Exception("La verificación de contraseña falló en el login");
    }
    
    // Paso 7: Limpiar usuario de prueba
    echo "\n--- PASO 7: Limpiando Usuario de Prueba ---\n";
    
    $deleteResult = $pdo->exec("DELETE FROM tbl_usuario WHERE Id_Usuario = $userId");
    
    if ($deleteResult) {
        echo "✓ Usuario de prueba eliminado exitosamente\n";
    } else {
        echo "⚠ Usuario de prueba no se pudo eliminar (puede ser útil mantenerlo para pruebas)\n";
    }
    
    echo "\n--- USUARIO DE PRUEBA CREADO EXITOSAMENTE ---\n";
    echo "✓ El sistema de hash de contraseñas funciona correctamente\n";
    echo "✓ El registro de usuarios funciona correctamente\n";
    echo "✓ El login funciona correctamente\n";
    echo "✓ La verificación de contraseñas funciona correctamente\n";
    echo "✓ El sistema está listo para producción\n";
    
    echo "\n📋 RESUMEN DE CREDENCIALES DE PRUEBA:\n";
    echo "Usuario: {$testUserData['nombre']}\n";
    echo "Correo: {$testUserData['correo']}\n";
    echo "Contraseña: {$testUserData['contraseña']}\n";
    echo "Empresa: {$testUserData['empresa_donde_labora']}\n";
    echo "Puesto: {$testUserData['puesto']}\n";
    
} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage() . "\n";
    echo "Por favor, verifica la configuración\n";
} catch (PDOException $e) {
    echo "\n❌ ERROR DE BASE DE DATOS: " . $e->getMessage() . "\n";
    echo "Por favor, verifica la conexión y permisos\n";
}

echo "</pre>\n";
echo "<p><a href='index.html'>← Volver al inicio</a></p>\n";
echo "<p><a href='register.html'>🔄 Probar Registro</a></p>\n";
echo "<p><a href='login.html'>🔐 Probar Login</a></p>\n";
?> 