<?php

$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verifica si el formulario se envió y si se proporcionaron datos requeridos
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["dni_cliente"]) && isset($_POST["nombre"])) {
    $dni_cliente = $_POST["dni_cliente"];
    $nombre = $_POST["nombre"];
    $domicilio = $_POST["domicilio"];
    $telefono = $_POST["telefono"];
    $email = $_POST["email"];
    $provincia = $_POST["provincia"];
    $localidad = $_POST["localidad"];
    $codigo_postal = $_POST["codigo_postal"];
    $observacion_cliente = $_POST["observacion_cliente"];

    // Verifica nuevamente si el cliente ya existe en la base de datos
    $sql_check = "SELECT * FROM clientes WHERE dni = '$dni_cliente'";
    $result_check = $conn->query($sql_check);

    if ($result_check->num_rows === 0) {
        // El cliente no existe, por lo tanto, procede con el registro
        // Inserta los datos del cliente en la tabla de clientes
        $sql_register = "INSERT INTO clientes (dni, nombreYapellido, domicilio, telefono, email, provincia, localidad, codpostal, obs)
                        VALUES ('$dni_cliente', '$nombre', '$domicilio', '$telefono', '$email', '$provincia', '$localidad', '$codigo_postal', '$observacion_cliente')";

        if ($conn->query($sql_register) === TRUE) {
            // Cliente registrado con éxito
            header("Location: reclamo.php?dni-nuevo=$dni_cliente");
        } else {
            echo "Error al registrar el cliente: " . $conn->error;
        }

    } else {
        // El cliente ya está registrado, redirige a la página de reclamos
        header("Location: reclamo.php?dni=$dni_cliente");
    }
}

// Cierra la conexión a la base de datos
$conn->close();
?>