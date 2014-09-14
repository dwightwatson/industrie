<?php namespace Watson\Industrie\Relations;

class BelongsToRelation implements RelationInterface {

    /**
     * The related instance object.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $relation;

    /**
     * Construct the relationship.
     *
     * @param  mixed  $relation
     * @return void
     */
    public function __construct($relation)
    {
        $this->relation = $relation;
    }

    /**
     * Get the related instance object.
     *
     * @return mixed
     */
    public function getRelation()
    {
        return $this->relation;
    }

    /**
     * Set the related instance object.
     *
     * @param  mixed  $relation
     * @return mixed
     */
    public function setRelation($relation)
    {
        return $this->relation = $relation;
    }

    /**
     * Save the given instance against the given relation.
     *
     *
     * @param  mixed  $instance
     * @param  mixed  $relationship
     * @return mixed
     */
    public function save($instance, $relationship)
    {
        $instance->{$relationship}()->associate($this->relation);
    }

}
