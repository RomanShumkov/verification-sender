<?php
namespace Lv\Shumkov\VerificationSender\Domain;

class Verification
{
    /**
     * @var string
     */
    private $msisdn;

    /**
     * @var string
     */
    private $code;

    /**
     * @param string $msisdn
     * @param string $code
     */
    public function __construct($msisdn, $code)
    {
        $this->msisdn = $msisdn;
        $this->code = $code;
    }

    /**
     * @return string
     */
    public function getMsisdn()
    {
        return $this->msisdn;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    public function equals(Verification $other)
    {
        return $this->getCode() === $other->getCode() && $this->getMsisdn() === $other->getMsisdn();
    }
}
