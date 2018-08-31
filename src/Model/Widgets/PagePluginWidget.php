<?php

namespace SilverCart\FacebookPlugins\Model\Widgets;

use SilverCart\Dev\Tools;
use SilverCart\Model\Widgets\Widget;
use SilverCart\Admin\Forms\AlertInfoField;
use SilverStripe\ORM\FieldType\DBBoolean;
use SilverStripe\ORM\FieldType\DBVarchar;
use SilverStripe\SiteConfig\SiteConfig;

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
class PagePluginWidget extends Widget
{
    /**
     * DB attributes.
     *
     * @var array
     */
    private static $db = [
        'PageURL'         => DBVarchar::class,
        'ShowTimeline'    => DBBoolean::class,
        'ShowEvents'      => DBBoolean::class,
        'ShowMessages'    => DBBoolean::class,
        'ShowSmallHeader' => DBBoolean::class,
        'HideCover'       => DBBoolean::class,
        'ShowFacePile'    => DBBoolean::class,
    ];
    /**
     * Table name.
     *
     * @var string
     */
    private static $table_name = 'FacebookPluginsPagePluginWidget';

    /**
     * Returns the CMS fields.
     * 
     * @return \SilverStripe\Forms\FieldList
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 31.08.2018
     */
    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        
        $fields->dataFieldByName('ShowTimeline')   ->setDescription($this->fieldLabel('ShowTimeline' . 'Desc'));
        $fields->dataFieldByName('ShowEvents')     ->setDescription($this->fieldLabel('ShowEvents' . 'Desc'));
        $fields->dataFieldByName('ShowMessages')   ->setDescription($this->fieldLabel('ShowMessages' . 'Desc'));
        $fields->dataFieldByName('ShowSmallHeader')->setDescription($this->fieldLabel('ShowSmallHeader' . 'Desc'));
        $fields->dataFieldByName('HideCover')      ->setDescription($this->fieldLabel('HideCover' . 'Desc'));
        $fields->dataFieldByName('ShowFacePile')   ->setDescription($this->fieldLabel('ShowFacePile' . 'Desc'));
        
        $fields->insertBefore('ShowTimeline', AlertInfoField::create('ShowTabsHint', $this->fieldLabel('ShowTabsHint')));
        
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
     * @since 31.08.2018
     */
    public function fieldLabels($includerelations = true)
    {
        return array_merge(
                parent::fieldLabels($includerelations),
                Tools::field_labels_for(self::class),
                [
                    'ShowTabsHint' => _t(self::class . '.ShowTabsHint', "To use this widget proerly at least one of the options \"Show Timeline\", \"Show Events\" or \"Show Messages\" must be active."),
                ]
        );
    }
    
    /**
     * Adds the Facebook Plugin SDK code on after write if not done yet.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 31.08.2018
     */
    protected function onAfterWrite()
    {
        parent::onAfterWrite();
        $siteConfig = SiteConfig::current_site_config();
        if (empty($siteConfig->FacebookPluginSDKCode)) {
            $siteConfig->FacebookPluginSDKCode = $siteConfig->DefaultFacebookPluginSDKCode->getValue();
            $siteConfig->write();
        }
    }
    
    /**
     * Returns the value to use in the template's data-tabs attribute.
     * 
     * @return string
     */
    public function getDataTabs()
    {
        $dataTabs = [];
        if ($this->ShowTimeline) {
            $dataTabs[] = 'timeline';
        }
        if ($this->ShowEvents) {
            $dataTabs[] = 'events';
        }
        if ($this->ShowMessages) {
            $dataTabs[] = 'messages';
        }
        return implode(',', $dataTabs);
    }
    
    /**
     * Returns the value to use in the template's data-small-header attribute.
     * 
     * @return string
     */
    public function getDataSmallHeader()
    {
        return $this->ShowSmallHeader ? 'true' : 'false';
    }
    
    /**
     * Returns the value to use in the template's data-hide-cover attribute.
     * 
     * @return string
     */
    public function getDataHideCover()
    {
        return $this->HideCover ? 'true' : 'false';
    }
    
    /**
     * Returns the value to use in the template's data-show-facepile attribute.
     * 
     * @return string
     */
    public function getDataShowFacePile()
    {
        return $this->ShowFacePile ? 'true' : 'false';
    }
}