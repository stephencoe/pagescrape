<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Context\SnippetAcceptingContext;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context, SnippetAcceptingContext
{
	/**
	 * Initializes context.
	 *
	 * Every scenario gets its own context instance.
	 * You can also pass arbitrary arguments to the
	 * context constructor through behat.yml.
	 */
	public function __construct()
	{
	}

	/** @Given /^I am in a directory "([^"]*)"$/ */
	public function iAmInADirectory($dir)
	{
		chdir($dir);
	}

	/**
	 * @When /^I run "([^"]*)" command$/
	 */
	public function iRunCommand($command)
	{
		exec($command, $output);
		$this->output = trim(implode("\n", $output));
	}

	/**
	 * @Given /^the response is JSON$/
	 */
	public function theResponseIsJson()
	{
		$data = json_decode($this->output);

		if (empty($data)) {
			throw new Exception("Response was not JSON\n" . $this->output);
		}
	}

	/**
	 * @Given /^the first element contains the keys "([^"]*)"$/
	 */
	public function theArrayHasRequiredKeys($requiredKeys)
	{
		$results = json_decode($this->output, true);
		foreach(explode(',', $requiredKeys) as $key) {
			if (!array_key_exists($key, $results['results'][0])) {
				throw new Exception(sprintf('The key %s is missing from the output', $key));
			}
		}
	}
}
