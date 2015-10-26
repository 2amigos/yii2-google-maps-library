<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\services;

use dosamigos\google\maps\ClientAbstract;
use yii\helpers\ArrayHelper;
use yii\base\InvalidConfigException;
use Yii;

/**
 * DirectionsClient
 *
 * Utility class to call Google's Directions API. For further information, please visit
 * https://developers.google.com/maps/documentation/directions/
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class DirectionsClient extends ClientAbstract
{
    /**
     * @inheritdoc
     * @param array $config
     */
    public function __construct($config = [])
    {

        $this->params = ArrayHelper::merge(
            [
                'origin' => null,
                'destination' => null,
                'mode' => null,
                'waypoints' => null,
                'alternatives' => null,
                'avoid' => null,
                'language' => null,
                'units' => null,
                'region' => null,
                'departure_time' => null,
                'arrival_time' => null,
            ],
            $this->params
        );

        parent::__construct($config);
    }

    /**
     * Returns the api url
     * @return string
     */
    public function getUrl()
    {
        return 'https://maps.googleapis.com/maps/api/directions/' . $this->format;
    }

    /**
     * Makes a geocoding request for an direction parameters. Please, review the documentation on
     * https://developers.google.com/maps/documentation/directions/intro#DirectionsResponses for further information about the
     * expected results.
     *
     * @param array $params parameters for the request. These override [DirectionsRequest::params].
     *
     * @return mixed|null
     * @throws \yii\base\InvalidConfigException
     */
    public function lookup($params = [])
    {
        $this->params = ArrayHelper::merge($this->params, $params);

        if ($this->params['origin'] == null && $this->params['destination'] == null) {
            throw new InvalidConfigException('"origin" and "destination" must be set for the request. Both cannot be null');
        }

        return parent::request();
    }
} 