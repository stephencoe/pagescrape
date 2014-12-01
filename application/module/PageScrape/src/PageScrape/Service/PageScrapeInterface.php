<?php
namespace PageScrape\Service;

interface PageScrapeInterface
{
    /**
     * Get the page being scraped
     * @return mixed
     */
    public function getPage($url);

    /**
     * Scrape the content and generate the response
     * @param $url
     * @return mixed
     */
    public function scrapePage($url);
}
