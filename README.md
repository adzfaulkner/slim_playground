Slim Playground
===============

After hearing a lot of people's appraisal of the Slim PHP microframework, I thought I'd
give it a whirl and here is the result.

Requirements
------------

  * PHP 5.5+
  * Composer

Installation
------------

  1. Git clone this repo
  2. Navigate to root of cloned directory via terminal
  3. Execute `composer install` in terminal
  4. Create data/cache and assign it necessary permissions
  5. Either populate the config/settings.production.php or clone it and create a config/settings.local.php. Either way populate the db creds using http://doctrine-orm.readthedocs.org/projects/doctrine-dbal/en/latest/reference/configuration.html as a guide.
  6. Create a database as configured above.

Enhancements
------------

  * Add tests
  * De-serialize the User entity in the middleware layer
  * Add logout functionality
  * Add logging
