<?php

use Watson\Industrie\Factory;

class FactoryTest extends PHPUnit_Framework_TestCase {

    public $loader;

    public function setUp()
    {
        $this->loader = Mockery::mock('Watson\Industrie\Loaders\LoaderInterface');
        Factory::setLoader($this->loader);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetBuilderLoadsDefinitionsIfNotLoaded()
    {
        $this->loader->shouldReceive('loadDefinitions')->once();

        Factory::getBuilder();
    }

    public function testGetBuilderReturnsNewBuilder()
    {
        $definitions = Mockery::mock('Watson\Industrie\Definitions\RepositoryInterface');
        Factory::setDefinitions($definitions);

        $result = Factory::getBuilder();

        $this->assertInstanceOf('Watson\Industrie\Builder', $result);
    }

}
