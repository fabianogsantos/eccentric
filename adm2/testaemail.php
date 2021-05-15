<?php
$to_email = "fgsantos@unaerp.br";
$subject = "Teste simples de envio de email via PHP";
$body = "Olá, este é um email de teste enviado por PHP Script";
$headers = "From: sender\'s email";
 
if (mail($to_email, $subject, $body, $headers)) {
    echo "Email enviado com sucesso para $to_email.";
} else {
    echo "Falha no envio do email.";
}
