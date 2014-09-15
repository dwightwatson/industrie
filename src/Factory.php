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
     * Get the builder.
     *
     * @return \Watson\Industrie\Builder
     */
    public static function getInstance()
    {
        if ( ! self::$builder)
        {
            self::$builder = new Builder(
                new DefinitionRepository,
                new FakerGenerator
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
     * Set the model definition for the given class.
     *
     * @param  string         $class
     * @param  array|Closure  $definition
     * @return void
     */
    public static function setDefinition($class, $definition)
    {
        self::getInstance()->getDefinitions()->setDefinition($class, $definition);
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
        return self::getInstance()->setTimes($times);
    }

    /**
     * Get the attribtues for a class.
     *
     * @param  string  $class
     * @return array
     */
    public static function attributesFor($class, $overrides = [])
    {
        return self::getInstance()->attributesFor($class, $overrides);
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
        return self::getInstance()->build($class, $overrides);
    }

    /**
     * Build and persist classes with attributes set.
     *
     * @param  string  $class
     * @return mixed
     */
    public static function create($class, $overrides = [])
    {
        return self::getInstance()->create($class, $overrides);
    }

}
