<div id="custom-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h2>Actualizar Estado de la Orden</h2>
        <form id="form-actualizar-orden" method="post" action="actualizar_estado_orden.php" class="login">
            <div class="form-group">
                <label for="nuevo-estado">Nuevo Estado:</label>
                <select id="nuevo-estado" name="nuevo_estado">
                    <option value="1-asignada">Asignada</option>
                    <option value="2-pendiente">Pendiente</option>
                    <option value="3-completada">Completada</option>
                    <option value="4-cancelada">Cancelada</option>
                </select>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción (opcional):</label>
                <textarea id="descripcion" name="descripcion" rows="4"></textarea>
            </div>
            <input type="hidden" id="orden-id" name="orden_id" value="">
            <input type="hidden" id="reclamo-id" name="reclamo_id" value="">
            <input type="hidden" id="tipo-orden" name="tipo_orden" value="">
            <button type="submit" id="guardar-orden">Guardar</button>
        </form>
    </div>
</div>