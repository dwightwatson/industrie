<?php namespace Watson\Industrie\Loaders;

use Illuminate\Filesystem\Filesystem;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class DefinitionLoader implements LoaderInterface {

    /**
     * Illuminate filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * Construct the loader.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    public function __construct(Filesystem $file)
    {
        $this->file = $file;
    }

    /**
     * Locations to search for model definitions.
     *
     * @var array
     */
    protected $directories = [
        'app/spec/factories',
        'app/tests/factories',
        'spec/factories',
        'tests/factories'
    ];

    /**
     * Find the directory that contains the factory definitions.
     *
     * @return mixed
     */
    public function getDefinitionDirectories()
    {
        $directories = [];

        foreach ($this->directories as $directory)
        {
            if ($this->file->isDirectory(base_path() . "/{$directory}"))
            {
                $directories[] = base_path(). "/{$directory}";
            }
        }

        if (count($directories))
        {
            return $directories;
        }

        throw new FactoryDirectoryNotFoundException;
    }

    /**
     * Get a recursive iterator for all files in the given directory.
     *
     * @param  string  $directory
     * @return RecursiveIteratorIterator
     */
    public function getDirectoryIterator($directory)
    {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );
    }

    /**
     * Collect all the files from the factory definitions directory.
     *
     * @return array
     */
    public function getDefinitionFiles()
    {
        $filenames = [];

        foreach ($this->getDefinitionDirectories() as $directory)
        {
            foreach ($this->file->allFiles($directory) as $file)
            {
                $filenames[] = $file->getRealPath();
            }
        }

        return $filenames;
    }

    /**
     * Load all the definition files.
     *
     * @return void
     */
    public function loadDefinitions()
    {
        foreach ($this->getDefinitionFiles() as $file)
        {
            require_once($file);
        }
    }

}
