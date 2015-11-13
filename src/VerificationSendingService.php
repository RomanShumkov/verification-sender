<?php
namespace Lv\Shumkov\VerificationSender;

use Lv\Shumkov\VerificationSender\Domain\GatewayFailureException;
use Lv\Shumkov\VerificationSender\Domain\Verification;
use Lv\Shumkov\VerificationSender\Domain\VerificationSender;

class VerificationSendingService
{
    /**
     * @var VerificationSender
     */
    private $sender;

    /**
     * @param VerificationSender $sender
     */
    public function __construct(VerificationSender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param string $msisdn
     * @param string $code
     * @throws VerificationFailureException
     */
    public function send($msisdn, $code)
    {
        try {
            $this->sender->send(new Verification($msisdn, $code));
        } catch (GatewayFailureException $e) {
            throw new VerificationFailureException('', 0, $e);
        }
    }
}
