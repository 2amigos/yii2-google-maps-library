<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\layers;

use yii\base\InvalidConfigException;

/**
 * KmlLayer
 *
 * A KmlLayer adds geographic markup to the map from a KML, KMZ or GeoRSS file that is hosted on a publicly accessible
 * web server. A KmlFeatureData object is provided for each feature when clicked.
 *
 * For further information please visit its
 * [documentation](https://developers.google.com/maps/documentation/javascript/reference#KmlLayer) at Google.
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class KmlLayer extends KmlLayerOptions
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
     * Returns the required initialization javascript code
     *
     * @return string
     */
    public function getJs()
    {
        $name = $this->getName();
        $options = $this->getEncodedOptions();

        return "var {$name} = new google.maps.KmlLayer({$options});";
    }
} 