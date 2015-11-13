<?php
require_once __DIR__ . '/../vendor/autoload.php';

$service = new \Lv\Shumkov\VerificationSender\VerificationSendingService(
    new \Lv\Shumkov\VerificationSender\Domain\VerificationSenderFailover(
        [
            new \Lv\Shumkov\VerificationSender\Gateways\TelesignVerificationSender(
                new \Atolye15\Telesign('customer-id', 'secret-key')
            ),
            new \Lv\Shumkov\VerificationSender\Gateways\CardboardfishVerificationSender()
        ]
    )
);

// throws \Exception with message "CardboardfishVerificationSender not implemented yet"
$service->send('37100000000', 'ABC');
