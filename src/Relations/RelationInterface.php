<?php namespace Watson\Industrie\Relations;

interface RelationInterface {

    /**
     * Construct the relationship.
     *
     * @param  mixed  $relation
     * @param  mixed  $relationship
     * @return void
     */
    public function __construct($relation, $relationship);

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
     * Get the relationship name.
     *
     * @return mixed
     */
    public function getRelationship();

    /**
     * Set the relationship name.
     *
     * @param  mixed  $relationship
     * @return mixed
     */
    public function setRelationship($relationship);

    /**
     * Save the given instance against the given relation.
     *
     * @param  mixed  $instance
     * @return mixed
     */
    public function save($instance);

}
