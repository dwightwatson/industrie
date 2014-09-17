<?php namespace Watson\Industrie\Generators;

use Faker\Factory as Faker;
use Faker\Generator as Generator;
use Watson\Industrie\Builder;
use Watson\Industrie\Relations\BelongsToRelation;

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
    public function __construct(Generator $faker = null)
    {
        $this->faker = $faker ?: Faker::create('en_US');
    }

    /**
     * Get the builder.
     *
     * @return \Watson\Industrie\Builder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * Set the builder.
     *
     * @param  \Watson\Industrie\Builder  $builder
     * @return void
     */
    public function setBuilder($builder)
    {
        $this->builder = $builder;
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

    /**
     * Generate the belongs to relationship.
     *
     * @param  string  $class
     * @param  array   $overrides
     * @return \Watson\Industrie\Relations\BelongsToRelation
     */
    public function belongsTo($class, $overrides = [])
    {
        $instance = $this->builder->create($class, $overrides, 1);

        return new BelongsToRelation($instance);
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
