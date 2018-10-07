<?php

namespace SilverCart\FacebookPlugins\Extensions;

use SilverCart\Dev\Tools;
use SilverCart\Forms\FormFields\TextareaField;
use SilverCart\Forms\FormFields\TextField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\LiteralField;
use SilverStripe\Forms\ToggleCompositeField;
use SilverStripe\ORM\DataExtension;
use SilverStripe\ORM\FieldType\DBText;
use SilverStripe\ORM\FieldType\DBHTMLText;

/**
 * Extension for SiteConfig.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins_Extensions
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 31.08.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class SiteConfigExtension extends DataExtension
{
    /**
     * DB attributes
     *
     * @var array
     */
    private static $db = [
        'FacebookPluginSDKCode'      => DBText::class,
        'FacebookAppID'              => 'Varchar(32)',
        'FacebookAppSecret'          => 'Varchar(48)',
        'FacebookDefaultAccessToken' => 'Varchar(48)',
        'FacebookAccessToken'        => DBText::class,
        'FacebookPageID'             => 'Varchar(32)',
    ];
    /**
     * Casted attributes
     *
     * @var array
     */
    private static $casting = [
        'DefaultFacebookPluginSDKCode' => DBHTMLText::class,
    ];
    
    /**
     * Adds a translation section
     *
     * @param FieldList $fields The FieldList
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 31.08.2018
     */
    public function updateCMSFields(FieldList $fields)
    {
        $fields->findOrMakeTab('Root.SocialMedia')->setTitle($this->owner->fieldLabel('SocialMediaTab'));
        $fields->addFieldToTab('Root.SocialMedia', ToggleCompositeField::create(
                'FacebookAppConnection',
                $this->owner->fieldLabel('FacebookAppConnection'),
                [
                    TextField::create('FacebookAppID',              $this->owner->fieldLabel('FacebookAppID')),
                    TextField::create('FacebookAppSecret',          $this->owner->fieldLabel('FacebookAppSecret')),
                    TextField::create('FacebookDefaultAccessToken', $this->owner->fieldLabel('FacebookDefaultAccessToken')),
                    TextField::create('FacebookAccessToken',        $this->owner->fieldLabel('FacebookAccessToken')),
                    TextField::create('FacebookPageID',             $this->owner->fieldLabel('FacebookPageID')),
                ]
        )->setStartClosed(!empty($this->owner->FacebookAppID)));
        $fields->addFieldToTab('Root.SocialMedia', TextareaField::create('FacebookPluginSDKCode', $this->owner->fieldLabel('FacebookPluginSDKCode'))
                ->setDescription($this->owner->fieldLabel('FacebookPluginSDKCodeDesc')));
        if (empty($this->owner->FacebookPluginSDKCode)) {
            $fields->addFieldToTab('Root.SocialMedia', LiteralField::create('FacebookPluginSDKCodeDesc', $this->owner->renderWith(self::class . '_DefaultSDKCodeDesc')));
        }
    }
    
    /**
     * Updates the fields labels
     *
     * @param array &$labels Labels to update
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 31.08.2018
     */
    public function updateFieldLabels(&$labels)
    {
        $labels = array_merge(
                $labels,
                Tools::field_labels_for(self::class),
                [
                    'FacebookAppConnection' => _t(self::class . ".FacebookAppConnection", "Facebook App Connection Settings"),
                ]
        );
    }
    
    /**
     * Returns the default Facebook Plugin SDK code.
     * 
     * @return \SilverStripe\ORM\FieldType\DBHTMLText
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 31.08.2018
     */
    public function getDefaultFacebookPluginSDKCode()
    {
        return $this->owner->renderWith(self::class . '_DefaultSDKCode');
    }
}