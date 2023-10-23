<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["idadmin"]) && isset($_POST["idestado"]) && isset($_POST["reclamo_id"])) {
    $idadmin = $_POST["idadmin"];
    $idestado = $_POST["idestado"];
    $reclamo_id = $_POST["reclamo_id"];

    // Realiza las actualizaciones en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "UPDATE reclamos SET idadmin = '$idadmin', idestado = '$idestado' WHERE id = $reclamo_id";

    if ($conn->query($sql) === TRUE) {
        // Actualización exitosa
        echo '<script>alert("Reclamo actualizado exitosamente.");</script>';
        header("Location: reclamos.php");
        exit;
    } else {
        echo "Error al actualizar el reclamo: " . $conn->error;
    }

    $conn->close();
}
?>