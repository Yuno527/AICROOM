<?php
require_once 'check_auth.php';

// Verificar si el usuario está logueado
if (!isLoggedIn()) {
    // Si no está logueado, redirigir al login
    header('Location: login.html');
    exit;
}

// Si está logueado, incluir el index.html
$currentUser = getCurrentUser();
include 'index.html';
?> 