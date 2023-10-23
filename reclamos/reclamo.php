<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de reclamo ONLINE</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@500&family=Nunito:wght@500&family=Roboto+Condensed:ital@1&display=swap"
        rel="stylesheet" />
</head>

<body class="page-specific">
    <div class="header">
        <div class="logo">
            <a href="../index.html"><img src="../resources/logo-fornax-png.png" /></a>
        </div>
        <nav class="menu">
            <div class="nav-links">
                <a href="../reclamos/cliente.html">Volver</a>
            </div>
        </nav>
    </div>
    <div class="container">
        <?php
        if (isset($_GET['dni-nuevo'])) {
            $dni_cliente = $_GET['dni-nuevo'];
            echo "El cliente con DNI $dni_cliente ha sido registrado exitosamente.";
        } else {
            $dni_cliente = $_GET['dni'];
            echo "Cliente encontrado. Continúe con su reclamo.";
        }
        ?>
        <h2>Registro de Reclamo</h2>
        <form method="post" action="procesar_reclamo.php">
            <div class="linea">
                <p>Número de DNI<span> *</span></p>
                <input type="text" name="dni_cliente" readonly value="<?php echo $dni_cliente; ?>" required />
            </div>
            <div class="linea">
                <p>Modelo de <br>artefacto<span> *</span></p>
                <input type="text" name="modelo" required />
            </div>
            <div class="linea">
                <p>Numero de serie<span> *</span></p>
                <input type="number" name="serial" required />
            </div>
            <div class="linea">
                <p>¿Está en garantía?</p>
                <input type="checkbox" name="garantia" />
            </div>
            <div class="linea">
                <p>Problema que presenta el producto<span> *</span></p>
                <textarea name="desc" required></textarea>
            </div>
            <button type="submit" name="submit">Enviar Reclamo</button>
        </form>
    </div>

    <div class="footer">
        <div class="redes item-ft">
            <a href="https://www.instagram.com/fornax.cocinas/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-brand-instagram" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M4 4m0 4a4 4 0 0 1 4 -4h8a4 4 0 0 1 4 4v8a4 4 0 0 1 -4 4h-8a4 4 0 0 1 -4 -4z"></path>
                    <path d="M12 12m-3 0a3 3 0 1 0 6 0a3 3 0 1 0 -6 0"></path>
                    <path d="M16.5 7.5l0 .01"></path>
                </svg></a>
            <a href="https://www.facebook.com/Fornax.Cocinas/" target="_blank"><svg xmlns="http://www.w3.org/2000/svg"
                    class="icon icon-tabler icon-tabler-brand-facebook" width="24" height="24" viewBox="0 0 24 24"
                    stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3"></path>
                </svg></a>
            <a href="https://api.whatsapp.com/send?phone=3416530650&text=Hola, tengo una consulta:" target="_blank"><svg
                    xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-whatsapp" width="24"
                    height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                    stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path d="M3 21l1.65 -3.8a9 9 0 1 1 3.4 2.9l-5.05 .9"></path>
                    <path
                        d="M9 10a.5 .5 0 0 0 1 0v-1a.5 .5 0 0 0 -1 0v1a5 5 0 0 0 5 5h1a.5 .5 0 0 0 0 -1h-1a.5 .5 0 0 0 0 1">
                    </path>
                </svg></a>
        </div>
        <div class="direccion item-ft">
            <p>Rueda 1540 - Rosario - Argentina</p>
        </div>
        <div class="item-ft">
            <p>cocinas@fornax.com.ar</p>
        </div>
    </div>
    <script src="script.js"></script>
</body>

</html>