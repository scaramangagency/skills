<?php
/**
 * Ducks API plugin for Craft CMS 3.x
 *
 * RESTful API to CRUD ducks
 *
 * @link      https://scaramanga.agency
 * @copyright Copyright (c) 2021 Scaramanga Agency
 */

namespace scaramangagency\ducksapi\controllers;

use scaramangagency\ducksapi\DucksApi;

use Craft;
use craft\web\Controller;

use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;
/**
 * @author    Scaramanga Agency
 * @package   DucksApi
 * @since     1.0.0
 */
class DefaultController extends Controller
{

    // Protected Properties
    // =========================================================================

    /**
     * @var    bool|array Allows anonymous access to this controller's actions.
     *         The actions must be in 'kebab-case'
     * @access protected
     */
    protected $allowAnonymous = true;

    // Public Methods
    // =========================================================================

    /**
     * @return mixed
     */
    public function actionSetDucks($id = null)
    {
        $this->requirePostRequest();
        
        return DucksApi::$plugin->ducksApiService->setDucks($id, $this->request->getRawBody());
    }

    /**
     * @return mixed
     */
    public function actionGetDucks($id = null)
    {
        return DucksApi::$plugin->ducksApiService->getDucks($id);
    }

    /**
     * @return mixed
     */
    public function actionDeleteDuck($id)
    {
        $this->requirePostRequest();

        if (!$id) {
            throw new BadRequestHttpException('You have not passed a required attribute: id');
        }
        
        return DucksApi::$plugin->ducksApiService->deleteDuck($id);
    }
}
