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
     * Adds some JS files.
     * 
     * @param array &$jsFiles JS files
     * 
     * @return void
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 10.07.2018
     */
    public function updateRequireExtendedJavaScript(&$jsFiles)
    {
        $jsFiles = array_merge(
            $jsFiles,
            [
                'silvercart/facebook-plugins:client/js/Facebook.js',
            ]
        );
    }
}