<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\layers;

use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * WeatherLayerOptions
 *
 * This object defines the properties that can be set on a [WeatherLayer] object.
 *
 * @property boolean clickable If true, the layer receives mouse events. Default value is true.
 * @property string labelColor The color of labels on the weather layer. If this is not explicitly set, the label color
 * is chosen automatically depending on the map type.
 * @property string map The map on which to display the layer.
 * @property boolean suppressInfoWindows Suppress the rendering of info windows when weather icons are clicked.
 * @property string temperatureUnits The units to use for temperature.
 * @property string windSpeedUnits The units to use for wind speed.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\layers
 */
class WeatherLayerOptions extends ObjectAbstract
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
                'clickable' => null,
                'labelColor' => null,
                'map' => null,
                'suppressInfoWindows' => null,
                'windSpeedUnits' => null
            ],
            $this->options
        );

        parent::__construct($config);
    }

    /**
     * Sets the map name making sure it is not going to be encoded as a js string.
     *
     * @param $value
     */
    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }

    /**
     * Sets the labelColor making sure it is not going to be encoded as a js string.
     *
     * @param string $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setLabelColor($value) {
        if(!LabelColor::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "labelColor" value');
        }
        $this->options['labelColor'] = new JsExpression($value);
    }

    /**
     * Sets the temperatureUnits making sure it is not going to be encoded as a js string.
     *
     * @param string $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setTemperatureUnits($value)
    {
        if (!TemperatureUnit::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "temperatureUnits" value');
        }
        $this->options['temperatureUnits'] = new JsExpression($value);
    }

    /**
     * Sets the windSpeedUnits making sure it is not going to be encoded as a js string.
     *
     * @param string $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setWindSpeedUnits($value) {
        if(!WindSpeedUnits::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "windSpeedUnits" value');
        }
        $this->options['windSpeedUnits'] = new JsExpression($value);
    }
}