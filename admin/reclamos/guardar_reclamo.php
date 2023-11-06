<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener los valores del formulario
    $reclamoId = $_POST["reclamoId"];
    $nuevoEstado = $_POST["estado"]; // Cambiado de "nuevoEstado" a "estado"

    // Realizar la actualización en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");
    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Construye la consulta SQL para actualizar el estado del reclamo
    $query = "UPDATE reclamos SET estado = ? WHERE id = ?";
    
    // Prepara la consulta
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    // Vincula los parámetros
    $stmt->bind_param("si", $nuevoEstado, $reclamoId);

    // Ejecuta la actualización
    if ($stmt->execute()) {
        // Actualización exitosa
        echo "Reclamo actualizado con éxito.";
    } else {
        // Maneja errores en la actualización
        echo "Error al actualizar el reclamo: " . $stmt->error;
    }

    // Cierra la conexión a la base de datos
    $stmt->close();
    $conn->close();
}
?>
