<?php

declare(strict_types=1);

namespace App\Converter;

final class FlattenWhenSingleProperty
{
    /**
     * @param iterable<mixed> $source
     * @param callable(iterable<mixed>): iterable<mixed> $next
     *
     * @return iterable<mixed>
     */
    public function __invoke(iterable $source, callable $next): iterable
    {
        $result = null;
        $keys = 0;

        foreach ($source as $value) {
            ++$keys;
            $result = $value;

            if (!is_iterable($result)) {
                return $next($source);
            }

            if ($keys > 1) {
                return $next($source);
            }
        }

        if ($result === null) {
            return $next($source);
        }

        return $next($result);
    }
}
