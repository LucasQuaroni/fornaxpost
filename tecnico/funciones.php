<?php
function obtenerOrdenesServicioParaTecnico($tecnicoID)
{
    $conn = new mysqli("localhost", "root", "", "fornaxpost");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "SELECT idserviciotecnico, tipo, direccion, descripcion, estado FROM servicios WHERE idtecnico = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $tecnicoID);
    $stmt->execute();

    $result = $stmt->get_result();
    $ordenes = [];

    while ($row = $result->fetch_assoc()) {
        $ordenes[] = $row;
    }

    $stmt->close();
    $conn->close();

    return $ordenes;
}

function generarCuerpoTablaOrdenes($ordenes)
{
    $cuerpoTabla = '';

    foreach ($ordenes as $orden) {
        $cuerpoTabla .= "<tr>";
        $cuerpoTabla .= "<td>" . $orden['idserviciotecnico'] . "</td>";
        if ($orden["tipo"] == 'F') {
            $cuerpoTabla .= "<td>" . 'En fabrica' . "</td>";
        } elseif ($orden["tipo"] == 'D') {
            $cuerpoTabla .= "<td>" . 'A domicilio' . "</td>";
        }
        $cuerpoTabla .= "<td>" . $orden['direccion'] . "</td>";
        $cuerpoTabla .= "<td>" . $orden['descripcion'] . "</td>";
        $cuerpoTabla .= "<td>" . $orden['estado'] . "</td>";
        $cuerpoTabla .= "</tr>";
    }

    return $cuerpoTabla;
}

// Luego, en tu código principal, puedes llamar a esta función pasando el ID del chofer en sesión:
$tecnicoID = $_SESSION['usuario']; // Esto asume que 'usuario' contiene el ID del chofer.
$ordenesFlete = obtenerOrdenesServicioParaTecnico($tecnicoID);
?>