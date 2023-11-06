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
?>

<!DOCTYPE html>
<html lang="es">

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
            <input type="text" id="searchInput" placeholder="Buscar por DNI o Estado">
            <button class='boton' onclick="buscarReclamos()">Buscar</button>
        </div>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>DNI del denunciante</th>
                    <th>Fecha de alta</th>
                    <th>Serial del producto</th>
                    <th>Descripción del reclamo</th>
                    <th>Responsable</th>
                    <th>Estado</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id='reclamosTable'>
                <?php include 'consultar_reclamos.php'; ?>
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
    <?php include 'modal.php'; ?>
    <script>
        // JavaScript para abrir el modal al hacer clic en el botón "Actualizar"
        // JavaScript para abrir el modal al hacer clic en el botón "Actualizar"
        function actualizarReclamo(reclamoId, dni, fecha, serial, descripcion, estado, responsable) {
            // Abrir el modal de actualización
            const modalActualizar = document.getElementById('modal-actualizar');
            modalActualizar.style.display = 'block';

            // Asignar el ID del reclamo al campo oculto en el formulario
            document.getElementById('reclamoId').value = reclamoId;

            // Rellenar los campos con los datos existentes del reclamo
            document.getElementById('dni').value = dni;
            document.getElementById('fecha').value = fecha;
            document.getElementById('serial').value = serial;
            document.getElementById('descripcion').value = descripcion;

            // En el campo "estado," selecciona la opción correspondiente
            const estadoSelect = document.getElementById('estado');
            for (let option of estadoSelect.options) {
                if (option.value === estado) {
                    option.selected = true;
                    break;
                }
            }

            // En el campo "responsable," selecciona la opción correspondiente
            const responsableSelect = document.getElementById('responsable');
            for (let option of responsableSelect.options) {
                if (option.value === responsable) {
                    option.selected = true;
                    break;
                }
            }
        }


        function almacenarReclamo() {
            const form = document.getElementById('formulario-actualizar');
            const formData = new FormData(form);

            fetch('guardar_reclamo.php', {
                method: 'POST',
                body: formData,
            })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                })
                .catch(error => {
                    // Manejar errores de la solicitud AJAX
                    console.error('Error al almacenar el reclamo:', error);
                });

            // Cierra el modal después de enviar el formulario
            const modalActualizar = document.getElementById('modal-actualizar');
            modalActualizar.style.display = 'none';
        }

        function buscarReclamos() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const filas = document.querySelectorAll('#reclamosTable tr');
            filas.forEach(function (fila) {
                const columnaDNI = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const columnaEstado = fila.querySelector('td:nth-child(7)').textContent.toLowerCase();
                if (columnaDNI.includes(searchValue) || columnaEstado.includes(searchValue)) {
                    fila.style.display = 'table-row';
                } else {
                    fila.style.display = 'none';
                }
            });
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