<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $idserviciotecnico = isset($_POST['idServicioTecnico']) ? $_POST['idServicioTecnico'] : null;
    $descripcion = $_POST["descripcion"];
    $tipo = $_POST["tipo"];
    $direccion = $_POST["direccion"];
    $responsable = $_POST["responsable"];
    $reclamo = $_POST["reclamo"];
    $estado = $_POST["estado"];

    //inserción en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    if ($idserviciotecnico) {
        //modificando una orden existente
        $sql = "UPDATE servicios SET direccion='$direccion', descripcion='$descripcion', tipo='$tipo', idtecnico='$responsable', idreclamo='$reclamo', estado = '$estado' WHERE idserviciotecnico='$idserviciotecnico'";
    } else {
        //creando una nueva orden
        $sql = "INSERT INTO servicios (direccion, descripcion, estado, tipo, idtecnico, idreclamo) VALUES ('$direccion', '$descripcion', '1-asignada', '$tipo', '$responsable', '$reclamo')";
    }

    if ($conn->query($sql) === TRUE) {
        header("Location: servicio.PHP");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }


    $conn->close();
}
?>