<?php

class DefinitionLoaderTest extends PHPUnit_Framework_TestCase {

    protected $file;

    protected $loader;

    public function setUp()
    {
        $this->file = Mockery::mock('Illuminate\Filesystem\Filesystem');

        $this->loader = new Watson\Industrie\Loaders\DefinitionLoader($this->file, 'foo');
    }

    public function tearDown()
    {
        Mockery::close();
    }

    public function testGetsBasePath()
    {
        $result = $this->loader->getBasePath();

        $this->assertEquals('foo', $result);
    }

    public function testSetsBasePath()
    {
        $this->loader->setBasePath('bar');

        $this->assertEquals('bar', $this->loader->getBasePath());
    }


    public function testGetsDefinitionDirectories()
    {
        $this->file->shouldReceive('isDirectory')
            ->andReturn(true);

        $result = $this->loader->getDefinitionDirectories();

        $this->assertCount(4, $result);
    }

    public function testThrowsExceptionWithoutDefinitionDirectories()
    {
        $this->setExpectedException('Watson\Industrie\Exceptions\FactoryDirectoryNotFoundException');

        $this->file->shouldReceive('isDirectory')->andReturn(false);

        $this->loader->getDefinitionDirectories();
    }

    public function testGetsDefinitionFiles()
    {
        $this->file->shouldReceive('isDirectory')
            ->andReturn(true);

        $this->file->shouldReceive('allFiles')
            ->andReturn([]);

        $this->loader->getDefinitionFiles();
    }

}
