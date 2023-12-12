<div id="miModalModificar" class="modal">
    <div class="modal-content">
        <span class="close" id="cerrarModalModificar">&times;</span>
        <h2>Modificar Orden de Servicio Tecnico</h2>
        <form id="formularioOrdenServicioTecnico" action="guardar_servicio.php" method="POST" class="login">
            <div class="linea">
                <p for="tipo">Tipo:</p>
                <select id="tipoModificar" name="tipo">
                    <option value="F">En fabrica</option>
                    <option value="D">A domicilio</option>
                </select>
            </div>

            <div class="linea">
                <p for="direccion">Dirección:</p>
                <input type="text" id="direccionModificar" name="direccion">
            </div>

            <div class="linea">
                <p for="descripcion">Descripción:</p>
                <input type="text" id="descripcionModificar" name="descripcion" required>
            </div>

            <div class="linea">
                <p for="estado">Estado:</p>
                <select id="estadoModificar" name="estado" required>
                    <option value="1-asignada">Asignada</option>
                    <option value="2-pendiente">Pendiente</option>
                    <option value="3-completada">Completada</option>
                    <option value="4-cancelada">Cancelada</option>
                </select>
            </div>

            <div class="linea">
                <p for="responsable">Responsable:</p>
                <select id="responsableModificar" name="responsable" required>
                </select>
            </div>

            <div class="linea">
                <p for="reclamo">Reclamo:</p>
                <select id="reclamoModificar" name="reclamo">
                </select>
            </div>

            <input type="hidden" id="idServicioTecnico" name="idServicioTecnico">
            <button type="submit" class="button">Guardar Cambios</button>
        </form>
    </div>
</div>
<script>
    //llenar los selects con opciones de responsables y reclamos
    function llenarSelects() {
        var selectResponsable = document.getElementById("responsableModificar");
        var selectReclamo = document.getElementById("reclamoModificar");

        responsables.forEach(function (responsable) {
            var option = document.createElement("option");
            option.value = responsable.idusuario;
            option.text = responsable.nombreYapellido;
            selectResponsable.appendChild(option);
        });

        // Llenar el select de reclamos
        reclamos.forEach(function (reclamo) {
            var option = document.createElement("option");
            if (reclamo.nombre == 'T - Reparacion pendiente' || reclamo.nombre == 'T - Visita pendiente') {
                option.value = reclamo.id;
                option.text = reclamo.id + " - " + reclamo.nombre;
                selectReclamo.appendChild(option);
            }
        });
    }

    //llenar los selects al cargar la página
    llenarSelects();
</script>