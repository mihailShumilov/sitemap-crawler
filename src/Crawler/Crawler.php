<?php


namespace Crawler;


class Crawler {

    private $url;

    /**
     * Crawler constructor.
     *
     * @param string $url
     */
    public function __construct(string $url) {
        $this->url = $url;
    }
}
