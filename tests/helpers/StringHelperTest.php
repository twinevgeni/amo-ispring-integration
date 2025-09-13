<?php

namespace tests\jewellclub\helpers;

use PHPUnit\Framework\TestCase;
use jewellclub\helpers\common\StringHelper;

class StringHelperTest extends TestCase
{
    public function testIsEmpty(): void {
        $this->assertTrue(StringHelper::isEmpty(null));
        $this->assertTrue(StringHelper::isEmpty(""));
        $this->assertFalse(StringHelper::isEmpty("123"));
        $this->assertFalse(StringHelper::isEmpty("1234"));
    }

    public function testIsNotEmpty(): void {
        $this->assertFalse(StringHelper::isNotEmpty(null));
        $this->assertFalse(StringHelper::isNotEmpty(""));
        $this->assertTrue(StringHelper::isNotEmpty("123"));
        $this->assertTrue(StringHelper::isNotEmpty("1234"));
        $this->assertTrue(StringHelper::isNotEmpty("avdsf asdffe reww aerfsdd"));
    }
}