# About Subscription

## Implemented Feature:
* Developer using Laravel Framework 5.7.14
* Has HTTP JSON API
* ORM and relationships/associations using Eloquent
* Validating requests
* Usage of other framework features: migrations, seeders, tests, etc
* PSR-2 compliant source code as much possible.

## how to run a project on local environment
- Create your database using MySQL client.
- Add your local database setting to the .env file.
- In the Terminal / Command Line, navigate to this directory and run the following commands:
	* composer install
	* php artisan migrate --seed
	  this will create user with email: admin@mailerlite.com, password: 123456
	* php artisan serve
## Running test:
- Create your testing database using MySQL client
- Add your local database details to the .env.testing file.
- In the Terminal / Command Line, navigate to this directory and run the following commands:
	* php artisan migrate --env=testing
	* vendor/bin/phpunit --coverage-html ./reports


## Background / Intro
This app has two parts [a] API and [b] Front end using the API.

###List of API's:

## Field list
GET api/v1/field/list
Give list of all field, which can be use to render Subscription Form.

## Register API User
POST api/v1/register
Register new user.

## Login API user
POST api/v1/login
Login and generate new API key on every login.

## Logout API user
POST api/v1/login 
Clears API key, to make it invalid.

## Subscriber list
GET api/v1/subscriber/list
Return list of all subscriber for the login user(base on API key).

## Add Subscriber
POST api/v1/subscriber
Create new subscription

## Update Subscriber
PATCH api/v1/subscriber/{subscription}
Update subscriber details, this can be used by login user to update subcriber details,
except "STATE".

## Get Subscriber
GET api/v1/subscriber/{subscription}
Get single subscriber details

## Delete Subscriber
DELETE api/v1/subscriber/{subscription}
Delete single subscriber.

###Front End:
Front end is just demo how the use the api's. Front developer using vue.js and has single controller FrontendController for routing.