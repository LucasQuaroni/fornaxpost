<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["responsable"]) && isset($_POST["reclamo_id"])) {
    $responsable = $_POST["responsable"];
    $reclamo_id = $_POST["reclamo_id"];

    // Realiza las actualizaciones en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $sql = "UPDATE reclamos SET responsable = '$responsable' WHERE id = $reclamo_id";

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