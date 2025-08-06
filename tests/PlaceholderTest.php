<?php

declare(strict_types=1);

namespace App\Tests;

use App\Placeholder;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

/**
 * @internal
 */
#[CoversClass(Placeholder::class)]
final class PlaceholderTest extends TestCase
{
    #[Test]
    public function it_echoes_a_value(): void
    {
        $placeholder = new Placeholder('Test: ');
        $result = $placeholder->echo('Hello');

        self::assertSame('Test: Hello', $result);
    }
}
