<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}

include("../../conexion.php");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reclamos</title>
    <link rel="stylesheet" href="../../estilos.css">
</head>

<body>
    <div class="header">
        <div class="logo">
            <img src="../../resources/logo-fornax-png.png">
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
                    <th>Estado</th>
                    <th>Responsable</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id='reclamosTable'>
                <?php include 'consultar_reclamos.php'; ?>
            </tbody>
        </table>
    </div>
    <div id="cliente-modal" class="modal">
        <div class="modal-content-chico">
        </div>
    </div>
    <div id="artefacto-modal" class="modal">
        <div class="modal-content-chico">
        </div>
    </div>
    <?php include 'modal.php'; ?>
    <script>
        // Cuando se abre el modal
        document.body.classList.add("modal-open");

        // Cuando se cierra el modal
        document.body.classList.remove("modal-open");

        //abrir el modal al hacer clic en el botón "Actualizar"
        function actualizarReclamo(reclamoId) {
            const filaReclamo = document.querySelector(`#reclamosTable tr[data-id="${reclamoId}"]`);
            const estadoActual = filaReclamo.getAttribute('data-estado');

            // Llenar los campos del modal con los datos obtenidos
            document.getElementById('reclamoId').value = reclamoId;
            document.getElementById('dni').value = filaReclamo.getAttribute('data-dni');
            document.getElementById('fecha').value = filaReclamo.getAttribute('data-fecha');
            document.getElementById('serial').value = filaReclamo.getAttribute('data-serial');
            document.getElementById('descripcion').value = filaReclamo.getAttribute('data-descripcion');
            document.getElementById('estado').value = estadoActual;

            //responsables disponibles para el estado actual
            cargarResponsables(estadoActual, filaReclamo.getAttribute('data-responsable'));

            // Abrir el modal de actualización
            const modalActualizar = document.getElementById('modal-actualizar');
            modalActualizar.style.display = 'block';
        }

        //responsables disponibles según el estado seleccionado
        function cargarResponsables(estadoActual, responsableActual) {
            const responsablesFiltrados = responsables.filter((responsable) => {
                return (
                    (responsable['rol'] === 'C' && ['RETPEN', 'ENVPEN'].includes(estadoActual)) ||
                    (responsable['rol'] === 'T' && ['VISPEN', 'REPPEN'].includes(estadoActual)) ||
                    (responsable['rol'] === 'A' && ['FIN', 'CAN', 'PEN', 'REVPEN', 'RETIMP', 'ENFAB', 'COCINS', 'COCLIS', 'ENVIMP'].includes(estadoActual))
                );
            });

            const selectResponsable = document.getElementById('responsable');
            selectResponsable.innerHTML = '';

            //opciones de responsables filtrados
            responsablesFiltrados.forEach((responsable) => {
                const option = document.createElement('option');
                option.value = responsable['idusuario'];
                option.text = responsable['nombreYapellido'];

                if (responsable['idusuario'] === responsableActual) {
                    option.selected = true;
                }

                selectResponsable.appendChild(option);
            });
        }

        function buscarReclamos() {
            const searchValue = document.getElementById('searchInput').value.toLowerCase();
            const filas = document.querySelectorAll('#reclamosTable tr');
            filas.forEach(function (fila) {
                const columnaDNI = fila.querySelector('td:nth-child(2)').textContent.toLowerCase();
                const columnaEstado = fila.querySelector('td:nth-child(6)').textContent.toLowerCase();
                if (columnaDNI.includes(searchValue) || columnaEstado.includes(searchValue)) {
                    fila.style.display = 'table-row';
                } else {
                    fila.style.display = 'none';
                }
            });
        }

        //abrir el modal al hacer clic en un DNI de cliente
        const clienteLinks = document.querySelectorAll('.cliente-link');
        const clienteModal = document.getElementById('cliente-modal');

        clienteLinks.forEach((link) => {
            link.addEventListener('click', function () {
                const dni = this.getAttribute('data-dni');

                fetch(`detalle_cliente.php?dni=${dni}`)
                    .then((response) => response.text())
                    .then((data) => {
                        //actualiza el contenido del modal con los detalles del cliente
                        const modalContent = clienteModal.querySelector('.modal-content-chico');
                        modalContent.innerHTML = '<span class="close-modal" onclick="cerrarModal(\'cliente-modal\')">&times;</span>' + data;

                        clienteModal.style.display = 'block';
                    })
                    .catch((error) => {
                        console.error('Error al cargar los detalles del cliente:', error);
                    });
            });
        });

        //abrir el modal al hacer clic en el número de serie del artefacto
        const artefactoLinks = document.querySelectorAll('.artefacto-link');
        const artefactoModal = document.getElementById('artefacto-modal');

        artefactoLinks.forEach((link) => {
            link.addEventListener('click', function () {
                const serial = this.getAttribute('data-serial');

                fetch(`detalle_artefacto.php?serial=${serial}`)
                    .then((response) => response.text())
                    .then((data) => {
                        //actualiza el contenido del modal con los detalles del artefacto
                        const modalContent = artefactoModal.querySelector('.modal-content-chico');
                        modalContent.innerHTML = '<span class="close-modal" onclick="cerrarModal(\'artefacto-modal\')">&times;</span>' + data;

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

        //cerrar el modal al hacer clic fuera del modal
        window.addEventListener('click', function (event) {
            if (event.target.classList.contains('modal')) {
                event.target.style.display = 'none';
            }
        });
    </script>
</body>

</html>