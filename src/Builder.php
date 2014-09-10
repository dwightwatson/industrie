<?php namespace Watson\Industrie;

use Watson\Industrie\Exceptions\ClassNotFoundException;

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
    public function __construct(array $definitions)
    {
        $this->definitions = $definitions;
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
    public function attributesFor($class, $overrides)
    {
        return call_user_func($this->definitions[$class], new FakerGenerator);
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
        return $this->build($class, $overrides)->save();
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

        return new $class;
    }

}
