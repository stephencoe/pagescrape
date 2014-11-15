<?php
namespace PageScrape\Service;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Message\Response;
use Zend\Dom\DOMXPath;

abstract class PageScrape
{
	/**
	 * @var \DOMDocument
	 */
	protected $content;

	/**
	 * @var Client
	 */
	protected $client;

	public function __construct()
	{
		$this->client = new Client();
	}

	/**
	 * Load the dom
	 * @param Response $html
	 * @return \DOMDocument
	 */
	public function loadDom($html)
	{
		$content = new \DOMDocument();
		libxml_use_internal_errors(true);// suppress errors for the dirty code html body. :(
		$content->loadHTML($html);
		return $content;
	}

	/**
	 * @param $page
	 * @param $selector
	 * @return array
	 * @throws \Exception
	 */
	public function getListLinks($page, $selector)
	{
		$this->content = $this->loadDom($page);
		if (!$this->content instanceof \DOMDocument) {
			throw new \Exception('Invalid data, unable to process');
		}

		$xpath = new DOMXPath($this->content);
		//get the top stories
		$stories = $xpath->query($selector);

		$links = [];
		foreach ($stories as $story) {
			/** @var \DomElement $anchor */
			$anchor = $xpath->query('a[1]', $story)->item(0);

			// add the page request to queue
			$links[] = $anchor->getAttribute('href');
		}

		return $links;
	}

	/**
	 * @param string $url
	 * @return Response
	 * @throws \Exception
	 */
	public function getPage($url)
	{
		try {
			/** @var Response $response */
			$response = $this->client->get($url);
		} catch (\Exception $e) {
			throw new \Exception(sprintf('Unable to get url : %s', $url));
		}

		if (200 !== $response->getStatusCode()) {
			return false;
		}
		return $response;
	}

	/**
	 * Init Guzzle MultiRequests
	 * @param array $urls
	 * @return \GuzzleHttp\BatchResults
	 */
	public function getPages(array $urls)
	{
		$requests = [];
		foreach ($urls as $url) {
			$requests[] = $this->client->createRequest('GET', $url);
		}

		return Pool::batch($this->client, $requests);
	}
}