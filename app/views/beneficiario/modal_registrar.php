<!-- app/views/beneficiario/modal_registrar.php -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="formRegistrar">
        <div class="modal-header">
          <h5 class="modal-title" id="registroModalLabel">Registrar Nuevo Beneficiario</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
            <div class="mb-3">
                <label for="apellidos" class="form-label">Apellidos</label>
                <input type="text" name="apellidos" id="apellidos" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombres" class="form-label">Nombres</label>
                <input type="text" name="nombres" id="nombres" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="dni" class="form-label">DNI</label>
                <input type="text" name="dni" id="dni" class="form-control" maxlength="8" required>
            </div>
            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono</label>
                <input type="text" name="telefono" id="telefono" class="form-control" maxlength="9" required>
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

<!-- Incluye SweetAlert2 desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('formRegistrar').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://localhost/rest-api-prestamos/app/controllers/Beneficiario/BeneficiarioController.php?accion=crear', {
        method: 'POST',
        body: formData
    })

    .then(response => response.json())
    .then(data => {
        if(data.success){
            Swal.fire({
                icon: 'success',
                title: '¡Registrado!',
                text: 'El beneficiario ha sido registrado correctamente.',
                timer: 2000,
                showConfirmButton: false
            }).then(() => {
                location.reload(); // Recarga la página para actualizar lista
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.message || 'Ocurrió un error al registrar.'
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
