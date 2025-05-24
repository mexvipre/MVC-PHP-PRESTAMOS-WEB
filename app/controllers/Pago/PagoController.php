<?php
require_once __DIR__ . '/../../models/Contrato/Contrato.php';

$accion = $_GET['accion'] ?? null;

if ($accion === 'listarPorContrato') {
    $idcontrato = $_GET['idcontrato'] ?? null;
    if (!$idcontrato) {
        echo json_encode(['success' => false, 'message' => 'Falta idcontrato']);
        exit;
    }

    $contrato = new Contrato();
    $respuesta = $contrato->listarCuotasConPagos($idcontrato);

    if ($respuesta['success']) {
   
        echo json_encode([
            'success' => true,
            'pagos' => $respuesta['cuotas']
        ]);
    } else {
        echo json_encode([
            'success' => false,
            'message' => $respuesta['message'] ?? 'Error desconocido'
        ]);
    }
    exit;
}
?>
