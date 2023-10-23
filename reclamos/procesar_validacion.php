<?php

$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si el formulario se envió y si se proporcionó un DNI
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_cliente"])) {
    $dni_cliente = $_POST["dni_cliente"];

    // Consulta a la base de datos para verificar la existencia del cliente
    $sql = "SELECT * FROM clientes WHERE dni = '$dni_cliente'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // El cliente ya está registrado, redirige a la página de reclamos
        header("Location: reclamo.php?dni=$dni_cliente");
    } else {
        // El cliente no está registrado, redirige a la página de registro de cliente
        header("Location: registro_cliente.php?dni=$dni_cliente");
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>