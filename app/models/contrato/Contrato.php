<?php
require_once __DIR__ . '/../../../config/conexion.php';

class Contrato {
    private $conn;

    public function __construct() {
        global $conn; // conexión global mysqli
        $this->conn = $conn;
    }

public function crear($idbeneficiario, $monto, $interes, $fechainicio, $diapago, $numcuotas) {
    $sql = "INSERT INTO contratos (idbeneficiario, monto, interes, fechainicio, diapago, numcuotas, creado)
            VALUES (?, ?, ?, ?, ?, ?, NOW())";

    $stmt = $this->conn->prepare($sql);
    if (!$stmt) {
        return false;
    }
    return $stmt->bind_param(
        "iddsii",
        $idbeneficiario,
        $monto,
        $interes,
        $fechainicio,
        $diapago,
        $numcuotas
    ) && $stmt->execute();
}

public function listarCuotasConPagos($idcontrato) {
    // 1. Obtener el número de cuotas del contrato
    $sqlNumCuotas = "SELECT numcuotas FROM contratos WHERE idcontrato = ?";
    $stmtNum = $this->conn->prepare($sqlNumCuotas);
    if (!$stmtNum) {
        return ['success' => false, 'message' => 'Error preparando consulta numcuotas: ' . $this->conn->error];
    }
    $stmtNum->bind_param('i', $idcontrato);
    $stmtNum->execute();
    $resultNum = $stmtNum->get_result();
    if ($resultNum->num_rows === 0) {
        return ['success' => false, 'message' => 'Contrato no encontrado'];
    }
    $rowNum = $resultNum->fetch_assoc();
    $numcuotas = (int)$rowNum['numcuotas'];
    $stmtNum->close();

    // 2. Obtener pagos realizados para el contrato
    $sqlPagos = "SELECT idpago, numero_cuota, fechapago, monto, penalidad, medio 
                 FROM pagos 
                 WHERE idcontrato = ?";
    $stmtPagos = $this->conn->prepare($sqlPagos);
    if (!$stmtPagos) {
        return ['success' => false, 'message' => 'Error preparando consulta pagos: ' . $this->conn->error];
    }
    $stmtPagos->bind_param('i', $idcontrato);
    $stmtPagos->execute();
    $resultPagos = $stmtPagos->get_result();

    $pagos = [];
    while ($pago = $resultPagos->fetch_assoc()) {
        $pagos[$pago['numero_cuota']] = $pago;
    }
    $stmtPagos->close();

    // 3. Construir array con todas las cuotas (pagadas o no)
    $cuotas = [];
    for ($i = 1; $i <= $numcuotas; $i++) {
        if (isset($pagos[$i])) {
            $cuotas[] = $pagos[$i];
        } else {
            $cuotas[] = [
                'idpago' => null,
                'numero_cuota' => $i,
                'fechapago' => null,
                'monto' => null,
                'penalidad' => 0,
                'medio' => null,
            ];
        }
    }

    return ['success' => true, 'cuotas' => $cuotas];
}


    
    public function listar() {
        $sql = "SELECT c.*, b.apellidos, b.nombres 
                FROM contratos c
                INNER JOIN beneficiarios b ON c.idbeneficiario = b.idbeneficiario
                ORDER BY c.creado DESC";

        $result = $this->conn->query($sql);

        if (!$result) {
            die("Error en consulta: " . $this->conn->error);
        }

        $contratos = [];

        while ($row = $result->fetch_assoc()) {
            $contratos[] = $row;
        }
        return $contratos;
    }
}

// Prueba rápida (opcional)
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    $model = new Contrato();
    $data = $model->listar();
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}
