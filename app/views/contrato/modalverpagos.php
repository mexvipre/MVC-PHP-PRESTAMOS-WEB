<!-- Modal para ver pagos -->
<div class="modal fade" id="modalVerPagos" tabindex="-1" aria-labelledby="modalVerPagosLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalVerPagosLabel">Pagos del Prestamo</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body" id="contenidoPagos">
        <!-- Contenido de pagos cargado por JS -->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap Bundle JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.querySelectorAll('.btn-ver-pagos').forEach(button => {
    button.addEventListener('click', function() {
        const contratoId = this.getAttribute('data-id');
        const nombreBeneficiario = this.getAttribute('data-nombre');
        const monto = parseFloat(this.getAttribute('data-monto'));
        const interesAnual = parseFloat(this.getAttribute('data-interes'));
        const numCuotas = parseInt(this.getAttribute('data-numcuotas'));

        const modalBody = document.getElementById('contenidoPagos');
        const modalTitle = document.getElementById('modalVerPagosLabel');

        modalTitle.textContent = `Pagos del Contrato - ${nombreBeneficiario}`;
        modalBody.innerHTML = `<p>Cargando pagos...</p>`;

        if (isNaN(monto) || isNaN(interesAnual) || isNaN(numCuotas) || numCuotas <= 0) {
            modalBody.innerHTML = `<p class="text-danger">Datos inválidos para calcular la cuota.</p>`;
            return;
        }

        function calcularCuotaSistemaFrances(monto, interesMensual, numCuotas) {
            if (interesMensual === 0) {
                return Number((monto / numCuotas).toFixed(2));
            } else {
                const factor = Math.pow(1 + interesMensual, numCuotas);
                return Number((monto * (interesMensual * factor) / (factor - 1)).toFixed(2));
            }
        }

        // Interés mensual en decimal
        const interesMensualDecimal = interesAnual / 100;

        const cuotaMensual = calcularCuotaSistemaFrances(monto, interesMensualDecimal, numCuotas);
        const totalAPagar = cuotaMensual * numCuotas;
        const interesTotal = totalAPagar - monto;

        const modal = new bootstrap.Modal(document.getElementById('modalVerPagos'));
        modal.show();

        fetch(`http://localhost/rest-api-prestamos/app/controllers/Pago/PagoController.php?accion=listarPorContrato&idcontrato=${contratoId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const pagos = data.pagos || [];

                    const resumenHTML = `
                      <div class="card mb-2 p-2" style="font-size: 0.85rem;">
                        <h6 class="mb-2 text-center" style="font-size: 0.9rem;">Resumen del Contrato</h6>
                        <div class="row text-center gx-2 gy-1">
                          <div class="col-6 col-md-3"><strong>Capital</strong><br>S/. ${monto.toFixed(2)}</div>
                          <div class="col-6 col-md-3"><strong>Interés mensual</strong><br>${interesAnual.toFixed(2)}%</div>
                          <div class="col-6 col-md-3"><strong>Plazo (cuotas)</strong><br>${numCuotas}</div>
                          <div class="col-6 col-md-3"><strong>Cuota mensual</strong><br>S/. ${cuotaMensual.toFixed(2)}</div>
                          <div class="col-6 col-md-3"><strong>Total a pagar</strong><br>S/. ${totalAPagar.toFixed(2)}</div>
                          <div class="col-6 col-md-3"><strong>Interés total</strong><br>S/. ${interesTotal.toFixed(2)}</div>
                        </div>
                      </div>
                      <hr class="my-2">
                    `;

                    if (pagos.length > 0) {
                        let tablaHTML = `
                            <table class="table table-bordered table-striped table-sm" style="font-size:0.85rem;">
                                <thead>
                                    <tr>
                                        <th>ID Pago</th>
                                        <th>Cuota</th>
                                        <th>Fecha Pago</th>
                                        <th>Monto</th>
                                        <th>Penalidad</th>
                                        <th>Medio</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                        `;

                        pagos.forEach(pago => {
                            const estado = pago.fechapago ? 'Pagado' : 'Pendiente';
                            const fechaPago = pago.fechapago ?? '-';
                            const montoPago = pago.monto ? parseFloat(pago.monto).toFixed(2) : '-';
                            const penalidad = pago.penalidad ? parseFloat(pago.penalidad).toFixed(2) : '0.00';
                            const medio = pago.medio ?? '-';

                            tablaHTML += `
                                <tr>
                                    <td>${pago.idpago ?? '-'}</td>
                                    <td>${pago.numero_cuota ?? '-'}</td>
                                    <td>${fechaPago}</td>
                                    <td>S/. ${montoPago}</td>
                                    <td>S/. ${penalidad}</td>
                                    <td>${medio}</td>
                                    <td>${estado}</td>
                                </tr>
                            `;
                        });

                        tablaHTML += '</tbody></table>';
                        modalBody.innerHTML = resumenHTML + tablaHTML;
                    } else {
                        modalBody.innerHTML = resumenHTML + `<p style="font-size: 0.85rem;">No hay pagos registrados para este contrato.</p>`;
                    }
                } else {
                    modalBody.innerHTML = `<p class="text-danger" style="font-size: 0.85rem;">Error al cargar los pagos. Intente más tarde.</p>`;
                }
            })
            .catch(() => {
                modalBody.innerHTML = `<p class="text-danger" style="font-size: 0.85rem;">Error al cargar los pagos. Intente más tarde.</p>`;
            });
    });
});
</script>
