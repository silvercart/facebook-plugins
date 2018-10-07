<?php

namespace SilverCart\FacebookPlugins\Dev\Tasks;

/**
 * Task to handle some dev/test stuff.
 * 
 * @package SilverCart
 * @subpackage FacebookPlugins\Dev\Tasks
 * @author Sebastian Diel <sdiel@pixeltricks.de>
 * @since 07.10.2018
 * @copyright 2018 pixeltricks GmbH
 * @license see license file in modules root directory
 */
class DevTask extends Task
{
    use \SilverCart\Dev\CLITask;
    
    /**
     * Allowed actions.
     *
     * @var array
     */
    private static $allowed_actions = [
        'createTestPage',
        'getPageCategories',
    ];
    /**
     * Facebook user ID to use as context for test content.
     *
     * @var string
     */
    private static $facebook_user_id = '';

    /**
     * Requests the Facebook page categories list.
     *
     * @return void 
     */
    public function getPageCategories()
    {
        $response = $this->getClient()->sendGetRequest('/fb_page_categories');
        var_dump($response);
    }
    
    /**
     * Creates a Facebook page for test purposes.
     * 
     * @return void
     * 
     * @author Sebastian Diel <sdiel@pixeltricks.de>
     * @since 07.10.2018
     */
    public function createTestPage()
    {
        $fbUserID = $this->config()->get('facebook_user_id');
        $response = $this->getClient()->sendPostRequest("/{$fbUserID}/accounts", [
            'category_enum' => 'GAME',
            'name'          => 'My Test Page',
            'about'         => 'My Test Page Description.',
            'picture'       => 'https://scontent-frx5-1.xx.fbcdn.net/v/t1.0-1/p480x480/38676730_1251748578295905_1655666238560403456_n.png?_nc_cat=108&oh=11b86e7f303e80eddbbeb556cac66092&oe=5C1C9832',
            'cover_photo'   => [
                'url' => 'https://scontent-frx5-1.xx.fbcdn.net/v/t1.0-9/42982635_1297254310411998_3317289772854018048_n.jpg?_nc_cat=110&oh=2c7ff7ee756234ac9e901ede0da6971e&oe=5C1DB5C7',
            ],
        ]);
        var_dump($response);
    }
}