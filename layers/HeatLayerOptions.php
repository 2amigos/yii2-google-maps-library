<?php

/*
 *
 * @copyright Copyright (c) 2013-2019 2amigos
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 *
 */

namespace dosamigos\google\maps\layers;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * HeatLayerOptions
 *
 * This object defines the properties that can be set on a [HeatLayer] object.
 *
 * @property boolean $dissipating Specifies whether heatmaps dissipate on zoom. When dissipating is false the radius of
 * influence increases with zoom level to ensure that the color intensity is preserved at any given geographic location.
 * Defaults to false.
 * @property string $map The map on which to display the layer.
 * @property string $gradient  The color gradient of the heatmap, specified as an array of CSS color strings. All CSS3
 * colors — including RGBA — are supported except for extended named colors and HSL(A) values.
 * @property integer $maxIntensity The maximum intensity of the heatmap. By default, heatmap colors are dynamically scaled
 * according to the greatest concentration of points at any particular pixel on the map. This property allows you to
 * specify a fixed maximum. Setting the maximum intensity can be helpful when your dataset contains a few outliers with
 * an unusually high intensity.
 * @property integer $radius The radius of influence for each data point, in pixels.
 * @property integer $opacity The opacity of the heatmap, expressed as a number between 0 and 1.
 *
 * @author Antonio Ramirez <hola@2amigos.us>
 *
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class HeatLayerOptions extends ObjectAbstract
{
    use OptionsTrait;

    /**
     * @inheritdoc
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->options = ArrayHelper::merge(
            [
                'map' => null,
                'data' => [],
                'dissipating' => null,
                'gradient' => null,
                'maxIntensity' => null,
                'radius' => null,
                'opacity' => null,
            ],
            $this->options
        );
        parent::__construct($config);
    }

    /**
     * Sets the map, making sure is not going to be converted into a js string.
     *
     * @param $value
     */
    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }

    /**
     * Adds a coordinate to the path array
     *
     * @param LatLng $coord
     *
     * @return $this
     */
    public function addCoord(LatLng $coord)
    {
        $cloned = clone $coord;
        $cloned->setName(null);
        $this->options['data'][] = $coord;

        return $this;
    }

    /**
     * Sets the path of the polygon
     *
     * @param array $coords
     */
    public function setDatas(array $coords)
    {
        foreach ($coords as $coord) {
            $this->addCoord($coord);
        }
    }

    /**
     * @param $value
     */
    public function setGradient($value)
    {
        $this->options['gradient'] = new JsExpression($value);
    }
}
