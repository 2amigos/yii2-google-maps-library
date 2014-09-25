<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\controls;

use dosamigos\google\maps\MapTypeId;
use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * MapTypeControlOptions
 *
 * Options for the rendering of the map type control.
 *
 * For further information please visit its
 * [documentation](https://developers.google.com/maps/documentation/javascript/reference#MapTypeControlOptions) at Google.
 *
 * ```
 * use dosamigos\google\maps\controls\MapTypeControlOptions;
 * use dosamigos\google\maps\controls\MapTypeControlStyle;
 * use dosamigos\google\maps\Map;
 *
 * $options = new MapTypeControlOptions(['style' => MapTypeControlStyle::DROPDOWN_MENU]);
 *
 * $map = new Map(['mayTypeControlOptions' => $options]);
 *
 * ```
 *
 * @property array mapTypeIds IDs of map types to show in the control.
 * @property string position Position id by [ControlPosition]. Used to specify the position of the control on the map.
 * The default position is [ControlPosition::TOP_RIGHT].
 * @property string style. Used to select what style of map type control to display. Use [MapTypeControlStyle] for it.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps\controls
 */
class MapTypeControlOptions extends ObjectAbstract
{
    use OptionsTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->options = ArrayHelper::merge(
            [
                'mapTypeIds' => [],
                'position' => ControlPosition::TOP_RIGHT,
                'style' => null
            ],
            $this->options
        );
    }

    /**
     * Sets the map type ids and makes sure to get the proper value on the array
     *
     * @param array $types
     */
    public function setMapTypeIds(array $types)
    {
        $parsed = [];
        foreach ($types as $type) {
            $parsed[] = MapTypeId::getIsValid($type)
                ? new JsExpression($type)
                : $type;
        }

        $this->options['mapTypeIds'] = $parsed;
    }

    /**
     * Sets the position and makes sure is a valid [ControlPosition] value.
     *
     * @param string $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setPosition($value)
    {
        if (!ControlPosition::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "position" value');
        }
        $this->options['position'] = $value;
    }

    /**
     * Sets the style and makes sure is a valid [MapTypeControlStyle] value.
     *
     * @param string $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setStyle($value)
    {
        if (!MapTypeControlStyle::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "style" value');
        }

        $this->options['style'] = $value;
    }
} 