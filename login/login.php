<!DOCTYPE html>
<html lang="en">

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
      <a href="../index.html"><img src="../resources/logo-fornax-png.png" />
      </a>
    </div>
    <nav class="menu">
      <div class="nav-links">
        <a href="../index.html">Volver</a>
      </div>
    </nav>
  </div>
  <div class="container">
    <div class="card">
      <h1>Funcionalidades restringidas</h1>
      <br>
      <form name="myForm" class="login" action="autenticarLogin.php" method="POST">
        <div class="linea">
          <p>Usuario</p>
          <input type="text" id="user" name="user" />
        </div>
        <div class="linea">
          <p>Contraseña</p>
          <input type="password" id="pass" name="pass" />
        </div>
        <button type="submit">Ingresar</button>
      </form>
      <br>
      <?php
      session_start();
      $error_message = isset($_SESSION['error_message']) ? $_SESSION['error_message'] : "";
      unset($_SESSION['error_message']);
      ?>
      <div class="error-message">
        <?php echo $error_message; ?>
      </div>
    </div>
  </div>
</body>

</html>