<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "fornaxpost");

if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Realiza una consulta para obtener los reclamos de la base de datos
$sql = "SELECT r.id, r.dni, r.fecha, r.serial, r.descripcion, e.idestado, e.nombre AS estado, e.descripcion AS estado_descripcion, e.responsable AS estado_responsable 
        FROM reclamos AS r
        JOIN estados AS e ON r.idestado = e.idestado
        ORDER BY e.responsable";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reclamos</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="logo-fornax-png.png">
        </div>
        <nav class="menu">
            <div class="nav-links">
                <a href="../admin.php">Volver</a>
            </div>
            <div class="nav-links">
                <a href="../../reclamos/cliente.php">Alta manual</a>
            </div>
        </nav>
    </div>
    <div class="table-container">
        <h1>Reclamos</h1>
        <div class="search-bar">
            <input type="text" id="dniSearch" placeholder="Buscar por DNI o Estado">
            <button class='boton' onclick="buscarReclamosPorDNI()">Buscar</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI del denunciante</th>
                    <th class="wider-cell">Fecha de alta</th>
                    <th>Serial del producto</th>
                    <th>Descripción del reclamo</th>
                    <th>Responsable</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id='reclamosTable'>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td class='cliente-link' data-dni='" . $row["dni"] . "'>" . $row["dni"] . "</td>";
                        echo "<td>" . $row["fecha"] . "</td>";
                        echo "<td class='artefacto-link' data-serial='" . $row["serial"] . "'>" . $row["serial"] . "</td>";
                        echo "<td>" . $row["descripcion"] . "</td>";
                        echo "<td>" . $row["estado_responsable"] . "</td>";
                        echo "<td>" . $row["estado"] . "</td>";
                        echo "<td><button class='boton' onclick='actualizarReclamo(" . $row["id"] . ")'>Actualizar</button></td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='9'>No hay reclamos disponibles.</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>
    <div id="cliente-modal" class="modal">
        <div class="modal-content">
        </div>
    </div>
    <div id="artefacto-modal" class="modal">
        <div class="modal-content">
        </div>
    </div>
    <script>
        function buscarReclamosPorDNI() {
            const dniEstado = document.getElementById('dniSearch').value.toLowerCase();
            const filas = document.querySelectorAll('#reclamosTable tr');
            filas.forEach(function (fila) {
                const columnaDNI = fila.querySelector('.cliente-link').textContent.toLowerCase();
                const columnaSerial = fila.querySelector('.artefacto-link').textContent.toLowerCase();
                const columnaEstado = fila.cells[6].textContent.toLowerCase();
                if (columnaDNI.includes(dniEstado) || columnaSerial.includes(dniEstado) || columnaEstado.includes(dniEstado)) {
                    fila.style.display = 'table-row';
                } else {
                    fila.style.display = 'none';
                }
            });
        }

        function actualizarReclamo(idReclamo) {
            const idEstado = document.getElementById(`idestado_${idReclamo}`).value;
            if (!idEstado) {
                alert('Por favor, complete el campo de Estado.');
                return;
            }
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'actualizar_reclamos.php';
            const idEstadoInput = document.createElement('input');
            idEstadoInput.type = 'hidden';
            idEstadoInput.name = 'idestado';
            idEstadoInput.value = idEstado;
            const reclamoIdInput = document.createElement('input');
            reclamoIdInput.type = 'hidden';
            reclamoIdInput.name = 'reclamo_id';
            reclamoIdInput.value = idReclamo;
            form.appendChild(idEstadoInput);
            form.appendChild(reclamoIdInput);
            document.body.appendChild(form);
            form.submit();
        }

        // JavaScript para abrir el modal al hacer clic en un DNI de cliente
        const clienteLinks = document.querySelectorAll('.cliente-link');
        const clienteModal = document.getElementById('cliente-modal');

        clienteLinks.forEach((link) => {
            link.addEventListener('click', function () {
                const dni = this.getAttribute('data-dni');

                // Llama a detalle_cliente.php con el parámetro DNI
                fetch(`detalle_cliente.php?dni=${dni}`)
                    .then((response) => response.text())
                    .then((data) => {
                        // Actualiza el contenido del modal con los detalles del cliente
                        const modalContent = clienteModal.querySelector('.modal-content');
                        modalContent.innerHTML = '<span class="close-modal" onclick="cerrarModal(\'cliente-modal\')">&times;</span>' + data;

                        // Muestra el modal
                        clienteModal.style.display = 'block';
                    })
                    .catch((error) => {
                        console.error('Error al cargar los detalles del cliente:', error);
                    });
            });
        });

        // JavaScript para abrir el modal al hacer clic en el número de serie del artefacto
        const artefactoLinks = document.querySelectorAll('.artefacto-link');
        const artefactoModal = document.getElementById('artefacto-modal');

        artefactoLinks.forEach((link) => {
            link.addEventListener('click', function () {
                const serial = this.getAttribute('data-serial');

                // Llama a detalle_artefacto.php con el parámetro Serial
                fetch(`detalle_artefacto.php?serial=${serial}`)
                    .then((response) => response.text())
                    .then((data) => {
                        // Actualiza el contenido del modal con los detalles del artefacto
                        const modalContent = artefactoModal.querySelector('.modal-content');
                        modalContent.innerHTML = '<span class="close-modal" onclick="cerrarModal(\'artefacto-modal\')">&times;</span>' + data;

                        // Muestra el modal
                        artefactoModal.style.display = 'block';
                    })
                    .catch((error) => {
                        console.error('Error al cargar los detalles del artefacto:', error);
                    });
            });
        });

        function cerrarModal(modalId) {
            const modal = document.getElementById(modalId);
            modal.style.display = 'none';
        }

        // JavaScript para cerrar el modal al hacer clic fuera del modal
        window.addEventListener('click', function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });
    </script>
</body>

</html>