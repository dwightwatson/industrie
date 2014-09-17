<?php namespace Watson\Industrie;

use Closure;
use Watson\Industrie\Definitions\DefinitionRepository;
use Watson\Industrie\Definitions\RepositoryInterface;
use Watson\Industrie\Generators\FakerGenerator;
use Watson\Industrie\Generators\GeneratorInterface;
use Watson\Industrie\Loaders\DefinitionLoader;
use Watson\Industrie\Loaders\LoaderInterface;

class Factory {

    /**
     * The definition repository.
     *
     * @var \Watson\Industrie\Definitions\RepositoryInterface
     */
    protected static $definitions;

    /**
     * The generator instance.
     *
     * @var \Watson\Industrie\Generators\GeneratorInterface
     */
    protected static $generator;

    /**
     * The loader instance.
     *
     * @var \Watson\Industrie\Loaders\LoaderInterface
     */
    protected static $loader;

    /**
     * Get the builder.
     *
     * @return \Watson\Industrie\Builder
     */
    public static function getBuilder()
    {
        if ( ! self::$definitions)
        {
            self::getLoader()->loadDefinitions();
        }

        return new Builder(self::getDefinitions(), self::getGenerator());
    }

    /**
     * Get the loader.
     *
     * @return \Watson\Industrie\Loaders\DefinitionLoader
     */
    public static function getLoader()
    {
        if ( ! self::$loader)
        {
            self::$loader = new DefinitionLoader;
        }

        return self::$loader;
    }

    /**
     * Set the loader.
     *
     * @param  \Watson\Industrie\Loaders\LoaderInterface
     * @return void
     */
    public static function setLoader(LoaderInterface $loader)
    {
        self::$loader = $loader;
    }

    /**
     * Get the class definitions repository.
     *
     * @return \Watson\Industrie\Definitions\RepositoryInterface
     */
    public static function getDefinitions()
    {
        if ( ! self::$definitions)
        {
            self::$definitions = new DefinitionRepository;
        }

        return self::$definitions;
    }

    /**
     * Set the class defintions repository.
     *
     * @param  \Watson\Industrie\Definitions\RepositoryInterface  $definitions
     * @return void
     */
    public static function setDefinitions(RepositoryInterface $definitions)
    {
        self::$definitions = $definitions;
    }

    /**
     * Get the content generator instance.
     *
     * @return \Watson\Industrie\Generators\GeneratorInterface
     */
    public static function getGenerator()
    {
        if ( ! self::$generator)
        {
            self::$generator = new FakerGenerator;
        }

        return self::$generator;
    }

    /**
     * Set the content generator instance.
     *
     * @param  \Watson\Industrie\Generators\GeneratorInterface  $generator
     * @return void
     */
    public static function setGenerator(GeneratorInterface $generator)
    {
        self::$generator = $generator;
    }

    /**
     * Set the model definition for the given class.
     *
     * @param  string   $class
     * @param  Closure  $definition
     * @return void
     */
    public static function setDefinition($class, Closure $definition)
    {
        self::getDefinitions()->setDefinition($class, $definition);
    }

    /**
     * Add the definition for a class to the repository.
     *
     * @param  string   $class
     * @param  Closure  $definition
     * @return void
     */
    public static function blueprint($class, Closure $definition)
    {
        return self::setDefinition($class, $definition);
    }

    /**
     * Syntax-helper for setting the number of times the generator should run.
     *
     * @param  int  $times
     * @return self
     */
    public static function times($times = 2)
    {
        return self::getBuilder()->setTimes($times);
    }

    /**
     * Get the attribtues for a class.
     *
     * @param  string  $class
     * @return array
     */
    public static function attributesFor($class, $overrides = [])
    {
        return self::getBuilder()->attributesFor($class, $overrides);
    }

    /**
     * Wrapper to get the attributes for a class.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return array
     */
    public static function getAttributes($class, $overrides = [])
    {
        return self::attributesFor($class, $overrides);
    }

    /**
     * Build classes with attributes set.
     *
     * @param  string  $class
     * @return mixed
     */
    public static function build($class, $overrides = [])
    {
        return self::getBuilder()->build($class, $overrides);
    }

    /**
     * Build and persist classes with attributes set.
     *
     * @param  string  $class
     * @return mixed
     */
    public static function create($class, $overrides = [])
    {
        return self::getBuilder()->create($class, $overrides);
    }

}
