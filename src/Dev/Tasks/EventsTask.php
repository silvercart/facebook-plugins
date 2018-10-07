<?php

namespace SilverCart\FacebookPlugins\Dev\Tasks;

use SilverCart\FacebookPlugins\Client\EventsClient;
use SilverCart\FacebookPlugins\Model\Event;
use SilverCart\FacebookPlugins\Model\EventTime;

/**
 * Task to pull a page's events from Facebook.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Dev\Tasks
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class EventsTask extends Task
{
    use \SilverCart\Dev\CLITask;
    
    /**
     * Allowed actions.
     *
     * @var array
     */
    private static $allowed_actions = [
        'pull',
    ];
    /**
     * Client class name
     *
     * @var string
     */
    private static $client_class_name = EventsClient::class;
    
    /**
     * Returns the events client.
     * 
     * @return EventsClient
     */
    public function getClient()
    {
        return parent::getClient();
    }
    
    /**
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function pull()
    {
        $events = $this->getClient()->pull();
        if (!is_null($events)) {
            $totalEvents  = count($events);
            $currentIndex = 1;
            foreach ($events as $event) {
                $xofy          = $this->getXofY($currentIndex, $totalEvents);
                $currentIndex++;
                $facebookID    = $event['id'];
                $eventName     = $event['name'];
                $existingEvent = Event::getByFacebookID($facebookID);
                if (!($existingEvent instanceof Event)
                 || !$existingEvent->exists()) {
                    $existingEvent = Event::create();
                    $existingEvent->FacebookID = $facebookID;
                    $this->printInfo("{$xofy} - creating new event '{$eventName}' [#{$facebookID}]", self::$CLI_COLOR_GREEN);
                } else {
                    $this->printInfo("{$xofy} - updating existing event '{$eventName}' [#{$facebookID}]");
                }
                
                $startTime = date('Y-m-d H:i:s', strtotime($event['start_time']));
                $endTime   = date('Y-m-d H:i:s', strtotime($event['end_time']));
                $existingEvent->Name        = $eventName;
                $existingEvent->Description = $event['description'];
                $existingEvent->Place       = $event['place']['name'];
                $existingEvent->EndTime     = $endTime;
                $existingEvent->StartTime   = $startTime;
                $existingEvent->write();
                
                $eventTimes  = $event['event_times'];
                $facebookIDs = [];
                $totalEventTimes  = count($eventTimes);
                $currentTimeIndex = 1;
                foreach ($eventTimes as $eventTime) {
                    $xofy          = $this->getXofY($currentTimeIndex, $totalEventTimes);
                    $currentTimeIndex++;
                    $facebookID        = $eventTime['id'];
                    $facebookIDs[]     = $facebookID;
                    $existingEventTime = EventTime::getByFacebookID($facebookID);
                    $startTime         = date('Y-m-d H:i:s', strtotime($eventTime['start_time']));
                    $endTime           = date('Y-m-d H:i:s', strtotime($eventTime['end_time']));
                    if (!($existingEventTime instanceof EventTime)
                     || !$existingEventTime->exists()) {
                        $existingEventTime = EventTime::create();
                        $existingEventTime->FacebookID = $facebookID;
                        $existingEventTime->EventID    = $existingEvent->ID;
                        $this->printInfo("\t{$xofy} - creating new time {$startTime} [#{$facebookID}]", self::$CLI_COLOR_GREEN);
                    } else {
                        $this->printInfo("\t{$xofy} - updating existing time {$startTime} [#{$facebookID}]");
                    }
                    $existingEventTime->EndTime   = $endTime;
                    $existingEventTime->StartTime = $startTime;
                    $existingEventTime->write();
                }
                $existingEvent->EventTimes()->exclude('FacebookID', $facebookIDs)->where('StartTime > NOW()')->removeAll();
            }
        }
    }
}