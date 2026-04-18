# 🚕 Proyecto CarreraTaxi - Ingeniería de Software

Este proyecto es el resultado del trabajo realizado para la asignatura de **Ingeniería de Software** en la **Universidad de Cartagena**. Se trata de una aplicación web desarrollada en PHP 8 que aplica conceptos avanzados como **Domain-Driven Design (DDD)** y **Arquitectura Hexagonal**, con el objetivo de gestionar las carreras de una empresa de taxis de manera eficiente y escalable.

---

## 📋 Información del Proyecto

| Campo | Detalle |
|---|---|
| **Asignatura** | Ingeniería de Software |
| **Ejercicio asignado** | CarreraTaxi |
| **Entidad principal** | `Carrera` (cliente, taxi, kilómetros, barrioInicio, barrioLlegada, cantidadPasajeros, taxista, precio, duracionMinutos) |
| **Arquitectura** | Hexagonal (Ports & Adapters) |
| **Paradigma** | Domain-Driven Design (DDD) |
| **Stack** | PHP 8.1+ · MySQL · PDO · Composer (PSR-4) |

---

## 🏗️ Arquitectura Hexagonal

El proyecto separa el código en tres capas bien definidas:

```
📦 CarreraTaxi/
├── src/
│   ├── Carrera/
│   │   ├── Domain/                        ← 🔴 NÚCLEO (sin dependencias externas)
│   │   │   ├── Carrera.php                  Entidad de dominio
│   │   │   └── CarreraRepository.php        Puerto (interfaz de persistencia)
│   │   ├── Application/                   ← 🟡 CASOS DE USO
│   │   │   ├── CreateCarreraUseCase.php
│   │   │   ├── ListCarrerasUseCase.php
│   │   │   ├── FindCarreraByIdUseCase.php
│   │   │   ├── UpdateCarreraUseCase.php
│   │   │   └── DeleteCarreraUseCase.php
│   │   └── Infrastructure/Persistence/    ← 🟢 ADAPTADOR MySQL
│   │       └── PdoCarreraRepository.php
│   │
│   └── User/
│       ├── Domain/                        ← 🔴 NÚCLEO
│       │   ├── User.php
│       │   ├── UserRepository.php
│       │   └── EmailSender.php            Puerto para correos
│       ├── Application/                   ← 🟡 CASOS DE USO
│       │   ├── AuthService.php            Login / Logout / Sesión
│       │   ├── RegisterUserUseCase.php
│       │   ├── ChangePasswordUseCase.php
│       │   └── PasswordRecoveryUseCase.php
│       └── Infrastructure/               ← 🟢 ADAPTADORES
│           ├── Persistence/
│           │   └── PdoUserRepository.php
│           └── Mail/
│               └── FileEmailAdapter.php   Mock: guarda emails en disco
│
├── config/
│   └── database.php                       Configuración PDO
├── database/
│   └── schema.sql                         Esquema completo de la BD
├── views/                                 Vistas compartidas (layout)
├── logs/emails/                           Correos simulados (desarrollo)
│
├── index.php          → Listado de carreras
├── registrar.php      → Crear carrera
├── editar.php         → Editar carrera
├── login.php          → Inicio de sesión
├── logout.php         → Cerrar sesión
├── cambiar-password.php    → Cambiar contraseña
└── olvide-password.php     → Recuperar contraseña (simulado)
```

---

## ⚙️ Requisitos

- PHP 8.1 o superior
- MySQL 5.7 o superior
- Composer
- Servidor web: Apache (XAMPP, WAMP, Laragon) o Nginx

---

## 🚀 Instalación

### 1. Clonar el repositorio

```bash
git clone https://github.com/egomezg-udc/CarreraTaxi.git
cd CarreraTaxi
```

### 2. Instalar dependencias (Autoload PSR-4)

```bash
composer install
```

### 3. Crear la base de datos

Ejecuta el script en MySQL (desde phpMyAdmin o terminal):

```bash
mysql -u root -p < database/schema.sql
```

O copia y pega el contenido de `database/schema.sql` en tu cliente MySQL.

### 4. Configurar la conexión

Edita `config/database.php`:

```php
$host     = 'localhost';
$dbname   = 'ingenieria_software_carreras_taxi';
$user     = 'root';       // tu usuario MySQL
$password = '';           // tu contraseña MySQL
```

### 5. Colocar en el servidor web

