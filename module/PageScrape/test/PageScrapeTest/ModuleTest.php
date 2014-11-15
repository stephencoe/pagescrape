<?php

namespace PageScrapeTest;

use PHPUnit_Framework_TestCase;
use PageScrape\Module;

/**
 * @covers PageScrape\Module
 */
class ModuleTest extends PHPUnit_Framework_TestCase
{
	/**
	 * @covers PageScrape\Module::getAutoloaderConfig
	 */
	public function testGetAutoloaderConfig()
	{
		$module = new Module();
		// just testing ZF specification requirements
		$this->assertInternalType('array', $module->getAutoloaderConfig());
	}

	/**
	 * @covers PageScrape\Module::getConfig
	 */
	public function testGetConfig()
	{
		$module = new Module();
		// just testing ZF specification requirements
		$this->assertInternalType('array', $module->getConfig());
	}

	/**
	 * @covers PageScrape\Module::getServiceConfig
	 */
	public function testGetServiceConfig()
	{
		$module = new Module();
		// just testing ZF specification requirements
		$this->assertInternalType('array', $module->getServiceConfig());
	}

}
