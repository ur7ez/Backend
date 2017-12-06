<?php
/**
 * Created by PhpStorm.
 * User: Mike
 * Date: 27.11.2017
 * Time: 19:55
 */
class ArrayTest extends \PHPUnit\Framework\TestCase
{
    public function testEmpty()
    {
        $data = [];
        $this->assertEquals(0, count($data));
    }

    public function testInsertion()
    {
        $data = [];
        array_push($data, 0);
        $this->assertNotEmpty($data);
    }

    /**
     * @expectedException PHPUnit\Framework\Error\Error
     */
    public function testFailingInclude()
    {
        include 'not_existing_file.php';
    }
}