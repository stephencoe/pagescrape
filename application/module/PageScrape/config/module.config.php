<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

return array(

    'controllers' => array(
        'invokables' => array(
            'PageScrape\Controller\Cli' => 'PageScrape\Controller\CliController',
        ),
    ),
    'console' => array(
        'router' => array(
            'routes' => array(
                'scrape-page' => array(
                    'options' => array(
                        'route'    => 'scrape bbc-top-shared',
                        'defaults' => array(
                            'controller' => 'PageScrape\Controller\Cli',
                            'action'     => 'scrapeBBCTopShared',
                        ),
                    ),
                ),
            ),
        ),
    ),
);
