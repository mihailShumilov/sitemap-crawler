<?php


namespace Crawler\Sitemap;


use Symfony\Component\VarDumper\VarDumper;

class Sitemap09 extends Sitemap {

    private $isLock           = false;
    private $isLastMode       = false;
    private $lastModeWasFound = false;

    private $link;

    public function startElement($xmlParser, string $name, array $attributes): void {
        switch ($name) {
            case self::NODE_LOC:
                $this->isLock           = true;
                $this->lastModeWasFound = false;
                break;
            case self::NODE_LASTMOD:
                $this->isLastMode       = true;
                $this->lastModeWasFound = true;
                break;
        }
    }

    public function endElement($xmlParser, string $name): void {
        switch ($name) {
            case self::NODE_LOC:
                $this->isLock = false;
                if (!$this->lastModeWasFound && $this->link) {
                    $this->linksList[] = $this->link;
                }
                $this->link = '';
                break;
            case self::NODE_LASTMOD:
                $this->isLastMode = false;
                break;
        }
    }

    public function characterData($xmlParser, $data): void {
        if ($this->isLastMode) {
            $checkTime    = strtotime('-24 hours');
            $lastModeTime = strtotime($data);
            if (($lastModeTime > $checkTime) && $this->link) {
                $this->linksList[] = $this->link;
            }
        } elseif ($this->isLock) {
            $this->link = $data;
        }
    }

}
