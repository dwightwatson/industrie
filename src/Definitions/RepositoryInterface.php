<?php namespace Watson\Industrie\Definitions;

interface RepositoryInterface {

    /**
     * Get the definition for the given class.
     *
     * @param  string  $class
     * @return mixed
     * @throws \Watson\Industrie\Excetpions\DefinitionNotFoundException
     */
    public function getDefinition($class);

    /**
     * Get all the definitions loaded.
     *
     * @return mixed
     */
    public function getDefinitions();

    /**
     * Set the definition for the given class.
     *
     * @param  string  $class
     * @param  mixed   $definition
     * @return mixed
     */
    public function setDefinition($class, $definition);

}
