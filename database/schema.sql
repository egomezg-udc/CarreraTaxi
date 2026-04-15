-- ============================================================
-- ESQUEMA DE BASE DE DATOS - CarreraTaxi
-- Ejecutar en MySQL como usuario root
-- ============================================================

CREATE DATABASE IF NOT EXISTS ingenieria_software_carreras_taxi
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ingenieria_software_carreras_taxi;

-- Tabla de usuarios del sistema
CREATE TABLE IF NOT EXISTS users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nombre        VARCHAR(255) NOT NULL,
    email         VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    rol           ENUM('admin', 'taxista') NOT NULL DEFAULT 'taxista',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de carreras de taxi
CREATE TABLE IF NOT EXISTS carreras (
    id                 INT AUTO_INCREMENT PRIMARY KEY,
    cliente            VARCHAR(255)     NOT NULL,
    taxi               VARCHAR(100)     NOT NULL,
    kilometros         DECIMAL(10, 2)   NOT NULL,
    barrioInicio       VARCHAR(255)     NOT NULL,
    barrioLlegada      VARCHAR(255)     NOT NULL,
    cantidadPasajeros  INT              NOT NULL,
    taxista            VARCHAR(255)     NOT NULL,
    precio             DECIMAL(10, 2)   NOT NULL,
    duracionMinutos    INT              NOT NULL,
    created_at         TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Usuario admin por defecto (password: Admin1234)
-- El hash fue generado con password_hash('Admin1234', PASSWORD_BCRYPT)
INSERT INTO users (nombre, email, password_hash, rol)
VALUES (
    'Administrador',
    'admin@carrератакsi.com',
    '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
    'admin'
) ON DUPLICATE KEY UPDATE id=id;
