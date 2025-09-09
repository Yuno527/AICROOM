<?php
session_start();
require_once 'config.php';

echo "<h2>Verificación del Usuario Admin</h2>";

try {
    $pdo = getConnection();
    
    // Verificar todos los usuarios
    $stmt = $pdo->query("SELECT Id_Usuario, nombre, correo, rol FROM tbl_usuario ORDER BY Id_Usuario");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo "<h3>Usuarios en la base de datos:</h3>";
    echo "<table border='1' style='border-collapse: collapse; width: 100%;'>";
    echo "<tr><th>ID</th><th>Nombre</th><th>Correo</th><th>Rol</th></tr>";
    
    foreach ($users as $user) {
        $rowColor = $user['rol'] === 'admin' ? 'background-color: #d4edda;' : '';
        echo "<tr style='$rowColor'>";
        echo "<td>" . $user['Id_Usuario'] . "</td>";
        echo "<td>" . $user['nombre'] . "</td>";
        echo "<td>" . $user['correo'] . "</td>";
        echo "<td>" . $user['rol'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
    
    // Verificar si hay usuarios admin
    $stmt = $pdo->prepare("SELECT COUNT(*) as total FROM tbl_usuario WHERE rol = 'admin'");
    $stmt->execute();
    $adminCount = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    echo "<h3>Resumen:</h3>";
    echo "<p>Total de usuarios: " . count($users) . "</p>";
    echo "<p>Usuarios admin: $adminCount</p>";
    
    if ($adminCount == 0) {
        echo "<p style='color: red;'>❌ No hay usuarios admin. Necesitas crear uno.</p>";
        echo "<h3>Crear usuario admin:</h3>";
        echo "<form method='post'>";
        echo "<p>Nombre: <input type='text' name='nombre' value='Breiner' required></p>";
        echo "<p>Correo: <input type='email' name='correo' value='breiner@admin.com' required></p>";
        echo "<p>Contraseña: <input type='password' name='password' value='admin123' required></p>";
        echo "<p><input type='submit' name='create_admin' value='Crear Admin'></p>";
        echo "</form>";
    } else {
        echo "<p style='color: green;'>✅ Hay usuarios admin disponibles.</p>";
    }
    
    // Procesar creación de admin
    if (isset($_POST['create_admin'])) {
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $password = $_POST['password'];
        
        try {
            $stmt = $pdo->prepare("INSERT INTO tbl_usuario (nombre, correo, contraseña, rol) VALUES (?, ?, ?, 'admin')");
            $stmt->execute([$nombre, $correo, $password]);
            
            echo "<p style='color: green;'>✅ Usuario admin creado exitosamente!</p>";
            echo "<p>Credenciales: $correo / $password</p>";
            
        } catch (Exception $e) {
            echo "<p style='color: red;'>❌ Error creando admin: " . $e->getMessage() . "</p>";
        }
    }
    
} catch (Exception $e) {
    echo "<p style='color: red;'>❌ Error: " . $e->getMessage() . "</p>";
}
?> 