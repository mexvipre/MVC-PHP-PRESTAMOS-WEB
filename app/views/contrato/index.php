<?php
require_once __DIR__ . '/../../models/Contrato/Contrato.php';
require_once __DIR__ . '/../../models/Beneficiario/Beneficiario.php';

$model = new Contrato();
$contratos = $model->listar();

$modelBen = new Beneficiario();
$beneficiarios = $modelBen->listarSinContrato();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Contratos</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
    <!-- Font Awesome CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
</head>
<body>

<div class="container my-4">

    <!-- Cabecera con botón para registrar contrato -->
    <div class="card-body d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Lista de Contratos</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroContratoModal">
            Registrar Contrato
        </button>
    </div>

    <?php if (empty($contratos)): ?>
        <p class="mt-3">No hay contratos registrados.</p>
    <?php else: ?>
        <table class="table table-bordered table-hover mt-3">
            <caption>Contratos Registrados</caption>
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Beneficiario</th>
                    <th>Monto</th>
                    <th>Interés (%)</th>
                    <th>Fecha de Pagos</th>
                    <th>Día de Pago</th>
                    <th>Cuotas</th>
                    <th>Estado</th>
                    <th>Creado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($contratos as $cont): ?>
                <tr>
                    <td><?= htmlspecialchars($cont['idcontrato']) ?></td>
                    <td><?= htmlspecialchars($cont['apellidos'] . ', ' . $cont['nombres']) ?></td>
                    <td><?= number_format($cont['monto'], 2) ?></td>
                    <td><?= number_format($cont['interes'], 2) ?></td>
                    <td><?= htmlspecialchars($cont['fechainicio']) ?></td>
                    <td><?= htmlspecialchars($cont['diapago']) ?></td>
                    <td><?= htmlspecialchars($cont['numcuotas']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($cont['estado'])) ?></td>
                    <td><?= htmlspecialchars($cont['creado']) ?></td>
                    <td class="text-center">
                        <button 
                            class="btn btn-sm btn-outline-success btn-ver-pagos" 
                            title="Ver Pagos" 
                            data-id="<?= $cont['idcontrato'] ?>"
                            data-nombre="<?= htmlspecialchars($cont['apellidos'] . ', ' . $cont['nombres']) ?>"
                            data-monto="<?= $cont['monto'] ?>"
                            data-interes="<?= $cont['interes'] ?>"
                            data-numcuotas="<?= $cont['numcuotas'] ?>"
                        >
                            <i class="fas fa-sack-dollar"></i>
                        </button>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<!-- Modal para registrar contrato -->
<?php include __DIR__ . '/modal_registrar.php'; ?>
<?php include __DIR__ . '/modalverpagos.php'; ?>


</body>
</html>
