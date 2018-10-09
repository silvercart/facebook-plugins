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
        $this->setPageAccessToken();
        $events   = [];
        $fbPageID = self::get_page_id();
        $fields   = implode(',', [
            'description',
            'end_time',
            'name',
            'place',
            'start_time',
            'event_times',
            'id',
            'cover',
            'attending_count',
            'interested_count',
            'maybe_count',
        ]);
        $response = $this->sendGetRequest("/{$fbPageID}/events?fields={$fields}");
        if (!is_null($response)) {
            $decodedBody = $response->getDecodedBody();
            $events      = $decodedBody['data'];
        }
        return $events;
    }
}