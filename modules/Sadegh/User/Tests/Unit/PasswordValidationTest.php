<?php

namespace Sadegh\User\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Sadegh\User\Rules\ValidPassword;

class PasswordValidationTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_password_should_not_be_less_than_6_character()
    {
         $result = (new ValidPassword())->passes('','12@aA');
         $this->assertEquals(0,$result);
    }

    public function test_password_should_include_sign_character()
    {
         $result = (new ValidPassword())->passes('','12sdaA');
         $this->assertEquals(0,$result);
    }

    public function test_password_should_include_digit_character()
    {
         $result = (new ValidPassword())->passes('','!@ghjksdaA');
         $this->assertEquals(0,$result);
    }

    public function test_password_should_include_Capital_character()
    {
         $result = (new ValidPassword())->passes('','!@ghjksda');
         $this->assertEquals(0,$result);
    }

    public function test_password_should_include_small_character()
    {
         $result = (new ValidPassword())->passes('','!@WQERT1');
         $this->assertEquals(0,$result);
    }


}
