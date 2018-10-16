<?php

if (!function_exists('array_to_xml')) {
    /**
     * Convert an array to valid XML.
     *
     * @param string $xml
     * @param bool $outputRoot
     * @return array
     */
    function array_to_xml($array, $root = '')
    {
        return \Spatie\ArrayToXml\ArrayToXml::convert($array, $root);
    }
}

if (!function_exists('xml_to_array')) {
    /**
     * Convert valid XML to an array.
     *
     * @param string $xml
     * @param bool $outputRoot
     * @return array
     */
    function xml_to_array($xml, $outputRoot = false)
    {
    	return \Mtownsend\CollectionXml\XmlToArray::convert($xml, $outputRoot);
    }
}
