<?php namespace Watson\Industrie;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

class DefinitionLoader {

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
    public function getFactoryDirectory()
    {
        foreach ($this->directories as $directory)
        {
            if (is_dir(base_path() . "/{$directory}"))
            {
                return base_path(). "/{$directory}";
            }
        }

        throw new FactoryDirectoryNotFoundException;
    }

    /**
     * Collect all the files from the factory definitions directory.
     *
     * @return array
     */
    public function getDefinitionFiles()
    {
        $directory = $this->getFactoryDirectory();

        $filenames = [];

        foreach ($this->getDirectoryIterator($directory) as $file)
        {
            if ($file->isFile())
            {
                $filenames[] = $file->getRealPath();
            }
        }

        return $filenames;
    }

    public function getDirectoryIterator($directory)
    {
        return new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory)
        );
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
            require $file;
        }
    }

}
