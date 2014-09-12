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
    public function getDefinitionDirectory()
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
        $directory = $this->getDefinitionDirectory();

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
