<?php


namespace Crawler\Sitemap;


use Symfony\Component\VarDumper\VarDumper;

abstract class Sitemap implements SitemapInterface {
    public static function create(string $schema): Sitemap {
        switch ($schema) {
            case 'http://www.sitemaps.org/schemas/sitemap/0.9':
                return new Sitemap09();
                break;
        }
    }
}
