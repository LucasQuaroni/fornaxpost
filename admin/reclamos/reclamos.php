<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/login.php");
    exit;
}
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
                include('consultar_reclamos.php');
                ?>
            </tbody>
        </table>
    </div>
    <script>
        function buscarReclamosPorDNI() {
            const dniEstado = document.getElementById('dniSearch').value.toLowerCase(); // Obtener el valor de búsqueda

            // Obtener todas las filas de la tabla
            const filas = document.querySelectorAll('#reclamosTable tr');

            // Iterar sobre las filas y ocultar/mostrar según el DNI o el estado
            filas.forEach(function (fila) {
                const columnaDNI = fila.cells[1].textContent.toLowerCase(); // Obtener DNI en la fila

                // Obtener el valor del select del estado
                const selectEstado = fila.querySelector(`#idestado_${fila.cells[0].textContent}`);
                console.log(selectEstado.value)
                // Obtener el valor seleccionado en el select del estado
                const estadoSeleccionado = selectEstado.value;

                // Si el DNI o el estado en la fila o el estado seleccionado contiene el texto buscado, mostrar la fila; de lo contrario, ocultarla.
                if (columnaDNI.includes(dniEstado) || estadoSeleccionado.includes(dniEstado)) {
                    fila.style.display = 'table-row'; // Mostrar la fila
                } else {
                    fila.style.display = 'none'; // Ocultar la fila
                }
            });
        }



        function actualizarReclamo(idReclamo) {
            // Recopila los valores de ID Admin e ID Estado desde la fila
            const idAdmin = document.getElementById(`idadmin_${idReclamo}`).value;
            const idEstado = document.getElementById(`idestado_${idReclamo}`).value;

            // Verifica si los campos están completos
            if (!idAdmin || !idEstado) {
                alert('Por favor, complete ambos campos.');
                return;
            }

            // Crea un formulario y agrega los campos
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = 'actualizar_reclamos.php';

            const idAdminInput = document.createElement('input');
            idAdminInput.type = 'hidden';
            idAdminInput.name = 'idadmin';
            idAdminInput.value = idAdmin;

            const idEstadoInput = document.createElement('input');
            idEstadoInput.type = 'hidden';
            idEstadoInput.name = 'idestado';
            idEstadoInput.value = idEstado;

            const reclamoIdInput = document.createElement('input');
            reclamoIdInput.type = 'hidden';
            reclamoIdInput.name = 'reclamo_id';
            reclamoIdInput.value = idReclamo;

            form.appendChild(idAdminInput);
            form.appendChild(idEstadoInput);
            form.appendChild(reclamoIdInput);

            // Agrega el formulario al cuerpo del documento y envíalo
            document.body.appendChild(form);
            form.submit();
        }

    </script>
</body>

</html>