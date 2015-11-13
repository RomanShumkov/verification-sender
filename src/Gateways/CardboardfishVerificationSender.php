<?php
namespace Lv\Shumkov\VerificationSender\Gateways;

use Lv\Shumkov\VerificationSender\Domain\Verification;
use Lv\Shumkov\VerificationSender\Domain\VerificationSender;

class CardboardfishVerificationSender implements VerificationSender
{
    /**
     * {@inheritDoc}
     */
    public function send(Verification $verification)
    {
        throw new \Exception('CardboardfishVerificationSender not implemented yet');
    }
}
