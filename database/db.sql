CREATE DATABASE IF NOT EXISTS hospital_pro;
USE hospital_pro;

-- 2. TABLAS NÚCLEO
CREATE TABLE roles (
    id_rol INT PRIMARY KEY, 
    nombre_rol VARCHAR(50)
);

INSERT INTO roles VALUES (1, 'Administrador'), (2, 'Operativo');

CREATE TABLE usuarios (
    id_user INT PRIMARY KEY AUTO_INCREMENT,
    nombre_completo VARCHAR(100),
    username VARCHAR(50) UNIQUE,
    password VARCHAR(255),
    fk_rol INT,
    fecha_registro DATE,
    FOREIGN KEY (fk_rol) REFERENCES roles (id_rol)
);

INSERT INTO usuarios (nombre_completo, username, password, fk_rol, fecha_registro)
VALUES 
('Ana Garcia', 'admin_ana', '12345', 1, '2024-01-10'),
('Luis Perez', 'oper_luis', '12345', 2, '2024-01-15'),
('Maria Lopez', 'admin_maria', '12345', 1, '2024-02-01');

-- 3. TABLAS DE PROCESOS
CREATE TABLE pacientes (
    id_paciente INT PRIMARY KEY AUTO_INCREMENT,
    nombre VARCHAR(100),
    edad INT,
    genero ENUM ('M', 'F', 'Otro'),
    eps VARCHAR(50),
    fecha_ingreso DATE
);

INSERT INTO pacientes VALUES 
(NULL, 'Juanito Alimaña', 5, 'M', 'Sura', '2024-03-01'),
(NULL, 'Pepa Pig', 25, 'F', 'Coomeva', '2024-03-02'),
(NULL, 'Pedro Picapiedra', 45, 'M', 'Sura', '2024-03-02');

CREATE TABLE pqr_quejas (
    id_pqr INT PRIMARY KEY AUTO_INCREMENT,
    tipo VARCHAR(50),
    estado VARCHAR(20),
    id_paciente INT,
    fecha DATE,
    FOREIGN KEY (id_paciente) REFERENCES pacientes(id_paciente)
);

INSERT INTO pqr_quejas VALUES 
(NULL, 'Queja', 'Pendiente', 1, '2024-03-05'),
(NULL, 'Sugerencia', 'Resuelta', 2, '2024-03-06');

CREATE TABLE citas_medicas (
    id_cita INT PRIMARY KEY AUTO_INCREMENT, -- CORREGIDO: AUTO_INCREMENT
    especialidad VARCHAR(50),
    estado_cita VARCHAR(20), 
    fecha DATE,
    id_paciente INT,
    FOREIGN KEY (id_paciente) REFERENCES pacientes (id_paciente)
);

INSERT INTO citas_medicas VALUES 
(NULL, 'Pediatría', 'Cumplida', '2024-03-10', 1),
(NULL, 'Odontologia', 'Cancelada', '2024-03-11', 2);

CREATE TABLE medicamentos (
    id_med INT PRIMARY KEY AUTO_INCREMENT,
    nombre_med VARCHAR(100),
    stock_actual INT,
    stock_minimo INT,
    precio DECIMAL(10,2)
);

INSERT INTO medicamentos VALUES 
(NULL, 'Acetaaminofén Jarabe', 50, 100, 15000.00),
(NULL, 'Ibuprofeno 500mg', 200, 50, 800.00);

CREATE TABLE medicos (
    id_medico INT PRIMARY KEY AUTO_INCREMENT,
    nombre_medico VARCHAR(100),
    especialidad VARCHAR(50),
    turno VARCHAR(20) -- CORREGIDO: Comentarios
);

INSERT INTO medicos VALUES 
(NULL, 'Dr.House', 'Diagnóstico', 'Noche'),
(NULL, 'Dra.Polo', 'Pediatría', 'Mañana');

CREATE TABLE facturacion (
    id_factura INT PRIMARY KEY AUTO_INCREMENT,
    metodo_pago VARCHAR(50),
    monto DECIMAL(10, 2), -- CORREGIDO: Coma y estructura
    fecha_pago DATE
);

INSERT INTO facturacion VALUES 
(NULL, 'Efectivo', 50000.00, '2024-03-01'),
(NULL, 'Tarjeta', 120000.00, '2024-03-02');

