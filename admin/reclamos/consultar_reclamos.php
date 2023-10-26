<?php

$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Realiza una consulta para obtener los reclamos de la base de datos
$sql = "SELECT * FROM reclamos ORDER BY idadmin";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["id"] . "</td>";
        echo "<td>" . $row["dni"] . "</td>";
        echo "<td>" . $row["fecha"] . "</td>";
        echo "<td>" . $row["serial"] . "</td>";
        echo "<td>" . $row["descripcion"] . "</td>";

        // Consulta para obtener opciones de "RESPONSABLE" desde la base de datos
        $sqlAdmins = "SELECT idusuario, usuario, rol FROM usuarios";
        $resultAdmins = $conn->query($sqlAdmins);
        echo "<td><select id='idadmin_" . $row["id"] . "'>";
        while ($admin = $resultAdmins->fetch_assoc()) {
            $selected = ($admin['idusuario'] == $row['idadmin']) ? 'selected' : '';
            echo "<option value='" . $admin["idusuario"] . "' $selected>" . $admin["usuario"] . " - " . $admin["rol"] ."</option>";
        }
        echo "</select></td>";

        // Consulta para obtener opciones de "ESTADO" desde la base de datos
        $sqlEstados = "SELECT idestado, nombre FROM estados";
        $resultEstados = $conn->query($sqlEstados);
        echo "<td><select id='idestado_" . $row["id"] . "'>";
        while ($estado = $resultEstados->fetch_assoc()) {
            $selected = ($estado['idestado'] == $row['idestado']) ? 'selected' : '';
            echo "<option value='" . $estado["nombre"] . "' $selected>" . $estado["nombre"] . "</option>";
        }
        echo "</select></td>";

        echo "<td><button class='boton' onclick='actualizarReclamo(" . $row["id"] . ")'>Actualizar</button></td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>No hay reclamos disponibles.</td></tr>";
}

// Cierra la conexión a la base de datos
$conn->close();
?>
