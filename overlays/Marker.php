<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\overlays;

use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\LatLngBounds;
use dosamigos\google\maps\OverlayTrait;
use dosamigos\google\maps\Point;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\helpers\ArrayHelper;

/**
 * Marker
 *
 * Google maps marker. For information about the options available please visit:
 * https://developers.google.com/maps/documentation/javascript/reference?csw=1#MarkerOptions
 *
 * @property Point anchorPoint The offset from the marker's position to the tip of an InfoWindow that has been opened
 * with the marker as anchor.
 * @property string animation Which animation to play when marker is added to a map.
 * @property boolean clickable If true, the marker receives mouse and touch events. Default value is true.
 * @property boolean crossOnDrag If false, disables cross that appears beneath the marker when dragging. This option is
 * true by default.
 * @property string cursor Mouse cursor to show on hover
 * @property boolean draggable If true, the marker can be dragged. Default value is false.
 * @property string|Icon|Symbol icon Icon for the foreground. If a string is provided, it is treated as though it were
 * an Icon with the string as url.
 * @property string map Map on which to display Marker.
 * @property int opacity The marker's opacity between 0.0 and 1.0.
 * @property boolean optimized Optimization renders many markers as a single static element. Optimized rendering is
 * enabled by default. Disable optimized rendering for animated GIFs or PNGs, or when each marker must be rendered as a
 * separate DOM element (advanced usage only).
 * @property LatLng position Marker position. Required.
 * @property MarkerShape shape Image map region definition used for drag/click.
 * @property string title Rollover text
 * @property boolean visible If true, the marker is visible
 * @property int zIndex All markers are displayed on the map in order of their zIndex, with higher values displaying in
 * front of markers with lower values. By default, markers are displayed according to their vertical position on screen,
 * with lower markers appearing in front of markers further up the screen.
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class Marker extends MarkerOptions
{
    use OverlayTrait;

    /**
     * @inheritdoc
     */
    public function init()
    {
        if ($this->position == null) {
            throw new InvalidConfigException('"$position" cannot be null');
        }
    }

    /**
     * Sets the options based on a MarkerOptions object
     *
     * @param MarkerOptions $markerOptions
     */
    public function setOptions(MarkerOptions $markerOptions)
    {
        $options = array_filter($markerOptions->options);
        $this->options = ArrayHelper::merge($this->options, $options);
    }

    /**
     * The constructor js code for the Marker object
     * @return string
     */
    public function getJs()
    {
        $js = $this->getInfoWindowJs();

        $js[] = "var {$this->getName()} = new google.maps.Marker({$this->getEncodedOptions()});";

        foreach ($this->events as $event) {
            /** @var \dosamigos\google\maps\Event $event */
            $js[] = $event->getJs($this->getName());
        }

        return implode("\n", $js);
    }

    /**
     * Returns the marker coords code for the static version of Google Maps
     * @return string
     */
    public function getMarkerStatic()
    {
        return $this->getLat() . ', ' . $this->getLng();
    }

    /**
     * @param LatLngBounds $bounds
     *
     * @return mixed
     */
    public function isInBounds(LatLngBounds $bounds)
    {
        return $this->position instanceof LatLng && $this->position->isInBounds($bounds);
    }

    /**
     * Returns the center coordinates of an array of Markers
     *
     * @param Marker[] $markers
     *
     * @return LatLng|null
     * @throws \yii\base\InvalidParamException
     */
    public static function getCenterOfMarkers($markers)
    {
        $coords = [];
        foreach ($markers as $marker) {
            if (!($marker instanceof Marker)) {
                throw new InvalidParamException('$markers must be an array of "' . self::className() . '" objects');
            }
            $coords[] = $marker->position;
        }

        return LatLng::getCenterOfCoordinates($coords);
    }


    /**
     * Returns the center coordinates of the boundaries of an array of Markers
     *
     * @param Marker[] $markers
     *
     * @return LatLng
     */
    public static function getCenterCoordinates($markers)
    {
        $bounds = LatLngBounds::getBoundsOfMarkers($markers);

        return $bounds->getCenterCoordinates();
    }

} 