CREATE TABLE laboratorio (
    id_lab INT PRIMARY KEY AUTO_INCREMENT,
    tipo_examen VARCHAR(50),
    resultado VARCHAR(20), 
    fecha DATE
);

INSERT INTO laboratorio VALUES 
(NULL, 'Sangre', 'Normal', '2024-03-05'),
(NULL, 'Orina', 'Alterado', '2024-03-06');

CREATE TABLE camas_hosp (
    id_cama INT PRIMARY KEY AUTO_INCREMENT,
    piso INT,
    estado_cama VARCHAR(20) 
);

INSERT INTO camas_hosp VALUES 
(NULL, 1, 'Ocupada'),
(NULL, 2, 'Libre');

CREATE TABLE proveedores (
    id_prov INT PRIMARY KEY AUTO_INCREMENT, -- CORREGIDO: PRIMARY
    nombre_empresa VARCHAR(100),
    monto_deuda DECIMAL(10, 2),
    calificacion INT 
);

INSERT INTO proveedores VALUES 
(NULL, 'Meditech SA', 5000000, 5),
(NULL, 'Farmasur', 200000, 3);

CREATE TABLE ambulancias (
    id_amb INT PRIMARY KEY AUTO_INCREMENT,
    placa VARCHAR(10),
    km_recorrido INT,
    estado_mecanico VARCHAR(20) 
);

INSERT INTO ambulancias VALUES 
(NULL, 'XYC-123', 15000, 'Bueno'),
(NULL, 'ABC-789', 45000, 'Dañado');

CREATE TABLE insumos_aseo (
    id_aseo INT PRIMARY KEY AUTO_INCREMENT,
    articulo VARCHAR(50),
    cantidad INT,
    area_uso VARCHAR(50)
);

INSERT INTO insumos_aseo VALUES 
(NULL, 'Jabón Quirúrgico', 20, 'Urgencias'),
(NULL, 'Cloro', 5, 'Pisos');

CREATE TABLE historia_clin (
    id_hist INT PRIMARY KEY AUTO_INCREMENT,
    enfermedad VARCHAR(100),
    alergias VARCHAR(100),
    id_paciente INT,
    FOREIGN KEY (id_paciente) REFERENCES pacientes (id_paciente)
);

INSERT INTO historia_clin VALUES 
(NULL, 'Gripa Aviar', 'Polvo', 1),
(NULL, 'Gastritis', 'Ninguna', 2);

CREATE TABLE recetas (
    id_receta INT PRIMARY KEY AUTO_INCREMENT,
    id_medico INT,
    cantidad_med INT,
    fecha_receta DATE,
    FOREIGN KEY (id_medico) REFERENCES medicos (id_medico)
);

INSERT INTO recetas VALUES 
(NULL, 1, 3, '2024-03-08'),
(NULL, 2, 1, '2024-03-09');

CREATE TABLE nomina_pers (
    id_nom INT PRIMARY KEY AUTO_INCREMENT,
    cargo VARCHAR(50),
    sueldo DECIMAL(10, 2),
    faltas INT,
    fk_user INT, -- CORREGIDO: Se agregó la columna para la relación
    FOREIGN KEY (fk_user) REFERENCES usuarios (id_user)
);

INSERT INTO nomina_pers VALUES 
(NULL, 'Enfermera', 2500000, 0, 1),
(NULL, 'Secretaria', 1300000, 2, 2);

CREATE TABLE emergencias (
    id_em INT PRIMARY KEY AUTO_INCREMENT,
    triaje INT, 
    tiempo_espera_min INT,
    fecha DATE
);

INSERT INTO emergencias VALUES 
(NULL, 1, 5, '2024-03-10'),
(NULL, 4, 120, '2024-03-10');

CREATE TABLE equipos_med (
    id_equipo INT PRIMARY KEY AUTO_INCREMENT,
    nombre_equipo VARCHAR(100),
    estado_uso VARCHAR(20), 
    dias_para_mantenimiento INT
);

INSERT INTO equipos_med VALUES 
(NULL, 'Resonador Magnético', 'En uso', 5),
(NULL, 'Monitor Signos', 'Disponible', 30);