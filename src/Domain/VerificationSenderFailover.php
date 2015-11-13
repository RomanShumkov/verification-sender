<?php
namespace Lv\Shumkov\VerificationSender\Domain;

class VerificationSenderFailover implements VerificationSender
{
    /**
     * @var VerificationSender[]
     */
    private $senders;

    /**
     * @param VerificationSender[] $senders
     */
    public function __construct($senders)
    {
        $this->senders = $senders;
    }

    /**
     * {@inheritDoc}
     */
    public function send(Verification $verification)
    {
        $isSent = false;
        $exception = null;
        foreach ($this->senders as $sender) {
            try {
                $sender->send($verification);
                $isSent = true;
                break;
            } catch (GatewayFailureException $exception) {
                // do nothing
            }
        }

        if (!$isSent && $exception !== null) {
            throw $exception;
        }
    }
}
