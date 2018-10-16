The missing XML support for Laravel's Collection class.

## Installation

Install via composer:

```
composer require mtownsend/collection-xml
```

## Quick start

### Collection to xml

Convert data inside a Laravel Collection into valid XML:

```php
$collection = collect([
    'carrier' => 'fedex',
    'id' => 123,
    'tracking_number' => '9205590164917312751089',
]);

$xml = $collection->toXml();
```

### Collection to soap xml

*Heads up, this method is the most temperamental part of this package. Please thoroughly check your SOAP endpoint and requirements for best usage.*

```php
$collection = collect([
    'carrier' => 'fedex',
    'id' => 123,
    'tracking_number' => '9205590164917312751089',
]);

$xml = $collection->toSoapXml('Request', 'xmlBody', 'https://yourwebserver/service.asmx?wsdl');
```

**Please note:** the SoapFactory class will ping the ``$fullUrl`` to see if it is valid as it builds the SOAP xml. It will not trigger an api interaction, but you will experience an exception if your url is invalid.

### Xml to collection

Convert valid xml into an array before wrapping it in a collection:

```php
$xml = '<?xml version="1.0"?><root><carrier>fedex</carrier><id>123</id><tracking_number>9205590164917312751089</tracking_number></root>';

$collection = collect(xml_to_array($xml));
```

### Array to xml

Convert an array into xml without using a collection:

```php
$array = [
    'carrier' => 'fedex',
    'id' => 123,
    'tracking_number' => '9205590164917312751089',
];

$xml = array_to_xml($array);
```

## Helpers, methods, and arguments

**Helper**

``array_to_xml($array, $root = '')``

The ``$root`` argument allows you to customize the root xml element. Default is ``<root>``.

**Helper**

``xml_to_array($xml, $outputRoot = false)``

The ``$outputRoot`` determines whether or not the php array will have a ``@root`` key. Default is ``false``.

**Collection method**

``->toXml($root)``

See ``array_to_xml()`` above.

**Collection method**

``->toSoapXml($root = '', $soapRoot = '', $fullUrl, array $options = [])``

The ``$root`` argument allows you to customize the inner root xml element. Default is ``<root>``.

``$soapRoot`` is the outer xml root element. Default is ``xmlBody``.

``$fullUrl`` will be the fully qualified SOAP endpoint e.g. https://yourwebserver/service.asmx?wsdl. **Please note:** the SoapFactory class will ping the ``$fullUrl`` to see if it is valid as it builds the SOAP xml. It will not trigger an api interaction, but you will experience an exception if your url is invalid.

``$options`` will be an array of valid options for PHP's [SoapClient](http://php.net/manual/en/class.soapclient.php) class. By default ``['trace' => 1]`` is set.

## Purpose

Laravel has always favored json over xml with its api structure. Inevitably, developers will be required to interact with files or apis that require xml, and they are often left to figure it out for themselves.

This package aims to bring painless xml support to Laravel's Collection class, and bring a few useful helpers along.

## Credits

- Mark Townsend
- [Spatie](https://spatie.be/)
- All Contributors

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.