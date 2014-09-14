<?php namespace Watson\Industrie\Relations;

class BelongsToRelation implements RelationInterface {

    /**
     * The related instance object.
     *
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $relation;

    /**
     * The relationship name on the instance object.
     *
     * @var string
     */
    protected $relationship;

    /**
     * Construct the relationship.
     *
     * @param  mixed  $relation
     * @param  mixed  $relationship
     * @return void
     */
    public function __construct($relation, $relationship)
    {
        $this->relation = $relation;
        $this->relationshipName = $relationshipName;
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
     * Get the relationship name.
     *
     * @return mixed
     */
    public function getRelationship()
    {
        return $this->relationship;
    }

    /**
     * Set the relationship name.
     *
     * @param  mixed  $relationship
     * @return mixed
     */
    public function setRelationship($relationship)
    {
        return $this->relationship = $relationship;
    }

    /**
     * Save the given instance against the given relation.
     *
     *
     * @param  mixed  $instance
     * @param  mixed  $relation
     * @return mixed
     */
    public function save($instance)
    {
        $instance->{$this->relationshipName}()->associate($this->relation);
    }

}
