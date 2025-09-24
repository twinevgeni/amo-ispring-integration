<?php declare(strict_types=1);

namespace tests\amoispring\helpers;

use PHPUnit\Framework\TestCase;
use amoispring\helpers\common\LoggerHelper;

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