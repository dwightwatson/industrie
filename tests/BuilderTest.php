<?php

class BuilderTest extends PHPUnit_Framework_TestCase {

    protected $definitions;

    protected $builder;

    public function setUp()
    {
        $this->definitions = Mockery::mock('Watson\Industrie\Definitions\DefinitionRepository');
        $this->generator = Mockery::mock('Watson\Industrie\Generators\FakerGenerator');

        $this->builder = new Watson\Industrie\Builder($this->definitions, $this->generator);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetsDefinitions()
    {
        $result = $this->builder->getDefinitions();

        $this->assertEquals($this->definitions, $result);
    }

    public function testSetsDefinitions()
    {
        $mock = Mockery::mock('Watson\Industrie\Definitions\DefinitionRepository');

        $this->builder->setDefinitions($mock);

        $this->assertEquals($mock, $this->builder->getDefinitions());
    }

    public function testGetsGenerator()
    {
        $result = $this->builder->getGenerator();

        $this->assertEquals($this->generator, $result);
    }

    public function testSetsGenerator()
    {
        $mock = Mockery::mock('Watson\Industrie\Generators\FakerGenerator');

        $this->builder->setGenerator($mock);

        $this->assertEquals($mock, $this->builder->getGenerator());
    }

    public function testGetsTimes()
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
        $this->definitions->shouldReceive('getDefinition')
            ->with('Foo')
            ->once()
            ->andReturn(function($generator)
            {
                return ['foo' => 'bar'];
            });

        $this->generator->shouldReceive('setGenerateRelations')
            ->once()
            ->with(false);

        $result = $this->builder->attributesFor('Foo');

        $this->assertEquals(['foo' => 'bar'], $result);
    }

    public function testAttributesForWithOverrides()
    {
        $this->definitions->shouldReceive('getDefinition')
            ->with('Foo')
            ->once()
            ->andReturn(function($generator)
            {
                return ['foo' => 'bar'];
            });

        $this->generator->shouldReceive('setGenerateRelations')
            ->once()
            ->with(false);

        $result = $this->builder->attributesFor('Foo', ['foo' => 'baz']);

        $this->assertEquals(['foo' => 'baz'], $result);
    }

    public function testBuild()
    {

    }

    public function testCreate()
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
