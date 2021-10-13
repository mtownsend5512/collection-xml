<?php

namespace Mtownsend\CollectionXml\Providers;

use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use Mtownsend\CollectionXml\Soap\SoapFactory;
use Spatie\ArrayToXml\ArrayToXml;

class CollectionXmlServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('toXml', function ($root = '') {
            return ArrayToXml::convert($this->toArray(), $root);
        });

        Collection::macro('toSoapXml', function ($root = '', $soapRoot = 'xmlBody', $fullUrl = null, array $options = []) {
            $soapFactory = new SoapFactory($fullUrl, array_merge(['trace' => 1], $options));
            return $soapFactory->build([$soapRoot => $this->toXml($root)])->getSoapXml();
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
