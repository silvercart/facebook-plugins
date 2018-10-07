<?php

namespace SilverCart\FacebookPlugins\Model;

use SilverCart\Dev\Tools;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBDatetime;

/**
 * Represents a Facebook event.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Model
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class Event extends DataObject
{
    use Facebookable;
    use \SilverCart\ORM\ExtensibleDataObject;
    
    /**
     * DB table name.
     *
     * @var string
     */
    private static $table_name = 'FacebookEvent';
    /**
     * DB attributes.
     *
     * @var array
     */
    private static $db = [
        'FacebookID'  => 'Varchar(32)',
        'Name'        => 'Varchar(64)',
        'Place'       => 'Varchar(142)',
        'Description' => DBText::class,
        'StartTime'   => DBDatetime::class,
        'EndTime'     => DBDatetime::class,
    ];
    /**
     * Has many relations.
     *
     * @var array
     */
    private static $has_many = [
        'EventTimes' => EventTime::class,
    ];
    
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
     * @param bool $includerelations Include relations?
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
                    Tools::field_labels_for(self::class)
            );
        });
        return parent::fieldLabels($includerelations);
    }
}