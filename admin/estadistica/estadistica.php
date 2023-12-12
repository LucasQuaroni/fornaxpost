<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}

include("../../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Estadística</title>
    <link rel="stylesheet" href="../../estilos.css">
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="../../resources/logo-fornax-png.png">
        </div>
        <nav class="menu">
            <div class="nav-links">
                <a href="../admin.php">Volver</a>
            </div>
        </nav>
    </div>
    <div class="table-container">
        <h1>Estadística</h1>
    </div>