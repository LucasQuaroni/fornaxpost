<?php
$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Realiza una consulta para obtener los reclamos de la base de datos
$sql = "SELECT r.id, r.dni, r.fecha, r.serial, r.descripcion, r.idestado, e.responsable, e.nombre AS estado, e.descripcion AS estado_desc, u.nombreYapellido AS responsable_nombre
        FROM reclamos r
        LEFT JOIN estados e ON r.idestado = e.idestado
        LEFT JOIN usuarios u ON e.responsable = u.idusuario
        ORDER BY r.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["dni"] . "</td>";
        echo "<td>" . $row["fecha"] . "</td>";
        echo "<td>" . $row["serial"] . "</td>";
        echo "<td>" . $row["descripcion"] . "</td>";
        echo "<td>" . $row["responsable_nombre"] . "</td>";
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