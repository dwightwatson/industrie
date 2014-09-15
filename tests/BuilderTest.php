<?php

class BuilderTest extends PHPUnit_Framework_TestCase {

    public $repo;

    public $builder;

    public function setUp()
    {
        $this->repo = Mockery::mock('Watson\Industrie\Definitions\DefinitionRepository');
        $this->generator = Mockery::mock('Watson\Industrie\Generators\FakerGenerator');

        $this->generator->shouldReceive('setBuilder');

        $this->builder = new Watson\Industrie\Builder($this->repo, $this->generator);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetTimes()
    {
        $this->assertEquals(1, $this->builder->getTimes());
    }

    public function testSetTimes()
    {
        $this->builder->setTimes();
        $this->assertEquals(2, $this->builder->getTimes());

        $this->builder->setTimes(3);
        $this->assertEquals(3, $this->builder->getTimes());
    }

    public function testTimes()
    {
        $this->builder->times(3);
        $this->assertEquals(3, $this->builder->getTimes());
    }

    public function testAttributesFor()
    {
    }

    public function testAttributesForWithOverrides()
    {

    }

    public function testBuild()
    {

    }

    public function testBuildWithMissingClass()
    {
        $this->setExpectedException('Watson\Industrie\Exceptions\ClassNotFoundException');

        $this->builder->build('Foo');
    }

    public function testBuildWithIncompatibleClass()
    {
        $this->setExpectedException('Watson\Industrie\Exceptions\IncompatibleClassException');

        $this->builder->build('IncompatibleModelStub');
    }

}

class IncompatibleModelStub {}
