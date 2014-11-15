<?php

namespace PageScrape\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Console\Request as ConsoleRequest;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class CliController extends AbstractActionController implements ServiceLocatorAwareInterface
{
	/**
	 * @var ServiceLocatorInterface
	 */
	protected $serviceLocator;

	/**
	 * @var |PageScrap\Service\BBCScrapeService
	 */
	protected $scrapeService;

	public function scrapeBBCTopSharedAction()
	{
		$request = $this->getRequest();
		if (!$request instanceof ConsoleRequest){
			throw new \RuntimeException('You can only use this action from a console!');
		}
		
		$data = $this->getScrapeService()->scrapePage('http://www.bbc.co.uk/news/');

		if (!$data) {
			$data = ['status'=>false,'message'=>'NO RESULTS RETURNED'];
		}

		return json_encode($data, JSON_PRETTY_PRINT); // play nice
	}


	/**  Getters  & Setters */

	/**
	 * @return |PageScrap\Service\BBCScrapeService
	 */
	private function getScrapeService()
	{
		if (!$this->scrapeService) {
			$this->scrapeService = $this->getServiceLocator()->get('PageScrape\Service\BBCScrapeService');
		}
		return $this->scrapeService;
	}

	/**
	 * @param ServiceLocatorInterface $serviceLocator
	 * @return $this|void
	 */
	public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
	{
		$this->serviceLocator = $serviceLocator;
		return $this;
	}

	/**
	 * Get service locator
	 *
	 * @return ServiceLocatorInterface
	 */
	public function getServiceLocator()
	{
		return $this->serviceLocator;
	}

}
