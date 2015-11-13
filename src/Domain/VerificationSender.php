<?php
namespace Lv\Shumkov\VerificationSender\Domain;

interface VerificationSender
{
    /**
     * @param Verification $verification
     * @return void
     * @throws GatewayFailureException
     */
    public function send(Verification $verification);
}
