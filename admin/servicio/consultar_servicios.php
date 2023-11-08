<?php
$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Realiza una consulta para obtener los responsables
$queryResponsables = "SELECT idusuario, nombreYapellido FROM usuarios WHERE rol = 'T'";
$resultResponsables = $conn->query($queryResponsables);

// Realiza una consulta para obtener los reclamos
$queryReclamos = "SELECT reclamos.id as id, estados.nombre as nombre FROM reclamos INNER JOIN estados ON reclamos.idestado = estados.idestado";
$resultReclamos = $conn->query($queryReclamos);
// Realiza una consulta para obtener los reclamos de la base de datos
$sql = "SELECT servicios.idserviciotecnico, servicios.tipo, servicios.direccion, servicios.descripcion, servicios.estado, servicios.idtecnico, servicios.idreclamo, usuarios.nombreYapellido as responsable FROM servicios INNER JOIN usuarios ON servicios.idtecnico = usuarios.idusuario ORDER BY servicios.estado";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr data-idserviciotecnico='" . $row["idserviciotecnico"] . "' data-direccion='" . $row["direccion"] . "' data-descripcion='" . $row["descripcion"] . "' data-tipo='" . $row["tipo"] . "' data-responsable='" . $row["responsable"] . "' data-responsable-id='" . $row["idtecnico"] . "' data-reclamo='" . $row["idreclamo"] . "' data-estado='" . $row["estado"] . "'>";
        echo "<td>" . $row["idserviciotecnico"] . "</td>";
        if ($row["tipo"] == 'F') {
            echo "<td>" . 'En fabrica' . "</td>";
        } elseif ($row["tipo"] == 'D') {
            echo "<td>" . 'A domicilio' . "</td>";
        }
        echo "<td>" . $row["direccion"] . "</td>";
        echo "<td>" . $row["descripcion"] . "</td>";
        echo "<td>" . $row["estado"] . "</td>";
        echo "<td>" . $row["responsable"] . "</td>";
        echo "<td>" . $row["idreclamo"] . "</td>";
        echo "<td><button class='boton' onclick='abrirModificarServicio(" . $row["idserviciotecnico"] . ")'>Modificar</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hay reclamos disponibles.</td></tr>";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
<script>
    var responsables = <?php echo json_encode($resultResponsables->fetch_all(MYSQLI_ASSOC)); ?>;
    var reclamos = <?php echo json_encode($resultReclamos->fetch_all(MYSQLI_ASSOC)); ?>;
</script>