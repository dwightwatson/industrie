<?php namespace Watson\Industrie\Loaders;

use Illuminate\Filesystem\Filesystem;
use Watson\Industrie\Exceptions\FactoryDirectoryNotFoundException;

class DefinitionLoader implements LoaderInterface {

    /**
     * Illuminate filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $file;

    /**
     * The application base path.
     *
     * @var string
     */
    protected $basePath;

    /**
     * Construct the loader.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $file
     * @param  string  $basePath
     * @return void
     */
    public function __construct(Filesystem $file, $basePath = null)
    {
        $this->file = $file;
        $this->basePath = $basePath ?: base_path();
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
     * Get the loader base path.
     *
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * Set the loader base path.
     *
     * @param  string  $basePath
     * @return void
     */
    public function setBasePath($basePath)
    {
        $this->basePath = $basePath;
    }

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
            if ($this->file->isDirectory($this->getBasePath() . "/{$directory}"))
            {
                $directories[] = $this->getBasePath() . "/{$directory}";
            }
        }

        if (count($directories))
        {
            return $directories;
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
