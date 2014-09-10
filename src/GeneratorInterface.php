<?php namespace Watson\Industrie;

interface GeneratorInterface {

    /**
     * Generate a belongs to relationship with the class.
     *
     * @param  string  $class
     * @return mixed
     */
    public function belongsTo($class);

    /**
     * Generate a belongs to many relationship with the class a given number
     * of times.
     *
     * @param  string  $class
     * @param  int     $times
     * @return mixed
     */
    public function belongsToMany($class, $times = 1);

    /**
     * Generate a has many relationship with the class a given number of times.
     *
     * @param  string  $class
     * @param  int     $times
     * @return mixed
     */
    public function hasMany($class, $times = 1);

    /**
     * Generate a has many through relationship with the classes a given number
     * of times.
     *
     * @param  string  $class
     * @param  string  $through
     * @param  int     $times
     * @return mixed
     */
    public function hasManyThrough($class, $through, $times = 1);

    /**
     * Generate a has one relationship with the class.
     *
     * @param  string  $class
     * @return mixed
     */
    public function hasOne($class);

    /**
     * Generate a has one or many relationship with the class.
     *
     * @param  string  $class
     * @param  int     $times
     * @return mixed
     */
    public function hasOneOrMany($class, $times = 1);

}
