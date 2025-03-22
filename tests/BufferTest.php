<?php 


declare(strict_types=1);

use PHPallas\Buffer\Stock as Buffer;
use PHPUnit\Framework\TestCase;

final class BufferTest extends TestCase
{
    public function testIfBufferIsSingleton(): void
    {
        $buffer = Buffer::getInstance();
        $buffer->set("test", "value");

        $this->assertEquals($buffer, Buffer::getInstance());
    }

    public function testIfBufferWithoutScoping(): void
    {
        $buffer = Buffer::getInstance();
        $buffer->set("parent.child.name", "John");
        $this->assertEquals("John", $buffer->get("parent.child.name"));
        $this->assertEquals(["name" => "John"], $buffer->get("parent.child"));
        $this->assertEquals(["child" => ["name" => "John"]], $buffer->get("parent"));
        $buffer->clearAll();
    }

    public function testIfBufferWithScoping(): void
    {
        $buffer = Buffer::getInstance();
        $buffer->set("morder.name", "John", "fantacy");
        $this->assertEquals("John", $buffer->get("morder.name", "fantacy"));
        $this->assertEquals(null, $buffer->get("morder.name", "erer"));
        $this->assertEquals(null, $buffer->get("morder.name", "main"));
        $buffer->clearAll();
    }

    
}