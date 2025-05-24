<?php
require_once __DIR__ . '/../../models/Contrato/Contrato.php';

class ContratoController {
    private $model;

    public function __construct() {
        $this->model = new Contrato();
    }

    public function listar() {
        $contratos = $this->model->listar();
        include __DIR__ . '/../../views/contrato/listar.php';
    }

    public function guardar() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idbeneficiario = $_POST['idbeneficiario'] ?? null;
            $monto = $_POST['monto'] ?? null;
            $interes = $_POST['interes'] ?? 0.00;
            $fechainicio = $_POST['fechainicio'] ?? null;
            $diapago = $_POST['diapago'] ?? null;
            $numcuotas = $_POST['numcuotas'] ?? null;
            $estado = $_POST['estado'] ?? 'activo';

            // Validar datos mínimos
            if (!$idbeneficiario || !$monto || !$fechainicio || !$diapago || !$numcuotas) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'msg' => 'Faltan datos requeridos']);
                exit;
            }

            $res = $this->model->crear($idbeneficiario, $monto, $interes, $fechainicio, $diapago, $numcuotas, $estado);

            header('Content-Type: application/json');
            if ($res) {
                echo json_encode(['success' => true, 'msg' => 'Contrato registrado correctamente']);
            } else {
                echo json_encode(['success' => false, 'msg' => 'Error al registrar contrato']);
            }
            exit;
        }
    }
}

// Uso simple si se accede directamente:
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    $controller = new ContratoController();

    // Asumiendo que usas ?action=guardar o listar para decidir
    $action = $_GET['action'] ?? 'listar';

    if ($action === 'guardar') {
        $controller->guardar();
    } else {
        $controller->listar();
    }
}
