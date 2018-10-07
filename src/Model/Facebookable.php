<?php

namespace SilverCart\FacebookPlugins\Model;

/**
 * Trait to add Facebook specific functions to a Facebook model (DataObject).
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Model
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
trait Facebookable
{
    /**
     * Returns a DataObject by the given Facebook ID.
     * 
     * @param string $facebookID Facebook ID / object reference
     * 
     * @return static
     */
    public static function getByFacebookID($facebookID)
    {
        return self::get()->filter('FacebookID', $facebookID)->first();
    }
}