<?php

namespace SilverCart\FacebookPlugins\Dev\Tasks;

use SilverCart\FacebookPlugins\Client\Client;
use SilverStripe\Control\CliController;

/**
 * Basic Facebook Plugin Task.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Dev\Tasks
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class Task extends CliController
{
    use \SilverCart\Dev\CLITask;
    
    /**
     * Client class name
     *
     * @var string
     */
    private static $client_class_name = Client::class;
    /**
     * CLient
     *
     * @var Client
     */
    protected $client = null;
    
    /**
     * Returns the client.
     * 
     * @return Client
     */
    public function getClient()
    {
        if (is_null($this->client)) {
            $clientClassName = self::config()->get('client_class_name');
            $this->setClient($clientClassName::create());
            $this->client->setTask($this);
        }
        return $this->client;
    }
    
    /**
     * Returns the client.
     * 
     * @return $this
     */
    public function setClient($client)
    {
        $this->client = $client;
        return $this;
    }

    /**
     * Initializes the CLI arguments.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 06.10.2018
     */
    protected function init()
    {
        parent::init();
        $this->initArgs();
    }
}