Mueve o enlaza la carpeta dentro de `htdocs/` (XAMPP) o `www/` (WAMP/Laragon):

```
htdocs/CarreraTaxi/
```

### 6. Acceder desde el navegador

```
http://localhost/CarreraTaxi/login.php
```

> **Usuario por defecto:** `admin@carreras.com` | **Contraseña:** `Admin1234`  
> *(Recuerda crear el usuario con `RegisterUserUseCase` o insertarlo directamente en la BD)*

---

## 📌 Funcionalidades Implementadas

### CRUDL de Carreras
| Operación | Archivo | Caso de Uso |
|---|---|---|
| ➕ Crear | `registrar.php` | `CreateCarreraUseCase` |
| 📋 Listar | `index.php` | `ListCarrerasUseCase` |
| ✏️ Editar | `editar.php` | `UpdateCarreraUseCase` |
| 🗑️ Eliminar | `index.php?delete=` | `DeleteCarreraUseCase` |
| 🔍 Buscar por ID | (interno) | `FindCarreraByIdUseCase` |

### Módulo de Usuarios y Autenticación
| Funcionalidad | Archivo | Servicio/Caso de Uso |
|---|---|---|
| 🔐 Inicio de sesión | `login.php` | `AuthService::login()` |
| 🚪 Cerrar sesión | `logout.php` | `AuthService::logout()` |
| 🔒 Cambiar contraseña | `cambiar-password.php` | `ChangePasswordUseCase` |
| 📧 Recuperar contraseña | `olvide-password.php` | `PasswordRecoveryUseCase` + `FileEmailAdapter` |

### Recuperación de Contraseña (Simulación)

Se implementó siguiendo el principio de **Inversión de Dependencias**:

- **`EmailSender`** (Dominio): Interfaz/Puerto que define el contrato.
- **`FileEmailAdapter`** (Infraestructura): Adaptador Mock que guarda los "correos" en `logs/emails/*.txt` en lugar de enviarlos por SMTP.
- Para pasar a producción, bastará con crear un `PhpMailerAdapter` o `SendGridAdapter` implementando la misma interfaz, **sin modificar ninguna línea de la capa de Aplicación o Dominio**.

---

## 🗃️ Esquema de la Base de Datos

```sql
-- Tabla de usuarios
CREATE TABLE users (
    id            INT AUTO_INCREMENT PRIMARY KEY,
    nombre        VARCHAR(255) NOT NULL,
    email         VARCHAR(255) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,           -- bcrypt
    rol           ENUM('admin', 'taxista') DEFAULT 'taxista',
    created_at    TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de carreras
CREATE TABLE carreras (
    id                INT AUTO_INCREMENT PRIMARY KEY,
    cliente           VARCHAR(255)   NOT NULL,
    taxi              VARCHAR(100)   NOT NULL,
    kilometros        DECIMAL(10,2)  NOT NULL,
    barrioInicio      VARCHAR(255)   NOT NULL,
    barrioLlegada     VARCHAR(255)   NOT NULL,
    cantidadPasajeros INT            NOT NULL,
    taxista           VARCHAR(255)   NOT NULL,
    precio            DECIMAL(10,2)  NOT NULL,
    duracionMinutos   INT            NOT NULL,
    created_at        TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

---

## 🌿 Flujo de Trabajo Git

Se siguió el estándar de **commits atómicos** y **ramas por funcionalidad**:

| Rama | Descripción |
|---|---|
| `main` | Rama principal (solo recibe merges vía PR) |
| `feat/domain-layer` | Entidad Carrera + repositorio + casos de uso + vistas CRUDL |
| `feat/auth-login-module` | User entity, AuthService, Login/Logout/CambiarPassword |
| `feat/integracion-final` | Composer PSR-4 autoloading |
| `feat/password-recovery-sim` | Email mock adapter + PasswordRecoveryUseCase |
| `docs/readme-final` | Documentación del proyecto |

Convención de commits: **Conventional Commits** (`feat`, `fix`, `chore`, `docs`).

---

## 🧪 Verificar el Simulador de Correo

1. Ir a `http://localhost/CarreraTaxi/olvide-password.php`
2. Ingresar el email de un usuario registrado
3. Revisar la carpeta `logs/emails/`
4. Abrir el archivo `.txt` generado — contiene el enlace de recuperación

---

## 📜 Licencia

Proyecto académico — Universidad. Todos los derechos reservados.
