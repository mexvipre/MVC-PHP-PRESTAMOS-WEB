create database prestamos;
use prestamos;

CREATE TABLE beneficiarios (
    idbeneficiario INT AUTO_INCREMENT PRIMARY KEY,
	apellidos VARCHAR(50) NOT NULL,
    nombres VARCHAR(50) NOT NULL,
    dni VARCHAR(8) NOT NULL,
    telefono varchar (9) not null,
    creado datetime not null default now(),
    MODIFICADO datetime   NULL,
    constraint uk_dni_ben unique (dni)


)ENGINE = INNODB;

CREATE TABLE contratos (
    idcontrato INT AUTO_INCREMENT PRIMARY KEY,
    idbeneficiario INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    interes DECIMAL(5,2) DEFAULT 0.00,
    fechainicio DATE NOT NULL,
    diapago tinyint not null,
    numcuotas tinyint not null comment 'expresado en meses',
    estado enum ('activo', 'finalizado') not null default 'activo',
    creado DATETIME NOT NULL DEFAULT NOW(),
    modificado DATETIME NULL,
    
    CONSTRAINT fk_contrato_beneficiario FOREIGN KEY (idbeneficiario)
        REFERENCES beneficiarios(idbeneficiario)
) ENGINE = INNODB;



CREATE TABLE pagos (
    idpago INT AUTO_INCREMENT PRIMARY KEY,
    idcontrato INT NOT NULL,
    numero_cuota TINYINT NOT NULL COMMENT 'se debe cancelar  la cuota total  sin amortizaciones',
    fechapago DATEtime  NULL comment'fecha efectiva de pago',
    monto DECIMAL(7,2) NOT NULL,
    penalidad decimal (7,2) not null default 0 comment '10% de valor de cuota',
    medio enum('efectivo','deposito') null,
    CONSTRAINT fk_pago_contrato FOREIGN KEY (idcontrato)
        REFERENCES contratos(idcontrato),
        
	CONSTRAINT uk_numcuota_pag unique (idcontrato,numero_cuota)
) ENGINE = INNODB;


INSERT INTO beneficiarios (apellidos, nombres, dni, telefono)
VALUES ('Rojas Huarcaya', 'Max', '72672071', '928209520');


INSERT INTO contratos (
    idbeneficiario, monto, interes, fechainicio, diapago, numcuotas
)
VALUES (
    1, 3000, 5, '2025-05-01', 15, 12
);


INSERT INTO pagos (
    idcontrato,
    numero_cuota,
    fechapago,
    monto,
    penalidad,
    medio
)
VALUES
(1, 1, '2025-04-15 10:00:00', 338.48, 0, 'efectivo'),
(1, 2, '2025-05-17 10:00:00', 338.48, 33.85, 'deposito'),
(1, 3, NULL, 338.48, 0.00, null),
(1, 4, NULL, 338.48, 0.00, null),
(1, 5, NULL, 338.48, 0.00, null),
(1, 6, NULL, 338.48, 0.00, null),
(1, 7, NULL, 338.48, 0.00, null),
(1, 8, NULL, 338.48, 0.00, null),
(1, 9, NULL, 338.48, 0.00, null),
(1,10, NULL, 338.48, 0.00, null),
(1,11, NULL, 338.48, 0.00, null),
(1,12, NULL, 338.48, 0.00, null);




-- 1. ¿Cuántos pagos tiene pendiente MAX?
SELECT COUNT(*) AS pagos_pendientes
FROM pagos 
WHERE idcontrato = 1 AND fechapago IS NULL;

-- 2. ¿Cuánto es el total de la deuda actual?
SELECT SUM(monto) AS deuda_actual
FROM pagos 
WHERE idcontrato = 1 AND fechapago IS NULL;

-- 3. ¿Cuántos pagos se han realizado?
SELECT COUNT(*) AS pagos_realizados
FROM pagos 
WHERE idcontrato = 1 AND fechapago IS NOT NULL;

-- 4. ¿Cuántos pagos se realizaron en EFECTIVO?
SELECT COUNT(*) AS pagos_efectivo
FROM pagos 
WHERE idcontrato = 1 AND fechapago IS NOT NULL AND medio = 'efectivo';

-- 5. ¿Cuánto es el total de penalidad pagadas con DEPÓSITO?
SELECT SUM(penalidad) AS penalidad_deposito
FROM pagos 
WHERE idcontrato = 1 AND medio = 'deposito' AND penalidad > 0;

















