<?php
/**
 * @copyright Copyright (c) 2014 2amigOS! Consulting Group LLC
 * @link http://2amigos.us
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 */
namespace dosamigos\google\maps\services;

use dosamigos\google\maps\ObjectAbstract;
use yii\helpers\ArrayHelper;
use yii\web\JsExpression;

/**
 * DirectionsRenderer
 *
 * Google DirectionsRendered object. For further information please visit:
 * https://developers.google.com/maps/documentation/javascript/reference#DirectionsRenderer
 *
 * @property boolean draggable If true, allows the user to drag and modify the paths of routes rendered by this
 * DirectionsRenderer.
 * @property boolean hideRouteList This property indicates whether the renderer should provide UI to select amongst
 * alternative routes. By default, this flag is false and a user-selectable list of routes will be shown in the
 * directions' associated panel. To hide that list, set hideRouteList to true.
 * @property\dosamigos\google\maps\overlays\InfoWindow infoWindow The InfoWindow in which to render text information when a marker is clicked.
 * Existing info window content will be overwritten and its position moved. If no info window is specified, the
 * DirectionsRenderer will create and use its own info window. This property will be ignored if suppressInfoWindows
 * is set to true.
 * @property string map Map on which to display the directions.
 * @property array markerOptions Options for the markers. All markers rendered by the DirectionsRenderer will use
 * these options.
 * @property string panel The <div> in which to display the directions steps.
 * @property array polylineOptions Options for the polylines. All polylines rendered by the DirectionsRenderer will
 * use these options.
 * @property boolean preserveViewport By default, the input map is centered and zoomed to the bounding box of this
 * set of directions. If this option is set to true, the viewport is left unchanged, unless the map's center and
 * zoom were never set.
 * @property int routeIndex The index of the route within the DirectionsResult object. The default value is 0.
 * @property boolean suppressBicyclingLayer Suppress the rendering of the BicyclingLayer when bicycling directions
 * are requested.
 * @property boolean suppressInfoWindows Suppress the rendering of info windows.
 * @property boolean suppressMarkers Suppress the rendering of markers.
 * @property boolean suppressPolylines Suppress the rendering of polylines.
 *
 *
 * @author Antonio Ramirez <amigo.cobos@gmail.com>
 * @link http://www.ramirezcobos.com/
 * @link http://www.2amigos.us/
 * @package dosamigos\google\maps
 */
class DirectionsRenderer extends ObjectAbstract
{
    /**
     * @inheritdoc
     * @param array $config
     */
    public function __construct($config = [])
    {
        $this->options = ArrayHelper::merge(
            [
                'draggable' => null,
                'hideRouteList' => null,
                'infoWindow' => null,
                'map' => null,
                'markerOptions' => null,
                'panel' => null,
                'polylineOptions' => null,
                'preserveViewport' => null,
                'routeIndex' => null,
                'suppressBicyclingLayer' => null,
                'suppressInfoWindows' => null,
                'suppressMarkers' => null,
                'suppressPolylines' => null,
            ],
            $this->options
        );

        return parent::__construct($config);
    }

    /**
     * Sets the map option attribute
     * @param string $value
     */
    public function setMap($value)
    {
        $this->options['map'] = new JsExpression($value);
    }

    /**
     * The constructor js code for the DirectionsRenderer object
     * @return string
     */
    public function getJs()
    {
        if ($this->panel !== null) {
            $this->panel = new JsExpression("document.getElementById('{$this->panel}')");
        }

        return "var {$this->getName()} = new google.maps.DirectionsRenderer({$this->getEncodedOptions()});";
    }
} 