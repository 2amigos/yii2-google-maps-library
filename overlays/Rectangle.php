<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;

use dosamigos\google\maps\LatLngBounds;
use dosamigos\google\maps\OverlayTrait;
use yii\base\InvalidConfigException;
use yii\helpers\ArrayHelper;

/**
 * Rectangle
 *
 * A Google Maps Rectangle.
 *
 * @see https://developers.google.com/maps/documentation/javascript/reference?csw=1#RectangleOptions
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Rectangle extends RectangleOptions
{
    use OverlayTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->bounds == null) {
            throw new InvalidConfigException('"$bounds" cannot be null');
        }
    }

    /**
     * Sets the options based on a RectangleOptions object
     *
     * @param RectangleOptions $rectangleOptions
     */
    public function setOptions(RectangleOptions $rectangleOptions)
    {
        $options = array_filter($rectangleOptions->options);
        $this->options = ArrayHelper::merge($this->options, $options);
    }

    /**
     * Returns center of bounds
     * @return \dosamigos\google\maps\LatLng|null
     */
    public function getCenterOfBounds()
    {
        return (null !== $this->bounds && $this->bounds instanceof LatLngBounds)
            ? $this->bounds->getCenterCoordinates()
            : null;
    }

    /**
     * Returns the js code to create a rectangle on a map
     * @return string
     */
    public function getJs()
    {

        $js = $this->getInfoWindowJs();

        $js[] = "var {$this->getName()} = new google.maps.Rectangle({$this->getEncodedOptions()});";

        foreach($this->events as $event) {
            /** @var \dosamigos\google\maps\Event $event */
            $js[] = $event->getJs($this->getName());
        }

        return implode("\n", $js);
    }
} 
