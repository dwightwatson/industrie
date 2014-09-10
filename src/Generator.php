<?php namespace Watson\Industrie;

use Faker\Factory as Faker;

class Generator {

    /**
     * Faker instance.
     *
     * @var Faker\Factory
     */
    protected $faker;

    /**
     * Construct the generator.
     *
     * @param  string  $formatter
     * @return void
     */
    public function __construct($faker = null, $formatter = 'en_US')
    {
        $this->faker = Faker::create($formatter);
    }

    /**
     * Get the Faker instance.
     *
     * @return mixed
     */
    public function getGenerator()
    {
        return $this->faker;
    }

    /**
     * Set the Faker instance.
     *
     * @param  mixed  $faker
     * @return this
     */
    public function setGenerator($faker)
    {
        $this->faker = $faker;

        return $this;
    }

    public function belongsTo($class)
    {

    }

    public function belongsToMany($class)
    {

    }

    public function hasMany($class)
    {

    }

    public function hasManyThrough($class, $through)
    {

    }

    public function hasOne($class)
    {

    }

    public function hasOneOrMany($class)
    {

    }

    /**
     * Properties can fall back to Faker.
     *
     * @param  string  $key
     * @return mixed
     */
    public function __get($key)
    {
        return $this->faker->{$key};
    }

    /**
     * Methods can call back to Faker.
     *
     * @param  string  $method
     * @param  array   $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        return call_user_func_array([$this->faker, $method], $parameters);
    }

}
