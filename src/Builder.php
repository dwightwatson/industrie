<?php namespace Watson\Industrie;

use Watson\Industrie\Definitions\RepositoryInterface;
use Watson\Industrie\Exceptions\ClassNotFoundException;
use Watson\Industrie\Exceptions\DefinitionNotFoundException;
use Watson\Industrie\Exceptions\IncompatibleClassException;
use Watson\Industrie\Generators\GeneratorInterface;
use Watson\Industrie\Relations\RelationInterface;

class Builder {

    /**
     * Model definition repository.
     *
     * @var \Watson\Industrie\Definitions\RepositoryInterface
     */
    protected $definitions;

    /**
     * The generator instance.
     *
     * @var \Watson\Industrie\Generators\GeneratorInterface
     */
    protected $generator;

    /**
     * The number of times we are building the class.
     *
     * @param int
     */
    protected $times = 1;

    /**
     * Construct the builder.
     *
     * @param  \Watson\Industrie\Definitions\RepositoryInterface  $definitions
     * @param  \Watson\Industrie\Generators\GeneratorInterface    $generator
     * @return void
     */
    public function __construct(RepositoryInterface $definitions, GeneratorInterface $generator)
    {
        $this->definitions = $definitions;
        $this->generator = $generator;
    }

    /**
     * Get the definition repository.
     *
     * @return \Watson\Industrie\Definitions\RepositoryInterface
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * Set the definition repository.
     *
     * @param  \Watson\Industrie\Definitions\RepositoryInterface
     * @return void
     */
    public function setDefinitions(RepositoryInterface $definitions)
    {
        $this->definitions = $definitions;
    }

    /**
     * Get the generator.
     *
     * @return \Watson\Industrie\Generators\GeneratorInterface
     */
    public function getGenerator()
    {
        return $this->generator;
    }

    /**
     * Set the generator.
     *
     * @param  \Watson\Industrie\Generators\GeneratorInterface
     * @return void
     */
    public function setGenerator(GeneratorInterface $generator)
    {
        $this->generator = $generator;
    }

    /**
     * Get the number of times we are building the class.
     *
     * @return int
     */
    public function getTimes()
    {
        return $this->times;
    }

    /**
     * Set the number of times we are building the class.
     *
     * @param  int  $times
     * @return this
     */
    public function setTimes($times = 2)
    {
        $this->times = $times;

        return $this;
    }

    /**
     * Wrapper to set the number of times we are building the class.
     *
     * @param  int  $times
     * @return this
     */
    public function times($times = 2)
    {
        return $this->setTimes($times);
    }

    /**
     * Get the attributes for a class.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return array
     */
    public function attributesFor($class, $overrides = [])
    {
        $definition = $this->getDefinitions()->getDefinition($class);

        $this->generator->setBuilder($this);

        $attributes = call_user_func($definition, $this->generator);

        return array_merge($attributes, $overrides);
    }

    /**
     * Build classes with attributes set.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return mixed
     */
    public function build($class, $overrides = [])
    {
        return $this->buildInstance($class, $overrides);
    }

    /**
     * Build and persist classes with attributes set.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return mixed
     */
    public function create($class, $overrides = [])
    {
        $instances = [];

        for ($i = 0; $i < $this->getTimes(); $i++)
        {
            $instances[] = $this->buildInstance($class, $overrides, true);
        }

        return count($instances) > 1 ? $instances : $instances[0];
    }

    /*
     * Get an fresh instance of the class or class name provided.
     *
     * @param  stirng  $class
     * @return mixed
     */
    protected function getInstance($class)
    {
        if ( ! class_exists($class))
        {
            throw new ClassNotFoundException("The {$class} class was not found.");
        }

        if ( ! is_subclass_of($class, 'Illuminate\Database\Eloquent\Model'))
        {
            throw new IncompatibleClassException("The {$class} class is not an Eloquent model.");
        }

        return new $class;
    }

    /**
     * Build an instance of the given class with attributes.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @param  bool    $persist
     * @return mixed
     */
    protected function buildInstance($class, $overrides = [], $persist = false)
    {
        $instance = $this->getInstance($class);

        foreach ($this->attributesFor($class, $overrides) as $key => $value)
        {
            if ($value instanceof RelationInterface)
            {
                $value->save($instance, $key);
            }
            else
            {
                $instance->setAttribute($key, $value);
            }
        }

        if ($persist)
        {
            $instance->save();
        }

        return $instance;
    }

}
