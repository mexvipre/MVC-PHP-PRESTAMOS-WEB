<?php
require_once realpath(__DIR__ . '/../../../config/conexion.php');


$idcontrato = 1; // De Max

$q1 = $conn->query("SELECT COUNT(*) AS total FROM pagos WHERE idcontrato = $idcontrato AND fechapago IS NULL");
$pendientes = $q1->fetch_assoc()['total'];

$q2 = $conn->query("SELECT SUM(monto + penalidad) AS total FROM pagos WHERE idcontrato = $idcontrato AND fechapago IS NULL");
$deuda = $q2->fetch_assoc()['total'];

$q3 = $conn->query("SELECT COUNT(*) AS total FROM pagos WHERE idcontrato = $idcontrato AND fechapago IS NOT NULL");
$realizados = $q3->fetch_assoc()['total'];

$q4 = $conn->query("SELECT COUNT(*) AS total FROM pagos WHERE idcontrato = $idcontrato AND fechapago IS NOT NULL AND medio = 'efectivo'");
$efectivo = $q4->fetch_assoc()['total'];

$q5 = $conn->query("SELECT SUM(penalidad) AS total FROM pagos WHERE idcontrato = $idcontrato AND medio = 'deposito' AND penalidad > 0");
$penalidades = $q5->fetch_assoc()['total'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard de Max</title>
    <style>
        body { font-family: Arial; background: #f9f9f9; padding: 40px; }
        .card { background: #fff; border-left: 5px solid #007bff; margin-bottom: 20px; padding: 20px; box-shadow: 0 0 5px rgba(0,0,0,0.1); }
        h1 { color: #444; }
    </style>
</head>
<body>
    <h1>📊 Dashboard de Max</h1>

    <div class="card">🕓 Pagos pendientes: <strong><?= $pendientes ?></strong></div>
    <div class="card">💰 Deuda actual: <strong>S/ <?= number_format($deuda, 2) ?></strong></div>
    <div class="card">✅ Pagos realizados: <strong><?= $realizados ?></strong></div>
    <div class="card">💵 Pagos en efectivo: <strong><?= $efectivo ?></strong></div>
    <div class="card">⚠️ Penalidades por depósito: <strong>S/ <?= number_format($penalidades, 2) ?></strong></div>
</body>
</html>
