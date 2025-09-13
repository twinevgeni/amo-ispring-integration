<?php declare(strict_types=1);

namespace tests\jewellclub\helpers;

use PHPUnit\Framework\TestCase;
use jewellclub\helpers\common\LoggerHelper;

/**
 * ConfigHelperTest
 */
class LoggerHelperTest extends TestCase
{
    /**
     * @return void
     */
    public function testGetLogger(): void
    {
        $logger = LoggerHelper::getLogger("LoggerHelperTest");
        $this->assertNotNull($logger);
    }


}