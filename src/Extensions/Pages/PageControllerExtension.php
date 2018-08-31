<?php

namespace SilverCart\FacebookPlugins\Extensions\Pages;

use SilverStripe\Core\Extension;
use SilverStripe\SiteConfig\SiteConfig;

/**
 * Extension for the SilverCart PageController.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins_Extensions_Pages
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 31.08.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class PageControllerExtension extends Extension
{
    /**
     * Adds the Facebook Plugin SDK code to the custom header HTML content.
     * 
     * @param string &$headerCustomHtmlContent Content to update
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 31.08.2018
     */
    public function updateHeaderCustomHtmlContent(&$headerCustomHtmlContent)
    {
        $headerCustomHtmlContent .= SiteConfig::current_site_config()->FacebookPluginSDKCode;
    }
}