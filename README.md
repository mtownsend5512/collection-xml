The missing XML support for Laravel's Collection class.

This package is designed to work with the [Laravel](https://laravel.com) framework.

## Installation

Install via composer:

```
composer require mtownsend/collection-xml
```

### Registering the service provider

For Laravel 5.4 and lower, add the following line to your ``config/app.php``:

```php
/*
 * Package Service Providers...
 */
Mtownsend\CollectionXml\Providers\CollectionXmlServiceProvider::class,
```

For Laravel 5.5 and greater, the package will auto register the provider for you.

### Using Lumen

To register the service provider, add the following line to ``app/bootstrap/app.php``:

```php
$app->register(Mtownsend\CollectionXml\Providers\CollectionXmlServiceProvider::class);
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

// Returns
<?xml version="1.0"?>
<root>
    <carrier>fedex</carrier>
    <id>123</id>
    <tracking_number>9205590164917312751089</tracking_number>
</root>
```

### Collection to soap xml

*Heads up, this method is the most temperamental part of this package. Please thoroughly check your SOAP endpoint and requirements for best usage.*

```php
$collection = collect([
    'carrier' => 'fedex',
    'id' => 123,
    'tracking_number' => '9205590164917312751089',
]);

$xml = $collection->toSoapXml('request', 'xmlBody', 'https://yourwebserver/service.asmx?wsdl');

// Returns
<?xml version="1.0" encoding="UTF-8"?>
<SOAP-ENV:Envelope
    xmlns:SOAP-ENV="http://schemas.xmlsoap.org/soap/envelope/"
    xmlns:ns1="https://yourwebserver/service.asmx?wsdl">
    <SOAP-ENV:Body>
        <ns1:ProcessXMLRequest>
            <ns1:xmlBody>
                <?xml version="1.0"?>
                <request>
                    <carrier>fedex</carrier>
                    <id>123</id>
                    <tracking_number>9205590164917312751089</tracking_number>
                </request>
            </ns1:xmlBody>
        </ns1:ProcessXMLRequest>
    </SOAP-ENV:Body>
</SOAP-ENV:Envelope>
```

**Please note:** the SoapFactory class will ping the ``$fullUrl`` to see if it is valid as it builds the SOAP xml. It will not trigger an api interaction, but you will experience an exception if your url is invalid.

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

## Other packages you may be interested in

- [mtownsend/request-xml](https://github.com/mtownsend5512/request-xml)
- [mtownsend/response-xml](https://github.com/mtownsend5512/response-xml)
- [mtownsend/xml-to-array](https://github.com/mtownsend5512/xml-to-array)

## Credits

- Mark Townsend
- [Spatie](https://spatie.be/)
- All Contributors

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.