<?php
namespace PageScrape\Service;

use Zend\Dom\DOMXPath;
use GuzzleHttp\Message\Response;
use Symfony\Component\CssSelector\CssSelector;

class BBCScrapeService extends PageScrape implements PageScrapeInterface
{
	/**
	 * @var string
	 */
	protected $xpathSelector = '//*[@id="most-popular"]/div[1]/ol/li';

	/**
	 * @var array
	 */
	protected $ignoreList = ['the','a', 'is', 'and', 'i'];

	/**
	 * @param $url
	 * @return array
	 * @throws \Exception
	 */
	public function scrapePage ($url) {
		$startPage = $this->getPage($url);

		if(!$startPage) {
			return false;
		}

		$results = [];
		$links = $this->getListLinks($startPage->getBody()->getContents(), $this->xpathSelector);
		if (!$links) {
			return false;
		}

		$pages = $this->getPages($links);

		foreach ($pages as $page) {
			/** @var Response $page */
			$domXpath = new DOMXPath($this->loadDom($page));
			$topWord = key($this->mostUsedWord($domXpath));
			$results[] = [
				'href'	=>	$page->getEffectiveUrl(),
				'title'	=>	$domXpath->query(CssSelector::toXPath('h1.story-header'))->item(0)->nodeValue,
				'size'	=>	round($page->getHeader('content-length') / 1024, 2) .'kb',
				'most_used_word'	=>	$topWord
			];
		}
		return ['results'=>$results];
	}

	/**
	 * Find the most commonly occurring word
	 * @param $xpath
	 * @return array
	 */
	private function mostUsedWord($xpath)
	{
		$articleText = $xpath->query(CssSelector::toXPath('.story-body'))->item(0)->nodeValue;
		return $this->extractTopWords($articleText, $this->ignoreList, 1);
	}

	/**
	 * From StackOverflow
	 * @link http://stackoverflow.com/questions/3175390/most-used-words-in-text-with-php#7944981
	 * @param $string
	 * @param $stop_words
	 * @param int $max_count
	 * @return array
	 */
	public function extractTopWords($string, $stop_words = [], $max_count = 1) {
		$string = preg_replace('/ss+/i', '', $string);
		$string = trim($string); // trim the string
		$string = preg_replace('/[^a-zA-Z -]/', '', $string); // only take alphabet characters, but keep the spaces and dashes too…
		$string = strtolower($string); // make it lowercase

		preg_match_all('/\b.*?\b/i', $string, $match_words);
		$match_words = $match_words[0];

		foreach ( $match_words as $key => $item ) {
			if ( $item == '' || in_array(strtolower($item), $stop_words) || strlen($item) <= 3 ) {
				unset($match_words[$key]);
			}
		}

		$word_count = str_word_count( implode(" ", $match_words) , 1);
		$frequency = array_count_values($word_count);
		arsort($frequency);

		return array_slice($frequency, 0, $max_count);
	}
}
