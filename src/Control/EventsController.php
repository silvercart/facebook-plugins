<?php

namespace SilverCart\FacebookPlugins\Control;

use ReflectionClass;
use SilverCart\Dev\Tools;
use SilverCart\FacebookPlugins\Model\EventTime;
use SilverCart\FacebookPlugins\Model\Pages\EventsPage;
use SilverStripe\Control\Controller;

/**
 * Controller to handle Facebook event AJAX calls.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Control
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class EventsController extends Controller
{
    const LOAD_TYPE_ALL      = 'all';
    const LOAD_TYPE_PAST     = 'past';
    const LOAD_TYPE_UPCOMING = 'upcoming';
    /**
     * List of allowed actions.
     *
     * @var array
     */
    private static $allowed_actions = [
        'load',
    ];
    
    /**
     * Loads events and returns them as rendered HTML.
     * 
     * @param \SilverStripe\Control\HTTPRequest $request Request
     * 
     * @return DBHTMLText
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function load($request)
    {
        $html   = "";
        $events = null;
        $type   = $request->param('Type');
        $offset = $request->param('Offset');
        $length = $request->param('Length');
        if ($type == self::LOAD_TYPE_UPCOMING) {
            $events = EventTime::getUpcoming()->limit($length, $offset);
        } elseif ($type == self::LOAD_TYPE_PAST) {
            $events = EventTime::getPast()->limit($length, $offset);
        } elseif ($type == self::LOAD_TYPE_ALL) {
            $events = EventTime::get()->limit($length, $offset);
        }
        if (!is_null($events)) {
            $pageReflection  = new ReflectionClass(EventsPage::class);
            $pageNamespace   = $pageReflection->getNamespaceName();
            $eventReflection = new ReflectionClass(EventTime::class);
            $eventClassname  = $eventReflection->getShortName();
            $templateName    =  "{$pageNamespace}\\Includes\\{$eventClassname}Summary";
            foreach ($events as $event) {
                /* @var $event EventTime */
                $html .= $event->renderWith($templateName);
            }
        }
        print $html;
        exit();
    }
}