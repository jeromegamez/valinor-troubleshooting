<?php

declare(strict_types=1);

namespace App\Converter;

final class ConvertSnakeCaseKeysToCamelCase
{
    /**
     * @pure
     *
     * @param iterable<mixed> $source
     * @param pure-callable(iterable<mixed>): iterable<mixed> $next
     *
     * @return iterable<mixed>
     */
    public function __invoke(iterable $source, callable $next): iterable
    {
        return $next(self::camelCase($source));
    }

    /**
     * @pure
     *
     * @param iterable<mixed> $source
     *
     * @return array<array-key, mixed>
     */
    private static function camelCase(iterable $source): array
    {
        $result = [];

        foreach ($source as $key => $value) {
            if (is_iterable($value)) {
                $value = self::camelCase($value);
            }

            if (is_string($key) && $key !== '') {
                $key = self::convert($key);
            }

            $result[$key] = $value;
        }

        return $result;
    }

    /**
     * @pure
     *
     * @param non-empty-string $key
     */
    private static function convert(string $key): string
    {
        return lcfirst(str_replace('_', '', ucwords($key, '_'))); // @phpstan-ignore possiblyImpure.functionCall
    }
}
