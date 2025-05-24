<?php
require_once __DIR__ . '/../../models/Beneficiario/Beneficiario.php';

class BeneficiarioController {
    private $model;

    public function __construct() {
        $this->model = new Beneficiario();
    }

    public function crear() {
        // Recibir datos POST
        $apellidos = $_POST['apellidos'] ?? '';
        $nombres = $_POST['nombres'] ?? '';
        $dni = $_POST['dni'] ?? '';
        $telefono = $_POST['telefono'] ?? '';

        // Validar (puedes mejorar esta parte)
        if (!$apellidos || !$nombres || !$dni || !$telefono) {
            echo json_encode(['success' => false, 'message' => 'Faltan datos']);
            return;
        }

        // Insertar en DB usando el modelo
        $resultado = $this->model->crear($apellidos, $nombres, $dni, $telefono);

        if ($resultado) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['success' => false, 'message' => 'No se pudo registrar']);
        }
    }

    public function handleRequest() {
        $accion = $_GET['accion'] ?? '';

        if ($accion === 'crear' && $_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->crear();
        } else {
            echo json_encode(['success' => false, 'message' => 'Acción no válida']);
        }
    }
}

// Ejecutar controlador
$controller = new BeneficiarioController();
$controller->handleRequest();
