<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;

use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\OptionsTrait;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * MarkerShape
 *
 * Object for the anonymous constructor of a symbol. For further reference of the options available please visit
 * https://developers.google.com/maps/documentation/javascript/reference#Symbol
 *
 *
 * @property array coords The format of this attribute depends on the value of the type and follows the w3 AREA coords
 * specification found at http://www.w3.org/TR/REC-html40/struct/objects.html#adef-coords.
 * The coords attribute is an array of integers that specify the pixel position of the shape relative to the top-left
 * corner of the target image. The coordinates depend on the value of type as follows:
 *
 * - circle: coords is [x1,y1,r] where x1,y2 are the coordinates of the center of the circle, and r is the radius of the
 * circle.
 * - poly: coords is [x1,y1,x2,y2...xn,yn] where each x,y pair contains the coordinates of one vertex of the polygon.
 * - rect: coords is [x1,y1,x2,y2] where x1,y1 are the coordinates of the upper-left corner of the rectangle and x2,y2
 * are the coordinates of the lower-right coordinates of the rectangle.
 *
 * @property string type Describes the shape's type and can be circle, poly or rect.
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class MarkerShape extends ObjectAbstract
{
    use OptionsTrait;

    /**
     * @inheritdoc
     *
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->options = ArrayHelper::merge(
            [
                'coords' => null,
                'type' => null
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

        if ($this->coords == null) {
            throw new InvalidConfigException('"coords" cannot be null');
        }

        if ($this->type == null) {
            throw new InvalidConfigException('"type" cannot be null');
        }
    }

} 