<?php
session_start();
$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si el formulario se envió y si se proporcionó un DNI y un correo electrónico
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_cliente"]) && isset($_POST["mail_cliente"])) {
    $dni_cliente = $_POST["dni_cliente"];
    $mail_cliente = $_POST["mail_cliente"];

    // Consulta a la base de datos para verificar la existencia del cliente
    $sql = "SELECT * FROM clientes WHERE dni = '$dni_cliente' OR email = '$mail_cliente'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Cliente encontrado en la base de datos
        $row = $result->fetch_assoc();
        $dni_registrado = $row["dni"];
        $mail_registrado = $row["email"];

        if ($dni_cliente == $dni_registrado && $mail_cliente == $mail_registrado) {
            // El DNI y el correo electrónico ingresados coinciden con los registrados, redirige a la página de reclamos
            header("Location: reclamo.php?dni=$dni_cliente");
        } else {
            // El DNI o el correo electrónico ingresados no coinciden
            $_SESSION['error_message'] = "El DNI o el correo electrónico ingresados no coinciden. Por favor, inténtelo nuevamente.";
            header("Location: cliente.php");
        }
    } else {
        // El cliente no está registrado, redirige a la página de registro de cliente
        header("Location: registro_cliente.php?dni=$dni_cliente");
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>