<?php

namespace SilverCart\FacebookPlugins\Model\Widgets;

use SilverCart\Dev\Tools;
use SilverCart\FacebookPlugins\Model\EventTime;
use SilverCart\FacebookPlugins\Model\Pages\EventsPage;
use SilverCart\Model\Widgets\Widget;
use SilverStripe\ORM\FieldType\DBInt;

/**
 * Facebook Page Plugin Widget.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins_Model_Widgets
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 31.08.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class UpcomingEventsWidget extends Widget
{
    /**
     * DB attributes.
     *
     * @var array
     */
    private static $db = [
        'EventQuantity' => DBInt::class,
    ];
    /**
     * Table name.
     *
     * @var string
     */
    private static $table_name = 'FacebookUpcomingEventsWidget';

    /**
     * Returns the CMS fields.
     * 
     * @return \SilverStripe\Forms\FieldList
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        $fields->dataFieldByName('EventQuantity')->setDescription($this->fieldLabel('EventQuantity' . 'Desc'));
        
        return $fields;
    }
    
    /**
     * Returns the field labels.
     * 
     * @param bool $includerelations include relations?
     * 
     * @return array
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 08.10.2018
     */
    public function fieldLabels($includerelations = true)
    {
        return array_merge(
            parent::fieldLabels($includerelations),
            Tools::field_labels_for(self::class)
        );
    }
    
    /**
     * Returns all upcoming event times.
     * 
     * @return \SilverStripe\ORM\DataList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 08.10.2018
     */
    public function getUpcomingEvents()
    {
        return EventTime::getUpcoming()->limit($this->EventQuantity);
    }
    
    public function getEventsLink()
    {
        $eventsLink = '';
        $eventsPage = EventsPage::get()->first();
        if (!is_null($eventsPage)) {
            $eventsLink = $eventsPage->Link();
        }
        return $eventsLink;
    }
}