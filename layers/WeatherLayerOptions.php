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

class WeatherLayerOptions extends ObjectAbstract
{
    use OptionsTrait;

    public function __construct($config = [])
    {
        parent::__construct($config);

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
    }

    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }

    public function setLabelColor($value) {
        if(!LabelColor::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "labelColor" value');
        }
        $this->options['labelColor'] = new JsExpression($value);
    }

    public function setTemperatureUnits($value)
    {
        if (!TemperatureUnit::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "temperatureUnits" value');
        }
        $this->options['temperatureUnits'] = new JsExpression($value);
    }

    public function setWindSpeedUnits($value) {
        if(!WindSpeedUnits::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "windSpeedUnits" value');
        }
        $this->options['windSpeedUnits'] = new JsExpression($value);
    }
}