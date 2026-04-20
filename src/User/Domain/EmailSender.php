<?php
declare(strict_types=1);

namespace TaxiApp\User\Domain;

/**
 * CAPA DE DOMINIO - Puerto EmailSender
 * 
 * Contrato que define cómo el dominio solicita el envío de correos.
 * La implementación concreta (real o simulada) vive en Infraestructura.
 * Esto es la Inversión de Dependencias en acción.
 */
interface EmailSender {
    /**
     * Envía (o simula el envío de) un correo electrónico.
     *
     * @param string $to      Destinatario
     * @param string $subject Asunto del correo
     * @param string $body    Cuerpo del mensaje en texto/HTML
     */
    public function send(string $to, string $subject, string $body): void;
}
