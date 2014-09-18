<?php

use Watson\Industrie\Factory;

class FactoryTest extends PHPUnit_Framework_TestCase {

    protected $loader;

    public function setUp()
    {
        $this->loader = Mockery::mock('Watson\Industrie\Loaders\LoaderInterface');
        Factory::setLoader($this->loader);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetsBuilderAndLoadsDefinitions()
    {
        $this->loader->shouldReceive('loadDefinitions')->once();

        $result = Factory::getBuilder();

        $this->assertInstanceOf('Watson\Industrie\Builder', $result);
    }

    public function testGetsLoader()
    {
        $result = Factory::getLoader();

        $this->assertEquals($this->loader, $result);
    }

    public function testSetsLoader()
    {
        $mock = Mockery::mock('Watson\Industrie\Loaders\LoaderInterface');
        Factory::setLoader($mock);

        $result = Factory::getLoader();

        $this->assertEquals($mock, $result);
    }

    public function testGetsDefinitions()
    {
        $result = Factory::getDefinitions();

        $this->assertInstanceOf('Watson\Industrie\Definitions\RepositoryInterface', $result);
    }

}
