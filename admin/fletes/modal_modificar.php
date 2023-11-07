<div id="miModalModificar" class="modal">
    <div class="modal-content">
        <span class="close" id="cerrarModalModificar">&times;</span>
        <h2>Modificar Orden de Flete</h2>
        <form id="formularioOrdenFlete" action="guardar_flete.php" method="POST">
            <div class="linea">
                <p for="direccion">Dirección:</p>
                <input type="text" id="direccionModificar" name="direccion" required>
            </div>

            <div class="linea">
                <p for="descripcion">Descripción:</p>
                <input type="text" id="descripcionModificar" name="descripcion" required>
            </div>

            <div class="linea">
                <p for="tipo">Tipo:</p>
                <select id="tipoModificar" name="tipo">
                    <option value="R">Retirar</option>
                    <option value="D">Llevar</option>
                </select>
            </div>

            <div class="linea">
                <p for="responsable">Responsable:</p>
                <select id="responsableModificar" name="responsable" required>
                    <!-- Opciones de responsables aquí -->
                </select>
            </div>

            <div class="linea">
                <p for="reclamo">Reclamo:</p>
                <select id="reclamoModificar" name="reclamo">
                    <!-- Opciones de reclamos aquí -->
                </select>
            </div>

            <div class="linea">
                <p for="estado">Estado:</p>
                <select id="estadoModificar" name="estado" required>
                    <option value="asignada">Asignada</option>
                    <option value="pendiente">Pendiente</option>
                    <option value="completada">Completada</option>
                    <option value="cancelada">Cancelada</option>
                </select>
            </div>

            <input type="hidden" id="idFlete" name="idFlete">
            <button type="submit">Guardar Cambios</button>
        </form>
    </div>
</div>
<script>
    // Función para llenar los selects con opciones de responsables y reclamos
    function llenarSelects() {
        var selectResponsable = document.getElementById("responsableModificar");
        var selectReclamo = document.getElementById("reclamoModificar");

        // Llenar el select de responsables
        responsables.forEach(function (responsable) {
            var option = document.createElement("option");
            option.value = responsable.idusuario;
            option.text = responsable.nombreYapellido;
            selectResponsable.appendChild(option);
        });

        // Llenar el select de reclamos
        reclamos.forEach(function (reclamo) {
            var option = document.createElement("option");
            option.value = reclamo.id;
            option.text = reclamo.id + " - " + reclamo.nombre;
            selectReclamo.appendChild(option);
        });
    }

    // Llamar a la función para llenar los selects al cargar la página
    llenarSelects();
</script>