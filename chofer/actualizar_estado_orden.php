<?php
function obtenerEstadoReclamoSegunTipo($nuevoEstado, $tipo)
{
    // Implementa la lógica para determinar el estado del reclamo según el tipo y el nuevo estado
    if ($nuevoEstado === '4-cancelada') {
        return ($tipo === 'R' ? 'RETIMP' : 'ENVIMP');
    } elseif ($nuevoEstado === '3-completada') {
        return ($tipo === 'R' ? 'ENFAB' : 'FIN');
    }
}

function actualizarEstadoReclamo($reclamoID, $nuevoEstadoReclamo, $conn)
{
    // Implementa la lógica para actualizar el estado del reclamo en la tabla de reclamos
    $query = "UPDATE reclamos SET idestado = ?, responsable = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("si", $nuevoEstadoReclamo, $reclamoID);
    $stmt->execute();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Obtener los valores del formulario
    $ordenID = $_POST['orden_id'];
    $nuevoEstado = $_POST['nuevo_estado'];
    $descripcion = $_POST['descripcion'];
    $reclamoID = $_POST['reclamo_id'];
    $tipoOrden = $_POST['tipo_orden']; // Agregamos la variable para el tipo de orden

    // Realizar las operaciones de actualización en la base de datos
    $conn = new mysqli("localhost", "root", "", "fornaxpost");

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error);
    }

    // Actualizar el estado y la descripción en la tabla de fletes
    $query = "UPDATE fletes SET estado = ?, descripcion = ? WHERE idflete = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssi", $nuevoEstado, $descripcion, $ordenID);
    $stmt->execute();

    // Verifica si la actualización de la tabla de fletes fue exitosa o maneja errores, si es necesario
    if ($stmt->affected_rows > 0) {
        // Actualización de la tabla de fletes exitosa
    } else {
        // Error en la actualización de la tabla de fletes
    }
    $stmt->close();

    // Verificar el nuevo estado y realizar actualizaciones en la tabla de reclamos según la lógica que proporcionaste
    if (($nuevoEstado === '4-cancelada' || $nuevoEstado === '3-completada') && $reclamoID !== false) {
        // Actualizar el estado del reclamo usando la función con el tipo de orden
        $estadoReclamo = obtenerEstadoReclamoSegunTipo($nuevoEstado, $tipoOrden);
        actualizarEstadoReclamo($reclamoID, $estadoReclamo, $conn);
    }
    // Cierra la conexión a la base de datos
    $conn->close();

    // Devuelve una respuesta de éxito o error, según sea necesario
    echo "<script>alert('Actualización exitosa')</script>"; // Puedes personalizar el mensaje de acuerdo a tu lógica
    echo "<script>window.location.replace('chofer.php')</script>"; // Puedes personalizar la redirección de acuerdo a tu lógica
} else {
    // Respuesta de error si se intenta acceder a esta página de manera incorrecta
    http_response_code(400);
    echo "Solicitud incorrecta";
}
?>