<?php
function obtenerEstadoReclamoSegunTipo($nuevoEstado, $tipo)
{
    if ($nuevoEstado === '4-cancelada') {
        return ($tipo === 'R' ? 'RETIMP' : 'ENVIMP');
    } elseif ($nuevoEstado === '3-completada') {
        return ($tipo === 'R' ? 'ENFAB' : 'FIN');
    }
}

function actualizarEstadoReclamo($reclamoID, $nuevoEstadoReclamo, $conn)
{
    $query = "UPDATE reclamos SET idestado = ?, responsable = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nuevoEstadoReclamo, $reclamoID);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ordenID = $_POST['orden_id'];
    $nuevoEstado = $_POST['nuevo_estado'];
    $descripcion = $_POST['descripcion'];
    $reclamoID = $_POST['reclamo_id'];
    $tipoOrden = $_POST['tipo_orden']; 

    include("../conexion.php");


    //actualizar el estado y la descripción en la tabla de fletes
    $query = "UPDATE fletes SET estado = ?, descripcion = ? WHERE idflete = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $nuevoEstado, $descripcion, $ordenID);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        // Actualización de la tabla de fletes exitosa
    } else {
        // Error en la actualización de la tabla de fletes
    }
    $stmt->close();

    // Verificar el nuevo estado y realizar actualizaciones en la tabla de reclamos
    if (($nuevoEstado === '4-cancelada' || $nuevoEstado === '3-completada') && $reclamoID !== false) {
        $estadoReclamo = obtenerEstadoReclamoSegunTipo($nuevoEstado, $tipoOrden);
        actualizarEstadoReclamo($reclamoID, $estadoReclamo, $conn);
    }
    $conn->close();
    echo "<script>window.location.replace('chofer.php')</script>";
} else {
    http_response_code(400);
    echo "Solicitud incorrecta";
}
?>