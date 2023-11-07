<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
  header("Location: ../login/login.php");
  exit;
}

// Incluir el archivo de funciones
include("funciones.php");

// Obtener el ID del chofer desde la sesión u otras fuentes
$tecnicoID = $_SESSION['idusuario'];

// Llamar a la función para obtener órdenes de flete
$ordenesFlete = obtenerOrdenesServicioParaTecnico($tecnicoID);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Servicio de PostVenta - FORNAX S.R.L</title>
  <link rel="stylesheet" href="../styles.css" />
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:wght@500&family=Nunito:wght@500&family=Roboto+Condensed:ital@1&display=swap"
    rel="stylesheet" />
</head>

<body>
  <div class="header">
    <div class="logo">
      <img src="../resources/logo-fornax-png.png" />
    </div>
    <nav class="menu">
      <div class="nav-links">
        <a href="../login/logout.php">Cerrar sesión</a>
      </div>
    </nav>
  </div>
  <div class="container">
    <p class="desc">ORDENES DE SERVICIO TÉCNICO</p>
    <div class="ordenes">
      <table>
        <thead>
          <tr>
            <th>ID de Orden</th>
            <th>Tipo</th>
            <th>Direccion</th>
            <th>Descripción</th>
            <th>Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $ordenesFlete = obtenerOrdenesServicioParaTecnico($tecnicoID);
          $cuerpoTabla = generarCuerpoTablaOrdenes($ordenesFlete);
          echo $cuerpoTabla;
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <script src="tecnico-script.js"></script>
</body>

</html>