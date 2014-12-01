<?php

namespace PageScrapeTest\Service;

use PageScrape\Service\BBCScrapeService;

class BBCScrapeServiceTest extends \PHPUnit_Framework_TestCase
{
    protected $bbcScrapeService;

    private $wordList = 'Landjaeger picanha turducken tri-tip shoulder. Cupim spare ribs ham hock flank chicken short ribs pork chop prosciutto porchetta alcatra andouille ball tip strip steak drumstick ham. Andouille swine jowl cow. Meatball cupim capicola sirloin, porchetta pork fatback turducken swine pancetta ball tip salami landjaeger brisket. Short loin frankfurter meatball, chuck t-bone brisket pork loin rump ham hock spare ribs meatloaf. Pancetta alcatra pastrami, jerky pork belly jowl salami ham hock porchetta tri-tip venison picanha turducken.';

    protected function setUp()
    {
        $this->bbcScrapeService = new BBCScrapeService();
    }

    public function testExtractTopWords()
    {
        $this->assertInternalType('array', $this->bbcScrapeService->extractTopWords($this->wordList, []));

        $this->assertEquals('pork', key($this->bbcScrapeService->extractTopWords($this->wordList, [])));

        //test stop words
        $this->assertNotEquals('pork', key($this->bbcScrapeService->extractTopWords($this->wordList, ['pork'])));
    }

    public function testLoadDom()
    {
        $dom = $this->bbcScrapeService->loadDom(file_get_contents(__DIR__ . '/../../../../../../tests/bbc.html'));
        $this->assertInstanceOf('\DomDocument', $dom);
    }

    public function testGetListLinks()
    {
        $html = '<div class="livestats livestats-tabbed tabbed most-popular" id="most-popular">
			<h2 class="livestats-header">Most Popular</h2>

			<h3 class="tab open"><a href="#">Shared</a></h3>

			<div class="panel open">
				<ol>
					<li class="first-child ol1">
						<a class="story" href=
						"http://www.bbc.co.uk/news/magazine-30038753"><span class=
						"livestats-icon livestats-1">1:</span> The disabled children
						locked up in cages</a>
					</li>

					<li class="ol2">
						<a class="story" href=
						"http://www.bbc.co.uk/news/magazine-30039300"><span class=
						"livestats-icon livestats-2">2:</span> The man who seemed not
						to notice danger</a>
					</li>

					<li class="ol3">
						<a class="story" href=
						"http://www.bbc.co.uk/news/technology-30054140"><span class=
						"livestats-icon livestats-3">3:</span> Five-year-old passes
						Microsoft exam</a>
					</li>

					<li class="ol4">
						<a class="story" href=
						"http://www.bbc.co.uk/news/uk-30052726"><span class=
						"livestats-icon livestats-4">4:</span> \'Possible homicide\' in
						abuse inquiry</a>
					</li>

					<li class="ol5">
						<a class="story" href=
						"http://www.bbc.co.uk/news/entertainment-arts-30018809"><span class="livestats-icon livestats-5">
						5:</span> Bottoms return to Rik Mayall TV bench</a>
					</li>
				</ol>
			</div>
		</div>';
        $links = $this->bbcScrapeService->getListLinks($html, '/div[@id="most-popular"]/div[1]/ol/l');
    }
}
