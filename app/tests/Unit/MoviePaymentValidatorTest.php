<?php

declare(strict_types=1);

namespace Unit;

use App\DTO\MoviePaymentDTO;
use App\Exception\CardExpirationValidationException;
use App\Exception\CardHolderValidationException;
use App\Exception\CardNumberValidationException;
use App\Exception\CvvValidationException;
use App\Exception\OrderNumberValidationException;
use App\Exception\SumValidationException;
use App\Validator\MoviePaymentValidator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MoviePaymentValidatorTest extends WebTestCase
{
    public function test_incorrect_card_number_length(): void
    {
        $testData = $this->validData;
        $testData[0] = '12345';

        $validator = new MoviePaymentValidator();

        $this->expectException(CardNumberValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_card_number_content(): void
    {
        $testData = $this->validData;
        $testData[0] = '1234567890qwe09';

        $validator = new MoviePaymentValidator();

        $this->expectException(CardNumberValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_card_holder_format(): void
    {
        $testData = $this->validData;
        $testData[1] = 'Lebedev Vyacheslav Romanovich';

        $validator = new MoviePaymentValidator();

        $this->expectException(CardHolderValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_card_holder_surname(): void
    {
        $testData = $this->validData;
        $testData[1] = 'lebedev Vyacheslav';

        $validator = new MoviePaymentValidator();

        $this->expectException(CardHolderValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_card_holder_name(): void
    {
        $testData = $this->validData;
        $testData[1] = 'Lebe-dev Vyacheslav-';

        $validator = new MoviePaymentValidator();

        $this->expectException(CardHolderValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_card_expiration_format(): void
    {
        $testData = $this->validData;
        $testData[2] = 'qw/22';

        $validator = new MoviePaymentValidator();

        $this->expectException(CardExpirationValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_card_expiration_value(): void
    {
        $testData = $this->validData;
        $testData[2] = '01/21';

        $validator = new MoviePaymentValidator();

        $this->expectException(CardExpirationValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_card_cvv_format(): void
    {
        $testData = $this->validData;
        $testData[3] = 111111;

        $validator = new MoviePaymentValidator();

        $this->expectException(CvvValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_order_number_format(): void
    {
        $testData = $this->validData;
        $testData[4] = '';

        $validator = new MoviePaymentValidator();

        $this->expectException(OrderNumberValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    public function test_incorrect_sum_format(): void
    {
        $testData = $this->validData;
        $testData[5] = '1,2,2';

        $validator = new MoviePaymentValidator();

        $this->expectException(SumValidationException::class);
        $validator->validate(new MoviePaymentDTO(...$testData));
    }

    private array $validData = [
        '1234567890123456',
        'Lebedev Vyacheslav',
        '08/24',
        123,
        'w34fa*%@#_idvkds',
        '1242,34'
    ];
}
