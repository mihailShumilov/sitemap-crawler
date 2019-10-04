<?php

namespace Crawler;

use SebastianBergmann\CodeCoverage\TestFixture\C;
use Symfony\Component\VarDumper\VarDumper;

class CrawlerTest extends \PHPUnit\Framework\TestCase {

    /**
     * @dataProvider provider
     *
     * @param string $url
     */
    public function testDataset(string $url): void {
        $this->assertIsString($url);
    }

    /**
     * @dataProvider provider
     *
     * @param string $url
     */
    public function testInit(string $url): void {
        $parser = new Crawler($url);
        $this->assertInstanceOf('Crawler\Crawler', $parser);
    }

    /**
     * @dataProvider provider
     * @param string $url
     *
     * @throws \Exception
     */
    public function testParse(string $url): void {
        $parser = new Crawler($url);
        $this->assertInstanceOf('Crawler\Crawler', $parser);
        $links    = $parser->getLinks();
        $link     = $links[random_int(0, count($links) - 1)];
        $parser   = new Crawler($link);
        $newsLink = $parser->getLinks();
        $this->assertNotEmpty($newsLink);
    }

    public function provider(): array {
        $data  = [];
        $files = glob(__DIR__ . '/../resources/urls.txt');
        foreach ($files as $file) {
            $fh = fopen($file, 'r');
            while ($line = fgets($fh)) {
                $data[] = [trim($line)];
            }
        }
        return $data;
    }
}
