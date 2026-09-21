-- =========================================================
-- Esquema: Registro de Diálisis Peritoneal
-- Motor: MySQL 8.0+
-- (usa UUID() como CHAR(36) y columnas generadas STORED,
--  ambas disponibles desde MySQL 8.0)
-- =========================================================

CREATE DATABASE IF NOT EXISTS dialisis_peritoneal
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE dialisis_peritoneal;

-- ---------------------------------------------------------
-- ROLES
-- ---------------------------------------------------------
CREATE TABLE roles (
    id      INT AUTO_INCREMENT PRIMARY KEY,
    nombre  VARCHAR(30) NOT NULL UNIQUE   -- 'admin', 'paciente', etc.
) ENGINE=InnoDB;

INSERT INTO roles (nombre) VALUES ('admin'), ('paciente');

-- ---------------------------------------------------------
-- USUARIOS
-- ---------------------------------------------------------
CREATE TABLE usuarios (
    id               CHAR(36) NOT NULL DEFAULT (UUID()) PRIMARY KEY,
    nombre_completo  VARCHAR(150) NOT NULL,
    email            VARCHAR(150) NOT NULL UNIQUE,
    password_hash    VARCHAR(255) NOT NULL,
    rol_id           INT NOT NULL,
    activo           BOOLEAN NOT NULL DEFAULT TRUE,
    fecha_creacion   TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_usuarios_rol
        FOREIGN KEY (rol_id) REFERENCES roles(id)
) ENGINE=InnoDB;

CREATE INDEX idx_usuarios_rol_id ON usuarios(rol_id);

-- ---------------------------------------------------------
-- PACIENTES (extiende a usuarios con rol 'paciente')
-- ---------------------------------------------------------
CREATE TABLE pacientes (
    id                        CHAR(36) NOT NULL DEFAULT (UUID()) PRIMARY KEY,
    usuario_id                CHAR(36) NOT NULL UNIQUE,
    fecha_nacimiento          DATE NOT NULL,
    tipo_dialisis             VARCHAR(50) NOT NULL,  -- ej. 'DPCA', 'DPA'
    fecha_inicio_tratamiento  DATE,
    medico_responsable        VARCHAR(150),
    CONSTRAINT fk_pacientes_usuario
        FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- ---------------------------------------------------------
-- SESIONES DE DIÁLISIS
-- ---------------------------------------------------------
CREATE TABLE sesiones_dialisis (
    id                    CHAR(36) NOT NULL DEFAULT (UUID()) PRIMARY KEY,
    paciente_id           CHAR(36) NOT NULL,
    registrado_por        CHAR(36) NOT NULL,  -- quién capturó el dato
    fecha                 DATE NOT NULL,
    hora_inicio           TIME NOT NULL,
    hora_fin              TIME,
    tipo_solucion         VARCHAR(50),      -- ej. 'Dianeal', 'Fisiosol'
    concentracion         VARCHAR(20),      -- ej. '1.5%', '2.5%', '4.25%'
    volumen_entrada_ml    INT NOT NULL,
    volumen_salida_ml     INT,
    ultrafiltracion_ml    INT GENERATED ALWAYS AS (volumen_salida_ml - volumen_entrada_ml) STORED,
    aspecto_liquido       VARCHAR(50),      -- ej. 'claro', 'turbio', 'hemático'
    imagen_liquido_ruta   VARCHAR(500),     -- ruta/URL del archivo, no el binario
    notas                 TEXT,
    creado_en             TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_sesiones_paciente
        FOREIGN KEY (paciente_id) REFERENCES pacientes(id) ON DELETE CASCADE,
    CONSTRAINT fk_sesiones_usuario
        FOREIGN KEY (registrado_por) REFERENCES usuarios(id),
    CONSTRAINT chk_volumen_entrada CHECK (volumen_entrada_ml >= 0),
    CONSTRAINT chk_volumen_salida CHECK (volumen_salida_ml IS NULL OR volumen_salida_ml >= 0),
    CONSTRAINT chk_horario CHECK (hora_fin IS NULL OR hora_fin > hora_inicio)
) ENGINE=InnoDB;

CREATE INDEX idx_sesiones_paciente_fecha ON sesiones_dialisis(paciente_id, fecha DESC);
CREATE INDEX idx_sesiones_registrado_por ON sesiones_dialisis(registrado_por);

-- ---------------------------------------------------------
-- SIGNOS VITALES (uno o varios por sesión: inicio, fin, etc.)
-- ---------------------------------------------------------
CREATE TABLE signos_vitales (
    id                    CHAR(36) NOT NULL DEFAULT (UUID()) PRIMARY KEY,
    sesion_id             CHAR(36) NOT NULL,
    hora_toma             TIME NOT NULL,
    presion_sistolica     SMALLINT,
    presion_diastolica    SMALLINT,
    frecuencia_cardiaca   SMALLINT,
    temperatura           DECIMAL(4,1),
    peso_kg               DECIMAL(5,2),
    saturacion_oxigeno    SMALLINT,
    CONSTRAINT fk_signos_sesion
        FOREIGN KEY (sesion_id) REFERENCES sesiones_dialisis(id) ON DELETE CASCADE,
    CONSTRAINT chk_sistolica CHECK (presion_sistolica BETWEEN 40 AND 260),
    CONSTRAINT chk_diastolica CHECK (presion_diastolica BETWEEN 20 AND 200),
    CONSTRAINT chk_frec_cardiaca CHECK (frecuencia_cardiaca BETWEEN 20 AND 250),
    CONSTRAINT chk_temperatura CHECK (temperatura BETWEEN 30.0 AND 45.0),
    CONSTRAINT chk_peso CHECK (peso_kg > 0),
    CONSTRAINT chk_saturacion CHECK (saturacion_oxigeno BETWEEN 0 AND 100)
) ENGINE=InnoDB;

CREATE INDEX idx_signos_sesion_id ON signos_vitales(sesion_id);

-- =========================================================
-- Notas de uso:
-- - ultrafiltracion_ml se calcula automáticamente (salida - entrada);
--   no la insertes manualmente.
-- - Los CHECK requieren MySQL 8.0.16 o superior para aplicarse
--   realmente (antes se aceptaban pero se ignoraban).
-- - Un usuario con rol 'admin' no necesita fila en 'pacientes'.
-- - Considera agregar un rol 'cuidador' en 'roles' si alguien más
--   además del paciente registrará sesiones.
-- =========================================================
