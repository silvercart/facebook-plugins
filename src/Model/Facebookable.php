<?php

namespace SilverCart\FacebookPlugins\Model;

use SilverStripe\Assets\Folder;

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
    
    /**
     * Creates the upload folder for Facebook cover images if it doesn't exist.
     *
     * @return Folder
     *
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 09.10.2018
     */
    public static function getCoverUploadFolder()
    {
        $uploadsFolder = Folder::get()->filter('Name', 'facebook-covers')->first();
        if (!($uploadsFolder instanceof Folder)) {
            $uploadsFolder = Folder::create();
            $uploadsFolder->Name = 'facebook-covers';
            $uploadsFolder->Title = 'facebook-covers';
            $uploadsFolder->ParentID = 0;
            $uploadsFolder->write();
        }
        return $uploadsFolder;
    }
}