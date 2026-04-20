<?php
declare(strict_types=1);

namespace TaxiApp\User\Infrastructure\Mail;

use TaxiApp\User\Domain\EmailSender;

/**
 * CAPA DE INFRAESTRUCTURA - Mock/Fake Email Adapter
 * 
 * Implementa el puerto EmailSender guardando los correos en disco
 * en lugar de enviarlos realmente. Ideal para entornos de desarrollo.
 * 
 * Para pasar a producción, SOLO habría que crear un PhpMailerAdapter
 * o SendGridAdapter que implemente la misma interfaz EmailSender,
 * SIN modificar ninguna línea de la lógica de negocio (Application/Domain).
 */
class FileEmailAdapter implements EmailSender {
    private string $logDir;

    public function __construct(string $logDir = null) {
        $this->logDir = $logDir ?? dirname(__DIR__, 5) . '/logs/emails';

        // Crear el directorio si no existe
        if (!is_dir($this->logDir)) {
            mkdir($this->logDir, 0755, true);
        }
    }

    public function send(string $to, string $subject, string $body): void {
        $timestamp = date('Y-m-d H:i:s');
        $filename  = $this->logDir . '/' . date('Ymd_His') . '_' . md5($to) . '.txt';

        $content = <<<EMAIL
        ============================================================
        SIMULACIÓN DE CORREO ELECTRÓNICO
        [CarreraTaxi - Password Recovery System]
        ============================================================
        Fecha:        $timestamp
        Para:         $to
        Asunto:       $subject
        ============================================================

        $body

        ============================================================
        NOTA: Este archivo simula un correo en entorno de desarrollo.
        En producción, usar PHPMailer o SendGrid con la misma interfaz.
        ============================================================
        EMAIL;

        file_put_contents($filename, $content);
    }
}
