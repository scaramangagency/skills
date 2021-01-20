<?php
/**
 * Ducks API plugin for Craft CMS 3.x
 *
 * RESTful API to CRUD ducks
 *
 * @link      https://scaramanga.agency
 * @copyright Copyright (c) 2021 Scaramanga Agency
 */

namespace scaramangagency\ducksapi\services;

use scaramangagency\ducksapi\DucksApi;

use Craft;
use craft\base\Component;
use craft\web\Application;
use craft\web\Request;
use craft\elements\Entry;
use craft\helpers\Db;

use yii\web\BadRequestHttpException;
use yii\web\UnauthorizedHttpException;

/**
 * @author    Scaramanga Agency
 * @package   DucksApi
 * @since     1.0.0
 */
class DucksApiService extends Component
{
    // Public Methods
    // =========================================================================

    /*
     * @return boolean
     */
    public function handleAuthentication()
    {
        // Did the request include user credentials?
        list($username, $password) = Craft::$app->getRequest()->getAuthCredentials();

        if (!$username || !$password) {
            throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
        }

        $user = Craft::$app->getUsers()->getUserByUsernameOrEmail(Db::escapeParam($username));

        if (!$user) {
            throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
        }

        if (!$user->authenticate($password)) {
            throw new UnauthorizedHttpException('Your request was made with invalid credentials.');
        }

        return $user->id;
    }

    /*
     * @return mixed
     */
    public function getDucks($id)
    {
        $user = DucksApi::$plugin->ducksApiService->handleAuthentication();

        if ($user) {
            if ($id) {
                $ducks = Entry::find()->id($id)->one();

                if (!$ducks) {
                    throw new BadRequestHttpException('A duck does not exist with that id.');
                }

                if ($ducks->authorId != $user) {
                    throw new UnauthorizedHttpException('You do not have permissions to select this duck.');
                }
            } else {
                $ducks = Entry::find()->authorId($user)->all();
            }
            
            $response = [
                'success' => true,
                'response' => []
            ];
            
            if ($id) {
                $response['response'][] = [
                    "id" => $ducks->id,
                    "name" => $ducks->title,
                    "price" => $ducks->price,
                    "created" => $ducks->dateCreated
                ];
            } else {
                foreach ($ducks as $duck) {
                    $response['response'][] = [
                        "id" => $duck->id,
                        "name" => $duck->title,
                        "price" => $duck->price,
                        "created" => $duck->dateCreated
                    ];
                }
            }
            

            return $response;
        }
    }

    /*
     * @return mixed
     */
    public function setDucks($id, $request)
    {
        $user = DucksApi::$plugin->ducksApiService->handleAuthentication();

        if ($user) {
            $payload = json_decode($request);

            if (!$id) {
                $entry = new Entry();
                $entry->sectionId = 1;
                $entry->typeId = 1;
                $entry->authorId = $user;
                $entry->enabled = true;
                $entry->title = $payload->name;
                $entry->setFieldValues([
                    'price' => $payload->price
                ]);

                $saved = Craft::$app->elements->saveElement($entry);
                
                if ($saved) {
                    $result = [
                        'success' => true,
                        'response' => [
                            'id' => $entry->id,
                            'name' => $entry->title,
                            'price' => $entry->price,
                            'created' => $entry->dateCreated
                        ]
                    ];

                    return $result;
                } else {
                    throw new BadRequestHttpException('Failed to add new duck.');
                }

            } else {
                $entry = Entry::find()->id($id)->one();
                
                if (!$entry) {
                    throw new BadRequestHttpException('A duck does not exist with that id.');
                }
                
                if ($entry->authorId != $user) {
                    throw new UnauthorizedHttpException('You do not have permissions to update this duck.');
                }

                $entry->title = $payload->name;

                $entry->setFieldValues([
                    'price' => $payload->price
                ]);

                $saved = Craft::$app->elements->saveElement($entry);

                if ($saved) {
                    $result = [
                        'success' => true,
                        'response' => [
                            'id' => $entry->id,
                            'title' => $entry->title,
                            'price' => $entry->price,
                            'created' => $entry->dateCreated
                        ]
                    ];

                    return $result;
                } else {
                    throw new BadRequestHttpException('Failed to update this duck.');
                }
            }
        }
    }

    /*
     * @return mixed
     */
    public function deleteDuck($id)
    {
        $user = DucksApi::$plugin->ducksApiService->handleAuthentication();

        if ($user) {
            $entry = Entry::find()->id($id)->one();

            if (!$entry) {
                throw new BadRequestHttpException('A duck does not exist with that id.');
            }

            if ($entry->authorId != $user) {
                throw new UnauthorizedHttpException('You do not have permissions to remove this duck.');
            }

            $removed = Craft::$app->elements->deleteElement($entry);

            if ($removed) {
                $result = [
                    'success' => true
                ];

                return $result;
            } else {
                throw new BadRequestHttpException('Failed to remove this duck.');
            }
        }

    }
}
