<?php

class DefinitionLoaderTest extends PHPUnit_Framework_TestCase {

    protected $file;

    protected $loader;

    public function setUp()
    {
        $this->file = Mockery::mock('Illuminate\Filesystem\Filesystem');

        $this->loader = new Watson\Industrie\Loaders\DefinitionLoader($this->file);
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testNothing()
    {

    }

}
