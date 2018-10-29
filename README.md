# FILINI
This is small project using the Zend Framework MVC.

# Prerequisites
- apache 2.2+
- php 7.0+
- mysql
- composer
- vagrant & VM

# Installation
Clone repository
```
$ git clone https://github.com/iPaulK/filini.git && cd filini
```
Update dependencies
```
$ composer update
```
Init configs for doctrine
```
$ cp ./config/autoload/doctrine.local.php.dist ./config/autoload/doctrine.local.php
```
Run
```
$ vagrant up --provision
```
Connect 
```
$ vagrant ssh
```
Generate entity classes and method stubs from your mapping information.
```
$ php vendor/bin/doctrine-module orm:generate:entities module/Core/src
```
Processes the schema and either update the database schema of EntityManager Storage Connection or generate the SQL output.
```
$ php vendor/bin/doctrine-module orm:schema-tool:update --force
```
Loading of data fixtures for the Doctrine ORM from a directory module/Core/src/DataFixtures/ORM/
```
$ php vendor/bin/doctrine-module data-fixtures:load --append
```
Open on yout browser:
```
$ http://localhost:8080
```