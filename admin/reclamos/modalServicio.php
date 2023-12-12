<div id="miModalServicio" class="modal">
    <div class="modal-content">
        <h2>Alta Manual de Orden de Servicio Técnico</h2>
        <form id="formularioOrdenServicio" action="guardar_servicio.php" method="POST" class="login">
            <div class="linea">
                <p for="descripcion">Descripción:</p>
                <input type="text" id="descripcion" name="descripcion" required>
            </div>


            <div class="linea">
                <p for="tipo">Tipo:</p>
                <select id="tipo" name="tipo" readonly>
                    <option value="F">En fabrica</option>
                    <option value="D">A domicilio</option>
                </select>
            </div>

            <div class="linea">
                <p for="direccion">Dirección:</p>
                <input type="text" id="direccion" name="direccion">
            </div>

            <div class="linea">
                <p for="responsable">Responsable:</p>
                <select id="responsable" name="responsable" readonly>
                    <?php
                    include("../../conexion.php");

                    $queryResponsables = "SELECT idusuario, nombreYapellido FROM usuarios WHERE rol = 'T'";
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

                    $queryReclamos = "SELECT reclamos.id as id, estados.nombre as nombre FROM reclamos INNER JOIN estados ON reclamos.idestado = estados.idestado WHERE reclamos.idestado = 'REPPEN' OR reclamos.idestado = 'VISPEN'";
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
            <input type="hidden" id="reclamoIdServicio" name="reclamoIdServicio">
            <input type="hidden" id="responsableIdServicio" name="responsableIdServicio">
            <button type="submit">Guardar Orden</button>
        </form>
    </div>
</div>
<script>
    // Script para asignar valores a campos ocultos
    var reclamoIdServicio = document.getElementById("miModalServicio").getAttribute("data-reclamo-id");
    var responsableIdServicio = document.getElementById("miModalServicio").getAttribute("data-responsable-id");

    document.getElementById("reclamoIdServicio").value = reclamoIdServicio;
    document.getElementById("responsableIdServicio").value = responsableIdServicio;

    // Validación dinámica para el tipo según el estado
    var estadoServicio = "<?php echo $nuevoEstado; ?>";

    if (estadoServicio === 'VISPEN') {
        // Si el estado es VISPEN, establece el tipo como "A domicilio"
        document.getElementById("tipo").value = "D";
    } else if (estadoServicio === 'REPPEN') {
        // Si el estado es REPPEN, establece el tipo como "En fabrica"
        document.getElementById("tipo").value = "F";
    }
</script>