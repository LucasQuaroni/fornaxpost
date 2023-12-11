<?php
session_start();

// Verificar si la sesión está iniciada
if (isset($_SESSION['es_admin']) && $_SESSION['es_admin']) {
  $usuarioEsAdmin = true;
} else {
  $usuarioEsAdmin = false;
}

function mostrarBoton($esAdmin)
{
  if ($esAdmin) {
    echo '<a id="volver" href="../admin/admin.php">Volver al Menú ADMIN</a>';
  } else {
    echo '<a id="volver" href="../index.html">Volver al inicio</a>';
  }
}


?>

<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Reclamo Exitoso!</title>
  <link rel="stylesheet" href="../estilos.css">
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
  </div>
  <div class="container">

    <h1>Reclamo registrado con éxito!</h1>
    <div class="resumen">
      <div class="line">
        <label for=""><b>Número de DNI:</b></label>
        <p>
          <?php echo $_SESSION['dni_cliente']; ?>
        </p>
      </div>
      <div class="line">
        <label for=""><b>Modelo de artefacto:</b></label>
        <p>
          <?php echo $_SESSION['modelo_artefacto']; ?>
        </p>
      </div>
      <div class="line">
        <label for=""><b>Número de serie:</b></label>
        <p>
          <?php echo $_SESSION['numero_serie']; ?>
        </p>
      </div>
      <div class="line">
        <label for=""><b>¿Está en garantía?</b></label>
        <p>
          <?php
          if (($_SESSION['en_garantia'] == "S")) {
            $garantia = 'Si';
          } else {
            $garantia = 'No';
          }
          echo $garantia;
          ?>
        </p>
      </div>
      <div class="line">
        <label for=""><b>Problema del producto:</b></label>
        <p>
          <?php echo $_SESSION['problema_producto']; ?>
        </p>
      </div>
    </div>
    <?php
    mostrarBoton($usuarioEsAdmin);
    ?>
    <br>
  </div>

</body>

</html>