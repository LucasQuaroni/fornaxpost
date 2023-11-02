<?php
function obtenerOrdenesFleteParaChofer($choferID)
{
    $conn = new mysqli("localhost", "root", "", "fornaxpost");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    $query = "SELECT idflete, direccion, descripcion, tipo, estado FROM fletes WHERE idchofer = ?";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $choferID);
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
        $cuerpoTabla .= "<td>" . $orden['idflete'] . "</td>";
        $cuerpoTabla .= "<td>" . $orden['direccion'] . "</td>";
        $cuerpoTabla .= "<td>" . $orden['descripcion'] . "</td>";
        $cuerpoTabla .= "<td>" . $orden['tipo'] . "</td>";
        $cuerpoTabla .= "<td>" . $orden['estado'] . "</td>";
        $cuerpoTabla .= "</tr>";
    }

    return $cuerpoTabla;
}

// Luego, en tu código principal, puedes llamar a esta función pasando el ID del chofer en sesión:
$choferID = $_SESSION['usuario']; // Esto asume que 'usuario' contiene el ID del chofer.
$ordenesFlete = obtenerOrdenesFleteParaChofer($choferID);
?>