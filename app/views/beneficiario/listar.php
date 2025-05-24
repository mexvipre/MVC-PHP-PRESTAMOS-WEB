<?php
require_once __DIR__ . '/../../models/Beneficiario/Beneficiario.php';

$model = new Beneficiario();
$beneficiarios = $model->listar();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <title>Lista de Beneficiarios</title>
    <!-- Bootstrap CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>
<body>

<div class="container my-4">



    <!-- Card con botón para registrar -->
    <div class="card-body d-flex justify-content-between align-items-center">
        <h1 class="mb-0">Lista de Beneficiarios</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#registroModal">
            Registrar Beneficiario
        </button>
    </div>


    <?php if (empty($beneficiarios)): ?>
        <p>No hay beneficiarios registrados.</p>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <caption>Beneficiarios Registrados</caption>
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Apellidos</th>
                    <th>Nombres</th>
                    <th>DNI</th>
                    <th>Teléfono</th>
                    <th>Creado</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($beneficiarios as $ben): ?>
                <tr>
                    <td><?= htmlspecialchars($ben['idbeneficiario']) ?></td>
                    <td><?= htmlspecialchars($ben['apellidos']) ?></td>
                    <td><?= htmlspecialchars($ben['nombres']) ?></td>
                    <td><?= htmlspecialchars($ben['dni']) ?></td>
                    <td><?= htmlspecialchars($ben['telefono']) ?></td>
                    <td><?= htmlspecialchars($ben['creado']) ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

<!-- Incluimos el modal -->
<?php include __DIR__ . '/modal_registrar.php'; ?>

<!-- Bootstrap JS Bundle con Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
