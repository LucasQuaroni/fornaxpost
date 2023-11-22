<?php
include("../../conexion.php");

$queryResponsables = "SELECT idusuario, nombreYapellido FROM usuarios WHERE rol = 'C'";
$resultResponsables = $conn->query($queryResponsables);

//consulta para obtener los reclamos
$queryReclamos = "SELECT reclamos.id as id, estados.nombre as nombre FROM reclamos INNER JOIN estados ON reclamos.idestado = estados.idestado";
$resultReclamos = $conn->query($queryReclamos);

// consulta para obtener los reclamos de la base de datos
$sql = "SELECT fletes.idflete, fletes.tipo, fletes.direccion, fletes.descripcion, fletes.estado, fletes.idchofer, fletes.idreclamo, usuarios.nombreYapellido as responsable FROM fletes INNER JOIN usuarios ON fletes.idchofer = usuarios.idusuario ORDER BY fletes.estado";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-idflete='" . $row["idflete"] . "' data-direccion='" . $row["direccion"] . "' data-descripcion='" . $row["descripcion"] . "' data-tipo='" . $row["tipo"] . "' data-responsable='" . $row["responsable"] . "' data-responsable-id='" . $row["idchofer"] . "' data-reclamo='" . $row["idreclamo"] . "'>";
        echo "<td>" . $row["idflete"] . "</td>";
        if ($row["tipo"] == 'R') {
            echo "<td>" . 'Retirar' . "</td>";
        } elseif ($row["tipo"] == 'D') {
            echo "<td>" . 'Llevar' . "</td>";
        }
        echo "<td>" . $row["direccion"] . "</td>";
        echo "<td>" . $row["descripcion"] . "</td>";
        echo "<td>" . $row["estado"] . "</td>";
        echo "<td>" . $row["responsable"] . "</td>";
        echo "<td>" . $row["idreclamo"] . "</td>";
        echo "<td><button class='boton' onclick='abrirModificarFlete(" . $row["idflete"] . ")'>Modificar</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hay fletes disponibles.</td></tr>";
}

$conn->close();
?>
<script>
    var responsables = <?php echo json_encode($resultResponsables->fetch_all(MYSQLI_ASSOC)); ?>;
    var reclamos = <?php echo json_encode($resultReclamos->fetch_all(MYSQLI_ASSOC)); ?>;
</script>