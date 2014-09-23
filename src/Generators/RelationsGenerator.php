<?php namespace Watson\Industrie\Generators;

use Watson\Industrie\Relations\BelongsToRelation;
use Watson\Industrie\Factory;

abstract class RelationsGenerator implements GeneratorInterface {

    /**
     * Generated relations.
     *
     * @var array
     */
    protected $relations = [];

    /**
     * Generating relations.
     *
     * @var bool
     */
    protected $generateRelations = true;

    /**
     * Whether the generator will generate relations.
     *
     * @return bool
     */
    public function getGenerateRelations()
    {
        return $this->generateRelations;
    }

    /**
     * Set whether the generator will generate relations.
     *
     * @param  bool  $value
     * @return void
     */
    public function setGenerateRelations($value)
    {
        $this->generateRelations = $value;
    }

    /**
     * Generate the belongs to relationship.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return \Watson\Industrie\Relations\BelongsToRelation
     */
    public function belongsTo($class, $overrides = [])
    {
        if ($this->getGenerateRelations())
        {
            $instance = $this->getRelation($class, $overrides);

            return new BelongsToRelation($instance);
        }
    }

    /**
     * Get a related instance.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return mixed
     */
    protected function getRelation($class, $overrides)
    {
        if ( ! array_key_exists($class, $this->relations))
        {
            $this->relations[$class] = Factory::create($class, $overrides);
        }

        return $this->relations[$class];
    }
}
