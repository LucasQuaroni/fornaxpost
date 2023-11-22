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
  <title>Admin - Servicios</title>
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
      <div class="nav-links">
        <a id="abrirModal">Alta manual</a>
      </div>
    </nav>
  </div>
  <div class="table-container">
    <h1>Servicios técnicos</h1>
    <div class="search-bar">
      <input type="text" id="searchInput" placeholder="Buscar por tecnico, reclamo o estado">
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
  <?php include 'modal_modificar.php'; ?>
  <script>
    function abrirModificarServicio(idserviciotecnico) {
      document.getElementById('idServicioTecnico').value = idserviciotecnico;

      const filaSeleccionada = document.querySelector(`#reclamosTable tr[data-idserviciotecnico="${idserviciotecnico}"]`);

      document.getElementById("direccionModificar").value = filaSeleccionada.getAttribute("data-direccion");
      document.getElementById("descripcionModificar").value = filaSeleccionada.getAttribute("data-descripcion");
      document.getElementById("tipoModificar").value = filaSeleccionada.getAttribute("data-tipo");
      document.getElementById("responsableModificar").value = filaSeleccionada.getAttribute("data-responsable");
      document.getElementById("reclamoModificar").value = filaSeleccionada.getAttribute("data-reclamo");
      document.getElementById("estadoModificar").value = filaSeleccionada.getAttribute("data-estado");

      modalModificar.style.display = "flex";
    }

    function buscarServicios() {
      const searchValue = document.getElementById('searchInput').value.toLowerCase();
      const filas = document.querySelectorAll('#reclamosTable tr');
      filas.forEach(function (fila) {
        const columnaDNI = fila.querySelector('td:nth-child(5)').textContent.toLowerCase();
        const columnaEstado = fila.querySelector('td:nth-child(6)').textContent.toLowerCase();
        const columnaReclamo = fila.querySelector('td:nth-child(7)').textContent.toLowerCase();
        if (columnaDNI.includes(searchValue) || columnaEstado.includes(searchValue) || columnaReclamo.includes(searchValue)) {
          fila.style.display = 'table-row';
        } else {
          fila.style.display = 'none';
        }
      });
    }

    const modal = document.getElementById("miModal");
    const modalModificar = document.getElementById("miModalModificar");
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

    // Cerrar el modal de alta manual al hacer clic fuera de él
    window.addEventListener("click", function (event) {
      if (event.target === modal) {
        modal.style.display = "none";
      }
    });

    // Cerrar el modal de modificación al hacer clic fuera de él
    window.addEventListener("click", function (event) {
      if (event.target === modalModificar) {
        modalModificar.style.display = "none";
      }
    });
  </script>
</body>

</html>