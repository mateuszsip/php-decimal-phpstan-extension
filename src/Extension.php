<?php

declare(strict_types = 1);

namespace kejwmen\PhpDecimalPhpstanExtension;

use Decimal\Decimal;
use PHPStan\Type\ObjectType;
use PHPStan\Type\OperatorTypeSpecifyingExtension;
use PHPStan\Type\Type;

final class Extension implements OperatorTypeSpecifyingExtension
{
    public function isOperatorSupported(string $operatorSigil, Type $leftSide, Type $rightSide): bool
    {
        return $this->isDecimal($leftSide)
            && $this->isDecimal($rightSide)
            && $this->isSupportedSigil($operatorSigil);
    }

    public function specifyType(string $operatorSigil, Type $leftSide, Type $rightSide): Type
    {
        return new ObjectType(Decimal::class);
    }

    private function isDecimal(Type $type): bool
    {
        return $type->equals(new ObjectType(Decimal::class));
    }

    private function isSupportedSigil(string $operatorSigil)
    {
        return in_array(
            $operatorSigil,
            [
                '+',
                '-',
                '*',
                '/',
                '%',
                '**'
            ]
        );
    }
}
