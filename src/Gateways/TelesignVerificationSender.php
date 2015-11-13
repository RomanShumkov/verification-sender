<?php
namespace Lv\Shumkov\VerificationSender\Gateways;

use Lv\Shumkov\VerificationSender\Domain\GatewayFailureException;
use Lv\Shumkov\VerificationSender\Domain\Verification;
use Lv\Shumkov\VerificationSender\Domain\VerificationSender;
use Atolye15\Telesign;

class TelesignVerificationSender implements VerificationSender
{
    /**
     * @var Telesign
     */
    private $telesign;

    /**
     * @param Telesign $telesign
     */
    public function __construct(Telesign $telesign)
    {
        $this->telesign = $telesign;
    }

    /**
     * {@inheritDoc}
     */
    public function send(Verification $verification)
    {
        $result = $this->telesign->verify(
            $verification->getMsisdn(),
            $verification->getCode()
        );

        if (empty($result) || !empty($result['errors'])) {
            throw new GatewayFailureException();
        }
    }
}
