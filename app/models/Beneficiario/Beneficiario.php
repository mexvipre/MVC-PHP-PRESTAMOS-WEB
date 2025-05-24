<?php
require_once __DIR__ . '/../../../config/conexion.php';

class Beneficiario {
    private $conn;

    public function __construct() {
        global $conn;  // usar la conexión global desde conexion.php
        $this->conn = $conn;
    }


    public function crear($apellidos, $nombres, $dni, $telefono) {
    try {
        $sql = "INSERT INTO beneficiarios (apellidos, nombres, dni, telefono) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($sql);
        return $stmt->execute([$apellidos, $nombres, $dni, $telefono]);
    } catch (PDOException $e) {
        // Si es un error por clave duplicada o similar, puedes capturarlo aquí
        return false;
    }
}

public function listarSinContrato() {
    $sql = "SELECT * FROM beneficiarios 
            WHERE idbeneficiario NOT IN (
                SELECT idbeneficiario FROM contratos WHERE estado = 'activo'
            )
            ORDER BY idbeneficiario DESC";

    $result = $this->conn->query($sql);

    if (!$result) {
        die("Error en consulta: " . $this->conn->error);
    }

    $beneficiarios = [];

    while ($row = $result->fetch_assoc()) {
        $beneficiarios[] = $row;
    }
    return $beneficiarios;
}



    public function listar() {
        $sql = "SELECT * FROM beneficiarios ORDER BY idbeneficiario DESC";
        $result = $this->conn->query($sql);

        if (!$result) {
            die("Error en consulta: " . $this->conn->error);
        }

        $beneficiarios = [];

        while ($row = $result->fetch_assoc()) {
            $beneficiarios[] = $row;
        }
        return $beneficiarios;
    }
}

// Bloque de prueba para ver si funciona
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    $model = new Beneficiario();
    $data = $model->listar();
    echo '<pre>';
    var_dump($data);
    echo '</pre>';
}
