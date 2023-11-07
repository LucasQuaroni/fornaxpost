<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
  header("Location: ../login/login.php");
  exit;
}

$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
  die("Conexión fallida: " . $conn->connect_error);
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin - Servicios</title>
  <link rel="stylesheet" href="styles.css">
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
      <div class="nav-links">
        <a id="abrirModal">Alta manual</a>
      </div>
    </nav>
  </div>
  <div class="table-container">
    <h1>Servicios técnicos</h1>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Buscar por tecnico o estado">
      <button class='boton' onclick="buscarServicios()">Buscar</button>
    </div>
    <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Tipo</th>
          <th>Dirección</th>
          <th>Descripción</th>
          <th>Estado</th>
          <th>Responsable</th>
          <th>ID Reclamo</th>
          <th></th>
        </tr>
      </thead>
      <tbody id='reclamosTable'>
        <?php include 'consultar_servicios.php'; ?>
      </tbody>
    </table>
  </div>
  <?php include 'modal.php'; ?>
  <script>
    function buscarServicios() {
      const searchValue = document.getElementById('searchInput').value.toLowerCase();
      const filas = document.querySelectorAll('#reclamosTable tr');
      filas.forEach(function (fila) {
        const columnaDNI = fila.querySelector('td:nth-child(5)').textContent.toLowerCase();
        const columnaEstado = fila.querySelector('td:nth-child(6)').textContent.toLowerCase();
        if (columnaDNI.includes(searchValue) || columnaEstado.includes(searchValue)) {
          fila.style.display = 'table-row';
        } else {
          fila.style.display = 'none';
        }
      });
    }

    const modal = document.getElementById("miModal");
    const abrirModal = document.getElementById("abrirModal");
    const cerrarModal = document.getElementById("cerrarModal");

    abrirModal.addEventListener("click", function () {
      modal.style.display = "flex";
    });

    cerrarModal.addEventListener("click", function () {
      modal.style.display = "none";
    });

    // Agregar un evento clic al fondo transparente del modal
    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });
  </script>
</body>

</html>