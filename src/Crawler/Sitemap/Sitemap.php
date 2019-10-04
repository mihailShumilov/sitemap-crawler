<?php


namespace Crawler\Sitemap;


use Symfony\Component\VarDumper\VarDumper;

abstract class Sitemap implements SitemapInterface {

    public const NODE_LOC = 'LOC';
    public const NODE_LASTMOD = 'LASTMOD';

    protected $linksList = [];

    public static function create(string $schema): Sitemap {
        switch ($schema) {
            case 'http://www.sitemaps.org/schemas/sitemap/0.9':
                return new Sitemap09();
                break;
        }
    }

    /**
     * @return array
     */
    public function getLinksList(): array {
        return $this->linksList;
    }


}
