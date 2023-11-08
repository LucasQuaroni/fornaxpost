<?php

$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST["dni_cliente"]) || isset($_POST["dni-nuevo"]))) {
    $dni_cliente = $_POST["dni_cliente"];
    $modelo_artefacto = $_POST["modelo"];
    $numero_serie = $_POST["serial"];
    $en_garantia = isset($_POST["garantia"]) ? 'S' : 'N';
    $vendedor = $_POST["vendedor"];
    $problema_producto = $_POST["desc"];

    // Verificar si el artefacto ya existe en la base de datos
    $sql_select_artefacto = "SELECT serial FROM artefactos WHERE serial = '$numero_serie'";
    $result = $conn->query($sql_select_artefacto);

    if ($result->num_rows > 0) {
        // El artefacto ya existe, asignar el id del artefacto al reclamo
        $row = $result->fetch_assoc();
        $id_artefacto = $row["serial"];

        $sql_update_garantia = "UPDATE artefactos SET garantia = '$en_garantia' WHERE serial = '$id_artefacto'";

        if ($conn->query($sql_update_garantia) === TRUE) {
        } else {
            echo "Error al actualizar la garantía del artefacto: " . $conn->error;
            exit;
        }
    } else {
        // El artefacto no existe, insertarlo en la base de datos
        $sql_insert_artefacto = "INSERT INTO artefactos (serial, modelo, garantia, vendedor) VALUES ('$numero_serie', '$modelo_artefacto', '$en_garantia', '$vendedor')";
        if ($conn->query($sql_insert_artefacto) === TRUE) {
            $id_artefacto = $conn->insert_id;
        } else {
            echo "Error al insertar el artefacto: " . $conn->error;
            exit;
        }
    }

    // Obtener la fecha actual
    $fecha_reclamo = date("Y-m-d H:i:s");

    // Insertar los datos del reclamo en la tabla de reclamos
    $sql_insert_reclamo = "INSERT INTO reclamos (dni, fecha, serial, descripcion, idestado, responsable)
                          VALUES ('$dni_cliente', '$fecha_reclamo', '$numero_serie', '$problema_producto', 'PEN', 1)";

    if ($conn->query($sql_insert_reclamo) === TRUE) {
        session_start();
        $_SESSION['dni_cliente'] = $dni_cliente;
        $_SESSION['modelo_artefacto'] = $modelo_artefacto;
        $_SESSION['numero_serie'] = $numero_serie;
        $_SESSION['en_garantia'] = $en_garantia;
        $_SESSION['problema_producto'] = $problema_producto;

        header("Location: reclamo_exitoso.php");
        exit;
    } else {
        echo "Error al registrar el reclamo: " . $conn->error;
    }
}

$conn->close();
?>