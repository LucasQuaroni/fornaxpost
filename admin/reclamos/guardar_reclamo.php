<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reclamoId = $_POST["reclamoId"];
    $nuevoEstado = $_POST["estado"];
    $nuevoResponsable = $_POST["responsable"];

    //actualización en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $reclamoId = $conn->real_escape_string($reclamoId);
    $nuevoEstado = $conn->real_escape_string($nuevoEstado);

    //consulta SQL para actualizar el estado del reclamo
    $query = "UPDATE reclamos SET idestado = '$nuevoEstado', responsable = '$nuevoResponsable' WHERE id = '$reclamoId'";

    // Ejecuta
    if (mysqli_query($conn, $query)) {
        echo "<script>alert('Reclamo actualizado exitosamente'); window.location.href='reclamos.php';</script>";
        exit;
    } else {
        echo "Error al actualizar el reclamo: " . mysqli_error($conn);
    }

    mysqli_close($conn);
}
?>