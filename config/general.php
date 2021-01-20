<?php
/**
 * General Configuration
 *
 * All of your system's general configuration settings go in here. You can see a
 * list of the available settings in vendor/craftcms/cms/src/config/GeneralConfig.php.
 *
 * @see \craft\config\GeneralConfig
 */

use craft\helpers\App;

return [
    // Global settings
    '*' => [
        'defaultWeekStartDay' => 1,
        'omitScriptNameInUrls' => true,
        'cpTrigger' => 'admin',
        'securityKey' => App::env('SECURITY_KEY'),
        'disallowRobots' => true,
        'headlessMode' => true
    ],

    'dev' => [
        'devMode' => true
    ],

    'production' => [
        'allowAdminChanges' => false,
        'allowUpdates' => false
    ],
];
