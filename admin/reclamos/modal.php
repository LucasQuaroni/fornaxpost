<div id="modal-actualizar" class="modal">
    <div class="modal-content">
        <span class="close" onclick="cerrarModal('modal-actualizar')">&times;</span>
        <h2>Actualizar Reclamo</h2>
        <form id="formulario-actualizar" method="POST" action="guardar_reclamo.php">
            <div class="linea">
                <p>DNI del denunciante:</p>
                <input type="number">
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
                <p>Estado:</p>
                <select name="estado" id="estado"></select>
            </div>
            <div class="linea">
                <p>Responsable:</p>
                <select name="responsable" id="responsable"></select>
            </div>
            <input type="hidden" id="reclamoId" name="reclamoId">
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>