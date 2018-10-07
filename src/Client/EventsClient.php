<?php

namespace SilverCart\FacebookPlugins\Client;

/**
 * Client to pull a page's events from Facebook.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Client
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class EventsClient extends Client
{
    /**
     * Returns a list of future facebook events.
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function pull()
    {
        $events   = [];
        $fbPageID = self::get_page_id();
        $response = $this->sendGetRequest("/{$fbPageID}/events");
        if (!is_null($response)) {
            $decodedBody = $response->getDecodedBody();
            $events      = $decodedBody['data'];
        }
        return $events;
    }
}