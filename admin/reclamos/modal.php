<div id="modal-actualizar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal('modal-actualizar')">&times;</span>
        <h2>Actualizar Reclamo</h2>
        <form id="formulario-actualizar" method="POST" action="guardar_reclamo.php">
            <div class="linea">
                <p>DNI del denunciante:</p>
                <input type="number" name="dni" id="dni">
            </div>
            <div class="linea">
                <p>Fecha de alta:</p>
                <input type="date" name="fecha" id="fecha">
            </div>
            <div class="linea">
                <p>Serial del producto:</p>
                <input type="text" name="serial" id="serial">
            </div>
            <div class="linea">
                <p>Descripción del reclamo:</p>
                <input type="text" name="descripcion" id="descripcion">
            </div>
            <div class="linea">
                <div class="extra">
                    <p>Estado:</p>
                    <select name="estado" id="estado" onchange="cargarResponsablesPorEstado()">
                        <?php foreach ($estados as $estado) { ?>
                            <option value="<?php echo $estado['idestado']; ?>">
                                <?php echo $estado['nombre']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="extra">
                    <p>Responsable:</p>
                    <select name="responsable" id="responsable">
                        <?php foreach ($responsables as $responsable) { ?>
                            <option value="<?php echo $responsable['idusuario']; ?>">
                                <?php echo $responsable['nombreYapellido']; ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <input type="hidden" id="reclamoId" name="reclamoId">
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>
<script>
    // JavaScript para cargar responsables según el estado seleccionado
    function cargarResponsablesPorEstado() {
        const estadoSelect = document.getElementById('estado');
        const estadoSeleccionado = estadoSelect.value;

        // Filtra y carga los responsables disponibles para el estado seleccionado
        cargarResponsables(estadoSeleccionado);
    }
</script>