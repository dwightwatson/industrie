<?php namespace Watson\Industrie;

use Faker\Factory as Faker;
use Faker\Generator as Generator;

class FakerGenerator implements GeneratorInterface {

    /**
     * Builder instance.
     *
     * @var \Watson\Industrie\Builder
     */
    protected $builder;

    /**
     * Faker instance.
     *
     * @var \Faker\Factory
     */
    protected $faker;

    /**
     * Construct the generator.
     *
     * @param  Faker\Generator   $faker
     * @return void
     */
    public function __construct(Builder $builder, Generator $faker = null)
    {
        $this->builder = $builder;
        $this->faker = $faker ?: Faker::create('en_US');
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

    public function belongsToMany($class, $times = 1)
    {

    }

    public function hasMany($class, $times = 1)
    {

    }

    public function hasManyThrough($class, $through, $times = 1)
    {

    }

    public function hasOne($class)
    {
        return $this->hasOneOrMany($class);
    }

    public function hasOneOrMany($class, $times = 1)
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
        return $this->faker->format($key);
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
