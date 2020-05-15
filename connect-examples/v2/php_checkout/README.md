# Square Checkout Demo

This is a simple example application that utilizes Square's Checkout API. This examples does assume you are familiar with PHP development.

It takes a single payment, declared by the user, and creates an order to use in the Checkout API.

## To get it running

1. Clone or download this repo to your local computer
2. Get a local copy for your environment variables
```
cp .env.example .env
```

3. Update your API credentials in `.env` (created in step 2)
> <b>WARNING:</b> never upload .env with your credential/access_token

4. In `.env` there's a variable, `USE_PROD` to switch between production and sandbox; change it based on your needs.

5. Install your php dependencies using [Composer](https://getcomposer.org/):
```
composer install
```

6. Start your local server
```
php -S localhost:8888
```

This will start the server on `localhost:8888`, which you can navigate to in your favorite browser.

## Checkout API docs

For more information about Checkout please visit:

* https://docs.connect.squareup.com/payments/checkout/overview
* https://docs.connect.squareup.com/api/connect/v2#navsection-checkout
* https://github.com/square/connect-php-sdk/blob/master/docs/Api/CheckoutApi.md
