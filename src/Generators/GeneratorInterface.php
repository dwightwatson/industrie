<?php namespace Watson\Industrie\Generators;

interface GeneratorInterface {

    /**
     * Generate a belongs to relationship with the class.
     *
     * @param  string  $class
     * @return mixed
     */
    public function belongsTo($class);

}
