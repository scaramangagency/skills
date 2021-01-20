<?php
/**
 * Ducks API plugin for Craft CMS 3.x
 *
 * RESTful API to CRUD ducks
 *
 * @link      https://scaramanga.agency
 * @copyright Copyright (c) 2021 Scaramanga Agency
 */

namespace scaramangagency\ducksapi;

use scaramangagency\ducksapi\services\DucksApiService as DucksApiServiceService;

use Craft;
use craft\base\Plugin;
use craft\services\Plugins;
use craft\events\PluginEvent;
use craft\web\UrlManager;
use craft\events\RegisterUrlRulesEvent;

use yii\base\Event;

/**
 * Class DucksApi
 *
 * @author    Scaramanga Agency
 * @package   DucksApi
 * @since     1.0.0
 *
 * @property  DucksApiServiceService $ducksApiService
 */
class DucksApi extends Plugin
{
    // Static Properties
    // =========================================================================

    /**
     * @var DucksApi
     */
    public static $plugin;

    // Public Properties
    // =========================================================================

    /**
     * @var string
     */
    public $schemaVersion = '1.0.0';

    /**
     * @var bool
     */
    public $hasCpSettings = false;

    /**
     * @var bool
     */
    public $hasCpSection = false;

    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        self::$plugin = $this;

        Event::on(
            UrlManager::class,
            UrlManager::EVENT_REGISTER_SITE_URL_RULES,
            function (RegisterUrlRulesEvent $event) {
                $event->rules['get-ducks'] = 'ducks-api/default/get-ducks';
                $event->rules['get-ducks/<id>'] = 'ducks-api/default/get-ducks';
                $event->rules['set-ducks'] = 'ducks-api/default/set-ducks';
                $event->rules['set-ducks/<id>'] = 'ducks-api/default/set-ducks';
                $event->rules['delete-duck'] = 'ducks-api/default/delete-duck';
                $event->rules['delete-duck/<id>'] = 'ducks-api/default/delete-duck';
            }
        );

        Event::on(
            Plugins::class,
            Plugins::EVENT_AFTER_INSTALL_PLUGIN,
            function (PluginEvent $event) {
                if ($event->plugin === $this) {
                }
            }
        );

        Craft::info(
            Craft::t(
                'ducks-api',
                '{name} plugin loaded',
                ['name' => $this->name]
            ),
            __METHOD__
        );
    }

    // Protected Methods
    // =========================================================================

}
