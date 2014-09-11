<?php

class FakerGeneratorTest extends PHPUnit_Framework_TestCase {

    public $mock;

    public $generator;

    public function setUp()
    {
        $this->mock = Mockery::mock('Faker\Generator');

        $this->generator = new Watson\Industrie\FakerGenerator($this->mock);
    }

    public function testDefaultsToFakerGenerator()
    {
        $result = (new Watson\Industrie\FakerGenerator)->getGenerator();

        $this->assertInstanceOf('Faker\Generator', $result);
    }

    public function testGetGenerator()
    {
        $result = $this->generator->getGenerator();

        $this->assertInstanceOf('Faker\Generator', $result);
    }

    public function testSetGenerator()
    {
        $this->generator->setGenerator('foo');

        $this->assertEquals('foo', $this->generator->getGenerator());
    }

    public function testBelongsTo()
    {

    }

    public function testBelongsToMany()
    {

    }

    public function testHasMany()
    {

    }

    public function testHasManyThrough()
    {

    }

    public function testHasOne()
    {

    }

    public function testHasOneOrMany()
    {

    }

    public function testProperitesFallBackToGenerator()
    {
        $this->mock->shouldReceive('format')->with('foo')->andReturn('bar');

        $result = $this->generator->foo;

        $this->assertEquals('bar', $result);
    }

    public function testMethodsFallBackToGenerator()
    {
        $this->mock->shouldReceive('foo')->with('bar')->andReturn('baz');

        $result = $this->generator->foo('bar');

        $this->assertEquals('baz', $result);
    }

}
