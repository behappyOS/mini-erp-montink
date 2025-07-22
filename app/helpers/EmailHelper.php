<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../../vendor/autoload.php';

class EmailHelper
{
    public static function enviarConfirmacaoPedido($emailDestino, $nomeCliente, $pedidoId, $total, $endereco, $cep)
    {
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host = 'sandbox.smtp.mailtrap.io';
            $mail->SMTPAuth = true;
            $mail->Username = '5e7438cfd6e3c2';
            $mail->Password = '3ffc7004b36882';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('loja@seudominio.com', 'Minha Loja');
            $mail->addAddress($emailDestino, $nomeCliente);

            $mail->isHTML(true);
            $mail->Subject = "Confirmação do Pedido #{$pedidoId}";
            $mail->Body    = "
                <h2>Olá, {$nomeCliente}!</h2>
                <p>Seu pedido foi realizado com sucesso.</p>
                <p><strong>ID do Pedido:</strong> {$pedidoId}</p>
                <p><strong>Total:</strong> R$ {$total}</p>
                <p><strong>Endereço:</strong> [" . htmlspecialchars($endereco) . "], <strong>CEP:</strong> [" . htmlspecialchars($cep) . "]</p>
                <p>Obrigado por comprar conosco!</p>
            ";
            $mail->AltBody = "Pedido #{$pedidoId} confirmado. Total: R$ {$total}. Endereço: {$endereco}, CEP: {$cep}";

            $mail->send();
            return true;

        } catch (Exception $e) {
            error_log("Erro ao enviar e-mail: {$mail->ErrorInfo}");
            return false;
        }
    }
}
