<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sadegh\User\Rules\ValidMobile;

class MobileValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_mobile_can_not_be_less_than_10_charecter()
    {
        $result = (new ValidMobile())->passes('','98767897');
        $this->assertEquals(0,$result);
    }

    public function test_mobile_can_not_be_more_than_10_charecter()
    {
        $result = (new ValidMobile())->passes('','987678979');
        $this->assertEquals(0,$result);
    }
    public function test_mobile_should_start_by_9()
    {
        $result = (new ValidMobile())->passes('','387678979');
        $this->assertEquals(0,$result);
    }
}
