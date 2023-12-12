<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../../estilos.css">
</head>

<body>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $reclamoId = $_POST["reclamoId"];
        $nuevoEstado = $_POST["estado"];
        $nuevoResponsable = $_POST["responsable"];
        $nuevaDescripcion = $_POST["descripcion"];

        // Actualización en la base de datos
        include("../../conexion.php");

        $reclamoId = $conn->real_escape_string($reclamoId);
        $nuevoEstado = $conn->real_escape_string($nuevoEstado);
        $nuevoDescripcion = $conn->real_escape_string($nuevaDescripcion);

        // Consulta SQL para actualizar el estado del reclamo
        $query = "UPDATE reclamos SET idestado = '$nuevoEstado', responsable = '$nuevoResponsable', descripcion = '$nuevaDescripcion' WHERE id = '$reclamoId'";

        // Ejecuta la consulta
        if (mysqli_query($conn, $query)) {
            // Incluye el archivo modal.php
    
            // Verifica el estado y redirige según corresponda
            if ($nuevoEstado == 'VISPEN' || $nuevoEstado == 'REPPEN') {
                include("modalServicio.php");
                // Añade los atributos al modal de servicio
                echo '<script>
                var modalServicio = document.getElementById("miModalServicio");
                modalServicio.setAttribute("data-reclamo-id", "' . $reclamoId . '");
                modalServicio.setAttribute("data-responsable-id", "' . $nuevoResponsable . '");
                modalServicio.style.display = "block";
              </script>';
            } elseif ($nuevoEstado == 'RETPEN' || $nuevoEstado == 'ENVPEN') {
                include("modalFlete.php");
                // Añade los atributos al modal de flete
                echo '<script>
                var modalFlete = document.getElementById("miModalFlete");
                modalFlete.setAttribute("data-reclamo-id", "' . $reclamoId . '");
                modalFlete.setAttribute("data-responsable-id", "' . $nuevoResponsable . '");
                modalFlete.style.display = "block";
              </script>';
            } else {
                // Redirige a reclamos.php si no es ninguno de los estados especiales
                echo "<script>window.location.href='reclamos.php';</script>";
            }
        } else {
            // Puedes manejar un error en caso de que la consulta no sea exitosa
            echo "Error en la consulta: " . mysqli_error($conn);
        }
    }
    ?>
</body>

</html>