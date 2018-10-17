<?php

namespace SilverCart\FacebookPlugins\Model;

use SilverCart\Dev\Tools;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\FieldType\DBText;

/**
 * Represents a Facebook place.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Model
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 17.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class Place extends DataObject
{
    use Facebookable;
    use \SilverCart\ORM\ExtensibleDataObject;
    
    const COUNTRY_MAP = [
        "Deutschland" => "Germany",
    ];
    
    /**
     * DB table name.
     *
     * @var string
     */
    private static $table_name = 'FacebookPlace';
    /**
     * DB attributes.
     *
     * @var array
     */
    private static $db = [
        'FacebookID' => 'Varchar(32)',
        'Name'       => 'Varchar(128)',
        'Street'     => 'Varchar(256)',
        'ZIP'        => 'Varchar(32)',
        'City'       => 'Varchar(128)',
        'Country'    => 'Varchar(128)',
        'Latitude'   => 'Varchar(32)',
        'Longitude'  => 'Varchar(32)',
    ];
    /**
     * Has many relations.
     *
     * @var array
     */
    private static $has_many = [
        'Events' => Event::class,
    ];
    /**
     * Casted attributes.
     *
     * @var array
     */
    private static $casting = [
        'Address' => DBText::class,
        'Nice'    => DBText::class,
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
     * @since 17.10.2018
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
     * Returns the address.
     * 
     * @return DBText
     */
    public function getAddress()
    {
        $addressParts = [];
        if (!empty($this->Street)) {
            $addressParts[] = $this->Street;
        }
        if (!empty($this->ZIP)
         && !empty($this->City)) {
            $addressParts[] = "{$this->ZIP} {$this->City}";
        } elseif (!empty($this->ZIP)) {
            $addressParts[] = $this->ZIP;
        } elseif (!empty($this->City)) {
            $addressParts[] = $this->City;
        }
        return DBText::create()->setValue(implode(', ', $addressParts));
    }
    
    /**
     * Returns the place as a readable string.
     * 
     * @return DBText
     */
    public function getNice()
    {
        $nice    = $this->Name;
        $address = $this->getAddress()->getValue();
        if (!empty($address)) {
            $nice = "{$nice}, {$address}";
        }
        return $nice;
    }
    
    /**
     * Simple getter to search a place by an address with the format:
     * Street, ZIP City, Country
     * 
     * @param string $address Address string to search for
     * 
     * @return Place
     */
    public static function getByAddress($address)
    {
        list($street, $zipWithCity, $country) = explode(', ', $address);
        list($zip, $city) = explode(' ', $zipWithCity);
        if (array_key_exists($country, self::COUNTRY_MAP)) {
            $country = self::COUNTRY_MAP[$country];
        }
        return self::get()
                ->filter([
                    'Street'  => $street,
                    'ZIP'     => $zip,
                    'City'    => $city,
                    'Country' => $country,
                ])
                ->first();
    }
}