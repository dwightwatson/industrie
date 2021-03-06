Industrie
=========

[![Circle CI](https://circleci.com/gh/dwightwatson/industrie.png?style=shield)](https://circleci.com/gh/dwightwatson/industrie)

Industrie is a factory for generating Eloquent models on the fly, making testing easy. It's built upon the [Faker](https://github.com/fzaninotto/Faker) library which makes it really simple to populate your models with good data. It also handles the creation of related models, nested model variations and generating a number of models all at once.

**Please note that Industrie is still in development and has not yet reached a stable release. That means that it is not yet covered by a test suite and that the API is subject to change.**

# Installation
Simply install Industrie through Composer, just add it to your `require-dev` dependencies.

    "watson/industrie": "dev-master"

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

            'country' => $generator->belongsTo('App\Country')
        ];
    });

Notice that the methods provided by Faker are available on the generator passed into the closure, making it really easy to generate fake data. Also note that these will be recalculated every time you build a new instance so that you won't get stuck with multiple identical models.

# Building
Once you've defined your models you can go ahead and start building them. At the core is the `attributesFor()` method which will simply return an array with valid attributes for your model as per your definitions.

    Factory::attributesFor('App\User');

    // Array of attributes.
    // [
    //     'first_name'  => 'John',
    //     'family_name' => 'Smith',
    //     'email'       => 'john@smith.com',
    //     'password'    => 'foobarbaz',
    //     'status'      => 'approved'
    // ]

Cool, what if we wanted to actually `build()` these model instances though?

    Factory::build('App\User');

    // New populated user instace.
    // App\User([
    //     'first_name'  => 'Jane',
    //     'family_name' => 'Doe',
    //     'email'       => 'jane@doe.com',
    //     'password'    => 'hunter2',
    //     'status'      => 'approved'
    // ])

If you want multiple models too, it's a cinch with `times()`.

    Factory::times(2)->build('App\User');

    // Array of new users with relations.
    // [
    //     App\User([
    //         'first_name'  => 'John',
    //         'family_name' => 'Smith',
    //         'email'       => 'john@smith.com',
    //         'password'    => 'foobarbaz',
    //         'status'      => 'approved',
    // 
    //         'country'     => App\Country(...)
    //     ]),
    //     App\User([
    //         'first_name'  => 'Jane',
    //         'family_name' => 'Doe',
    //         'email'       => 'jane@doe.com',
    //         'password'    => 'hunter2',
    //         'status'      => 'approved',
    // 
    //         'country'     => App\Country(...)
    //     ])
    // ]

Finally, if you want to actually persist these new models as they are generated, use the `create()` method.

    Factory::create('App\User');

# Relationships
Relationships will only be generated when you create a model (not when you build the model or just fetch the attributes for a model, for example). Industrie will recursively loop through your model definitions and create the tree of dependencies for your model.

To define a relationship, simply set the field on your model definition using the `belongsTo` generator. You may also pass any overrides you wish through to the generator.

# Generators
By default Industrie ships with a generator that makes use of Faker with the `en_US` definitions. It's really simple to override the Faker dictionary by passing in another Faker generator instance to the `FakerGenerator`.

    // Pass your own Faker instance to \Watson\Industrie\Generators\FakerGenerator
    Factory::setGenerator(new FakerGenerator(Faker::create('en_AU')));

You can even replace the Faker generator completely with your own generator that implements `GeneratorInterface`.

    class MyGenerator extends \Watson\Industrie\Generators\GeneratorInterface {
        // ...
    }

    Factory::setGenerator(new MyGenerator);