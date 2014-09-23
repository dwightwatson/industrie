<?php namespace Watson\Industrie\Generators;

interface GeneratorInterface {

    /**
     * Whether the generator will generate relations.
     *
     * @return bool
     */
    public function getGenerateRelations();

    /**
     * Set whether the generator will generate relations.
     *
     * @param  bool  $value
     * @return void
     */
    public function setGenerateRelations($value);

    /**
     * Generate a belongs to relationship with the class.
     *
     * @param  string  $class
     * @return mixed
     */
    public function belongsTo($class);

}
