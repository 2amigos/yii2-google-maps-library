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
 * HeatLayer
 *
 * A heatmap is a visualization used to depict the intensity of data at geographical points. When the Heatmap Layer is
 * enabled, a colored overlay will appear on top of the map. By default, areas of higher intensity will be colored red,
 * and areas of lower intensity will appear green.
 *
 * For further information please visit its
 * [documentation](https://developers.google.com/maps/documentation/javascript/reference#KmlLayer) at Google.
 *
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 *
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class HeatLayer extends HeatLayerOptions
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
     * Returns the required initialization javascript code
     *
     * @return string
     */
    public function getJs()
    {
        $name = $this->getName();
        $options = $this->getEncodedOptions();
        return "var {$name} = new google.maps.visualization.HeatmapLayer({$options});";
    }
}
