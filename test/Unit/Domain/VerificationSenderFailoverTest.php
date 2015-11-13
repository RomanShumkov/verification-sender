<?php
namespace Lv\Shumkov\VerificationSender\Test\Unit\Domain;

use Lv\Shumkov\VerificationSender\Domain\GatewayFailureException;
use Lv\Shumkov\VerificationSender\Domain\Verification;
use Lv\Shumkov\VerificationSender\Domain\VerificationSenderFailover;
use Lv\Shumkov\VerificationSender\Test\Fakes\Domain\FakeVerificationSender;

class VerificationSenderFailoverTest extends \PHPUnit_Framework_TestCase
{
    const SOME_MSISDN = '37100000000';
    const SOME_CODE = 'some-code';

    /**
     * @var Verification
     */
    private $someVerification;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        parent::setUp();

        $this->someVerification = new Verification(self::SOME_MSISDN, self::SOME_CODE);
    }

    public function test_send__always__delegatesToFirstSender()
    {
        // arrange
        $firstSender = new FakeVerificationSender();
        $sut = new VerificationSenderFailover([$firstSender]);

        // act
        $sut->send($this->someVerification);

        // assert
        self::assertTrue($firstSender->sentVerification->equals($this->someVerification));
    }

    public function test_send__firstSenderFails__delegatesToSecondSender()
    {
        // arrange
        $firstSender = new FakeVerificationSender();
        $firstSender->exception = new GatewayFailureException();

        $secondSender = new FakeVerificationSender();

        $sut = new VerificationSenderFailover([$firstSender, $secondSender]);

        // act
        $sut->send($this->someVerification);

        // assert
        self::assertTrue($secondSender->sendHaveBeenCalledWith($this->someVerification));
    }

    public function test_send__firstSenderSucceeds__DoesNotDelegateToSecondSender()
    {
        // arrange
        $firstSender = new FakeVerificationSender();
        $secondSender = new FakeVerificationSender();
        $sut = new VerificationSenderFailover([$firstSender, $secondSender]);

        // act
        $sut->send($this->someVerification);

        // assert
        self::assertFalse($secondSender->sendHaveBeenCalled());
    }

    public function test_send__allSendersFail__throwsLastSenderException()
    {
        // arrange
        $firstSender = new FakeVerificationSender();
        $firstSender->exception = new GatewayFailureException('first sender failure');

        $secondSender = new FakeVerificationSender();
        $secondSender->exception = new GatewayFailureException('second sender failure');

        $sut = new VerificationSenderFailover([$firstSender, $secondSender]);

        // assert
        $this->setExpectedException(get_class($secondSender->exception), $secondSender->exception->getMessage());

        // act
        $sut->send($this->someVerification);
    }
}
