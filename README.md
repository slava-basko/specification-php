# Specification Pattern

Encapsulate your business logic for readable, clear, maintainable purposes.

## How to run tests

PHP 5
```shell
docker run -v `pwd`:/var/www --rm feitosa/php55-with-composer composer install
docker run -v `pwd`:/var/www --rm feitosa/php55-with-composer vendor/bin/phpunit
```

PHP 8
```shell
docker run -v `pwd`:/var/www --rm composer:2.5.8 composer install -d /var/www/
docker run -v `pwd`:/var/www --rm php:8.2-cli var/www/vendor/bin/phpunit /var/www/ -c /var/www/phpunit.xml.dist
```