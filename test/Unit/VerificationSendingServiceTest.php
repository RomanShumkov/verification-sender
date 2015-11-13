<?php
namespace Lv\Shumkov\VerificationSender\Test\Unit;

use Lv\Shumkov\VerificationSender\Domain\GatewayFailureException;
use Lv\Shumkov\VerificationSender\Domain\Verification;
use Lv\Shumkov\VerificationSender\Test\Fakes\Domain\FakeVerificationSender;
use Lv\Shumkov\VerificationSender\VerificationFailureException;
use Lv\Shumkov\VerificationSender\VerificationSendingService;

class VerificationSendingServiceTest extends \PHPUnit_Framework_TestCase
{
    const SOME_MSISDN = '37100000000';
    const SOME_CODE = 'some-code';

    /**
     * @var VerificationSendingService
     */
    private $sut;

    /**
     * @var FakeVerificationSender
     */
    private $fakeSender;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->fakeSender = new FakeVerificationSender();
        $this->sut = new VerificationSendingService($this->fakeSender);
    }

    public function test_send__always__delegatesSendingToSender()
    {
        // act
        $this->sut->send(self::SOME_MSISDN, self::SOME_CODE);

        // assert
        $expectedSentVerification = new Verification(self::SOME_MSISDN, self::SOME_CODE);
        self::assertTrue($this->fakeSender->sendHaveBeenCalledWith($expectedSentVerification));
    }

    public function test_send__gatewayFailure__throwsException()
    {
        // arrange
        $this->fakeSender->exception = new GatewayFailureException();

        // assert
        $this->setExpectedException(VerificationFailureException::class);

        // act
        $this->sut->send(self::SOME_MSISDN, self::SOME_CODE);
    }
}
