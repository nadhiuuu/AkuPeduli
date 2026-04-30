<?php

namespace Tests\Unit;

use App\Support\DisasterSeverityResolver;
use PHPUnit\Framework\TestCase;

class DisasterSeverityResolverTest extends TestCase
{
    public function test_it_marks_below_threshold_input_as_local_incident(): void
    {
        $result = DisasterSeverityResolver::resolve([
            'jumlah_korban' => 0,
            'jumlah_terdampak' => 49,
            'rumah_rusak' => 4,
            'fasilitas_vital_lumpuh' => false,
        ]);

        $this->assertSame(DisasterSeverityResolver::LOCAL, $result['status_bencana']);
        $this->assertFalse($result['eligible_for_campaign']);
    }

    public function test_it_marks_medium_when_any_medium_threshold_is_met(): void
    {
        $cases = [
            ['jumlah_korban' => 1, 'jumlah_terdampak' => 0, 'rumah_rusak' => 0],
            ['jumlah_korban' => 0, 'jumlah_terdampak' => 50, 'rumah_rusak' => 0],
            ['jumlah_korban' => 0, 'jumlah_terdampak' => 0, 'rumah_rusak' => 5],
        ];

        foreach ($cases as $case) {
            $result = DisasterSeverityResolver::resolve($case);

            $this->assertSame(DisasterSeverityResolver::MENENGAH, $result['status_bencana']);
            $this->assertTrue($result['eligible_for_campaign']);
        }
    }

    public function test_it_marks_critical_when_any_critical_threshold_is_met(): void
    {
        $cases = [
            ['jumlah_korban' => 11],
            ['jumlah_terdampak' => 501],
            ['rumah_rusak' => 51],
            ['fasilitas_vital_lumpuh' => true],
        ];

        foreach ($cases as $case) {
            $result = DisasterSeverityResolver::resolve($case);

            $this->assertSame(DisasterSeverityResolver::KRITIS, $result['status_bencana']);
            $this->assertTrue($result['eligible_for_campaign']);
        }
    }
}
