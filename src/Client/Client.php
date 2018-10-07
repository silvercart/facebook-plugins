<?php

namespace SilverCart\FacebookPlugins\Client;

use Facebook\Facebook;
use Facebook\Exceptions\FacebookResponseException;
use Facebook\Exceptions\FacebookSDKException;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Basic Client to connect to Facebook.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Client
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class Client
{
    use \SilverStripe\Core\Injector\Injectable;
    use \SilverStripe\Core\Config\Configurable;
    
    /**
     * Facebook App ID.
     *
     * @var string
     */
    private static $app_id = '';
    /**
     * Facebook App Secret.
     *
     * @var string
     */
    private static $app_secret = '';
    /**
     * Facebook default access token.
     *
     * @var string
     */
    private static $default_access_token = '';
    /**
     * Facebook access token.
     *
     * @var string
     */
    private static $access_token = '';
    /**
     * Facebook page ID.
     *
     * @var string
     */
    private static $page_id = '';
    /**
     * The Facebook instance.
     *
     * @var Facebook
     */
    protected $fb = null;
    /**
     * Current task context.
     *
     * @var \SilverCart\FacebookPlugins\Dev\Tasks\Task
     */
    protected $task = null;

    /**
     * Returns the Facebook access token.
     * 
     * @return string
     */
    public static function get_access_token()
    {
        return self::config()->get('access_token');
    }
    
    /**
     * Returns the Facebook page id.
     * 
     * @return string
     */
    public static function get_page_id()
    {
        return self::config()->get('page_id');
    }
    
    /**
     * Initializes the API configuration.
     * 
     * @return $this
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function __construct()
    {
        $config = SiteConfig::current_site_config();
        if (!empty($config->FacebookAppID)) {
            $this->config()->set('app_id', $config->FacebookAppID);
        }
        if (!empty($config->FacebookAppSecret)) {
            $this->config()->set('app_secret', $config->FacebookAppSecret);
        }
        if (!empty($config->FacebookDefaultAccessToken)) {
            $this->config()->set('default_access_token', $config->FacebookDefaultAccessToken);
        }
        if (!empty($config->FacebookAccessToken)) {
            $this->config()->set('access_token', $config->FacebookAccessToken);
        }
        if (!empty($config->FacebookAppID)) {
            $this->config()->set('app_id', $config->FacebookAppID);
        }
        if (!empty($config->FacebookPageID)) {
            $this->config()->set('page_id', $config->FacebookPageID);
        }
    }
    
    /**
     * Returns the Facebook instance.
     * 
     * @return Facebook
     */
    protected function getFB()
    {
        if (is_null($this->fb)) {
            $fbConfig = [
                'app_id'                => $this->config()->get('app_id'),
                'app_secret'            => $this->config()->get('app_secret'),
                'default_graph_version' => 'v2.10',
            ];
            if (!empty($this->config()->get('default_access_token'))) {
                $fbConfig['default_access_token'] = $this->config()->get('default_access_token');
            }
            $this->fb = new Facebook($fbConfig);
        }
        return $this->fb;
    }
    
    /**
     * Returns the current task context.
     * 
     * @return \SilverCart\FacebookPlugins\Dev\Tasks\Task
     */
    public function getTask()
    {
        return $this->task;
    }
    
    /**
     * Sets the current task context.
     * 
     * @param \SilverCart\FacebookPlugins\Dev\Tasks\Task $task Task context
     * 
     * @return $this
     */
    public function setTask($task)
    {
        $this->task = $task;
        return $this;
    }
    
    /**
     * Sends a get request to the given Facebook endpoint.
     * 
     * @param string $endpoint Endpoint
     * 
     * @return \Facebook\FacebookResponse
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function sendGetRequest($endpoint)
    {
        $response = null;
        try {
            $response = $this->getFB()->get($endpoint, self::get_access_token());
        } catch (FacebookResponseException $e) {
            $this->printError("Graph returned an error: {$e->getMessage()}");
        } catch (FacebookSDKException $e) {
            $this->printError("Facebook SDK an error: {$e->getMessage()}");
        }
        return $response;
    }
    
    /**
     * Sends a post request to the given Facebook endpoint.
     * 
     * @param string $endpoint Endpoint
     * @param arrayv $params   Post params to send
     * 
     * @return \Facebook\FacebookResponse
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function sendPostRequest($endpoint, $params = [])
    {
        $response = null;
        try {
            $response = $this->getFB()->post($endpoint, $params, self::get_access_token());
        } catch (FacebookResponseException $e) {
            $this->printError("Graph returned an error: {$e->getMessage()}");
        } catch (FacebookSDKException $e) {
            $this->printError("Facebook SDK an error: {$e->getMessage()}");
        }
        return $response;
    }
    
    /**
     * Prints the given $error message to the current task context ouput.
     * 
     * @param string $error Error message
     * 
     * @return $this
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    protected function printError($error)
    {
        $task = $this->getTask();
        if (!is_null($task)) {
            $task->printError($error);
        }
        return $this;
    }
}