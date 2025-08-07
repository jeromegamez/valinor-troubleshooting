<?php

declare(strict_types=1);

namespace App\Tests\Converter;

use App\Converter\ConvertSnakeCaseKeysToCamelCase;
use CuyZ\Valinor\MapperBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class ConvertSnakeCaseKeysToCamelCaseTest extends TestCase
{
    /**
     * @param iterable<mixed> $expected
     * @param non-empty-string $signature
     * @param iterable<mixed> $input
     */
    #[DataProvider('dataProvider')]
    #[Test]
    public function it_works(iterable $expected, string $signature, iterable $input): void
    {
        $mapper = (new MapperBuilder())
            ->registerConverter(new ConvertSnakeCaseKeysToCamelCase())
            ->mapper()
        ;

        $result = $mapper->map($signature, $input);

        self::assertSame($expected, $result);
    }

    /**
     * @return iterable<non-empty-string, array{signature: string, expected: iterable<mixed>, input: iterable<mixed>}>
     */
    public static function dataProvider(): iterable
    {
        yield 'flat' => [
            'signature' => 'array<string, string>',
            'input' => ['first_key' => 'first_value'],
            'expected' => ['firstKey' => 'first_value'],
        ];

        yield 'nested' => [
            'signature' => 'array<non-empty-string, non-empty-string|array<non-empty-string, non-empty-string>>',
            'input' => [
                'first_key' => 'first_value',
                'second_key' => [
                    'first_sub_key' => 'first_sub_value',
                    'second_sub_key' => 'second_sub_value',
                ],
            ],
            'expected' => [
                'firstKey' => 'first_value',
                'secondKey' => [
                    'firstSubKey' => 'first_sub_value',
                    'secondSubKey' => 'second_sub_value',
                ],
            ],
        ];
    }
}
