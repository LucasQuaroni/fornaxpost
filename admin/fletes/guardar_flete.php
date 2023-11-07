<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idFlete = isset($_POST['idFlete']) ? $_POST['idFlete'] : null;
    $direccion = $_POST['direccion'];
    $descripcion = $_POST['descripcion']; // Obtener la descripción del formulario
    $tipo = $_POST['tipo'];
    $responsable = $_POST['responsable'];
    $reclamo = $_POST['reclamo'];
    $estado = $_POST["estado"];

    $conn = new mysqli("localhost", "root", "", "fornaxpost");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    if ($idFlete) {
        // Estás modificando una orden existente
        $sql = "UPDATE fletes SET direccion='$direccion', descripcion='$descripcion', tipo='$tipo', idchofer='$responsable', idreclamo='$reclamo', estado = '$estado' WHERE idflete='$idFlete'";
    } else {
        // Estás creando una nueva orden
        $sql = "INSERT INTO fletes (direccion, descripcion, tipo, estado, idchofer, idreclamo) VALUES ('$direccion', '$descripcion', '$tipo', 'asignada', '$responsable', '$reclamo')";
    }

    if ($conn->query($sql) === TRUE) {
        // La operación se completó con éxito
        header("Location: FLETES.PHP");
        exit;
    } else {
        // Hubo un error
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>