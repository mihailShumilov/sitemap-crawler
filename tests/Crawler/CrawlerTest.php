<?php
namespace Crawler;

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

    public function provider(): array {
        $data = [];
        $files = glob(__DIR__ . '/../resources/urls.txt');
        foreach ($files as $file) {
            $fh = fopen($file, 'r');
            while($line = fgets($fh)){
                $data[] = [trim($line)];
            }
        }
        return $data;
    }
}
