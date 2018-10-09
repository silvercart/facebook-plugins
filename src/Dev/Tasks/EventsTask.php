<?php

namespace SilverCart\FacebookPlugins\Dev\Tasks;

use SilverCart\Extensions\Assets\ImageExtension;
use SilverCart\FacebookPlugins\Client\EventsClient;
use SilverCart\FacebookPlugins\Model\Event;
use SilverCart\FacebookPlugins\Model\EventTime;
use SilverStripe\Assets\Image;
use SilverStripe\View\ArrayData;

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
     * Pulls Facebook events and updates the local database.
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
            $this->printInfo("Found {$totalEvents} events.");
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
                $existingEvent->CountAttending  = $event['attending_count'];
                $existingEvent->CountInterested = $event['interested_count'];
                $existingEvent->CountMaybe      = $event['maybe_count'];
                $existingEvent->CoverID         = $this->getCover($event['cover'])->ID;
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
        } else {
            $this->printInfo("No events found.");
        }
    }
    
    /**
     * Returns the local event cover image.
     * If the cover image doesn't exist yet it will be created.
     * 
     * @param array $coverData Facebook cover data
     * 
     * @return Image
     */
    protected function getCover($coverData)
    {
        $uploadFolder   = Event::getCoverUploadFolder();
        $existingCovers = Image::get()->filter([
            'Title'    => $coverData['id'],
            'ParentID' => $uploadFolder->ID,
        ]);
        if ($existingCovers->exists()) {
            return $existingCovers->first();
        }
        $coverSource    = $coverData['source'];
        $ending         = ImageExtension::getEndingForFilePath($coverSource);
        $targetFilename = "{$coverData['id']}.{$ending}";
        $uploadPath     = ASSETS_PATH . DIRECTORY_SEPARATOR . $uploadFolder->Filename;
        if (empty($ending)) {
            $cover = ArrayData::create(['ID' => 0]);
        } else {
            $cover = ImageExtension::create_from_path($coverSource, $uploadPath, $targetFilename);
        }
        return $cover;
    }
}