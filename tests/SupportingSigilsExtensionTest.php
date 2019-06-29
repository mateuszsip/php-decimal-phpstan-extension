<?php
declare(strict_types = 1);

namespace kejwmen\PhpDecimalPhpstanExtension\Tests;

use Decimal\Decimal;
use kejwmen\PhpDecimalPhpstanExtension\Extension;
use PHPStan\Type\ObjectType;
use PHPUnit\Framework\TestCase;

class SupportingSigilsExtensionTest extends TestCase
{
    /**
     * @dataProvider supportingSigilsProvider
     */
    public function testIsOperatorSupported(string $sigil)
    {
        $extension = new Extension();

        $result = $extension->isOperatorSupported(
            $sigil,
            new ObjectType(Decimal::class),
            new ObjectType(Decimal::class)
        );

        self::assertTrue($result);
    }

    public function supportingSigilsProvider(): iterable
    {
        foreach (['+', '-', '*', '/', '%', '**'] as $sigil) {
            yield [$sigil];
        }
    }

    /**
     * @dataProvider notSupportingSigilsProvider
     */
    public function testIsNotOperatorSupported(string $sigil)
    {
        $extension = new Extension();

        $result = $extension->isOperatorSupported(
            $sigil,
            new ObjectType(Decimal::class),
            new ObjectType(Decimal::class)
        );

        self::assertFalse($result);
    }

    public function notSupportingSigilsProvider(): iterable
    {
        foreach (['a', '=', '(', '!', '@', '1'] as $sigil) {
            yield $sigil => [$sigil];
        }
    }
}
