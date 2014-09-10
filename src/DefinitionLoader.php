<?php namespace Watson\Industrie;

use Illuminate\Filesystem\Filesystem as File;

class DefinitionLoader {

    /**
     * File instance.
     *
     * @param \Illuminate\Support\Facades\File
     */
    protected $file;

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

    /*
     * Construct the definition loader.
     *
     * @param  File  $file
     * @return void
     */
    public function __construct(File $file)
    {
        $this->file = $file;
    }

    /**
     * Find the directory that contains the factory definitions.
     *
     * @return mixed
     */
    public function getFactoryDirectory()
    {
        foreach ($this->directories as $directory)
        {
            if ($this->file->isDirectory(base_path() . "/{$directory}"))
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

        return $this->file->files($directory);
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
