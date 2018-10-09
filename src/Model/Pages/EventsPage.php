<?php

namespace SilverCart\FacebookPlugins\Model\Pages;

use Page;
use SilverCart\Dev\Tools;
use SilverCart\FacebookPlugins\Model\Event;
use SilverCart\FacebookPlugins\Model\EventTime;
use SilverCart\Model\Pages\Page as SilverCartPage;
use SilverStripe\Control\Controller;
use SilverStripe\ORM\PaginatedList;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\View\ArrayData;

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
class EventsPage extends Page
{
    use \SilverCart\ORM\ExtensibleDataObject;
    
    /**
     * Page length for EventTimes.
     *
     * @var int
     */
    private static $event_time_page_length = 15;
    /**
     * Will be set to true as soon as $this->getCMSFields() is called.
     *
     * @var boolean
     */
    protected $getCMSFieldsIsCalled = false;

    /**
     * Returns the plural name.
     * 
     * @return string
     */
    public function plural_name()
    {
        return Tools::plural_name_for($this);
    }
    
    /**
     * Returns the singular name.
     * 
     * @return string
     */
    public function singular_name()
    {
        return Tools::singular_name_for($this);
    }
    
    /**
     * Returns the field labels.
     * 
     * @param boolean $includerelations Include relations?
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function fieldLabels($includerelations = true)
    {
        $this->beforeUpdateFieldLabels(function(&$labels) {
            $labels = array_merge(
                    $labels,
                    [
                        'UpcomingEvents' => _t(self::class . ".UpcomingEvents", "Upcoming Events"),
                        'PastEvents'     => _t(self::class . ".PastEvents", "Past Events"),
                    ]
            );
        });
        return parent::fieldLabels($includerelations);
    }
    
    /**
     * Returns the CMS fields.
     * 
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $this->getCMSFieldsIsCalled = true;
        return parent::getCMSFields();
    }
    
    /**
     * Adds breadcrumb items if necessary for the current action.
     *
     * @param int    $maxDepth       maximum depth level of shown pages in breadcrumbs
     * @param string $stopAtPageType name of pagetype to stop at
     * @param bool   $showHidden     true, if hidden pages should be displayed in breadcrumbs
     * 
     * @return ArrayList
     */
    public function getBreadcrumbItems($maxDepth = 20, $stopAtPageType = false, $showHidden = false)
    {
        $items          = parent::getBreadcrumbItems($maxDepth, $stopAtPageType, $showHidden);
        $breadcrumbItem = '';
        $ctrl           = Controller::curr();
        $action         = $ctrl->getAction();
        /* @var $ctrl EventsPageController */
        if ($action === 'event') {
            $event = $ctrl->getEvent();
            if (!is_null($event)) {
                $breadcrumbItem = $event->Name;
                $link           = $event->Link();
            }
        } elseif ($action === 'past'
               || $action === 'upcoming') {
            $breadcrumbItem = $this->fieldLabel(ucfirst($action) . 'Events');
            $link           = $this->Link($action);
        }
        if (!empty($breadcrumbItem)) {
            $title = DBText::create();
            $title->setValue($breadcrumbItem);
            $items->push(ArrayData::create([
                'MenuTitle' => $title,
                'Title'     => $title,
                'Link'      => $link,
            ]));
        }
        return $items;
    }
    
    /**
     * Returns the meta title. If not set, the meta-title of the 
     * single product in detail view or the title of the SiteTree object 
     * will be returned
     * 
     * @return string
     */
    public function getMetaTitle()
    {
        $metaTitle = $this->getField('MetaTitle');
        if (!$this->getCMSFieldsIsCalled
         && !Tools::isBackendEnvironment()
        ) {
            if (empty($metaTitle)) {
                $ctrl = Controller::curr();
                if ($ctrl->getAction() === 'event') {
                    $metaTitle = $ctrl->getEvent()->Name;
                } elseif ($ctrl->getAction() === 'past') {
                    $metaTitle = $this->fieldLabel('PastEvents');
                } elseif ($ctrl->getAction() === 'upcoming') {
                    $metaTitle = $this->fieldLabel('UpcomingEvents');
                } else {
                    $metaTitle = $this->Title;
                }
                if ($ctrl instanceof EventsPageController) {
                    $pageXofY  = "";
                    if ($ctrl->HasMorePagesThan(1)) {
                        $pageXofY = _t(SilverCartPage::class . '.PageXofY', 'Page {x} of {y}', [
                            'x' => $ctrl->CurrentPage(),
                            'y' => $ctrl->TotalPages(),
                        ]);
                        $pageXofY = " ({$pageXofY})";
                    }
                    $metaTitle = "{$metaTitle}{$pageXofY}";
                }
            }
            $this->extend('updateMetaTitle', $metaTitle);
        }
        return $metaTitle;
    }
    
    /**
     * Returns the upcoming events.
     * 
     * @return \SilverStripe\ORM\DataList
     */
    public function Events()
    {
        return Event::getUpcoming();
    }
    
    /**
     * Returns all upcoming event times.
     * 
     * @return \SilverStripe\ORM\DataList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function UpcomingEvents()
    {
        return EventTime::getUpcoming();
    }
    
    /**
     * Returns the upcoming event times as a paginated list.
     * 
     * @return PaginatedList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function PaginatedUpcomingEvents()
    {
        $list = PaginatedList::create($this->UpcomingEvents(), Controller::curr()->getRequest());
        $list->setPageLength($this->config()->get('event_time_page_length'));
        return $list;
    }
    
    /**
     * Returns all past event times.
     * 
     * @return \SilverStripe\ORM\DataList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function PastEvents()
    {
        return EventTime::getPast();
    }
    
    /**
     * Returns the past event times as a paginated list.
     * 
     * @return PaginatedList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function PaginatedPastEvents()
    {
        $list = PaginatedList::create($this->PastEvents(), Controller::curr()->getRequest());
        $list->setPageLength($this->config()->get('event_time_page_length'));
        return $list;
    }
}