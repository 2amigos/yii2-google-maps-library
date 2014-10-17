<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;


use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * CircleOptions
 *
 * Eases the configuration of a rectangle
 *
 * @property LatLng center The center. Required.
 * @property boolean clickable Indicates whether this Circle handles mouse events. Defaults to true.
 * @property boolean draggable If set to true, the user can drag this circle over the map. Defaults to false.
 * @property boolean editable If set to true, the user can edit this circle by dragging the control points shown at the
 * center and around the circumference of the circle. Defaults to false.
 * @property string fillColor The fill color. All CSS3 colors are supported except for extended named colors.
 * @property int fillOpacity The fill opacity between 0.0 and 1.0
 * @property string map Map on which to display Circle.
 * @property int radius The radius in meters on the Earth's surface
 * @property string strokeColor The stroke color. All CSS3 colors are supported except for extended named colors.
 * @property int strokeOpacity The stroke opacity between 0.0 and 1.0
 * @property string strokePosition The stroke position. Defaults to [StrokePosition::POSITION_CENTER]. This property is not
 * supported on Internet Explorer 8 and earlier.
 * @property int strokeWeight The stroke width in pixels.
 * @property boolean visible Whether this circle is visible on the map. Defaults to true.
 * @property int zIndex The zIndex compared to other circles.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class CircleOptions extends ObjectAbstract
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
                'center' => null,
                'clickable' => null,
                'draggable' => null,
                'editable' => null,
                'fillColor' => null,
                'fillOpacity' => null,
                'map' => null,
                'radius' => null,
                'strokeColor' => null,
                'strokeOpacity' => null,
                'strokePosition' => null,
                'strokeWeight' => null,
                'visible' => null,
                'zIndex' => null,
            ],
            $this->options
        );

        parent::__construct($config);
    }

    /**
     * Sets the map name making sure is not going to be converted into a js string.
     *
     * @param string $value
     */
    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }

    /**
     * Sets strokePosition option property.
     *
     * @param $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setStrokePosition($value)
    {
        if (!StrokePosition::getIsValid($value)) {
            throw new InvalidConfigException('Unknown "StrokePosition" value');
        }

        $this->options['strokePosition'] = new JsExpression($value);
    }

} 