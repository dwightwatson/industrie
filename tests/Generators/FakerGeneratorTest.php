<?php

class FakerGeneratorTest extends PHPUnit_Framework_TestCase {


    public $faker;

    public $generator;

    public function setUp()
    {
        $this->faker = Mockery::mock('Faker\Generator');

        $this->generator = new Watson\Industrie\Generators\FakerGenerator(
            $this->faker
        );
    }

    public function testDefaultsToFakerGenerator()
    {
        $result = (new Watson\Industrie\Generators\FakerGenerator)->getGenerator();

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

    public function testProperitesFallBackToGenerator()
    {
        $this->faker->shouldReceive('format')->with('foo')->andReturn('bar');

        $result = $this->generator->foo;

        $this->assertEquals('bar', $result);
    }

    public function testMethodsFallBackToGenerator()
    {
        $this->faker->shouldReceive('foo')->with('bar')->andReturn('baz');

        $result = $this->generator->foo('bar');

        $this->assertEquals('baz', $result);
    }

}
