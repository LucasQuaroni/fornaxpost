<?php
$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Realiza una consulta para obtener los reclamos de la base de datos
$sql = "SELECT r.id, r.dni, r.fecha, r.serial, r.descripcion, r.idestado, r.responsable, e.idestado, e.nombre AS estado, e.descripcion AS estado_desc, u.nombreYapellido as responsable_nombre, u.rol AS responsable_rol
        FROM reclamos r
        LEFT JOIN estados e ON r.idestado = e.idestado
        LEFT JOIN usuarios u ON r.responsable = u.idusuario
        ORDER BY r.id";

$result = $conn->query($sql);

// Consultas para obtener los posibles responsables
$sqlResponsables = "SELECT * FROM usuarios WHERE rol = 'Responsable'";
$resultResponsables = $conn->query($sqlResponsables);
$responsables = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $idestado = $row['idestado'];
        $estados = [];

        if ($idestado == 'PEN') {
            $estados = [
                'VISPEN',
                'RETPEN',
            ];
        } elseif ($idestado == 'VISPEN') {
            $estados = [
                'REVPEN',
                'FIN',
            ];
        } elseif ($idestado == 'REVPEN' || $idestado == 'RETIMP') {
            $estados = [
                'CAN',
                'RETPEN',
            ];
        } elseif ($idestado == 'RETPEN') {
            $estados = [
                'ENFAB',
                'RETIMP',
            ];
        } elseif ($idestado == 'ENFAB') {
            $estados = [
                'REPPEN',
            ];
        } elseif ($idestado == 'REPPEN') {
            $estados = [
                'COCINS',
                'COCLIS',
            ];
        } elseif ($idestado == 'COCINS' || $idestado == 'ENVIMP') {
            $estados = [
                'CAN',
                'ENVPEN',
            ];
        } elseif ($idestado == 'COCLIS') {
            $estados = [
                'ENVPEN',
            ];
        } elseif ($idestado == 'ENVPEN') {
            $estados = [
                'FIN',
                'ENVIMP',
            ];
        }

        // Ahora obtén los nombres de los estados
        $sqlEstados = "SELECT * FROM estados WHERE idestado IN ('" . implode("', '", $estados) . "')";
        $resultEstados = $conn->query($sqlEstados);
        $estados = [];
        while ($estadoRow = $resultEstados->fetch_assoc()) {
            $estados[] = $estadoRow;
        }

        // Agregar la información a las variables globales
        $row['posibles_estados'] = $estados;
        $row['responsables'] = $responsables;

        echo "<tr data-id='" . $row["id"] . "' data-dni='" . $row["dni"] . "' data-fecha='" . $row["fecha"] . "' data-serial='" . $row["serial"] . "' data-descripcion='" . $row["descripcion"] . "' data-estado='" . $row["idestado"] . "' data-responsable='" . $row["responsable"] . "'>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td><a class='cliente-link' data-dni='" . $row["dni"] . "'>" . $row["dni"] . "</a></td>";
        echo "<td>" . date('d-m-Y', strtotime($row["fecha"])) . "</td>";
        echo "<td><a class='artefacto-link' data-serial='" . $row["serial"] . "'>" . $row["serial"] . "</a></td>";
        echo "<td>" . $row["descripcion"] . "</td>";
        echo "<td>" . $row["responsable_rol"] . " - " . $row["responsable_nombre"] . "</td>";
        echo "<td>" . $row["estado"] . "</td>";
        echo "<td><button class='boton' onclick='actualizarReclamo(" . $row["id"] . ")'>Actualizar</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hay reclamos disponibles.</td></tr>";
}

// Cierra la conexión a la base de datos
$conn->close();
?>

<script>
    var estados = <?php echo json_encode($estados); ?>;
    var responsables = <?php echo json_encode($responsables); ?>;
</script>