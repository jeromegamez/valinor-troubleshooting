<?php

declare(strict_types=1);

namespace App\Tests\Converter;

use App\Converter\FlattenWhenSingleProperty;
use CuyZ\Valinor\MapperBuilder;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
class FlattenWhenSinglePropertyTest extends TestCase
{
    /**
     * @param iterable<mixed> $expected
     * @param non-empty-string $signature
     * @param iterable<mixed> $input
     */
    #[DataProvider('dataProvider')]
    #[Test]
    public function it_works_by_providing_a_class_string(iterable $expected, string $signature, iterable $input): void
    {
        $mapper = (new MapperBuilder())
            ->registerConverter(FlattenWhenSingleProperty::class)
            ->mapper()
        ;

        $result = $mapper->map($signature, $input);

        self::assertSame($expected, $result);
    }

    /**
     * @param iterable<mixed> $expected
     * @param non-empty-string $signature
     * @param iterable<mixed> $input
     */
    #[DataProvider('dataProvider')]
    #[Test]
    public function it_works_by_providing_a_class_instance(iterable $expected, string $signature, iterable $input): void
    {
        $mapper = (new MapperBuilder())
            ->registerConverter(new FlattenWhenSingleProperty())
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
        yield 'flattened' => [
            'signature' => 'array<string, string>',
            'input' => [
                'first_key' => [
                    'first_sub_key' => 'first_sub_value',
                    'second_sub_key' => 'second_sub_value',
                ],
            ],
            'expected' => [
                'first_sub_key' => 'first_sub_value',
                'second_sub_key' => 'second_sub_value',
            ],
        ];

        yield 'unchanged' => [
            'signature' => 'array<string, string>',
            'input' => [
                'first_key' => 'first_value',
                'second_key' => 'second_value',
            ],
            'expected' => [
                'first_key' => 'first_value',
                'second_key' => 'second_value',
            ],
        ];
    }
}
