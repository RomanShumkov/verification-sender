<?php
namespace Lv\Shumkov\VerificationSender\Test\Fakes\Domain;

use Lv\Shumkov\VerificationSender\Domain\Verification;
use Lv\Shumkov\VerificationSender\Domain\VerificationSender;

class FakeVerificationSender implements VerificationSender
{
    /**
     * @var Verification
     */
    public $sentVerification;

    /**
     * @var \Exception
     */
    public $exception;

    /**
     * {@inheritDoc}
     */
    public function send(Verification $verification)
    {
        $this->sentVerification = $verification;
        if ($this->exception) {
            throw $this->exception;
        }
    }

    /**
     * @param Verification $expectedVerification
     * @return bool
     */
    public function sendHaveBeenCalledWith(Verification $expectedVerification)
    {
        return $this->sendHaveBeenCalled() && $this->sentVerification->equals($expectedVerification);
    }

    /**
     * @return bool
     */
    public function sendHaveBeenCalled()
    {
        return $this->sentVerification !== null;
    }
}
