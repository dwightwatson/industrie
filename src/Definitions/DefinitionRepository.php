<?php namespace Watson\Industrie\Definitions;

use Closure;
use Watson\Industrie\Exceptions\DefinitionNotFoundException;

class DefinitionRepository implements RepositoryInterface {

    /**
     * All model definitions.
     *
     * @var array
     */
    protected $definitions = [];

    /**
     * Get the definition for the given class.
     *
     * @param  string  $class
     * @return mixed
     * @throws \Watson\Industrie\Excetpions\DefinitionNotFoundException
     */
    public function getDefinition($class)
    {
        if (array_key_exists($class, $this->definitions))
        {
            return $this->definitions[$class];
        }

        throw new DefinitionNotFoundException("The {$class} definition was not found.");
    }

    /**
     * Get all the definitions loaded.
     *
     * @return mixed
     */
    public function getDefinitions()
    {
        return $this->definitions;
    }

    /**
     * Set the definition for the given class.
     *
     * @param  string   $class
     * @param  Closure  $definition
     * @return mixed
     */
    public function setDefinition($class, Closure $definition)
    {
        return $this->definitions[$class] = $definition;
    }

}
