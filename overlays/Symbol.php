<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */

namespace dosamigos\google\maps\overlays;


use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\Point;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * Symbol
 *
 * Object for the anonymous constructor of a symbol. For further reference of the options available please visit
 * https://developers.google.com/maps/documentation/javascript/reference#Symbol
 *
 *
 * @property Point anchor The position of the symbol relative to the marker or polyline. The coordinates of the symbol's
 * path are translated left and up by the anchor's x and y coordinates respectively. By default, a symbol is anchored
 * at (0, 0). The position is expressed in the same coordinate system as the symbol's path.
 * @property string fillColor The symbol's fill color. All CSS3 colors are supported except for extended named colors.
 * For symbol markers, this defaults to 'black'. For symbols on polylines, this defaults to the stroke color of the
 * corresponding polyline.
 * @property int fillOpacity The symbol's fill opacity. Defaults to 0.
 * @property string path The symbol's path, which is a built-in symbol path, or a custom path expressed using SVG path
 * notation. Required.
 * @property int rotation The angle by which to rotate the symbol, expressed clockwise in degrees.
 * Defaults to 0. A symbol in an IconSequence where fixedRotation is false is rotated relative to the angle of the edge
 * on which it lies.
 * @property int scale The amount by which the symbol is scaled in size. For symbol markers, this defaults to 1;
 * after scaling, the symbol may be of any size. For symbols on a polyline, this defaults to the stroke weight of the
 * polyline; after scaling, the symbol must lie inside a square 22 pixels in size centered at the symbol's anchor.
 * @property string strokeColor The symbol's stroke color. All CSS3 colors are supported except for extended named
 * colors. For symbol markers, this defaults to 'black'. For symbols on a polyline, this defaults to the stroke color
 * of the polyline.
 * @property int strokeOpacity The symbol's stroke opacity. For symbol markers, this defaults to 1. For symbols on a
 * polyline, this defaults to the stroke opacity of the polyline.
 * @property int strokeWeight The symbol's stroke weight. Defaults to the scale of the symbol.
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Symbol extends ObjectAbstract
{
    /**
     * @inheritdoc
     *
     * @param array $config
     */
    public function __construct($config = [])
    {

        $this->options = ArrayHelper::merge(
            [
                'anchor' => null,
                'fillColor' => null,
                'fillOpacity' => null,
                'path' => null,
                'rotation' => null,
                'scale' => null,
                'strokeColor' => null,
                'strokeOpacity' => null,
                'strokeWeight' => null,
            ],
            $this->options
        );

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        if ($this->path == null) {
            throw new InvalidConfigException('"path" cannot be null');
        }

    }

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
     * @param SymbolPath $value
     *
     * @throws \yii\base\InvalidConfigException
     */
    public function setPath($value)
    {
        if (!SymbolPath::getIsValid($value)) {
            throw new InvalidConfigException('Unknown SymbolPath');
        }
        $this->options['path'] = new JsExpression($value);
    }

    /**
     * @return string the js constructor of the object
     */
    public function getJs()
    {
        $name = $this->getName(false) ? "var {$this->getName()} = " : "";
        $options = $this->getEncodedOptions();
        return "{$name}{$options}";
    }
} 