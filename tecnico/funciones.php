<?php
function obtenerOrdenesServicioParaTecnico($tecnicoID)
{
    include("../conexion.php");


    $query = "SELECT reclamos.id as idreclamo, servicios.idserviciotecnico, servicios.direccion, servicios.descripcion, servicios.tipo, servicios.estado FROM servicios INNER JOIN reclamos ON servicios.idreclamo = reclamos.id WHERE servicios.idtecnico = ? AND servicios.estado != '4-cancelada' AND servicios.estado != '3-completada'";

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
            $cuerpoTabla .= "<td>En fabrica</td>";
        } elseif ($orden["tipo"] == 'D') {
            $cuerpoTabla .= "<td>A domicilio</td>";
        }
        $cuerpoTabla .= "<td>" . $orden['direccion'] . "</td>";
        $cuerpoTabla .= "<td>" . $orden['descripcion'] . "</td>";
        $cuerpoTabla .= "<td>" . $orden['estado'] . "</td>";
        $cuerpoTabla .= "<td><button class='actualizar-orden boton' onclick='abrirModal(" . $orden['idserviciotecnico'] . ", " . $orden['idreclamo'] . ", \"" . $orden['tipo'] . "\")'>Actualizar</button>
        </td>";
        $cuerpoTabla .= "</tr>";
    }

    return $cuerpoTabla;
}

$tecnicoID = $_SESSION['idusuario'];
$ordenesFlete = obtenerOrdenesServicioParaTecnico($tecnicoID);
?>