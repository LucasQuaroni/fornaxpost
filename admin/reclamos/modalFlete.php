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
                <select id="tipo" name="tipo">
                    <option value="R">Retirar</option>
                    <option value="D">Llevar</option>
                </select>
            </div>

            <div class="linea">
                <p for="responsable">Responsable:</p>
                <select id="responsable" name="responsable">
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
                <select id="reclamo" name="reclamo">
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

            <button type="submit">Guardar Orden</button>
        </form>
    </div>
</div>