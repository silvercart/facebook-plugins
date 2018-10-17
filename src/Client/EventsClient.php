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
     * @param string $after Hash of the page to get the content after
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function pull($after = null)
    {
        $this->setPageAccessToken();
        $events     = [];
        $fbPageID   = self::get_page_id();
        $paramAfter = "";
        $fields     = implode(',', [
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
        if (!is_null($after)) {
            $paramAfter = "&after={$after}";
        }
        $response = $this->sendGetRequest("/{$fbPageID}/events?fields={$fields}{$paramAfter}");
        if (!is_null($response)) {
            $decodedBody = $response->getDecodedBody();
            if (array_key_exists('data', $decodedBody)) {
                $events = $decodedBody['data'];
            }
            if (array_key_exists('paging', $decodedBody)
             && array_key_exists('cursors', $decodedBody['paging'])
             && array_key_exists('after', $decodedBody['paging']['cursors'])
            ) {
                $events = array_merge($events, $this->pull($decodedBody['paging']['cursors']['after']));
            }
        }
        return $events;
    }
}