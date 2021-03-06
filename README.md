# Omnipay: Jeton Pay (BETA)

**Jeton Pay gateway for Omnipay payment processing library**

[Omnipay](https://github.com/thephpleague/omnipay) is a framework agnostic, multi-gateway payment
processing library for PHP 5.3+. This package implements Jeton Pay (www.jeton.com) support for Omnipay.

## Installation

Omnipay is installed via [Composer](http://getcomposer.org/). To install, simply add it
to your `composer.json` file:

```json
{
    "require": {
        "eozden/omnipay-jetonpay": "~1.0"
    }
}
```

And run composer to update your dependencies:

    $ curl -s http://getcomposer.org/installer | php
    $ php composer.phar update

## Basic Usage
```php
use Omnipay\Omnipay;

$gateway = Omnipay::create('Jeton');

$params = [
    'apiKey' => '',
    'transactionReference' => 10,
    'amount' => 10.00,
    'currency' => 'USD'
];

$response = $gateway->purchase($params)->send();

if ($response->isSuccessful()) {
    echo $response->getTransactionReference();
    echo $response->getMessage();
} else {
    echo $response->getMessage();
}
```

## Support

If you are having general issues with Omnipay, we suggest posting on
[Stack Overflow](http://stackoverflow.com/). Be sure to add the
[omnipay tag](http://stackoverflow.com/questions/tagged/omnipay) so it can be easily found.

If you want to keep up to date with release anouncements, discuss ideas for the project, or ask more detailed questions, there is also a [mailing list](https://groups.google.com/forum/#!forum/omnipay) which
you can subscribe to.

If you believe you have found a bug, please report it using the [GitHub issue tracker](https://github.com/eozden/omnipay-jetonpay/issues),
or better yet, fork the library and submit a pull request.