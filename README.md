Industrie
=========

Industrie is a factory for generating Eloquent models on the fly, making testing easy. It's built upon the [Faker](https://github.com/fzaninotto/Faker) library which makes it really simple to populate your models with good data. It also handles the creation of related models, nested model variations and generating a number of models all at once.

**Please note that Industrie is still in development and has not yet reached a stable release. That means that it is not yet covered by a test suite and that the API is subject to change.**

# Definitions

First you'll need to define the format of your model. In your `tests/factories` folder, create a definition file. For example, you might want to call the definition for your `User` model `Users.php`:

    <?php

    use Watson\Industrie\Factory;

    Factory::blueprint('App\User', function($generator) {
        return [
            'first_name'  => $generator->firstName,
            'family_name' => $generator->lastName,
            'email'       => $generator->email,
            'password'    => $generator->password,
            'status'      => 'approved',

            'posts' => $generator->hasMany('App\Post'),
        ];
    });

Notice that the methods provided by Faker are available on the generator passed into the closure, making it really easy to generate fake data. Also note that these will be recalculated every time you build a new instance so that you won't get stuck with multiple identical models.

The generator also provides methods to define the relationships between your models. The following relationship generators are made available to you.

* belongsTo
* belongsToMany
* hasMany
* hasManyThrough
* hasOne
* hasOneOrMany

# Building

Once you've defined your models you can go ahead and start building them. At the core is the `attributesFor()` method which will simply return an array with valid attributes for your model as per your definitions.

    Factory::attributesFor('App\User');

    [
        'first_name'  => 'John',
        'family_name' => 'Smith',
        'email'       => 'john@smith.com',
        'password'    => 'foobarbaz',
        'status'      => 'approved'
    ]

Cool, what if we wanted to actually `build()` these model instances though?

    Factory::build('App\User'); // new populated App\User instance

If you want multiple models too, it's a cinch with `times()`.

    Factory::times(2)->build('App\User'); // [$user1, $user2]

Finally, if you want to actually persist these new models as they are generated, use the `create()` method.

    Factory::create('App\User');

# Relationships

@todo