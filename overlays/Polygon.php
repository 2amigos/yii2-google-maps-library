<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;


use dosamigos\google\maps\LatLngBounds;
use dosamigos\google\maps\OverlayTrait;
use yii\helpers\ArrayHelper;

/**
 * Polygon
 *
 * Object to render polygons on the map.
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Polygon extends PolygonOptions
{
    use OverlayTrait;


    /**
     * Sets the options based on a MarkerOptions object
     *
     * @param PolygonOptions $polylineOptions
     */
    public function setOptions(PolygonOptions $polylineOptions)
    {
        $options = array_filter($polylineOptions->options);
        $this->options = ArrayHelper::merge($this->options, $options);
    }

    /**
     * Returns the center coordinates of paths
     * @return \dosamigos\google\maps\LatLng|null
     */
    public function getCenterOfPaths()
    {
        $paths = ArrayHelper::getValue($this->options, 'paths');

        return is_array($paths) && !empty($paths)
            ? LatLngBounds::getBoundsOfCoordinates($paths)->getCenterCoordinates()
            : null;
    }

    /**
     * Returns the center of bounds
     * @return \dosamigos\google\maps\LatLng
     */
    public function getCenterOfBounds()
    {
        return LatLngBounds::getBoundsOfPolygons([$this])->getCenterCoordinates();
    }

    /**
     * Returns the js code to create a rectangle on a map
     * @return string
     */
    public function getJs()
    {

        $js = $this->getInfoWindowJs();

        $js[] = "var {$this->getName()} = new google.maps.Polygon({$this->getEncodedOptions()});";

        foreach ($this->events as $event) {
            /** @var \dosamigos\google\maps\Event $event */
            $js[] = $event->getJs($this->getName());
        }


        return implode("\n", $js);
    }
} 