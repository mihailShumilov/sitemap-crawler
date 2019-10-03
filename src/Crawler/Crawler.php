<?php


namespace Crawler;


use Crawler\Sitemap\Sitemap;
use Symfony\Component\VarDumper\VarDumper;

class Crawler {

    public const NODE_SITEMAPINDEX = 'SITEMAPINDEX';


    public const ATTR_XMLNS = 'XMLNS';

    private $url;

    private $xmlString;

    private $xmlParser;

    private $sitemapFh;

    private $sitemapParser;

    /**
     * Crawler constructor.
     *
     * @param string $url
     */
    public function __construct(string $url) {
        $this->url = $url;
        $this->load();
        $this->prepareXmlParser();
        $this->process();
    }

    public function __destruct() {
        fclose($this->sitemapFh);
    }

    protected function load(): void {
        $this->sitemapFh = tmpfile();
        fwrite($this->sitemapFh, file_get_contents($this->url));
        fseek($this->sitemapFh, 0);
    }

    protected function process(): void {
        while ($line = fread($this->sitemapFh, 1024)) {
            if (!xml_parse($this->xmlParser, $line)) {
                echo "Error in the XML data\t" . xml_error_string(xml_get_error_code($this->xmlParser));
                break;
            }
        }
        xml_parser_free($this->xmlParser);
    }

    private function prepareXmlParser(): void {
        $this->xmlParser = xml_parser_create('UTF-8'); //With UTF8 encoding

        xml_parser_set_option($this->xmlParser, XML_OPTION_CASE_FOLDING,
                              true); //This is a default setting of making all tags uppercase, if set to false you will get the tag name as it's set in the XML.
        xml_parser_set_option($this->xmlParser, XML_OPTION_SKIP_WHITE, true); //This should skip values with no values
        xml_parser_set_option($this->xmlParser, XML_OPTION_TARGET_ENCODING, 'UTF-8'); //Set the output as UTF-8

        xml_set_element_handler($this->xmlParser, [$this, 'startElement'], [$this, 'endElement']);
        xml_set_character_data_handler($this->xmlParser, [$this, 'characterData']);
    }

    protected function startElement($xml_parser, $name, $attributes): void {
        if ($name === self::NODE_SITEMAPINDEX) {
            if (isset($attributes[self::ATTR_XMLNS])) {
                VarDumper::dump($attributes);
                $this->sitemapParser = Sitemap::create($attributes[self::ATTR_XMLNS]);
            }
        }
    }

    protected function endElement($xml_parser, $name): void {

    }

    protected function characterData($xml_parser, $data): void {

    }


}
