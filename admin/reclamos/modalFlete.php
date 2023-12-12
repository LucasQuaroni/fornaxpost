<div id="miModalFlete" class="modal">
    <div class="modal-content">
        <h2>Alta Manual de Orden de Flete</h2>
        <form id="formularioOrdenFlete" action="guardar_flete.php" method="POST" class="login">
            <div class="linea">
                <p for="direccion">Dirección:</p>
                <input type="text" id="direccion" name="direccion" required>
            </div>

            <div class="linea">
                <p for="descripcion">Descripción:</p>
                <input type="text" id="descripcion" name="descripcion" required>
            </div>

            <div class="linea">
                <p for="tipo">Tipo:</p>
                <select id="tipo" name="tipo" readonly>
                    <option value="R">Retirar</option>
                    <option value="D">Llevar</option>
                </select>
            </div>

            <div class="linea">
                <p for="responsable">Responsable:</p>
                <select id="responsable" name="responsable" readonly>
                    <?php
                    include("../../conexion.php");

                    $queryResponsables = "SELECT idusuario, nombreYapellido FROM usuarios WHERE rol = 'C'";
                    $resultResponsables = $conn->query($queryResponsables);

                    if ($resultResponsables->num_rows > 0) {
                        while ($row = $resultResponsables->fetch_assoc()) {
                            echo "<option value='" . $row['idusuario'] . "'>" . $row['nombreYapellido'] . "</option>";
                        }
                    }

                    $conn->close();
                    ?>
                </select>
            </div>

            <div class="linea">
                <p for="reclamo">Reclamo:</p>
                <select id="reclamo" name="reclamo" readonly>
                    <?php
                    include("../../conexion.php");

                    $queryReclamos = "SELECT reclamos.id as id, estados.nombre as nombre FROM reclamos INNER JOIN estados ON reclamos.idestado = estados.idestado WHERE reclamos.idestado = 'RETPEN' OR reclamos.idestado = 'ENVPEN'";
                    $resultReclamos = $conn->query($queryReclamos);

                    if ($resultReclamos->num_rows > 0) {
                        while ($row = $resultReclamos->fetch_assoc()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['id'] . " - " . $row['nombre'] . "</option>";
                        }
                    }

                    $conn->close();
                    ?>
                </select>
            </div>
            <input type="hidden" id="reclamoIdFlete" name="reclamoIdFlete">
            <input type="hidden" id="responsableIdFlete" name="responsableIdFlete">
            <button type="submit">Guardar Orden</button>
        </form>
    </div>
</div>
<script>
    // Script para asignar valores a campos ocultos
    var reclamoIdFlete = document.getElementById("miModalFlete").getAttribute("data-reclamo-id");
    var responsableIdFlete = document.getElementById("miModalFlete").getAttribute("data-responsable-id");

    document.getElementById("reclamoIdFlete").value = reclamoIdFlete;
    document.getElementById("responsableIdFlete").value = responsableIdFlete;

    // Validación dinámica para el tipo según el estado
    var estadoFlete = "<?php echo $nuevoEstado; ?>";

    if (estadoFlete === 'RETPEN') {
        // Si el estado es RETPEN, establece el tipo como "Retirar"
        document.getElementById("tipo").value = "R";
    } else if (estadoFlete === 'ENVPEN') {
        // Si el estado es ENVPEN, establece el tipo como "Llevar"
        document.getElementById("tipo").value = "D";
    }

</script>