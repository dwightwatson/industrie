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
     * Generate the belongs to relationship.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return \Watson\Industrie\Relations\BelongsToRelation
     */
    public function belongsTo($class, $overrides = [])
    {
        $instance = $this->getRelation($class, $overrides);

        return new BelongsToRelation($instance);
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
