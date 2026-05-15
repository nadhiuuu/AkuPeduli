<?php

namespace Tests\Unit;

use App\Support\RupiahInput;
use PHPUnit\Framework\TestCase;

class RupiahInputTest extends TestCase
{
    public function test_it_formats_plain_digits_with_indonesian_thousand_separators(): void
    {
        $this->assertSame('2.000.000', RupiahInput::format('2000000'));
        $this->assertSame('15.000.000', RupiahInput::format(15000000));
        $this->assertSame('0', RupiahInput::format(0));
    }

    public function test_it_normalizes_formatted_values_back_to_plain_integers(): void
    {
        $this->assertSame(2000000, RupiahInput::normalize('2.000.000'));
        $this->assertSame(15000000, RupiahInput::normalize('Rp 15.000.000'));
        $this->assertSame(100000, RupiahInput::normalize('100.000'));
    }

    public function test_it_returns_null_when_no_digits_are_present(): void
    {
        $this->assertNull(RupiahInput::normalize(''));
        $this->assertNull(RupiahInput::normalize(null));
        $this->assertSame('', RupiahInput::format(''));
    }
}
