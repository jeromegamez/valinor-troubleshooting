<?php

declare(strict_types=1);

namespace App;

final class Placeholder
{
    public function __construct(private string $prefix) {}

    public function echo(string $value): string
    {
        return $this->prefix . $value;
    }
}
