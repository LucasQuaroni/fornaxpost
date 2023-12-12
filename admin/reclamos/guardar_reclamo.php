<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reclamoId = $_POST["reclamoId"];
    $nuevoEstado = $_POST["estado"];
    $nuevoResponsable = $_POST["responsable"];
    $nuevaDescripcion = $_POST["descripcion"];

    //actualización en la base de datos
    include("../../conexion.php");

    $reclamoId = $conn->real_escape_string($reclamoId);
    $nuevoEstado = $conn->real_escape_string($nuevoEstado);
    $nuevoDescripcion = $conn->real_escape_string($nuevaDescripcion);

    //consulta SQL para actualizar el estado del reclamo
    $query = "UPDATE reclamos SET idestado = '$nuevoEstado', responsable = '$nuevoResponsable', descripcion = '$nuevaDescripcion' WHERE id = '$reclamoId'";

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