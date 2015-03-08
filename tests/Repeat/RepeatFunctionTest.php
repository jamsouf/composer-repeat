<?php

namespace Repeat;

class RepeatFunctionTest extends \PHPUnit_Framework_TestCase
{
    public function testAnonymousFunction()
    {
        $count = 0;
        Repeat::_function(7, function () use (&$count) {
            $count++;
        });
        
        $this->assertSame(7, $count);
    }
    
    public function testAnonymousFunctionUntil()
    {
        $count = 0;
        Repeat::_function(12,
            function () use (&$count) {
                $count++;
            },
            function () use (&$count) {
                return $count == 5 ? true : false;
            }
        );
        
        $this->assertSame(5, $count);
    }
    
    public function testAnonymousFunctionWithReturnValue()
    {
        $count = 0;
        $results = Repeat::_function(23, function () use (&$count) {
            $count++;
            return 'foo';
        });
        
        $this->assertSame(23, $count);
        $this->assertCount(23, $results);
        $this->assertSame('foo', $results[0]);
        $this->assertSame('foo', $results[22]);
    }
    
    public function testNamedFunctionWithReturnValue()
    {
        $a = 3;
        $b = 6;
        
        $multiplication = function () use (&$a, &$b) {
            return $a++ * $b++;
        };
        
        $results = Repeat::_function(4, $multiplication);
        
        $this->assertCount(4, $results);
        $this->assertSame(18, $results[0]);
        $this->assertSame(28, $results[1]);
        $this->assertSame(40, $results[2]);
        $this->assertSame(54, $results[3]);
    }
    
    public function testNamedFunctionAnonymousUntilWithReturnValue()
    {
        $a = 84;
        $b = 7;
        
        $subtraction = function () use (&$a, &$b) {
            return --$a - ++$b;
        };
        
        $results = Repeat::_function(6, $subtraction, function () use (&$a) {
            return $a <= 81 ? true : false;
        });
        
        $this->assertCount(3, $results);
        $this->assertSame(75, $results[0]);
        $this->assertSame(73, $results[1]);
        $this->assertSame(71, $results[2]);
    }
    
    public function testNamedFunctionNamedUntilWithResultReferenceAndReturnValue()
    {
        $createRandomNumbers = function () {
            return mt_rand(0, 1000);
        };
        
        $until = function ($result) {
            return count($result) == 3 ? true : false;
        };
        
        $results = Repeat::_function(9, $createRandomNumbers, $until);
        
        $this->assertCount(3, $results);
        $this->assertTrue($results[0] >= 0 && $results[0] <= 1000);
        $this->assertTrue($results[1] >= 0 && $results[1] <= 1000);
        $this->assertTrue($results[2] >= 0 && $results[2] <= 1000);
    }
    
    public function testNamedFunctionWithResultReferenceAndReturnValue()
    {
        $start = 4;
        $math = function ($result) use ($start) {
            $value = count($result) == 0 ? $start : $result[max(array_keys($result))];
            return $value * $value;
        };
        
        $results = Repeat::_function(4, $math);
        
        $this->assertCount(4, $results);
        $this->assertSame(16, $results[0]);
        $this->assertSame(256, $results[1]);
        $this->assertSame(65536, $results[2]);
        $this->assertSame(4294967296, $results[3]);
    }
}