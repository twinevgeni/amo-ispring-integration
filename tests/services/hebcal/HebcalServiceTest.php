<?php

namespace tests\jewellclub\services\hebcal;

use jewellclub\services\hebcal\HebcalService;
use PHPUnit\Framework\TestCase;

class HebcalServiceTest extends TestCase
{
    public function testInstance(): void
    {
        $hebcalService = HebcalService::getInstance();
        $this->assertNotNull($hebcalService);
    }

    public function testConvertGregorianToHebrew(): void
    {
        $gregorianDate = "2025-10-10";
        $hebcalService = HebcalService::getInstance();
        $response = $hebcalService->convertGregorianToHebrew($gregorianDate);
        $this->assertNotNull($response);
        $this->assertEquals($gregorianDate, $response->getGregorianDateStr());
    }
}