# ExchangeRatesApp

This currency converter is a small demonstration of Symfony 4 with PHP7 and GuzzleHttp V6 using Fixer's REST API
for fetching exchange rates.

## Installation

#### Clone repository

```
git clone git@github.com:dgreda/ExchangeRatesApp.git
``` 

#### Install dependencies with composer

```
composer install
```

#### Make sure that you have npm and yarn installed

[Install nodeJS](https://nodejs.org/en/download/)

[Install yarn](https://yarnpkg.com/lang/en/docs/install/)

#### Run the "frontend stuff"

```
npm install
yarn run encore dev
```

#### Start server 

```
php bin/console server:run
```

#### Navigate in your browser to the address specified in command's output looking like

```
 [OK] Server listening on http://127.0.0.1:8000


 // Quit the server with CONTROL-C.

PHP 7.2.0 Development Server started at Mon Jan  8 20:56:04 2018
Listening on http://127.0.0.1:8000
Document root is /Users/damiangreda/Dev/private/ExchangeRatesApp/public
Press Ctrl-C to quit.

```

#### Voilà!

Enjoy converting currencies back and forth, like you've never done before!

## Running tests

```
php bin/phpunit
```

## Notes

This is just MVP with basic validation of input data and some unit tests already written.
There is however still room for further development and improvements, considering better/customised exception handling
and of course better and nicer frontend.
