<?php


namespace Crawler\Sitemap;


use Symfony\Component\VarDumper\VarDumper;

class Sitemap09 extends Sitemap {

    private $isLock = false;

    public function startElement($xmlParser, string $name, array $attributes): void {
        if($name === self::NODE_LOC){
            $this->isLock = true;
        }
    }

    public function endElement($xmlParser, string $name): void {
        if($name === self::NODE_LOC){
            $this->isLock = false;
        }
    }

    public function characterData($xmlParser, $data): void {
        if($this->isLock){
            echo "LOC: {$data}\n";
        }
    }

}
