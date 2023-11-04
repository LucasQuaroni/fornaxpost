<?php
$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Realiza una consulta para obtener los reclamos de la base de datos
$sql = "SELECT fletes.idflete, fletes.tipo, fletes.direccion, fletes.descripcion, fletes.estado, fletes.idchofer, fletes.idreclamo, usuarios.nombreYapellido as responsable FROM fletes INNER JOIN usuarios ON fletes.idchofer = usuarios.idusuario ORDER BY idflete";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
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
        echo "<td><button class='boton' onclick='actualizarReclamo(" . $row["idflete"] . ")'>Actualizar</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hay reclamos disponibles.</td></tr>";
}

// Cierra la conexión a la base de datos
$conn->close();
?>