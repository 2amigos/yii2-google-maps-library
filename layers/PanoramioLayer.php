<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\layers;


use yii\base\InvalidConfigException;

/**
 * PanoramioLayer
 *
 * A PanoramioLayer displays photos from Panoramio as a rendered layer.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class PanoramioLayer extends WeatherLayerOptions
{
    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->map == null) {
            throw new InvalidConfigException('"map" cannot be null');
        }
    }

    /**
     * Returns the javascript code required to initialize the object
     * 
     * @return string
     */
    public function getJs()
    {
        $name = $this->getName();
        $options = $this->getEncodedOptions();

        return "var {$name} = new google.maps.PanoramioLayer({$options});";
    }
} 