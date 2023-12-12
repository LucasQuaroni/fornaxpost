<?php
function obtenerEstadoReclamoSegunTipo($nuevoEstado, $tipo)
{
    if ($nuevoEstado === '4-cancelada') {
        return ($tipo === 'D' ? 'REVPEN' : 'COCINS');
    } elseif ($nuevoEstado === '3-completada') {
        return ($tipo === 'D' ? 'FIN' : 'COCLIS');
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

    // Actualizar el estado y la descripción en la tabla de fletes
    $query = "UPDATE servicios SET estado = ?, descripcion = ? WHERE idserviciotecnico = ?";
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

    echo "<script>window.location.replace('tecnico.php')</script>";
} else {
    http_response_code(400);
    echo "Solicitud incorrecta";
}
?>