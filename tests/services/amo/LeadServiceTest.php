<?php

namespace tests\jewellclub\services\amo;

use PHPUnit\Framework\TestCase;
use jewellclub\services\amo\LeadService;

class LeadServiceTest extends TestCase
{
    public function testInstance(): void
    {
        $leadService = LeadService::getInstance();
        $this->assertNotNull($leadService);
    }
}