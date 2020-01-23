api-ns
======

Installation
------------

``` bash
$ git clone https://github.com/DanMistyk/api-ns.git
$ cd api-ns
$ composer install
```

Configuration
-------------
Change parameters.yml (app/confing/parameters.yml)

``` bash
# Create database
$ php bin/console doctrine:database:create
# Create schema
$ php bin/console doctrine:schema:create
# Load fixtures
$ php bin/console doctrine:fixtures:load
```
Usage
-----

``` bash
# Start server
$ php bin/console server:start
```
### API 

- **List users** : 

**URL** : 127.0.0.1:8000/users/
**Method** : GET 

- **Show user** : 

**URL** : 127.0.0.1:8000/users/{id}
**Method** : GET 

- **Edit user** : 

**URL** : 127.0.0.1:8000/users/{id}
**Method** : PUT
**Json** : {"firstname" : "xxx", "lastname": "xxx"} 

- **Delete user** : 

**URL** : 127.0.0.1:8000/users/{id}
**Method** : DELETE 
