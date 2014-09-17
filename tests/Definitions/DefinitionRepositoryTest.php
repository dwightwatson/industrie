<?php

class DefinitionRepositoryTest extends PHPUnit_Framework_TestCase {

    public $repo;

    public function setUp()
    {
        $this->repo = new Watson\Industrie\Definitions\DefinitionRepository;
    }

    public function testGetsDefinition()
    {
        $closure = function(){ return 'bar'; };

        $this->repo->setDefinition('foo', $closure);

        $this->assertEquals($closure, $this->repo->getDefinition('foo'));
    }

    public function testThrowsExceptionWhenGettingDefinitionThatDoesNotExist()
    {
        $this->setExpectedException('Watson\Industrie\Exceptions\DefinitionNotFoundException');

        $this->repo->getDefinition('foo');
    }

    public function testGetsAllDefinitions()
    {
        $closure1 = function(){ return 'bar'; };
        $closure2 = function(){ return 'baz'; };

        $this->repo->setDefinition('foo', $closure1);
        $this->repo->setDefinition('bat', $closure2);

        $this->assertEquals(['foo' => $closure1, 'bat' => $closure2], $this->repo->getDefinitions());
    }

    public function testSetsDefinition()
    {
        $closure = function(){ return 'bar'; };

        $result = $this->repo->setDefinition('foo', $closure);

        $this->assertEquals($closure, $result);
        $this->assertEquals($closure, $this->repo->getDefinition('foo'));
    }

}
