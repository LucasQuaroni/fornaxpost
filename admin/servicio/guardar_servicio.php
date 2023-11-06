<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $direccion = $_POST["direccion"];
    $responsable = $_POST["responsable"];
    $reclamo = $_POST["reclamo"];

    // Realiza la inserción en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "INSERT INTO servicios (direccion, descripcion, estado, tipo, idtecnico, idreclamo) VALUES ('$direccion', '$descripcion', 'asignada', '$tipo', '$responsable', '$reclamo')";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Orden de flete guardada exitosamente'); window.location.href='servicio.php';</script>";
        exit;
    } else {
        echo "Error al guardar la orden de flete: " . $conn->error;
    }

    $conn->close();
}
?>
