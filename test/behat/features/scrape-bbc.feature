Feature: Scrape BBC command
  In order to show how to describe commands in Behat
  As a Behat developer
  I need to show simple scenario based on http://symfony.com/doc/2.0/components/console.html#testing-commands

  Scenario: Running scrape bbc-top-shared command
    Given I am in a directory "./public"
    When I run "php index.php scrape bbc-top-shared" command
    Then the response is JSON
    And the first element contains the keys "title,href,most_used_word,size"
