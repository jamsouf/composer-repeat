<?php

namespace Repeat;

class RepeatStringTest extends \PHPUnit_Framework_TestCase
{
    public function testString()
    {
        $result = Repeat::_string(4, 'Lorem ipsum ');
        
        $this->assertSame('Lorem ipsum Lorem ipsum Lorem ipsum Lorem ipsum ', $result);
    }
    
    public function testStringWithIndexAndStep()
    {
        $result = Repeat::_string(3, '[{i}] Round{j} ');
        
        $this->assertSame('[0] Round1 [1] Round2 [2] Round3 ', $result);
    }
    
    public function testStringCount0()
    {
        $result = Repeat::_string(0, 'blub');
        
        $this->assertEmpty($result);
    }
    
    public function testStringUntilWithResultReference()
    {
        $result = Repeat::_string(17, 'foo', function ($result) {
            return substr_count($result, 'foo') == 2 ? true : false;
        });
        
        $this->assertSame('foofoo', $result);
    }
    
    public function testStringWithDelimiter()
    {
        $result = Repeat::_string(4, 'attribute-{i}', null, ', ');
        
        $this->assertSame('attribute-0, attribute-1, attribute-2, attribute-3', $result);
    }
    
    public function testStringUntilWithDelimiter()
    {
        $result = Repeat::_string(10, 'v1.{i}', function ($result) {
            return strpos($result, '.4') !== false ? true : false;
        }, ' / ');
        
        $this->assertSame('v1.0 / v1.1 / v1.2 / v1.3 / v1.4', $result);
    }
}