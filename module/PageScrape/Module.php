<?php

namespace PageScrape;

use PageScrape\Service\BBCScrapeService;
use Zend\Console\Adapter\AdapterInterface as Console;

class Module
{
	public function getServiceConfig()
	{
		return [
			'factories'=> [
				'PageScrape\Service\BBCScrapeService' => function () {
					return new BBCScrapeService();
				}
			]
		];
	}

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

	public function getConsoleUsage(Console $console)
	{
		return [
			'scrape bbc-top-shared'	=>	'Get the top shared stories from BBC News',
		];
	}
}
