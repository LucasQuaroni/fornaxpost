<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
  header("Location: ../login/login.php");
  exit;
}

include("funciones.php");

$choferID = $_SESSION['idusuario'];

//obtener órdenes de flete
$ordenesFlete = obtenerOrdenesFleteParaChofer($choferID);
?>
<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Servicio de PostVenta - FORNAX S.R.L</title>
  <link rel="stylesheet" href="../estilos.css" />
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
    <p class="desc">ORDENES DE FLETE</p>
    <div class="ordenes">
      <table>
        <thead>
          <tr>
            <th>ID de Orden</th>
            <th>Dirección</th>
            <th>Descripción</th>
            <th>Tipo</th>
            <th>Estado</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <?php
          $ordenesFlete = obtenerOrdenesFleteParaChofer($choferID);
          $cuerpoTabla = generarCuerpoTablaOrdenes($ordenesFlete);
          echo $cuerpoTabla;
          ?>
        </tbody>
      </table>
    </div>
  </div>
  <?php include("modal.php"); ?>
  <script>
    function abrirModal(ordenId, reclamoId, tipoOrden) {
      var modal = document.getElementById("custom-modal");
      var span = document.getElementById("close-modal");
      var form = document.getElementById("form-actualizar-orden");

      modal.style.display = "block";
      document.getElementById("orden-id").value = ordenId;
      document.getElementById("reclamo-id").value = reclamoId;
      document.getElementById("tipo-orden").value = tipoOrden;

      span.onclick = function () {
        modal.style.display = "none";
      }

      window.onclick = function (event) {
        if (event.target == modal) {
          modal.style.display = "none";
        }
      }
    }
    function procesarFormularioActualizacion() {
      var form = document.getElementById("form-actualizar-orden");
      var ordenId = document.getElementById("orden-id").value;
      var nuevoEstado = document.getElementById("nuevo-estado").value;
      var descripcion = document.getElementById("descripcion").value;

      // Realizar una solicitud AJAX para enviar los datos al servidor
      var xhr = new XMLHttpRequest();
      xhr.open("POST", "actualizar_estado_orden.php", true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

      xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
          // Proceso la respuesta del servidor
          var response = xhr.responseText;
          console.log(response);
        }
      };

      // Enviar los datos del formulario al servidor
      var data = "orden_id=" + ordenId + "&nuevo_estado=" + nuevoEstado + "&descripcion=" + descripcion;
      xhr.send(data);

      // Cerrar el modal después de enviar los datos
      var modal = document.getElementById("custom-modal");
      modal.style.display = "none";
    }
  </script>
</body>

</html>