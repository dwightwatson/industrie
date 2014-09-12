<?php namespace Watson\Industrie;

use Watson\Industrie\Exceptions\ClassNotFoundException;
use Watson\Industrie\Exceptions\DefinitionNotFoundException;
use Watson\Industrie\Exceptions\IncompatibleClassException;

class Builder {

    /**
     * Model definitions.
     *
     * @var array
     */
    protected $definitions;

    /**
     * The number of times we are building the class.
     *
     * @param int
     */
    protected $times = 1;

    /**
     * Construct the builder.
     *
     * @param  array  $definitions
     * @return void
     */
    public function __construct(array $definitions = array())
    {
        $this->definitions = $definitions;
    }

    public function getDefinition($class)
    {
        if (array_key_exists($class, $this->definitions))
        {
            return $this->definitions[$class];
        }

        throw new DefinitionNotFoundException("The {$class} definition was not found.");
    }

    public function setDefinition($class, $definition)
    {
        $this->definitions[$class] = $definition;
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
     * Get the attribtues for a class.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return array
     */
    public function attributesFor($class, $overrides = [])
    {
        $definition = $this->getDefinition($class);

        return array_merge(
            call_user_func($definition, new FakerGenerator($this)),
            $overrides
        );
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
        $instance = $this->getInstance($class);

        foreach ($this->attributesFor($class, $overrides) as $key => $value)
        {
            $instance->setAttribute($key, $value);
        }

        return $instance;
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
            $instance = $this->build($class, $overrides);
            $instance->save();

            $instances[] = $instance;
        }

        return count($instances) > 1 ? $instances : $instances[0];
    }

    /*
     * Get an fresh instance of the class or class name provided.
     *
     * @param  stirng  $class
     * @return mixed
     */
    public function getInstance($class)
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

}
