<?php


namespace Crawler\Sitemap;

/**
 * Interface SitemapInterface
 * @package Crawler\Sitemap
 */
interface SitemapInterface {

    /**
     * @param        $xmlParser
     * @param string $name
     * @param array  $attributes
     */
    public function startElement($xmlParser, string $name, array $attributes): void;

    /**
     * @param        $xmlParser
     * @param string $name
     */
    public function endElement($xmlParser, string  $name): void;

    /**
     * @param $xmlParser
     * @param $data
     */
    public function characterData($xmlParser, $data): void;
}
