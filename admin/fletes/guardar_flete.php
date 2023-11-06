<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $direccion = $_POST["direccion"];
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $responsable = $_POST["responsable"];
    $reclamo = $_POST["reclamo"];

    // Realiza la inserción en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "INSERT INTO fletes (direccion, descripcion, estado, tipo, idchofer, idreclamo) VALUES ('$direccion', '$descripcion', 'asignada', '$tipo', '$responsable', '$reclamo')";

    if ($conn->query($query) === TRUE) {
        echo "<script>alert('Orden de flete guardada exitosamente'); window.location.href='fletes.php';</script>";
        exit;
    } else {
        echo "Error al guardar la orden de flete: " . $conn->error;
    }

    $conn->close();
}
?>
