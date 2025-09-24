<?php

namespace tests\amoispring\services\amo;

use PHPUnit\Framework\TestCase;
use amoispring\services\amo\LeadService;

class LeadServiceTest extends TestCase
{
    public function testInstance(): void
    {
        $leadService = LeadService::getInstance();
        $this->assertNotNull($leadService);
    }
}