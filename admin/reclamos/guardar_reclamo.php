<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $reclamoId = $_POST["reclamoId"];
    $nuevoEstado = $_POST["estado"];
    $nuevoResponsable = $_POST["responsable"];

    // Realizar la actualización en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Escapa las variables para evitar inyección de SQL
    $reclamoId = $conn->real_escape_string($reclamoId);
    $nuevoEstado = $conn->real_escape_string($nuevoEstado);

    // Construye la consulta SQL para actualizar el estado del reclamo
    $query = "UPDATE reclamos SET idestado = '$nuevoEstado', responsable = '$nuevoResponsable' WHERE id = '$reclamoId'";

    // Ejecuta la actualización
    if (mysqli_query($conn, $query)) {
        // Actualización exitosa
        echo "<script>alert('Reclamo actualizado exitosamente'); window.location.href='reclamos.php';</script>";
        exit;
    } else {
        // Maneja errores en la actualización
        echo "Error al actualizar el reclamo: " . mysqli_error($conn);
    }

    // Cierra la conexión a la base de datos
    mysqli_close($conn);
}
?>