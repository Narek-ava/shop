<?php

namespace Tests\Unit\Enums;

use App\Enums\EnumHelper;
use App\Enums\StringableEnum;
use PHPUnit\Framework\TestCase;

class EnumHelperTest extends TestCase
{
    /**
     * A basic unit test example.
     */
        public function testValues()
    {
        // Define two mock StringableEnum objects
        $mockEnum1 = $this->getMockBuilder(StringableEnum::class)
            ->getMock();
        $mockEnum1->method('toString')
            ->willReturn('foo');

        $mockEnum2 = $this->getMockBuilder(StringableEnum::class)
            ->getMock();
        $mockEnum2->method('toString')
            ->willReturn('bar');

        // Call the values function with the mock objects
        $result = EnumHelper::values([$mockEnum1, $mockEnum2]);

        // Assert that the result matches the expected output
        $this->assertEquals(['foo', 'bar'], $result);
    }
}
