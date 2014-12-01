<?php
namespace PageScrapeTest\Controller;

use Zend\Test\PHPUnit\Controller\AbstractControllerTestCase;

class CliControllerTest extends AbstractControllerTestCase
{
    protected function setUp()
    {
        $this->setApplicationConfig(
            include __DIR__ . '/../../../../../config/application.config.php'
        );
        parent::setUp();
    }

    public function testScrapeBBCTopShared()
    {
        $this->setUseConsoleRequest(true);
        // dispatch url
        $this->dispatch('scrape bbc-top-shared');

        // basic assertions
        $this->assertResponseStatusCode(0);
        $this->assertActionName('scrapeBBCTopShared');
        $this->assertControllerName('PageScrape\Controller\Cli');

        // custom assert
        $sm = $this->getApplicationServiceLocator();

        $response = $this->getResponse();
        $this->assertJson($response->getContent());
    }
}
