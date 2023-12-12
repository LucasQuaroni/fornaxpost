<?php
function obtenerOrdenesFleteParaChofer($choferID)
{
    include("../conexion.php");

    $query = "SELECT reclamos.id as idreclamo, fletes.idflete, fletes.direccion, fletes.descripcion, fletes.tipo, fletes.estado FROM fletes INNER JOIN reclamos ON fletes.idreclamo = reclamos.id WHERE fletes.idchofer = ? AND fletes.estado != '4-cancelada' AND fletes.estado != '3-completada'";

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
        if ($orden["tipo"] == 'R') {
            $cuerpoTabla .= "<td>Retirar</td>";
        } elseif ($orden["tipo"] == 'D') {
            $cuerpoTabla .= "<td>Llevar</td>";
        }
        $cuerpoTabla .= "<td>" . $orden['estado'] . "</td>";
        $cuerpoTabla .= "<td><button class='actualizar-orden boton' onclick='abrirModal(" . $orden['idflete'] . ", " . $orden['idreclamo'] . ", \"" . $orden['tipo'] . "\")'>Actualizar</button>
        </td>";
        $cuerpoTabla .= "</tr>";
    }

    return $cuerpoTabla;
}

$choferID = $_SESSION['idusuario'];
$ordenesFlete = obtenerOrdenesFleteParaChofer($choferID);
?>