<?php
declare(strict_types=1);

namespace TaxiApp\User\Application;

use TaxiApp\User\Domain\UserRepository;
use TaxiApp\User\Domain\EmailSender;

/**
 * CAPA DE APLICACIÓN - Caso de Uso: Recuperar Contraseña
 * 
 * Orquesta el proceso de recuperación:
 * 1. Verifica que el email existe en el sistema.
 * 2. Genera un token seguro de recuperación.
 * 3. Delega el envío del correo al puerto EmailSender.
 * 
 * NO sabe si el correo se envía por SMTP, SendGrid o se guarda en disco.
 * Eso es responsabilidad del adaptador inyectado.
 */
class PasswordRecoveryUseCase {
    public function __construct(
        private UserRepository $userRepository,
        private EmailSender    $emailSender
    ) {}

    /**
     * Inicia el proceso de recuperación de contraseña.
     * 
     * @param string $email Email del usuario que olvidó su contraseña
     * @param string $baseUrl URL base de la app (ej: http://localhost/CarreraTaxi)
     * @return bool true si el email fue encontrado y el correo "enviado"
     */
    public function execute(string $email, string $baseUrl): bool {
        $user = $this->userRepository->findByEmail($email);

        if (!$user) {
            // No revelamos si el email existe o no (seguridad)
            return false;
        }

        // Generar token seguro de 64 caracteres
        $token     = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+1 hour'));
        $resetLink = "$baseUrl/reset-password.php?token=$token&email=" . urlencode($email);

        $subject = 'Recuperación de Contraseña - CarreraTaxi';
        $body    = <<<BODY
        Hola {$user->nombre},

        Recibimos una solicitud para restablecer la contraseña de tu cuenta
        asociada a este correo: $email

        Haz clic en el siguiente enlace para crear una nueva contraseña:

            $resetLink

        Este enlace expirará el: $expiresAt

        Si no solicitaste este cambio, puedes ignorar este mensaje.
        Tu contraseña actual no será modificada.

        —————————————————————————
        Sistema CarreraTaxi
        BODY;

        $this->emailSender->send($email, $subject, $body);

        return true;
    }
}
