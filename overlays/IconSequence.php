<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;


use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use dosamigos\google\maps\Point;
use yii\base\InvalidConfigException;
use yii\web\JsExpression;

/**
 * IconSequence
 *
 * Object for the anonymous constructor of an IconSequence which describes how icons are to be rendered on a line.
 * For further reference of the options available please visit
 * https://developers.google.com/maps/documentation/javascript/reference#IconSequence
 *
 *
 * @property boolean fixedRotation If true, each icon in the sequence has the same fixed rotation regardless of the
 * angle of the edge on which it lies. Defaults to false, in which case each icon in the sequence is rotated to align
 * with its edge.
 * @property Symbol icon The icon to render on the line.
 * @property string offset The distance from the start of the line at which an icon is to be rendered. This distance may
 * be expressed as a percentage of line's length (e.g. '50%') or in pixels (e.g. '50px'). Defaults to '100%'.
 * @property string repeat The distance between consecutive icons on the line. This distance may be expressed as a
 * percentage of the line's length (e.g. '50%') or in pixels (e.g. '50px'). To disable repeating of the icon,
 * specify '0'. Defaults to '0'.
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class IconSequence extends ObjectAbstract
{
    use OptionsTrait;

    /**
     * Sets the position at which to anchor an image in correspondence to the location of the marker on the map. By default,
     * the anchor is located along the center point of the bottom of the image.
     *
     * @param Point $point
     */
    public function setAnchor(Point $point)
    {
        $this->options['anchor'] = $point;
    }

    /**
     * Sets the path of the [IconSequence]
     *
     * @param $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setPath($value)
    {
        if (!SymbolPath::getIsValid($value)) {
            throw new InvalidConfigException('Unknown Symbol Path');
        }
        $this->options['path'] = new JsExpression($value);
    }
} 