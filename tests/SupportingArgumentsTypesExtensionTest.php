<?php
declare(strict_types = 1);

namespace kejwmen\PhpDecimalPhpstanExtension\Tests;

use Decimal\Decimal;
use kejwmen\PhpDecimalPhpstanExtension\Extension;
use PHPStan\Type\ObjectType;
use PHPStan\Type\Type;
use PHPUnit\Framework\TestCase;

class SupportingArgumentsTypesExtensionTest extends TestCase
{
    /**
     * @dataProvider supportingArgumentsProvider
     */
    public function testAreArgumentsSupported(Type $leftType, Type $rightType)
    {
        $extension = new Extension();

        $result = $extension->isOperatorSupported(
            '+',
            $leftType,
            $rightType
        );

        self::assertTrue($result);
    }

    public function supportingArgumentsProvider(): iterable
    {
        yield 'exact match' => [
            new ObjectType(Decimal::class),
            new ObjectType(Decimal::class),
        ];
    }

    /**
     * @dataProvider notSupportingArgumentsProvider
     */
    public function testAreNotArgumentsSupported(Type $leftType, Type $rightType)
    {
        $extension = new Extension();

        $result = $extension->isOperatorSupported(
            '+',
            $leftType,
            $rightType
        );

        self::assertFalse($result);
    }

    public function notSupportingArgumentsProvider(): iterable
    {
        yield 'not matching left' => [
            new ObjectType(\stdClass::class),
            new ObjectType(Decimal::class),
        ];

        yield 'not matching right' => [
            new ObjectType(Decimal::class),
            new ObjectType(\stdClass::class),
        ];

        yield 'not matching both' => [
            new ObjectType(\stdClass::class),
            new ObjectType(\stdClass::class),
        ];
    }
}
