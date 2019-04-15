<?php

/*
 *
 * @copyright Copyright (c) 2013-2019 2amigos 
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 */

namespace dosamigos\google\maps\layers;

use yii\base\InvalidConfigException;

/**
 * WeatherLayer
 *
 * Renders a layer that displays weather icons.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 *
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class WeatherLayer extends WeatherLayerOptions
{
    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if (null === $this->map) {
            throw new InvalidConfigException('"map" cannot be null');
        }
    }

    /**
     * Returns the required javascript code to initialize the object.
     *
     * @return string
     */
    public function getJs()
    {
        $name = $this->getName();
        $options = $this->getEncodedOptions();

        return "var {$name} = new google.maps.weather.WeatherLayer({$options});";
    }
}
