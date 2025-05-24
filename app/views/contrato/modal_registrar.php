<!-- app/views/contrato/modal_registrar.php -->
<div class="modal fade" id="registroContratoModal" tabindex="-1" aria-labelledby="registroContratoModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formRegistrarContrato">
        <div class="modal-header">
          <h5 class="modal-title" id="registroContratoModalLabel">Registrar Nuevo Contrato</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">

            <div class="mb-3">
                <label for="idbeneficiario" class="form-label">Beneficiario</label>
                <select name="idbeneficiario" id="idbeneficiario" class="form-select" required>
                    <option value="">Seleccione un beneficiario</option>
                    <?php
                    // Cargar beneficiarios para el combo (se espera $beneficiarios esté definido)
                    foreach ($beneficiarios as $b) {
                        echo '<option value="' . $b['idbeneficiario'] . '">' . htmlspecialchars($b['apellidos']) . ', ' . htmlspecialchars($b['nombres']) . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="monto" class="form-label">Monto</label>
                <input type="number" step="0.01" name="monto" id="monto" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="interes" class="form-label">Interés (%)</label>
                <input type="number" step="0.01" name="interes" id="interes" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="fechainicio" class="form-label">Fecha de Inicio</label>
                <input type="date" name="fechainicio" id="fechainicio" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="diapago" class="form-label">Día de Pago</label>
                <input type="number" name="diapago" id="diapago" class="form-control" min="1" max="31" required>
            </div>

            <div class="mb-3">
                <label for="numcuotas" class="form-label">Número de Cuotas</label>
                <input type="number" name="numcuotas" id="numcuotas" class="form-control" required>
            </div>

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          <button type="submit" class="btn btn-primary">Registrar</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('formRegistrarContrato').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

fetch('http://localhost/rest-api-prestamos/app/controllers/Contrato/ContratoController.php?action=guardar', {
    method: 'POST',
    body: formData
})

    .then(response => response.json())
    .then(data => {
        if(data.success){
            Swal.fire({
                icon: 'success',
                title: '¡Registrado!',
                text: 'El contrato ha sido registrado correctamente.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload();
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Ocurrió un error al registrar el contrato.'
            });
        }
    })
    .catch(error => {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudo conectar con el servidor.'
        });
        console.error('Error:', error);
    });
});
</script>
