<?php

use ReflectionClass as Reflect;
use PHPUnit\Framework\TestCase;
use Mtownsend\CollectionXml\Providers\CollectionXmlServiceProvider;

class CollectionXml extends TestCase
{

    /** @test array */
    protected $testCollection = [];

    /** @test string */
    protected $testXml;

    public function setUp()
    {
        $this->createDummyprovider()->boot();

        $this->testCollection = collect([
            'carrier' => 'fedex',
            'id' => 123,
            'tracking_number' => '9205590164917312751089',
        ]);
        $this->testXml = '<?xml version="1.0"?><root><carrier>fedex</carrier><id>123</id><tracking_number>9205590164917312751089</tracking_number></root>';
    }

    /**
     * Bootstrap the provider to introduce the xml macros
     */
    protected function createDummyprovider(): CollectionXmlServiceProvider
    {
        $reflectionClass = new Reflect(CollectionXmlServiceProvider::class);
        return $reflectionClass->newInstanceWithoutConstructor();
    }

    /**
     * Remove new lines from xml to standardize testing
     */
    protected function removeNewLines($string)
    {
        return preg_replace('~[\r\n]+~', '', $string);
    }

    /** @test */
    public function collection_can_convert_to_xml()
    {
        $xml = $this->removeNewLines($this->testCollection->toXml());
        $this->assertEquals($xml, $this->testXml);
    }

    /** @test */
    public function collection_can_convert_to_xml_with_custom_root()
    {
        $customRootXml = '<?xml version="1.0"?><Custom_Root><carrier>fedex</carrier><id>123</id><tracking_number>9205590164917312751089</tracking_number></Custom_Root>';
        $xml = $this->removeNewLines($this->testCollection->toXml('Custom_Root'));
        $this->assertEquals($xml, $customRootXml);
    }

    /** @test */
    public function array_can_convert_to_xml()
    {
        $array = $this->testCollection->toArray();
        $xml = $this->removeNewLines(array_to_xml($array));
        $this->assertEquals($xml, $this->testXml);
    }

    /** @test */
    public function xml_can_convert_to_array()
    {
        $this->assertEquals(xml_to_array($this->testXml), $this->testCollection->toArray());
    }
}
