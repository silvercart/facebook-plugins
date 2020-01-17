<?php

namespace SilverCart\FacebookPlugins\Model\Pages;

use PageController;
use SilverCart\FacebookPlugins\Model\Event;

/**
 * Page type to present Facebook events.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Model
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class EventsPageController extends PageController
{
    /**
     * List of allowed actions.
     *
     * @var array
     */
    private static $allowed_actions = [
        'event',
        'past',
        'upcoming',
        'monitor',
    ];
    
    public function getEvent()
    {
        $event = Event::singleton();
        if ($this->getAction() === 'event'
         && is_numeric($this->getRequest()->param('ID'))) {
            $event = Event::get()->byID($this->getRequest()->param('ID'));
        }
        return $event;
    }

    /**
     * Returns wether the current view has more pages than $pageCount (default: 1).
     *
     * @param int $pageCount The number of pages to check
     *
     * @return boolean
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function HasMorePagesThan($pageCount = 1)
    {
        return $pageCount < $this->TotalPages();
    }
    
    /**
     * Returns the current page number.
     * 
     * @return int
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function CurrentPage()
    {
        $currentPage = 1;
        if ($this->getAction() === 'past') {
            $currentPage = $this->data()->PaginatedPastEvents()->CurrentPage();
        } elseif ($this->getAction() === 'upcoming') {
            $currentPage = $this->data()->PaginatedUpcomingEvents()->CurrentPage();
        }
        return $currentPage;
    }
    
    /**
     * Returns the current page number.
     * 
     * @return int
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function TotalPages()
    {
        $totalPages = 1;
        if ($this->getAction() === 'past') {
            $totalPages = $this->data()->PaginatedPastEvents()->TotalPages();
        } elseif ($this->getAction() === 'upcoming') {
            $totalPages = $this->data()->PaginatedUpcomingEvents()->TotalPages();
        }
        return $totalPages;
    }
}