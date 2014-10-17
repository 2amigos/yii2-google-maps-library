<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;

use dosamigos\google\maps\ObjectAbstract;
use dosamigos\google\maps\Point;
use dosamigos\google\maps\Size;
use yii\helpers\ArrayHelper;

/**
 * Icon
 *
 * Object for the anonymous constructor of an icon. Passing an array with same options to the Marker would also do.
 *
 * @property Point anchor The position at which to anchor an image in correspondance to the location of the marker on the map.
 * By default, the anchor is located along the center point of the bottom of the image.
 * @property Point origin The position of the image within a sprite, if any. By default, the origin is located at the top left
 * corner of the image (0, 0).
 * @property Size scaledSize The size of the entire image after scaling, if any. Use this property to stretch/shrink an image
 * or a sprite.
 * @property Point size The display size of the sprite or image. When using sprites, you must specify the sprite size. If the
 * size is not provided, it will be set when the image loads.
 * @property string url The URL of the image or sprite sheet.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Icon extends ObjectAbstract
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
                'origin' => null,
                'scaledSize' => null,
                'size' => null,
                'url' => null,
            ],
            $this->options
        );

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function init()
    {

        $this->options = ArrayHelper::merge(
            [
                // String   Sets the URL of the image or sprite sheet
                'url' => null,
            ],
            $this->options
        );
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
     * Sets the position of the image within a sprite, if any. By default, the origin is located at the top left corner
     * of the image (0, 0).
     *
     * @param Point $origin
     */
    public function setOrigin(Point $origin)
    {
        $this->options['origin'] = $origin;
    }

    /**
     * Sets the size of the entire image after scaling, if any. Use this property to stretch/shrink an image or a sprite.
     *
     * @param Size $size
     */
    public function setScaledSize(Size $size)
    {
        $this->options['scaledSize'] = $size;
    }

    /**
     * Sets the display size of the sprite or image. When using sprites, you must specify the sprite size. If the size
     * is not provided, it will be set when the image loads.
     *
     * @param Size $size
     */
    public function setSize(Size $size)
    {
        $this->options['size'] = $size;
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