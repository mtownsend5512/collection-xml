<?php

namespace Mtownsend\CollectionXml\Soap;

use SoapClient;

/**
 * Use the SoapFactory class to build a valid SOAP request
 * but prevent it from making an actual request
 * and capture the data it builds for use.
 */
class SoapFactory extends SoapClient
{
    public $soapRequest;
    public $soapLocation;
    public $soapAction;
    public $soapVersion;

    public function __construct($wsdl, $options)
    {
        parent::__construct($wsdl, $options);
    }

    /**
     * Build the SOAP xml string
     * @param  array  $soapRootAndXml [$soapRoot => $xml]
     * @return Mtownsend\CollectionXml\Soap\SoapFactory
     */
    public function build(array $soapRootAndXml)
    {
        $this->ProcessXMLRequest($soapRootAndXml);
        return $this;
    }

    /**
     * Override the SoapClient __doRequest method.
     */
    public function __doRequest($request, $location, $action, $version, $one_way = 0)
    {
        $this->soapRequest = $request;
        $this->soapLocation = $location;
        $this->soapAction = $action;
        $this->soapVersion = $version;
        return ''; // Return a string value or the SoapClient throws an exception
    }

    /**
     * A proxy for the getSoapRequest method.
     * @return string
     */
    public function getSoapXml()
    {
        return $this->getSoapRequest();
    }

    /**
     * Return the SOAP request XML.
     * @return string
     */
    public function getSoapRequest()
    {
        return $this->soapRequest;
    }

    /**
     * Return the SOAP request location url.
     * @return string
     */
    public function getSoapLocation()
    {
        return $this->soapLocation;
    }

    /**
     * Return the SOAP request action.
     * @return string
     */
    public function getSoapAction()
    {
        return $this->soapAction;
    }

    /**
     * Return the SOAP request version number.
     * @return string
     */
    public function getSoapVersion()
    {
        return $this->soapVersion;
    }
}
