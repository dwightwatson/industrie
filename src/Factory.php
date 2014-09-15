<?php namespace Watson\Industrie;

use Watson\Industrie\Definitions\DefinitionRepository;
use Watson\Industrie\Generators\FakerGenerator;
use Watson\Industrie\Loaders\DefinitionLoader;

class Factory {

    /**
     * Builder instance.
     *
     * @var Builder
     */
    protected static $builder;

    /**
     * Loader instance.
     *
     * @var DefinitionLoader
     */
    protected static $loader;

    /**
     * The class implementing the RepositoryInterface to be used.
     *
     * @var string
     */
    protected static $repository = 'Watson\Industrie\Definitions\DefinitionRepository';

    /**
     * The class implementing the GeneratorInterface to be used.
     *
     * @var string
     */
    protected static $generator = 'Watson\Industrie\Generators\FakerGenerator';

    /**
     * Get the builder.
     *
     * @return \Watson\Industrie\Builder
     */
    public static function getBuilder()
    {
        if ( ! self::$builder)
        {
            self::$builder = new Builder(
                new self::$repository,
                new self::$generator
            );

            self::getLoader()->loadDefinitions();
        }

        return self::$builder;
    }

    /**
     * Set the builder.
     *
     * @param  mixed  $builder
     * @return void
     */
    public static function setBuilder($builder)
    {
        self::$builder = $builder;
    }

    /**
     * Get the loader.
     *
     * @return \Watson\Industrie\DefinitionLoader
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
     * Set the builder.
     *
     * @param  mixed  $loader
     * @return void
     */
    public static function setLoader($loader)
    {
        self::$loader = $loader;
    }

    /**
     * Get the repository class being used by the factory.
     *
     * @return string
     */
    public static function getRepository()
    {
        return self::$repository;
    }

    /**
     * Set the repository class being used by the factory.
     *
     * @param  string  $repository
     * @return void
     */
    public static function setRepository($repository)
    {
        self::$repository = $repository;
    }

    /**
     * Get the generator class being used by the factory.
     *
     * @return string
     */
    public static function getGenerator()
    {
        return self::$generator;
    }

    /**
     * Set the generator class being used by the factory.
     *
     * @param  string  $generator
     * @return void
     */
    public static function setGenerator($generator)
    {
        self::$generator = $generator;
    }

    /**
     * Set the model definition for the given class.
     *
     * @param  string         $class
     * @param  array|Closure  $definition
     * @return void
     */
    public static function setDefinition($class, $definition)
    {
        self::getBuilder()->getDefinitions()->setDefinition($class, $definition);
    }

    /**
     * Add the definition for a class to the repository.
     *
     * @param  string         $class
     * @param  array|Closure  $definition
     * @return void
     */
    public static function blueprint($class, $definition)
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
