<?php

namespace Tests\Unit;

use App\Support\JemberRegion;
use PHPUnit\Framework\TestCase;

class JemberRegionTest extends TestCase
{
    public function test_sumbersari_has_dependent_villages(): void
    {
        $villages = JemberRegion::villagesForDistrict('Sumbersari');

        $this->assertArrayHasKey('Sumbersari', $villages);
        $this->assertArrayHasKey('Kebonsari', $villages);
        $this->assertArrayHasKey('Tegalgede', $villages);
    }

    public function test_it_validates_village_membership(): void
    {
        $this->assertTrue(JemberRegion::isValidVillage('Sumbersari', 'Kranjingan'));
        $this->assertFalse(JemberRegion::isValidVillage('Sumbersari', 'Ajung'));
    }

    public function test_it_can_canonicalize_district_names_from_geojson(): void
    {
        $this->assertSame('Sumbersari', JemberRegion::canonicalDistrictName('sumbersari'));
        $this->assertSame('Tanggul', JemberRegion::canonicalDistrictName(' TANGGUL '));
    }
}
