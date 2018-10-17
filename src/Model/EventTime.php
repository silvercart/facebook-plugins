<?php

namespace SilverCart\FacebookPlugins\Model;

use SilverCart\Dev\Tools;
use SilverStripe\Control\Director;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBDatetime;
use SilverStripe\SiteConfig\SiteConfig;
use SilverStripe\View\Requirements;

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
class EventTime extends DataObject
{
    use Facebookable;
    use \SilverCart\ORM\ExtensibleDataObject;
    
    /**
     * DB table name.
     *
     * @var string
     */
    private static $table_name = 'FacebookEventTime';
    /**
     * DB attributes.
     *
     * @var array
     */
    private static $db = [
        'FacebookID' => 'Varchar(32)',
        'StartTime'  => DBDatetime::class,
        'EndTime'    => DBDatetime::class,
    ];
    /**
     * Has many relations.
     *
     * @var array
     */
    private static $has_one = [
        'Event' => Event::class,
    ];
    /**
     * Default sort.
     *
     * @var string
     */
    private static $default_sort = 'StartTime ASC';
    
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
    
    /**
     * Returns the Facebook link to this EventTime.
     * 
     * @return string
     */
    public function FacebookLink()
    {
        $paramEventTimeID = "";
        if ($this->FacebookID !== "0") {
            $paramEventTimeID = "?event_time_id={$this->FacebookID}";
        }
        return "{$this->Event()->FacebookLink()}{$paramEventTimeID}";
    }
    
    /**
     * Returns the relative link to this EventTime.
     * 
     * @return string
     */
    public function Link()
    {
        return "{$this->Event()->Link()}?time={$this->ID}";
    }
    
    /**
     * Returns the absolute link to this EventTime.
     * 
     * @return string
     */
    public function AbsoluteLink()
    {
        return Director::absoluteURL($this->Link());
    }
    
    /**
     * Creates the event micro data as a JSON string to use for SEO.
     * 
     * @param bool $plain Set to true to get the plain JSON string without HTML tag
     * 
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     */
    public function getMicrodata($plain = false) {
        $siteConfig = SiteConfig::current_site_config();
        $place    = $this->Event()->Place();
        $address  = [
            '@type'           => 'PostalAddress',
            'streetAddress'   => $place->Street,
            'addressLocality' => $place->City,
            'addressRegion'   => '',
            'postalCode'      => $place->ZIP,
            'addressCountry'  => $place->Country,
        ];
        $performer = [
            '@type' => 'Organization',
            'name'  => $siteConfig->ShopName,
            'url'   => Director::absoluteBaseURL(),
        ];
        $jsonData = [
            '@context'    => 'http://schema.org',
            '@type'       => 'Event',
            'name'        => htmlentities(strip_tags($this->Event()->Name)),
            'description' => htmlentities(strip_tags($this->Event()->Description)),
            'url'         => $this->AbsoluteLink(),
            'startDate'   => date('d/m/Y H:i', strtotime($this->StartTime)),
            'endDate'     => date('d/m/Y H:i', strtotime($this->EndTime)),
            'location'    => [
                '@type'   => 'Place',
                'name'    => $place->Name,
                'address' => $address,
            ],
            'performer'   => $performer,
        ];
        if ($this->Event()->Cover()->exists()) {
            $jsonData['image'] = $this->Event()->Cover()->AbsoluteLink();
        }
        $this->extend('updateMicrodata', $jsonData);

        if (defined('JSON_PRETTY_PRINT')) {
            $output = json_encode($jsonData, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        } else {
            $output = json_encode($jsonData);
        }
        if (!$plain) {
            $output = '<script type="application/ld+json">' . $output . '</script>';
        }
        return Tools::string2html($output);
    }
    
    /**
     * Loads the JSON microdata as a HTML head tag.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 08.10.2018
     */
    public function LoadMicrodata()
    {
        Requirements::insertHeadTags($this->getMicrodata(), "event-time-{$this->ID}");
    }
    
    /**
     * Returns all upcoming events.
     * 
     * @return \SilverStripe\ORM\DataList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public static function getUpcoming()
    {
        return self::get()->where("StartTime > NOW()")->sort("StartTime", "ASC");
    }
    
    /**
     * Returns all past events.
     * 
     * @return \SilverStripe\ORM\DataList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public static function getPast()
    {
        return self::get()->where("StartTime < NOW()")->sort("StartTime", "DESC");
    }
}