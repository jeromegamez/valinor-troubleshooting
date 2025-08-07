<?php

declare(strict_types=1);

namespace App\Converter;

final class FlattenWhenSingleProperty
{
    /**
     * @param iterable<mixed> $source
     */
    public function __invoke(iterable $source, callable $next): mixed
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

        return $next($result);
    }
}
