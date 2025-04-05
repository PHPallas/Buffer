<?php


declare(strict_types=1);

use PHPallas\Buffer\Stock as Buffer;
use PHPUnit\Framework\TestCase;

final class BufferTest extends TestCase
{
    public function testIfBufferIsSingleton()
    {
        $buffer = Buffer::getInstance();
        $buffer->set("test", "value");

        $this->assertEquals($buffer, Buffer::getInstance());
    }

    public function testIfBufferWithoutScoping()
    {
        $buffer = Buffer::getInstance();
        $buffer->set("parent.child.name", "John");
        $this->assertEquals("John", $buffer->get("parent.child.name"));
        $this->assertEquals(["name" => "John"], $buffer->get("parent.child"));
        $this->assertEquals(["child" => ["name" => "John"]], $buffer->get("parent"));
        $buffer->clearAll();
    }

    public function testIfBufferWithScoping()
    {
        $buffer = Buffer::getInstance();
        $buffer->set("morder.name", "John", "fantacy");
        $this->assertEquals("John", $buffer->get("morder.name", "fantacy"));
        $this->assertEquals(null, $buffer->get("morder.name", "erer"));
        $this->assertEquals(null, $buffer->get("morder.name", "main"));
        $buffer->clearAll();
    }

    public function testUnsetMethod()
    {
        $buffer = Buffer::getInstance();
        $buffer->set("morder.name", "John", "fantacy");
        $buffer->set("morder.age", 28, "fantacy");
        $this->assertEquals(["name" => "John", "age" => 28], $buffer->get("morder", "fantacy"));
        $buffer->unset("morder.age","fantacy");
        $this->assertEquals(["name" => "John"], $buffer->get("morder", "fantacy"));
    }

}