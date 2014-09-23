<?php namespace Watson\Industrie\Generators;

use Faker\Factory as Faker;
use Faker\Generator as Generator;
use Watson\Industrie\Relations\BelongsToRelation;
use Watson\Industrie\Factory;

class FakerGenerator implements GeneratorInterface {

    /**
     * Faker instance.
     *
     * @var \Faker\Factory
     */
    protected $faker;

    /**
     * Generated relations.
     *
     * @var array
     */
    protected $relations = [];

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
        $instance = $this->getRelation($class, $overrides);

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
