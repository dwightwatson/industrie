<?php namespace Watson\Industrie\Relations;

interface RelationInterface {

    /**
     * Construct the relationship.
     *
     * @param  mixed  $relation
     * @return void
     */
    public function __construct($relation);

    /**
     * Get the related instance object.
     *
     * @return mixed
     */
    public function getRelation();

    /**
     * Set the related instance object.
     *
     * @param  mixed  $relation
     * @return mixed
     */
    public function setRelation($relation);

    /**
     * Save the given instance against the given relation.
     *
     * @param  mixed  $instance
     * @param  mixed  $relationship
     * @return mixed
     */
    public function save($instance, $relationship);

}
