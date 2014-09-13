<?php

class DefinitionRepositoryTest extends PHPUnit_Framework_TestCase {

    public $repo;

    public function setUp()
    {
        $this->repo = new Watson\Industrie\DefinitionRepository;
    }

    public function testGetsDefinition()
    {
        $this->repo->setDefinition('foo', 'bar');

        $this->assertEquals('bar', $this->repo->getDefinition('foo'));
    }

    public function testThrowsExceptionWhenGettingDefinitionThatDoesNotExist()
    {
        $this->setExpectedException('Watson\Industrie\Exceptions\DefinitionNotFoundException');

        $this->repo->getDefinition('foo');
    }

    public function testGetsAllDefinitions()
    {
        $this->repo->setDefinition('foo', 'bar');
        $this->repo->setDefinition('bat', 'baz');

        $this->assertEquals(['foo' => 'bar', 'bat' => 'baz'], $this->repo->getDefinitions());
    }

    public function testSetsDefinition()
    {
        $this->repo->setDefinition('foo', 'bar');

        $this->assertEquals('bar', $this->repo->getDefinition('foo'));
    }

}
